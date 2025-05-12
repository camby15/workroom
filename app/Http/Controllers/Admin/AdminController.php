<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\AddAgentRequest;
use App\Models\Supportagent;
use App\Models\Ticket;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    /**
     * list of all agents
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function agents()
    {

        $agents = Supportagent::all();

        if ($agents->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No agents found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'agents' => $agents
        ]);

    }

    /**
     * list of all tickets
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function ticket(Request $request)
    {
        $ticket = Ticket::all();


        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'ticket' => $ticket
        ]);
    }

    /**
     * Summary of addAgent
     * @param \App\Http\Requests\Agent\AddAgentRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function addAgent(AddAgentRequest $request)
    {
        $data = $request->validated();
        $data['ticket_count'] = 0;

        $agent = Supportagent::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Agent added successfully',
            'agent' => $agent
        ]);
    }
}
