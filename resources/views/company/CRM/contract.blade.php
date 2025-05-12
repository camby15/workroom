@extends('layouts.vertical', ['page_title' => 'CRM Contract'])
@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css', 'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css', 'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css', 'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        /* Floating Label Styles */
        .form-floating {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-floating input.form-control,
        .form-floating select.form-select,
        .form-floating textarea.form-control {
            height: 50px;
            border: 1px solid #2f2f2f;
            border-radius: 10px;
            background-color: transparent;
            font-size: 1rem;
            padding: 1rem 0.75rem;
            transition: all 0.8s;
        }

        .form-floating textarea.form-control {
            min-height: 100px;
            height: auto;
            padding-top: 1.625rem;
        }

        .form-floating label {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            padding: 1rem 0.75rem;
            color: #2f2f2f;
            transition: all 0.8s;
            pointer-events: none;
            z-index: 1;
        }

        .form-floating input.form-control:focus,
        .form-floating input.form-control:not(:placeholder-shown),
        .form-floating select.form-select:focus,
        .form-floating select.form-select:not([value=""]),
        .form-floating textarea.form-control:focus,
        .form-floating textarea.form-control:not(:placeholder-shown) {
            border-color: #033c42;
            box-shadow: none;
        }

        .form-floating input.form-control:focus~label,
        .form-floating input.form-control:not(:placeholder-shown)~label,
        .form-floating select.form-select:focus~label,
        .form-floating select.form-select:not([value=""])~label,
        .form-floating textarea.form-control:focus~label,
        .form-floating textarea.form-control:not(:placeholder-shown)~label {
            height: auto;
            padding: 0 0.5rem;
            transform: translateY(-50%) translateX(0.5rem) scale(0.85);
            color: white;
            border-radius: 5px;
            z-index: 5;
        }

        .form-floating input.form-control:focus~label::before,
        .form-floating input.form-control:not(:placeholder-shown)~label::before,
        .form-floating select.form-select:focus~label::before,
        .form-floating select.form-select:not([value=""])~label::before,
        .form-floating textarea.form-control:focus~label::before,
        .form-floating textarea.form-control:not(:placeholder-shown)~label::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: #033c42;
            border-radius: 5px;
            z-index: -1;
        }

        .form-floating input.form-control:focus::placeholder {
            color: transparent;
        }

        /* Dark mode styles */
        [data-bs-theme="dark"] .form-floating input.form-control,
        [data-bs-theme="dark"] .form-floating select.form-select,
        [data-bs-theme="dark"] .form-floating textarea.form-control {
            border-color: #6c757d;
            color: #e9ecef;
        }

        [data-bs-theme="dark"] .form-floating label {
            color: #adb5bd;
        }

        [data-bs-theme="dark"] .form-floating input.form-control:focus,
        [data-bs-theme="dark"] .form-floating input.form-control:not(:placeholder-shown),
        [data-bs-theme="dark"] .form-floating select.form-select:focus,
        [data-bs-theme="dark"] .form-floating select.form-select:not([value=""]),
        [data-bs-theme="dark"] .form-floating textarea.form-control:focus,
        [data-bs-theme="dark"] .form-floating textarea.form-control:not(:placeholder-shown) {
            border-color: #0dcaf0;
        }

        [data-bs-theme="dark"] .form-floating input.form-control:focus~label::before,
        [data-bs-theme="dark"] .form-floating input.form-control:not(:placeholder-shown)~label::before,
        [data-bs-theme="dark"] .form-floating select.form-select:focus~label::before,
        [data-bs-theme="dark"] .form-floating select.form-select:not([value=""])~label::before,
        [data-bs-theme="dark"] .form-floating textarea.form-control:focus~label::before,
        [data-bs-theme="dark"] .form-floating textarea.form-control:not(:placeholder-shown)~label::before {
            background: #0dcaf0;
        }

        [data-bs-theme="dark"] select.form-select option {
            background-color: #212529;
            color: #e9ecef;
        }

        /* Modal styles */
        .modal-content {
            border-radius: 15px;
            border: none;
        }

        .modal-header {
            border-bottom: 1px solid #dee2e6;
            background-color: #f8f9fa;
            border-radius: 15px 15px 0 0;
        }

        [data-bs-theme="dark"] .modal-header {
            background-color: #343a40;
            border-color: #373b3e;
        }

        .modal-footer {
            border-top: 1px solid #dee2e6;
            border-radius: 0 0 15px 15px;
        }

        [data-bs-theme="dark"] .modal-footer {
            border-color: #373b3e;
        }

        /* Version Control, Document Storage, and Audit Trails styles */
        .audit-trails {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
        }

        [data-bs-theme="dark"] .audit-trails {
            background-color: #212529;
            border-color: #373b3e;
        }

        .audit-trails .timeline {
            position: relative;
            padding-left: 30px;
        }

        .audit-trails .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 2px;
            background-color: #dee2e6;
        }

        [data-bs-theme="dark"] .audit-trails .timeline::before {
            background-color: #495057;
        }

        .audit-trails .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        .audit-trails .timeline-item::before {
            content: '';
            position: absolute;
            left: -34px;
            top: 0;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #0dcaf0;
        }

        .audit-trails .timeline-content {
            padding: 15px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        [data-bs-theme="dark"] .audit-trails .timeline-content {
            background-color: #2c3034;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            /* Center the buttons */
            gap: 10px;
            /* Space between buttons */
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card crm-card">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="header-title mb-0">Contract Management</h4>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContractModal">
                                <i class="fas fa-plus me-1"></i> Add New Contract
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-centered table-hover dt-responsive nowrap w-100" id="contractTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Contract Title</th>
                                        <th>Customer Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($contracts as $contract)
                                        <tr>
                                            <td>{{ ($contracts->currentPage() - 1) * $contracts->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $contract->name }}</td>
                                            <td>{{ $contract->customer_name }}</td>
                                            <td>{{ date('Y-m-d', strtotime($contract->start_date)) }}</td>
                                            <td>{{ date('Y-m-d', strtotime($contract->end_date)) }}</td>
                                            <td><span
                                                    class="badge bg-{{ $contract->status === 'draft' ? 'warning' : 'success' }} justify-center">{{ ucfirst($contract->status) }}</span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">

                                                    <button class="btn btn-sm btn-warning action-btn me-1"
                                                        onclick="editContract({{ $contract->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    @if ($contract->file_path)
                                                        <button class="btn btn-sm btn-success action-btn me-1"
                                                            onclick="downloadContract({{ $contract->id }})">
                                                            <i class="fas fa-download"></i>
                                                        </button>
                                                    @endif
                                                    <button class="btn btn-sm btn-primary action-btn me-1"
                                                        onclick="sendForSignature({{ $contract->id }})"
                                                        data-id="{{ $contract->id }}" data-title="{{ $contract->name }}"
                                                        data-customer-name="{{ $contract->customer_name }}"
                                                        data-customer-email="{{ $contract->email }}">
                                                        <i class="fas fa-signature"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="deleteContract({{ $contract->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No contracts found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div id="paginationLinks" class="d-flex justify-content-center">
                            {{ $contracts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Audit Trails Section in a Card --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Audit Trails</h5>
        </div>
        <div class="card-body">
            <div class="audit-trails">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <select class="form-select" id="modalStatusFilter">
                            <option value="all">All Activities</option>
                            <option value="created">Created</option>
                            <option value="modified">Modified</option>
                            <option value="signed">Signed</option>
                            <option value="deleted">Deleted</option>
                        </select>
                    </div>
                    <div>
                        <input type="text" class="form-control" id="modalSearchInput" placeholder="Search activities...">
                    </div>
                </div>
                <div class="timeline">
                    <!-- Timeline items will be dynamically added here -->
                </div>
            </div>
        </div>
    </div>


    {{-- Audit Trail Modal --}}
    <div class="modal fade" id="auditTrailModal" tabindex="-1" aria-labelledby="auditTrailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="auditTrailModalLabel">Contract Audit Trail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-select" id="modalStatusFilter">
                                    <option value="all">All Activities</option>
                                    <option value="created">Created</option>
                                    <option value="modified">Modified</option>
                                    <option value="signed">Signed</option>
                                    <option value="deleted">Deleted</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="modalSearchInput"
                                    placeholder="Search activities...">
                            </div>
                        </div>
                    </div>
                    <div class="timeline">
                        <!-- Timeline items will be dynamically added here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Contract Modal --}}
    <div class="modal fade" id="editContractModal" tabindex="-1" aria-labelledby="editContractModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editContractModalLabel">Edit Contract</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editContractForm">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="edit_contract_name"
                                        name="contract_name" placeholder=" " required>
                                    <label for="edit_contract_name">Contract Name *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="edit_customer_name"
                                        name="customer_name" placeholder=" " required>
                                    <label for="edit_customer_name">Customer Name *</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="edit_email" name="email"
                                        placeholder=" " required>
                                    <label for="edit_email">Email *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="edit_start_date" name="start_date"
                                        placeholder=" " required>
                                    <label for="edit_start_date">Start Date *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="edit_end_date" name="end_date"
                                        placeholder=" " required>
                                    <label for="edit_end_date">End Date *</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="edit_notes" name="notes" placeholder=" " style="height: 100px"></textarea>
                                    <label for="edit_notes">Notes</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="file" class="form-control" id="edit_contract_file"
                                        name="contract_file" accept=".pdf,.doc,.docx">
                                    <label for="edit_contract_file">Contract File (PDF, DOC, DOCX)</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="updateContract()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Send for Signature Modal -->
    <div class="modal fade" id="sendForSignatureModal" tabindex="-1" aria-labelledby="sendForSignatureModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendForSignatureModalLabel">Send Contract for Signature</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="sendForSignatureForm" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="signerEmail" name="signer_email"
                                placeholder="Signer's Email" required>
                            <label for="signerEmail">Customer's Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="signerName" name="signer_name"
                                placeholder="Signer's Name" required>
                            <label for="signerName">Customer's Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="message" name="message" placeholder="Message to Signer" style="height: 100px"></textarea>
                            <label for="message">Message to Customer (Optional)</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="submitSendForSignature()">Send</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Contract Modal --}}
    <div class="modal fade" id="addContractModal" tabindex="-1" aria-labelledby="addContractModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addContractModalLabel">Add New Contract</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addContractForm" onsubmit="addContract(event)" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="name" id="contract_name"
                                        placeholder=" " required>
                                    <label for="contract_name">Contract Name *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="customer_name" id="customer_name"
                                        placeholder=" " required>
                                    <label for="customer_name">Customer Name *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder=" " required>
                                    <label for="email">Email *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="start_date" id="start_date"
                                        placeholder=" " required>
                                    <label for="start_date">Start Date *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="end_date" id="end_date"
                                        placeholder=" " required>
                                    <label for="end_date">End Date *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="file" class="form-control" name="signature_file" accept="image/*"
                                        id="signature_file" placeholder=" " required>
                                    <label for="signature_file">Upload Signature *</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" name="notes" id="notes" placeholder=" " style="height: 100px"></textarea>
                                    <label for="notes">Notes</label>
                                </div>
                            </div>

                            <!-- Auto Renewal Checkbox -->
                            <div class="col-12">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="auto_renewal"
                                        id="auto_renewal">
                                    <label class="form-check-label" for="auto_renewal">
                                        Auto Renewal
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#onlineContract">Online Contract</button>
                        <div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Contract</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- online Contract Modal --}}
    <div class="modal fade" id="onlineContract" tabindex="-1" aria-labelledby="onlineContract" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadContractModalLabel">Online Contract</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="contractForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="contractTitle" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="example@gmail.com"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" class="btn btn-primary">Send Contract</button>
                    </div>
                </form>


                <script>
                    document.getElementById('contractForm').addEventListener('submit', function(event) {
                        event.preventDefault();

                        const form = event.target;
                        const formData = new FormData(form);
                        const jsonData = {};

                        formData.forEach((value, key) => {
                            jsonData[key] = value;
                        });

                        // Disable the button and show loading text
                        const submitButton = form.querySelector('button[type="submit"]');
                        const originalText = submitButton.innerHTML;
                        submitButton.disabled = true;
                        submitButton.innerHTML =
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...';

                        fetch("{{ route('contract.send') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                                },
                                body: JSON.stringify(jsonData),
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Handle success
                                Swal.fire({
                                    icon: data.type || 'success',
                                    title: data.title || 'Success',
                                    text: data.message || 'Contract sent!',
                                    timer: 3000
                                });
                                // Optionally hide modal
                                var modal = bootstrap.Modal.getInstance(document.getElementById('onlineContract'));
                                modal.hide();

                                // Re-enable the button and restore original text
                                submitButton.disabled = false;
                                submitButton.innerHTML = originalText;
                            })
                            .catch(error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Something went wrong.',
                                });
                                console.error(error);

                                // Re-enable the button and restore original text
                                submitButton.disabled = false;
                                submitButton.innerHTML = originalText;
                            });
                    });
                </script>


            </div>
        </div>
    </div>
    {{-- Delete Contract Modal --}}
    <div class="modal fade" id="deleteContractModal" tabindex="-1" aria-labelledby="deleteContractModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteContractModalLabel">Delete Contract</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this contract? This action cannot be undone.</p>
                    <form id="deleteContractForm" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteContract">Delete</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Upload Contract Modal --}}
    <div class="modal fade" id="uploadContractModal" tabindex="-1" aria-labelledby="uploadContractModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadContractModalLabel">Upload Contract</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="uploadContractForm" action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="contractTitle" class="form-label">Contract Title</label>
                            <input type="text" class="form-control" id="contractTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="contractFile" class="form-label">Upload File</label>
                            <input type="file" class="form-control" id="contractFile" name="file" required>
                        </div>
                        <div class="mb-3">
                            <label for="contractNotes" class="form-label">Notes</label>
                            <textarea class="form-control" id="contractNotes" name="notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Upload Contract</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function addContract(event) {
    event.preventDefault(); // Prevent default form submission

    const signatureInput = document.getElementById('signature_file');
    const file = signatureInput.files[0];

    const formData = new FormData();
    formData.append('name', document.getElementById('contract_name').value);
    formData.append('customer_name', document.getElementById('customer_name').value);
    formData.append('email', document.getElementById('email').value);
    formData.append('start_date', document.getElementById('start_date').value);
    formData.append('end_date', document.getElementById('end_date').value);
    formData.append('notes', document.getElementById('notes').value);

    // Only append auto_renewal if checked
    if (document.getElementById('auto_renewal').checked) {
        formData.append('auto_renewal', 1); // send value 1 if checked
    }

    if (file) {
        formData.append('signature_file', file);
    }

    const token = document.querySelector('meta[name="csrf-token"]').content;

    if (!formData.get('name') || !formData.get('customer_name') || !formData.get('email') ||
        !formData.get('start_date') || !formData.get('end_date')) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'Please fill in all required fields'
        });
        return;
    }

    fetch('/company/CRM/contract', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Contract added successfully'
            });
            $('#addContractModal').modal('hide');
            location.reload();
        } else {
            throw new Error(data.message || 'Failed to add contract');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'An error occurred while adding the contract'
        });
    });
}




        // Edit Contract
        function editContract(id) {
            // Show loading state
            Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Get CSRF token
            const token = document.querySelector('meta[name="csrf-token"]').content;

            // Fetch contract details
            fetch(`/company/CRM/contract/${id}/show`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const contract = data.contract;

                        // Format dates for HTML5 date input
                        const formatDate = (dateString) => {
                            const date = new Date(dateString);
                            return date.toISOString().split('T')[0];
                        };

                        // Populate form fields
                        document.getElementById('edit_contract_name').value = contract.name;
                        document.getElementById('edit_customer_name').value = contract.customer_name;
                        document.getElementById('edit_email').value = contract.email;
                        document.getElementById('edit_start_date').value = formatDate(contract.start_date);
                        document.getElementById('edit_end_date').value = formatDate(contract.end_date);
                        document.getElementById('edit_notes').value = contract.notes || '';

                        // Store contract ID for update
                        document.getElementById('editContractForm').dataset.contractId = contract.id;

                        // Show modal
                        Swal.close();
                        $('#editContractModal').modal('show');
                    } else {
                        throw new Error(data.message || 'Failed to fetch contract details');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Failed to fetch contract details'
                    });
                });
        }

        // Update Contract
        function updateContract() {
            const form = document.getElementById('editContractForm');
            const contractId = form.dataset.contractId;
            const formData = new FormData(form);

            // Show loading state
            Swal.fire({
                title: 'Saving...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Get CSRF token
            const token = document.querySelector('meta[name="csrf-token"]').content;

            // Send update request
            fetch(`/company/CRM/contract/edit/${contractId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Contract updated successfully'
                        }).then(() => {
                            // Close modal and refresh page
                            $('#editContractModal').modal('hide');
                            window.location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Failed to update contract');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Failed to update contract'
                    });
                });
        }

        function deleteContract(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteContractForm');
                    form.action = `/company/CRM/contract/delete/${id}`;

                    // Submit form with AJAX
                    fetch(form.action, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: data.message || 'Contract has been deleted.',
                                    icon: 'success'
                                }).then(() => {
                                    // Always refresh the page
                                    window.location.reload();
                                });
                            } else {
                                throw new Error(data.message || 'Delete failed');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                error.message || 'There was an error deleting the contract.',
                                'error'
                            );
                        });
                }
            });
        }

        // Initialize send for signature modal
        function sendForSignature(id) {
            const button = document.querySelector(`button[data-id="${id}"]`);
            const customerName = button.getAttribute('data-customer-name');
            const customerEmail = button.getAttribute('data-customer-email');

            // Pre-populate the form fields
            document.getElementById('signerEmail').value = customerEmail;
            document.getElementById('signerName').value = customerName;

            // Set the form action
            const form = document.getElementById('sendForSignatureForm');
            form.action = `/company/CRM/contract/${id}/send-for-signature`;

            $('#sendForSignatureModal').modal('show');
        }

        // Submit signature request
        function submitSendForSignature() {
            const form = document.getElementById('sendForSignatureForm');
            const formData = new FormData(form);

            $.ajax({
                url: form.action,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Contract has been sent for signature.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#sendForSignatureModal').modal('hide');
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message || 'Failed to send contract for signature.'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to send contract for signature.'
                    });
                }
            });
        }

        // Download Contact 
        function downloadContract(id) {
            window.location.href = `/company/CRM/contract/${id}/download`;
        }

        // Event listener for delete button
        $(document).on('click', '.deleteContractBtn', function() {
            const id = $(this).data('id');
            deleteContract(id);
        });


        document.addEventListener('DOMContentLoaded', function() {
            const filterSelect = document.getElementById('modalStatusFilter');
            filterSelect.addEventListener('change', function() {
                const selectedValue = this.value;
                // Add filter logic here
            });

            const searchInput = document.getElementById('modalSearchInput');
            searchInput.addEventListener('input', function() {
                const searchValue = this.value;
                // Add search logic here
            });
        });
    </script>
@endsection
