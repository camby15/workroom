<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class CustomersImport
{
    private $companyId;
    private $userId;
    private $rowCount = 0;
    private $successCount = 0;
    private $failedCount = 0;
    private $failures = [];

    public function __construct($companyId, $userId)
    {
        $this->companyId = $companyId;
        $this->userId = $userId;
    }

    public function import($file)
    {
        $handle = fopen($file->getPathname(), 'r');
        
        // Read the header row
        $headers = fgetcsv($handle);
        
        // Validate headers
        $requiredHeaders = [
            'Name', 'Company', 'Email', 'Phone', 'Address', 
            'Sector', 'Category', 'Status', 'Value'
        ];
        foreach ($requiredHeaders as $requiredHeader) {
            if (!in_array($requiredHeader, $headers)) {
                throw new \Exception("Missing required column: $requiredHeader");
            }
        }

        // Process each row
        while (($row = fgetcsv($handle)) !== false) {
            $this->rowCount++;

            // Create an associative array from the row
            $customerData = array_combine($headers, $row);

            // Validate customer data
            $validator = Validator::make($customerData, [
                'Name' => 'required|string|max:255',
                'Company' => 'required|string|max:255',
                'Email' => 'required|email|unique:customers,email,NULL,id,company_id,' . $this->companyId,
                'Phone' => 'required|string|max:20',
                'Address' => 'required|string|max:500',
                'Sector' => 'nullable|string|max:100',
                'Category' => 'nullable|in:Standard,VIP,HVC',
                'Status' => 'nullable|in:Active,Inactive,Pending,VIP,Blacklisted,On Hold,Suspended,Regular,New',
                'Value' => 'nullable|numeric|min:0'
            ]);

            // If validation fails, log the error and continue
            if ($validator->fails()) {
                $this->failedCount++;
                $this->failures[] = [
                    'row' => $this->rowCount,
                    'data' => $customerData,
                    'errors' => $validator->errors()->all()
                ];
                continue;
            }

            try {
                // Create the customer
                $customer = new Customer();
                $customer->company_id = $this->companyId;
                $customer->name = $customerData['Name'];
                $customer->company = $customerData['Company'];
                $customer->email = $customerData['Email'];
                $customer->phone = $customerData['Phone'];
                $customer->address = $customerData['Address'];
                $customer->sector = $customerData['Sector'] ?? null;
                $customer->category = $customerData['Category'] ?? 'Standard';
                $customer->status = $customerData['Status'] ?? 'Active';
                $customer->value = $customerData['Value'] ?? 0;
                $customer->created_by = $this->userId;
                $customer->save();

                $this->successCount++;

            } catch (\Exception $e) {
                Log::error('Customer import row failed', [
                    'row' => $customerData,
                    'error' => $e->getMessage()
                ]);
                $this->failedCount++;
                $this->failures[] = [
                    'row' => $this->rowCount,
                    'data' => $customerData,
                    'errors' => [$e->getMessage()]
                ];
            }
        }

        // Close the file
        fclose($handle);

        return $this;
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getFailedCount()
    {
        return $this->failedCount;
    }

    public function getFailures()
    {
        return $this->failures;
    }
}
