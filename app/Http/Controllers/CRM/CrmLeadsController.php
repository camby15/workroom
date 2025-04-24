<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CrmLeads;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\{Auth, Session, Log, Validator};
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class CrmLeadsController extends Controller
{
    /**
     * Display a listing of leads.
     * 
     * @return View|RedirectResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Validate user authentication
            if (!Auth::check()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Please login to continue'
                ], 401);
            }
    
            // Get the current company ID from session
            $companyId = Session::get('selected_company_id');
            
            if (!$companyId) {
                Log::warning('No company ID in session for leads');
                return response()->json([
                    'error' => true,
                    'message' => 'Company session expired. Please login again.'
                ], 403);
            }
    
            // Fetch non-deleted leads for the current company with pagination
            $leads = CrmLeads::where('company_id', $companyId)
                ->whereNull('deleted_at')  // Explicitly fetch non-deleted leads
                ->orderBy('created_at', 'desc')
                ->paginate(5);
    
            Log::info('Fetched active leads', [
                'company_id' => $companyId,
                'active_lead_count' => $leads->total()
            ]);
    
            return response()->json([
                'error' => false,
                'message' => 'Leads fetched successfully',
                'data' => $leads->items(), // Leads data
                'pagination' => [
                    'total' => $leads->total(),
                    'per_page' => $leads->perPage(), 
                    'current_page' => $leads->currentPage(),
                    'last_page' => $leads->lastPage(),
                    'next_page_url' => $leads->nextPageUrl(),
                    'prev_page_url' => $leads->previousPageUrl()
                ]
            ]);
    
        } catch (\Exception $e) {
            Log::error('Error fetching leads', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'company_id' => $companyId ?? 'Unknown'
            ]);
    
            return response()->json([
                'error' => true,
                'message' => 'Error fetching leads: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Store a newly created lead.
     */
    public function store(Request $request)
    {
        try {
            // Validate user authentication
            if (!Auth::check()) {
                return $request->ajax() 
                    ? response()->json(['error' => 'Unauthorized access'], 401)
                    : redirect()->back()->with('error', 'Unauthorized access');
            }

            // Get the current company ID
            $companyId = Session::get('selected_company_id');
            
            if (!$companyId) {
                return $request->ajax() 
                    ? response()->json(['error' => 'Company session expired'], 401)
                    : redirect()->back()->with('error', 'Company session expired');
            }

            // Validate input
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:crm_leads,email',
                'phone' => 'required|string|max:20',
                'source' => 'required|in:Website,Referral,Social Media,Direct,Other',
                'contact_person' => 'nullable|string|max:255',
                'contact_person_email' => 'nullable|email|max:255',
                'contact_person_phone' => 'nullable|string|max:20',
                'notes' => 'nullable|string|max:1000'
            ]);

            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }


            // Create new lead
            $lead = new CrmLeads();
            $lead->company_id = $companyId;
            $lead->name = $request->input('name');
            $lead->email = $request->input('email');
            $lead->phone = $request->input('phone');
            $lead->source = $request->input('source');
            $lead->contact_person = $request->input('contact_person');
            $lead->contact_person_email = $request->input('contact_person_email');
            $lead->contact_person_phone = $request->input('contact_person_phone');
            $lead->notes = $request->input('notes', '');
            $lead->status = 'New'; // Default status
            
            if ($lead->save()) {
                Log::info('Lead created successfully', [
                    'lead_id' => $lead->id,
                    'company_id' => $companyId
                ]);

                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Lead added successfully',
                        'data' => $lead
                    ]);
                }

                return redirect()->back()->with('success', 'Lead added successfully');
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create lead',
                    'errors' => ['Failed to create lead']
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to create lead');

        } catch (\Exception $e) {
            Log::error('Error creating lead', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating lead: ' . $e->getMessage(),
                    'errors' => [$e->getMessage()]
                ], 500);
            }

            return redirect()->back()->with('error', 'Error creating lead: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing a lead.
     */
    public function edit($id)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['error' => 'Unauthorized access'], 401);
            }
    
            $companyId = Session::get('selected_company_id');
            if (!$companyId) {
                return response()->json(['error' => 'Company session expired'], 401);
            }

            // Log the ID being used to fetch the lead
            Log::info('Attempting to fetch lead with ID:', ['id' => $id, 'company_id' => $companyId]);

            // Log the query being executed
            Log::info('Querying for lead:', [
                'lead_id' => $id,
                'company_id' => $companyId,
                'query' => CrmLeads::where('id', $id)->where('company_id', $companyId)->toSql(),
                'bindings' => CrmLeads::where('id', $id)->where('company_id', $companyId)->getBindings(),
            ]);

            $lead = CrmLeads::where('id', $id)
                ->where('company_id', $companyId)
                ->firstOrFail();
    
            Log::info('Lead data fetched for edit:', $lead->toArray()); // Debug log
    
            return response()->json($lead);
        } catch (\Exception $e) {
            Log::error('Error preparing lead edit: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to prepare edit' . $e->getMessage()], 500); // Include the exception message], 500);
        }
    }

    /**
     * Update an existing lead's information
     */
    public function update(Request $request, $id)
    {
        try {
            // Get the current company ID from session
            $companyId = Session::get('selected_company_id');
            Log::info('Update request received', [
                'company_id' => $companyId,
                'lead_id' => $id,
                'is_ajax' => $request->ajax(),
                'request_method' => $request->method()
            ]);

            if (!$companyId) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Company session expired'
                    ], 401);
                }
                return redirect()->back()->with('error', 'Company session expired');
            }

            // Fetch the lead
            Log::info('Fetching lead for update', ['id' => $id, 'company_id' => $companyId]);
            $lead = CrmLeads::where('id', $id)
                ->where('company_id', $companyId)
                ->firstOrFail();

            // Log the current lead data
            Log::info('Current lead data before update', $lead->toArray());

            // Check if this is a status update
            if (
                $request->ajax() &&
                $request->has('status') &&
                // Only 'status' and possibly '_method' fields present (from dropdown)
                (count($request->all()) === 1 || (count($request->all()) === 2 && $request->has('_method')))
            ) {
                return $this->updateStatus($request, $id);
            }

            // Log the incoming request data
            Log::info('Request data for update', [
                'all_data' => $request->all()
            ]);

            // Validate incoming request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:crm_leads,email,' . $lead->id . ',id,company_id,' . $companyId,
                'phone' => 'nullable|string',
                'source' => 'nullable|string',
                'notes' => 'nullable|string|max:1000',
                'status' => 'nullable|string',
                'contact_person' => 'nullable|string|max:255',
                'contact_person_email' => 'nullable|email|max:255',
                'contact_person_phone' => 'nullable|string|max:20',
                'appointment_date' => 'nullable|date',
                'appointment_time' => 'nullable|date_format:H:i',
                'appointment_type' => 'nullable|string',
                'appointment_notes' => 'nullable|string'
            ]);

            // Log the validated data
            Log::info('Validated data for update', [
                'validated_data' => $validatedData
            ]);

            // Update the lead's information
            Log::info('Attempting to update lead', [
                'lead_id' => $lead->id,
                'data_to_update' => $validatedData
            ]);
            
            $lead->update($validatedData);

            // Log the updated lead data
            Log::info('Lead updated successfully', [
                'lead_id' => $lead->id,
                'company_id' => $companyId,
                'updated_data' => $lead->toArray()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Lead has been updated successfully',
                    'data' => $lead
                ]);
            }

            return redirect()->route('crm.leads.index')
                ->with('success', 'Lead updated successfully');

        } catch (\ValidationException $e) {
            Log::error('Validation error during lead update', [
                'errors' => $e->errors(),
                'lead_id' => $id,
                'company_id' => $companyId
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating lead', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'lead_id' => $id,
                'company_id' => $companyId
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update lead. Please try again.',
                    'errors' => [$e->getMessage()]
                ], 500);
            }

            return back()->with('error', 'Failed to update lead. Please try again.');
        }
    }

    /**
     * Soft delete a lead
     */
    public function destroy($id)
    {
        try {
            $lead = CrmLeads::findOrFail($id);
            
            // Soft delete the lead
            $lead->delete();

            // Return response based on request type
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Lead has been moved to trash successfully'
                ]);
            }

            return redirect()->back()->with('success', 'Lead has been moved to trash successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting lead: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to move lead to trash. Please try again.'
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to move lead to trash. Please try again.');
        }
    }
    
   /**
     * Schedule an appointment for a lead
     */
    public function scheduleAppointment(Request $request)
    {
        try {
            if (!Auth::check()) {
                return redirect()->back()->with('error', 'Unauthorized access');
            }

            $companyId = Session::get('selected_company_id');
            if (!$companyId) {
                return redirect()->back()->with('error', 'Company session expired');
            }

            // Validate appointment details
            $validator = Validator::make($request->all(), [
                'lead_id' => 'required|exists:crm_leads,id',
                'appointment_date' => 'required|date_format:Y-m-d',
                'appointment_time' => 'required|date_format:H:i',
                'notes' => 'nullable|string|max:1000'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Find the lead
            $lead = CrmLeads::where('id', $request->input('lead_id'))
                ->where('company_id', $companyId)
                ->firstOrFail();

            // Update lead with appointment details
            $lead->appointment_date = $request->input('appointment_date');
            $lead->appointment_time = $request->input('appointment_time');
            $lead->appointment_notes = $request->input('notes', '');
            $lead->status = 'Appointment Scheduled';
            $lead->save();

            Log::info('Appointment scheduled for lead', [
                'lead_id' => $lead->id,
                'company_id' => $companyId,
                'appointment_date' => $lead->appointment_date,
                'appointment_time' => $lead->appointment_time
            ]);

            return redirect()->back()->with('success', 'Appointment scheduled successfully');

        } catch (\Exception $e) {
            Log::error('Error scheduling appointment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Error scheduling appointment: ' . $e->getMessage());
        }
    }

    /**
     * Convert a lead to a opportunity.
     */
    public function convertToOpportunity(Request $request)
    {
        try {
            // Validate user authentication
            if (!Auth::check()) {
                return redirect()->back()->with('error', 'Unauthorized access');
            }

            // Get the current company ID
            $companyId = Session::get('selected_company_id');
            if (!$companyId) {
                return redirect()->back()->with('error', 'Company session expired');
            }

            // Validate input
            $validator = Validator::make($request->all(), [
                'lead_id' => 'required|exists:crm_leads,id',
                'customer_category' => 'required|in:partner,vendor,client',
                'customer_value' => 'required|numeric|min:0'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Find the lead
            $lead = CrmLeads::where('id', $request->input('lead_id'))
                ->where('company_id', $companyId)
                ->firstOrFail();

            // Create a new customer
            $customer = new \App\Models\Customer();
            $customer->company_id = $companyId;
            $customer->name = $lead->name;
            $customer->email = $lead->email;
            $customer->phone = $lead->phone;
            $customer->category = $request->input('customer_category');
            $customer->value = $request->input('customer_value');
            $customer->status = 'Active';
            $customer->address = ''; // Optional: Add address if available
            $customer->sector = ''; // Optional: Add sector if available

            if ($customer->save()) {
                // Mark lead as converted
                $lead->status = 'Converted';
                $lead->save();

                Log::info('Lead converted to customer', [
                    'lead_id' => $lead->id,
                    'customer_id' => $customer->id,
                    'company_id' => $companyId
                ]);

                return redirect()->back()->with('success', 'Lead converted to customer successfully');
            }

            return redirect()->back()->with('error', 'Failed to convert lead to customer');

        } catch (\Exception $e) {
            Log::error('Error converting lead to customer', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Error converting lead to customer: ' . $e->getMessage());
        }
    }

    /**
     * Bulk upload leads from a CSV file
     */
    public function bulkUpload(Request $request)
    {
        try {
            // Validate user authentication
            if (!Auth::check()) {
                return $request->ajax() 
                    ? response()->json(['error' => 'Unauthorized access'], 401)
                    : redirect()->route('auth.login')->with('error', 'Please login to continue');
            }

            // Get the current company ID from session
            $companyId = Session::get('selected_company_id');
            if (!$companyId) {
                return $request->ajax() 
                    ? response()->json(['error' => 'Company session expired'], 401)
                    : redirect()->route('auth.login')->with('error', 'Company session expired. Please login again.');
            }

            // Validate file upload
            $validator = Validator::make($request->all(), [
                'bulk_upload_file' => 'required|file|mimes:csv,txt|max:2048'
            ]);

            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid file upload',
                        'errors' => $validator->errors()
                    ], 422);
                }
                return back()->withErrors($validator)->with('error', 'Invalid file upload');
            }

            $file = $request->file('bulk_upload_file');

            // Read CSV file
            $csvData = array_map('str_getcsv', file($file));
            
            // Remove header row
            $headers = array_shift($csvData);

            // Validate headers
            $requiredHeaders = ['Name', 'Email', 'Phone', 'Source', 'Contact Person', 'Contact Person Email', 'Contact Person Phone', 'Notes'];
            foreach ($requiredHeaders as $header) {
                if (!in_array($header, $headers)) {
                    if ($request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'message' => "Missing required column: $header"
                        ], 422);
                    }
                    return back()->with('error', "Missing required column: $header");
                }
            }

            // Prepare leads for bulk insert
            $leads = [];
            $successCount = 0;
            $errorCount = 0;
            $errors = [];

            foreach ($csvData as $row) {
                $leadData = array_combine($headers, $row);

                // Validate each lead
                $leadValidator = Validator::make($leadData, [
                    'Name' => 'required|string|max:255',
                    'Email' => 'required|email|unique:crm_leads,email',
                    'Phone' => 'required|string|max:20',
                    'Source' => 'required|in:Website,Referral,Social Media,Direct,Other',
                    'Contact Person' => 'required|string|max:255',
                    'Contact Person Email' => 'required|email',
                    'Contact Person Phone' => 'required|string|max:20',
                    'Notes' => 'nullable|string'
                ]);

                if ($leadValidator->fails()) {
                    $errorCount++;
                    $errors[] = $leadValidator->errors()->first();
                    continue;
                }

                $leads[] = [
                    'company_id' => $companyId,
                    'name' => $leadData['Name'],
                    'email' => $leadData['Email'],
                    'phone' => $leadData['Phone'],
                    'source' => $leadData['Source'],
                    'contact_person' => $leadData['Contact Person'],
                    'contact_person_email' => $leadData['Contact Person Email'],
                    'contact_person_phone' => $leadData['Contact Person Phone'],
                    'notes' => $leadData['Notes'] ?? null,
                    'status' => 'New', // Default status
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                $successCount++;
            }

            // Bulk insert leads
            if (!empty($leads)) {
                CrmLeads::insert($leads);
            }

            Log::info('Bulk leads uploaded', [
                'company_id' => $companyId,
                'total_leads' => $successCount,
                'errors' => $errorCount
            ]);

            $message = "$successCount leads uploaded successfully";
            if ($errorCount > 0) {
                $message .= " (with $errorCount errors)";
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'data' => [
                        'success_count' => $successCount,
                        'error_count' => $errorCount,
                        'errors' => $errors
                    ]
                ]);
            }

            return redirect()->back()
                ->with('success', $message)
                ->withErrors($errors);

        } catch (\Exception $e) {
            Log::error('Error in bulk lead upload', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to upload leads: ' . $e->getMessage(),
                    'errors' => [$e->getMessage()]
                ], 500);
            }

            return back()
                ->with('error', 'Failed to upload leads: ' . $e->getMessage())
                ->with('errors', [$e->getMessage()]);
        }
    }

    /**
     * Download CSV template for bulk leads upload
     */
    public function downloadTemplate()
    {
        try {
            $filename = 'Leads Bulk Upload Template.csv';
            $tempFile = tempnam(sys_get_temp_dir(), $filename);
            $handle = fopen($tempFile, 'w');
        
            // Write the header row
            $headers = [
                'Name',
                'Email', 
                'Phone', 
                'Source', 
                'Contact Person', 
                'Contact Person Email', 
                'Contact Person Phone', 
                'Notes'
            ];
            fputcsv($handle, $headers);
        
            // Write an example row
            $exampleRow = [
                'John Doe',
                'john.doe@example.com',
                '0243000000',
                'Referral',
                'Jane Smith',
                'jane.smith@example.com',
                '+1 (555) 123-4567',
                'Potential client from networking event'
            ];
            fputcsv($handle, $exampleRow);
        
            fclose($handle);
        
            return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error('Error creating leads template: ' . $e->getMessage());
            return back()->with('error', 'Unable to download template');
        }
    }
    /**
     * Handle AJAX status update for a lead
    */
    public function updateStatus(Request $request, $id)
    {
        // Log the incoming request for debugging
        Log::info('updateStatus called', ['id' => $id, 'request' => $request->all()]);

        try {
            // Get the company ID from the session
            $companyId = Session::get('selected_company_id');

            // Find the lead by ID and company ID
            $lead = CrmLeads::where('id', $id)
                ->where('company_id', $companyId)
                ->firstOrFail();

            // Validate the incoming status
            $request->validate([
                'status' => 'required|string|in:New,Qualified,Unqualified,Converted'
            ]);

            // Log status before update
            Log::info('Status before update', [
                'lead_id' => $lead->id,
                'status' => $lead->status,
                'company_id' => $companyId
            ]);

            // Update and save the status
            $lead->status = $request->input('status');
            $lead->save();

            // Log status after update
            Log::info('Status after update', [
                'lead_id' => $lead->id,
                'status' => $lead->status,
                'company_id' => $companyId
            ]);

            // Log successful update
            Log::info('Lead status updated via AJAX', [
                'lead_id' => $lead->id,
                'status' => $lead->status,
                'company_id' => $companyId
            ]);

            // Return JSON response
            return response()->json([
                'success' => true,
                'message' => 'Status updated',
                'data' => $lead
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error updating lead status', [
                'message' => $e->getMessage(),
                'lead_id' => $id,
                'company_id' => isset($companyId) ? $companyId : null
            ]);

            // Return error JSON response
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status',
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }

}
