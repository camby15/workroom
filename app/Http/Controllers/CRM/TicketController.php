<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class TicketController extends Controller
{
    // Middleware to ensure user is authenticated
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $companyId = $this->getCompanyId();
            $userId = Auth::id();
            
            $perPage = $request->input('per_page', 5); 
        
            $tickets = Ticket::with(['agent', 'attachments'])
                ->where('company_id', $companyId)
                ->orderBy('created_at', 'DESC')
                ->paginate($perPage);
                
            return response()->json([
                'success' => true,
                'tickets' => $tickets->items(),
                'pagination' => [
                    'total' => $tickets->total(),
                    'per_page' => $tickets->perPage(),
                    'current_page' => $tickets->currentPage(),
                    'last_page' => $tickets->lastPage(),
                    'from' => $tickets->firstItem(),
                    'to' => $tickets->lastItem()
                ],
                'meta' => [
                    'company_id' => $companyId,
                    'user_id' => Auth::id()
                ]
              ]);

        } catch (\Exception $e) {
            return $this->handleError('Failed to retrieve tickets', $e);
        }
    }

    public function show(Request $request)
    {
        try {
            
            return response()->json(Ticket::findOrFail($request->id));
            
        } catch (\Exception $e) {
            return $this->handleError('Failed to retrieve ticket', $e, 404);
        }

    }
    


    public function store(Request $request)
    {
        try {
            $companyId = $this->getCompanyId();
            $userId = Auth::id();
            
            $validated = $request->validate([
                'customer' => 'required|string|max:255',
                'priority' => 'required|in:high,medium,low',
                'subject' => 'required|string|max:255',
                'category' => 'required|in:technical,billing,feature,general',
                'agent_id' => 'required|exists:users,id',
                'description' => 'nullable|string',
                'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
            ]);
            
            $ticket = Ticket::create(array_merge($validated, [
                'company_id' => $companyId,
                'user_id' => $userId,
                'status' => 'open' // Default status
            ]));

            $this->handleAttachments($request, $ticket);

            return response()->json([
                'success' => true,
                'message' => 'Ticket created successfully!',
                'ticket' => $ticket->load('agent', 'attachments'),
                'ticket_id' => $ticket->ticket_id,
                'meta' => [
                    'company_id' => $companyId,
                    'user_id' => $userId
                ]
            ], 201);

        } catch (\Exception $e) {
            return $this->handleError('Failed to create ticket', $e);
        }
    }

   

   public function destroy(Ticket $ticket)
   {
       try {
           $this->verifyCompanyOwnership($ticket);
           
           // Update the ticket status to 'closed' instead of deleting it
           $ticket->update(['status' => 'closed']);
   
           return response()->json([
               'success' => true,
               'message' => "Ticket status set to closed successfully.",
               'meta' => [
                   'company_id' => $ticket->company_id,
                   'user_id' => Auth::id()
               ]
           ]);
       } catch (\Exception $e) {
           return $this->handleError('Failed to close ticket', $e);
       }
   }
   

  

    // Helper Methods
    
    protected function getCompanyId()
    {
        $companyId = Session::get('selected_company_id');
        if (!$companyId) {
            throw new \Exception('Company session expired');
        }
        return $companyId;
    }

    protected function verifyCompanyOwnership(Ticket $ticket)
    {
        $companyId = $this->getCompanyId();
        if ($ticket->company_id != $companyId) {
            throw new \Exception('Unauthorized access to ticket');
        }
    }

    protected function handleAttachments(Request $request, Ticket $ticket)
    {
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('ticket-attachments', 'public');
                
                TicketAttachment::create([
                    'ticket_id' => $ticket->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                    'company_id' => $ticket->company_id,
                    'user_id' => Auth::id()
                ]);
            }
        }
    }

    protected function handleError($message, \Exception $e, $status = 500)
    {
        Log::error($message . ': ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $e->getMessage(),
            'meta' => [
                'company_id' => Session::get('selected_company_id'),
                'user_id' => Auth::id()
            ]
        ], $status);
    }
}