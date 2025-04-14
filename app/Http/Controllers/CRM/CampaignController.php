<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CampaignController extends Controller
{
    /**
     * Display a listing of campaigns.
     */
    public function index()
    {
        try {
            // Extensive logging for debugging
            Log::info('Campaign Index Method Called', [
                'authenticated' => Auth::check(),
                'user_id' => Auth::id(),
                'session_data' => Session::all()
            ]);

            if (!Auth::check()) {
                Log::warning('User not authenticated when accessing campaigns');
                return redirect()->route('auth.login')->with('error', 'Please login to continue');
            }

            $companyId = Session::get('selected_company_id');
            
            // Log company ID details
            Log::info('Company ID Check', [
                'company_id' => $companyId,
                'is_null' => is_null($companyId)
            ]);

            if (!$companyId) {
                Log::warning('No company ID found in session');
                return redirect()->route('auth.login')->with('error', 'Company session expired. Please login again.');
            }

            // Fetch campaigns with extensive logging
            $campaigns = Campaign::where('company_id', $companyId)
                ->where('deleted', 0) // Use where() instead of and()
                ->latest()
                ->paginate(10); // Paginate 10 per page

            // Log campaigns details
            Log::info('campaigns Fetch Result', [
                'count' => $campaigns->count(),
                'company_id' => $companyId,
                'first_Campaign' => $campaigns->first() ? $campaigns->first()->toArray() : null
            ]);

            // Always pass $campaigns, even if it's an empty collection
            return response()->json([
                'error' => false,
                'message' => 'campaigns fetched successfully',
                'data' => $campaigns->items(), // Leads data
                'pagination' => [
                    'total' => $campaigns->total(),
                    'per_page' => $campaigns->perPage(), 
                    'current_page' => $campaigns->currentPage(),
                    'last_page' => $campaigns->lastPage(),
                    'next_page_url' => $campaigns->nextPageUrl(),
                    'prev_page_url' => $campaigns->previousPageUrl()
                ]
            ]);
    
        } catch (\Exception $e) {
            // Comprehensive error logging
            Log::error('Error in Campaign Index Method', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'company_id' => Session::get('selected_company_id')
            ]);
            
            // Pass an empty collection to prevent undefined variable error
            return view('company.CRM.marketing', [
                'campaigns' => collect(),
                'activeTab' => 'customer'
            ]);
        }
    }

    // public function index1()
    // {
    //     $campaigns = Campaign::where('deleted', 0)->latest()->get();
    //     return view('company.CRM.marketing', compact('campaigns'));
    // }

    public function filter(Request $request)
    {
        $campaigns = Campaign::query()
            ->with('campaignDetails')
            ->where('company_id', session('selected_company_id'));

        if ($request->filled('search')) {
            $campaigns->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $campaigns->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $campaigns->where('status', $request->status);
        }

        $campaigns = $campaigns->latest()->get();

        $html = view('company.CRM.marketing', compact('campaigns'))->render();

        return response()->json(['html' => $html]);
    }

    /**
     * Show the form for creating a new campaign.
     */
    public function create()
    {
        return view('campaigns.create');
    }

    /**
     * Store a newly created campaign in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'budget' => 'required|numeric|min:0',
            'target_audience' => 'nullable|array',
            'campaign_goals' => 'nullable|string',
            'kpis_lead_goal' => 'nullable|numeric', 
            'kpis_conversion_goal' => 'nullable|numeric', 
            'kpis_roi_goal' => 'nullable|numeric', 
            'status' => 'required|string|in:active,inactive,draft',
        ]);

        $validated['company_id'] = Auth::user()->companyProfile->id ?? null;
        $validated['created_by'] = Auth::id();
        $validated['deleted'] = 0; // Not deleted by default

        try {
            // Create Campaign
            $campaign = Campaign::create($validated);

            // Create Campaign Detail Entry
            CampaignDetail::create([
                'campaign_id' => $campaign->id,
                'goals' => $validated['campaign_goals'] ?? null,
                'notes' => null, // You can add a notes input later if needed
                'kpis' => json_encode([
                    'lead_goal' => $request->kpi_lead_goal,
                    'conversion_goal' => $request->kpi_conversion_goal,
                    'roi_goal' => $request->kpi_roi_goal,
                ]),
                'created_by' => Auth::id(),
            ]);

            Session::flash('success', 'Campaign created successfully!');
        } catch (\Exception $e) {
            Log::error('Campaign creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage()); // Show real error
        }

        return redirect()->back();
    }

    /**
     * Show a specific campaign.
     */
    public function show(Campaign $campaign)
    {
        if ($campaign->deleted) {
            abort(404);
        }
        return view('campaigns.show', compact('campaign'));
    }

    /**
     * Show the form for editing a campaign.
     */
    public function edit(Campaign $campaign)
    {
        if ($campaign->deleted) {
            abort(404);
        }
        return view('campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        try {
            if ($campaign->deleted) {
                abort(404);
            }

            // Check if the request is primarily for notes/documents
            $isNoteOrDocumentUpdate = $request->has('notes') || $request->hasFile('documents');

            // Define base validation rules
            $rules = [
                'notes' => 'nullable|array',
                'documents' => 'nullable|array',
                'documents.*' => 'file|mimes:pdf,doc,docx,jpg,png,jpeg',
            ];
            // Only enforce campaign field validations if it's not just a note/document update
            if (!$isNoteOrDocumentUpdate) {
                $rules = array_merge($rules, [
                    'name' => 'required|string|max:255',
                    'type' => 'required|string',
                    'start_date' => 'required|date',
                    'end_date' => 'required|date|after_or_equal:start_date',
                    'budget' => 'required|numeric|min:0',
                    'target_audience' => 'nullable|array',
                    'campaign_goals' => 'nullable|string',
                    'kpi_lead_goal' => 'nullable|numeric',
                    'kpi_conversion_goal' => 'nullable|numeric',
                    'kpi_roi_goal' => 'nullable|numeric',
                    'status' => 'required|string|in:draft,active,paused,completed,cancelled',
                ]);
            }
            // dd($request);
            // dd($isNoteOrDocumentUpdate);
            // Validate dynamically
            $validated = $request->validate($rules);
            $validated['edited_by'] = Auth::id();

            DB::beginTransaction();

            // Only update campaign fields if it's a full update
            if (!$isNoteOrDocumentUpdate) {
                $campaign->update($validated);
            }

            // Retrieve existing campaign details
            $campaignDetails = $campaign->campaignDetails()->firstOrCreate([
                'campaign_id' => $campaign->id
            ]);

            // Merge new notes with existing notes
            $existingNotes = json_decode($campaignDetails->notes, true) ?? [];
            $newNotes = $validated['notes'] ?? [];
            $mergedNotes = array_merge($existingNotes, $newNotes);

            // Handle document uploads
            $existingDocuments = json_decode($campaignDetails->documents, true) ?? [];
            $newDocuments = [];

            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $document) {
                    $path = $document->store('campaign_documents', 'public'); // Store in `storage/app/public/campaign_documents`
                    $newDocuments[] = $path;
                }
            }

            // Merge old and new document paths
            $mergedDocuments = array_merge($existingDocuments, $newDocuments);

            // Update campaign details
            $campaignDetails->update([
                'goals' => $validated['campaign_goals'] ?? $campaignDetails->goals,
                'notes' => json_encode($mergedNotes),
                'documents' => json_encode($mergedDocuments),
                'kpis' => json_encode([
                    'lead_goal' => $validated['kpi_lead_goal'] ?? null,
                    'conversion_goal' => $validated['kpi_conversion_goal'] ?? null,
                    'roi_goal' => $validated['kpi_roi_goal'] ?? null,
                ]),
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Campaign updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating campaign: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }



    public function storeNotes(Request $request, $campaignId) {
        $campaign = Campaign::findOrFail($campaignId);
    
        // Get existing campaign details
        $campaignDetails = json_decode($campaign->campaignDetails, true) ?? [];
    
        // Initialize notes and documents if not present
        if (!isset($campaignDetails['notes'])) {
            $campaignDetails['notes'] = [];
        }
        if (!isset($campaignDetails['documents'])) {
            $campaignDetails['documents'] = [];
        }
    
        // Append new notes
        foreach ($request->notes as $note) {
            if (!empty($note)) {
                $campaignDetails['notes'][] = [
                    'content' => $note,
                    'added_at' => now(),
                ];
            }
        }
    
        // Handle document uploads
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('campaign-documents', 'public');
    
                $campaignDetails['documents'][] = [
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'added_at' => now(),
                ];
            }
        }
    
        // Update campaign details
        $campaign->campaignDetails = json_encode($campaignDetails);
        $campaign->save();
    
        return back()->with('success', 'Notes and documents added.');
    }
    
    public function destroy(Campaign $campaign)
    {
        try {
            if ($campaign->deleted) {
                abort(404);
            }

            // Ensure campaign exists before attempting update
            if (!$campaign) {
                return redirect()->back()->with('error', 'Campaign not found.');
            }

            $updated = $campaign->update([
                'deleted' => 1,
                'deleted_at' => now(),
                'deleted_by' => Auth::id(),
            ]);

            if (!$updated) {
                return redirect()->back()->with('error', 'Campaign deletion failed.');
            }

            return redirect()->back()->with('success', 'Campaign deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting campaign: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete the campaign. Please try again.');
        }
    }

}
