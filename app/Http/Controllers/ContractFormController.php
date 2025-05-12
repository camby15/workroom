<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contra;
use App\Models\Contract;
use App\Models\ContractSignature;
use App\Models\ContractAttachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;
class ContractFormController extends Controller
{
    //

    private function logAuditTrail($contractId, $message)
    {
        Log::info("Audit Trail - Contract ID: $contractId, Message: $message");
    }


    public function showContractForm()
    {
        return view('external/client-contractForm');
    }


    public function submitContract(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'notes' => 'nullable|string',
            'signature_file' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:10240',
            'auto_renewal' => 'nullable',
        ]);

        $publicPath = null;


        $autoRenewal = $request->has('auto_renewal') ? 1 : 0; // Convert to boolean (1 or 0)

        // Optional debugging to log the value of auto_renewal
        Log::debug('Auto Renewal value: ' . $autoRenewal);

        // Handle file upload (check if file exists first)
        if ($request->hasFile('signature_file')) {
            $file = $request->file('signature_file');
            $destinationPath = public_path('images/signatures');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $filename);

            $publicPath = 'images/signatures/' . $filename;
        }

        try {
            $contract = Contract::create([
                'name' => $request->name,
                'customer_name' => $request->customer_name,
                'email' => $request->email,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'notes' => $request->notes,
                'status' => 'draft',
                'created_by' => null,
                'updated_by' => null,
                'auto_renewal' => $autoRenewal,
            ]);

            ContractSignature::create([
                'contract_id' => $contract->id,
                'signer_name' => $request->customer_name,
                'signer_email' => $request->email,
                'status' => 'pending',
                'created_by' => $request->customer_name,
                'signature_image_path' => $publicPath,
            ]);

            $this->logAuditTrail($contract->id, 'Contract created');

            return response()->json([
                'success' => true,
                'message' => 'Contract created successfully',
                'contract' => $contract
            ]);
        } catch (Exception $e) {
            Log::error('Contract creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create contract',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
