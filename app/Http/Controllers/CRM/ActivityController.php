<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ActivityController extends Controller
{ 
    /**
     * Display a listing of activities.
     */
    public function index()
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('auth.login')->with('error', 'Please login to continue');
            }

            $companyId = Session::get('selected_company_id');
            
            if (!$companyId) {
                return redirect()->route('auth.login')->with('error', 'Company session expired. Please login again.');
            }

            $activities = Activity::with(['user', 'relatedModel'])
                ->where('company_id', $companyId)
                ->whereNull('deleted_at')
                ->orderBy('id', 'desc')
                ->paginate(5);

                return response()->json([
                    'error' => false,
                    'message' => 'Opportunities fetched successfully',
                    'data' => $activities->items(), // Leads data
                    'pagination' => [
                        'total' => $activities->total(),
                        'per_page' => $activities->perPage(), 
                        'current_page' => $activities->currentPage(),
                        'last_page' => $activities->lastPage(),
                        'next_page_url' => $activities->nextPageUrl(),
                        'prev_page_url' => $activities->previousPageUrl()
                    ]
                ]);
       
        } catch (\Exception $e) {
            Log::error('Activity Index Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching activities');
        }
    }

    /**
     * Store a new activity.
     */
    public function store(Request $request)
    {
        try {

            $companyId = Session::get('selected_company_id');
            $userId = Auth::id();




            if($request->type == "task"){

                $validated = $request->validate([
                    'title' => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'type' => 'required|string|in:task,call,meeting,event',
                    'related_to' => 'nullable|string',
                    'related_to_type' => 'nullable|string',
                    'start_date' => 'required|date',
                    'end_date' => 'nullable|date|after_or_equal:start_date',
                    'priority' => 'required|string|in:low,medium,high'
                ]);
    
               
    
                $activityData = [
                    'company_id' => $companyId,
                    'user_id' => $userId,
                    'title' => $validated['title'],
                    'description_agenda_notes' => $validated['description'],
                    'type' => $validated['type'],
                    'related_to' => $validated['related_to'],
                    'related_to_type' => $validated['related_to_type'],
                    'start_date' => $validated['start_date'],
                    'priority' => $validated['priority'],
                    'status' => 'pending'
                ];

            }else  if($request->type == "meeting"){
                $validated = $request->validate([
                    'meetingTitle' => 'required|string|max:255',
                    'meetingAgenda' => 'nullable|string',
                    'type' => 'required|string|in:task,call,meeting,event',
                    'meetingParticipants' => 'nullable|string',
                    'meetingDate' => 'nullable|date|after_or_equal:start_date',
                    'meetingDuration' => 'nullable|string',

                ]);
    
               
    
                $activityData = [
                    'company_id' => $companyId,
                    'user_id' => $userId,
                    'title' => $validated['meetingTitle'],
                    'description_agenda_notes' => $validated['meetingAgenda'],
                    'type' => $validated['type'],
                    'participants' => $validated["meetingParticipants"],
                    'start_date' => $validated['meetingDate'],
                    'duration' => $validated["meetingDuration"],
                    'status' => 'pending'
                ];

            }else  if($request->type == "call"){


                $validated = $request->validate([
                    'callTitle' => 'required|string|max:255',
                    'callNotes' => 'nullable|string',
                    'type' => 'required|string|in:task,call,meeting,event',
                    'contact' => 'nullable|string',
                    'callType' => 'nullable|string',
                    // 'start_date' => 'required|date',
                    'callDate' => 'nullable|date|after_or_equal:start_date',
                    
                ]);
    
               
    
                $activityData = [
                    'company_id' => $companyId,
                    'user_id' => $userId,
                    'title' => $validated['callTitle'],
                    'description_agenda_notes' => $validated['callNotes'],
                    'type' => $validated['type'],
                    'contact' => $validated['contact'],
                    'call_event_type' => $validated['callType'],
                    'start_date' => $validated['callDate'],
                    'status' => 'pending'
                ];

            }else  if($request->type == "event"){
                $validated = $request->validate([
                    'eventName' => 'required|string|max:255',
                    'eventDescription' => 'nullable|string',
                    'type' => 'required|string|in:task,call,meeting,event',
                
                    'eventType' => 'nullable|string',
                    'eventStart' => 'required|date',
                    'eventEnd' => 'nullable|date|after_or_equal:start_date',
        
                ]);
    
               
    
                $activityData = [
                    'company_id' => $companyId,
                    'user_id' => $userId,
                    'title' => $validated['eventName'],
                    'description_agenda_notes' => $validated['eventDescription'],
                    'type' => $validated['type'],
                    'call_event_type' => $validated['eventType'],
                    'start_date' => $validated['eventStart'],
                    'end_date' => $validated["eventEnd"],
                    'status' => 'pending'
                ];

            }
           

            // Only add end_date if it's set
            if (isset($validated['end_date'])) {
                $activityData['end_date'] = $validated['end_date'];
            }

            $activity = Activity::create($activityData);

            return response()->json([
                'success' => true,
                'message' => 'Activity created successfully',
                'data' => $activity
            ]);

        } catch (\Exception $e) {
            Log::error('Activity Store Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

   
  
    /**
     * Delete an activity.
     */
    public function destroy($id)
    {
        try {
            $activity = Activity::where('company_id', Session::get('selected_company_id'))
                ->where('id', $id)
                ->first();

            if (!$activity) {
                return response()->json(['error' => 'Activity not found'], 404);
            }

            $activity->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Activity Delete Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete activity'], 500);
        }
    }

    /**
     * Complete an activity.
     */
    public function complete($id)
    {
        try {
            $activity = Activity::where('company_id', Session::get('selected_company_id'))
                ->where('id', $id)
                ->first();

            if (!$activity) {
                return response()->json(['error' => 'Activity not found'], 404);
            }

            $activity->update([
                'status' => 'completed',
                'end_date' => now()
            ]);

            return response()->json(['success' => true, 'activity' => $activity]);
        } catch (\Exception $e) {
            Log::error('Activity Complete Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to complete activity'], 500);
        }
    }

    /**
 * Update an activity.
 */
public function update(Request $request, $id)
{
    try {
        $activity = Activity::where('company_id', Session::get('selected_company_id'))
            ->where('id', $id)
            ->first();

        if (!$activity) {
            return response()->json(['error' => 'Activity not found'], 404);
        }

        $companyId = Session::get('selected_company_id');
        $userId = Auth::id();

        if($request->type == "task"){
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'type' => 'required|string|in:task,call,meeting,event',
                'related_to' => 'nullable|string',
                'related_to_type' => 'nullable|string',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'priority' => 'required|string|in:low,medium,high'
            ]);

            $activityData = [
                'title' => $validated['title'],
                'description_agenda_notes' => $validated['description'],
                'type' => $validated['type'],
                'related_to' => $validated['related_to'],
                'related_to_type' => $validated['related_to_type'],
                'start_date' => $validated['start_date'],
                'priority' => $validated['priority']
            ];

        } else if($request->type == "meeting") {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'type' => 'required|string|in:task,call,meeting,event',
                'participants' => 'nullable|string',
                'start_date' => 'required|date',
                'duration' => 'nullable|string',
            ]);

            $activityData = [
                'title' => $validated['title'],
                'description_agenda_notes' => $validated['description'],
                'type' => $validated['type'],
                'participants' => $validated['participants'],
                'start_date' => $validated['start_date'],
                'duration' => $validated['duration']
            ];

        } else if($request->type == "call") {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'type' => 'required|string|in:task,call,meeting,event',
                'contact' => 'nullable|string',
                'call_event_type' => 'nullable|string',
                'start_date' => 'required|date',
            ]);

            $activityData = [
                'title' => $validated['title'],
                'description_agenda_notes' => $validated['description'],
                'type' => $validated['type'],
                'contact' => $validated['contact'],
                'call_event_type' => $validated['call_event_type'],
                'start_date' => $validated['start_date']
            ];

        } else if($request->type == "event") {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'type' => 'required|string|in:task,call,meeting,event',
                'call_event_type' => 'nullable|string',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ]);

            $activityData = [
                'title' => $validated['title'],
                'description_agenda_notes' => $validated['description'],
                'type' => $validated['type'],
                'call_event_type' => $validated['call_event_type'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date']
            ];
        }

        // Only add end_date if it's set
        if (isset($validated['end_date'])) {
            $activityData['end_date'] = $validated['end_date'];
        }

        $activity->update($activityData);

        return response()->json([
            'success' => true,
            'message' => 'Activity updated successfully',
            'data' => $activity
        ]);

    } catch (\Exception $e) {
        Log::error('Activity Update Error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Refresh activities.
     */
    public function refresh(Request $request)
    {
        $activities = Activity::where('company_id', session('selected_company_id'))
            ->with(['relatedModel'])
            ->orderBy('start_date', 'desc')
            ->get()
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'title' => $activity->title,
                    'type' => $activity->type,
                    'related_to' => $activity->related_to,
                    'related_to_type' => $activity->related_to_type,
                    'relatedModel' => $activity->relatedModel,
                    'start_date' => $activity->start_date,
                    'all_day' => $activity->all_day,
                    'status' => $activity->status,
                    'priority' => $activity->priority
                ];
            });

        return response()->json([
            'activities' => $activities
        ]);
    }


public function getActivityStatistics()
{
    try {
        $companyId = Session::get('selected_company_id');
        
        if (!$companyId) {
            return response()->json([
                'success' => false,
                'message' => 'Company session not found'
            ], 401);
        }

        // Get all counts in a single query for better performance
        $stats = Activity::where('company_id', $companyId)
            ->whereNull('deleted_at')
            ->selectRaw('
                COUNT(*) as total_activities,
                SUM(CASE WHEN type = "task" THEN 1 ELSE 0 END) as task_count,
                SUM(CASE WHEN type = "call" THEN 1 ELSE 0 END) as call_count,
                SUM(CASE WHEN type = "meeting" THEN 1 ELSE 0 END) as meeting_count,
                SUM(CASE WHEN type = "event" THEN 1 ELSE 0 END) as event_count,
                SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_count
            ')
            ->first();

        return response()->json([
            'success' => true,
            'data' => [
                'total_activities' => $stats->total_activities,
                'by_type' => [
                    'task' => $stats->task_count,
                    'call' => $stats->call_count,
                    'meeting' => $stats->meeting_count,
                    'event' => $stats->event_count
                ],
                'completion_rate' => $stats->total_activities > 0 
                    ? round($stats->completed_count / $stats->total_activities * 100, 2)
                    : 0
            ]
        ]);

    } catch (\Exception $e) {
        Log::error('Activity statistics error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch activity statistics'
        ], 500);
    }
}

/**
 * Display the specified activity.
 */
public function show($id)
{
    try {
        $activity = Activity::where('company_id', Session::get('selected_company_id'))
            ->where('id', $id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $activity
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Activity not found'
        ], 404);
    }
}
}