@extends('layouts.vertical', ['page_title' => 'Requisition Management'])

@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css'])
    <style>
        /* Form control styling */
        .form-control::placeholder,
        .form-select::placeholder {
            color: var(--#{$prefix}gray-500);
            opacity: 0.7;
        }

        [data-bs-theme="dark"] .form-control::placeholder,
        [data-bs-theme="dark"] .form-select::placeholder {
            color: var(--#{$prefix}gray-400);
            opacity: 0.8;
        }

        /* Requisition card styling */
        .requisition-card {
            background: var(--#{$prefix}card-bg);
            border: 1px solid var(--#{$prefix}border-color);
            border-radius: 0.5rem;
            padding: 1.25rem;
            transition: all 0.3s ease;
        }

        [data-bs-theme="dark"] .requisition-card {
            background: var(--#{$prefix}dark);
            border-color: var(--#{$prefix}gray-700);
        }

        .requisition-card:hover {
            transform: translateY(-2px);
            border-color: var(--#{$prefix}primary);
            box-shadow: 0 3px 10px rgba(var(--#{$prefix}dark-rgb), 0.1);
        }

        /* Loading animation */
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .loading-pulse {
            animation: pulse 1.5s ease-in-out infinite;
            background: var(--#{$prefix}gray-200);
        }

        [data-bs-theme="dark"] .loading-pulse {
            background: var(--#{$prefix}gray-700);
        }

        /* Status tags */
        .status-tag {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-tag::before {
            content: '';
            display: inline-block;
            width: 0.5rem;
            height: 0.5rem;
            margin-right: 0.5rem;
            border-radius: 50%;
        }

        .status-tag.draft {
            background: rgba(var(--#{$prefix}info-rgb), 0.1);
            color: var(--#{$prefix}info);
        }

        .status-tag.draft::before {
            background-color: var(--#{$prefix}info);
        }

        .status-tag.submitted {
            background: rgba(var(--#{$prefix}warning-rgb), 0.1);
            color: var(--#{$prefix}warning);
        }

        .status-tag.submitted::before {
            background-color: var(--#{$prefix}warning);
        }

        .status-tag.approved {
            background: rgba(var(--#{$prefix}success-rgb), 0.1);
            color: var(--#{$prefix}success);
        }

        .status-tag.approved::before {
            background-color: var(--#{$prefix}success);
        }

        .status-tag.rejected {
            background: rgba(var(--#{$prefix}danger-rgb), 0.1);
            color: var(--#{$prefix}danger);
        }

        .status-tag.rejected::before {
            background-color: var(--#{$prefix}danger);
        }

        [data-bs-theme="dark"] .status-tag {
            filter: brightness(1.2);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 2.5rem;
            border: 2px dashed var(--#{$prefix}border-color);
            border-radius: 0.5rem;
            margin: 1.5rem 0;
        }

        [data-bs-theme="dark"] .empty-state {
            border-color: var(--#{$prefix}gray-700);
        }

        /* Form improvements */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: var(--#{$prefix}gray-700);
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        [data-bs-theme="dark"] .form-label {
            color: var(--#{$prefix}gray-300);
        }

        /* Input focus states */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--#{$prefix}primary);
            box-shadow: 0 0 0 0.15rem rgba(var(--#{$prefix}primary-rgb), 0.25);
        }

        [data-bs-theme="dark"] .form-control:focus,
        [data-bs-theme="dark"] .form-select:focus {
            background-color: var(--#{$prefix}dark);
        }

        /* Steps indicator */
        .step-indicator {
            display: flex;
            align-items: center;
            margin: 2rem 0;
        }

        .step {
            flex: 1;
            text-align: center;
            position: relative;
        }

        .step::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            background: var(--#{$prefix}border-color);
            top: 1rem;
            left: 50%;
            z-index: 1;
        }

        .step:last-child::after {
            display: none;
        }

        .step-number {
            width: 2rem;
            height: 2rem;
            background: var(--#{$prefix}body-bg);
            border: 2px solid var(--#{$prefix}border-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .step.active .step-number {
            background: var(--#{$prefix}primary);
            border-color: var(--#{$prefix}primary);
            color: #fff;
        }

        [data-bs-theme="dark"] .step-number {
            background: var(--#{$prefix}dark);
            border-color: var(--#{$prefix}gray-700);
        }

        .form-floating {
            position: relative;
            margin-bottom: 1rem;
        }
        .form-floating input.form-control,
        .form-floating select.form-select,
        .form-floating textarea.form-control {
            height: 50px;
            border: 1px solid var(--#{$prefix}border-color);
            border-radius: 10px;
            background-color: var(--#{$prefix}input-bg);
            color: var(--#{$prefix}body-color);
            font-size: 1rem;
            padding: 1rem 0.75rem;
            transition: all 0.8s;
        }
        .form-floating textarea.form-control {
            height: auto;
            min-height: 100px;
        }
        .form-floating label {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            padding: 1rem 0.75rem;
            color: var(--#{$prefix}body-color);
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
            border-color: var(--#{$prefix}primary);
            box-shadow: 0 0 0 0.15rem rgba(var(--#{$prefix}primary-rgb), 0.25);
        }
        .form-floating input.form-control:focus ~ label,
        .form-floating input.form-control:not(:placeholder-shown) ~ label,
        .form-floating select.form-select:focus ~ label,
        .form-floating select.form-select:not([value=""]) ~ label,
        .form-floating textarea.form-control:focus ~ label,
        .form-floating textarea.form-control:not(:placeholder-shown) ~ label {
            height: auto;
            padding: 0 0.5rem;
            transform: translateY(-50%) translateX(0.5rem) scale(0.85);
            color: var(--#{$prefix}primary);
            background-color: var(--#{$prefix}body-bg);
            border-radius: 5px;
            z-index: 5;
        }
        .badge-active { background-color: var(--#{$prefix}success); color: #fff; }
        .badge-inactive { background-color: var(--#{$prefix}danger); color: #fff; }
        .badge-pending { background-color: var(--#{$prefix}warning); color: #fff; }
        .requisition-card {
            border-radius: 10px;
            transition: all 0.3s;
            background-color: var(--#{$prefix}card-bg);
            border: 1px solid var(--#{$prefix}border-color);
            padding: 1.25rem;
        }
        .requisition-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(var(--#{$prefix}dark-rgb), 0.1);
        }
        .requisition-item {
            padding: 1rem;
            margin-bottom: 0.5rem;
            border: 1px solid var(--#{$prefix}border-color);
            border-radius: 0.5rem;
            background: var(--#{$prefix}card-bg);
        }
        .requisition-item.priority-high {
            border-left: 4px solid var(--#{$prefix}danger);
        }
        .requisition-item.priority-normal {
            border-left: 4px solid var(--#{$prefix}success);
        }
        .placeholder-item {
            border: 2px dashed var(--#{$prefix}primary);
            border-radius: 0.5rem;
            margin: 0.5rem 0;
            padding: 1rem;
            background: var(--#{$prefix}tertiary-bg);
        }
        .requisition-timeline {
            position: relative;
            padding-left: 30px;
        }
        .requisition-timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--#{$prefix}border-color);
        }
        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -21px;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--#{$prefix}primary);
            border: 2px solid var(--#{$prefix}body-bg);
        }
        .form-switch .form-check-input {
            width: 2.5em;
            margin-left: -2.9em;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%280, 0, 0, 0.25%29'/%3e%3c/svg%3e");
            background-position: left center;
            border-radius: 2em;
            transition: background-position .15s ease-in-out;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item">Operations</li>
                            <li class="breadcrumb-item active">Requisition</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Requisition Management</h4>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Total Requisitions</h5>
                        <h3>156</h3>
                        <p class="mb-0 text-muted">This month</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Pending Approval</h5>
                        <h3>12</h3>
                        <p class="mb-0 text-warning">Needs review</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Budget Available</h5>
                        <h3>$45,000</h3>
                        <p class="mb-0 text-success">Current period</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Approved</h5>
                        <h3>89</h3>
                        <p class="mb-0 text-info">Last 30 days</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Requisition Form -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Requisition</h4>
                    </div>
                    <div class="card-body">
                        <form id="requisitionForm">
                            <!-- Basic Information -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="title" placeholder=" ">
                                        <label for="title">Requisition Title</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="department">
                                            <option value="">Select Department</option>
                                            <option value="it">IT</option>
                                            <option value="hr">HR</option>
                                            <option value="finance">Finance</option>
                                            <option value="operations">Operations</option>
                                        </select>
                                        <label for="department">Department</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="priority">
                                            <option value="">Select Priority</option>
                                            <option value="low">Low</option>
                                            <option value="medium">Medium</option>
                                            <option value="high">High</option>
                                        </select>
                                        <label for="priority">Priority Level</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Items Section -->
                            <div class="mt-4">
                                <h5>Items</h5>
                                <div id="itemsContainer">
                                    <div class="row g-3 mb-3 item-row">
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input type="text" class="form-control item-name" placeholder=" ">
                                                <label>Item Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-floating">
                                                <input type="number" class="form-control item-quantity" placeholder=" ">
                                                <label>Quantity</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-floating">
                                                <input type="number" class="form-control item-price" placeholder=" ">
                                                <label>Unit Price</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control item-total" readonly placeholder=" ">
                                                <label>Total Cost</label>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger remove-item">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary" id="addItem">
                                    <i class="ri-add-line"></i> Add Item
                                </button>
                            </div>

                            <!-- Budget Section -->
                            <div class="row g-3 mt-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="budgetCode" placeholder=" ">
                                        <label for="budgetCode">Budget Code/Cost Center</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="totalBudget" readonly placeholder=" ">
                                        <label for="totalBudget">Total Estimated Cost</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Justification and Attachments -->
                            <div class="row g-3 mt-4">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="justification" placeholder=" "></textarea>
                                        <label for="justification">Purpose/Justification</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Attachments</label>
                                        <input type="file" class="form-control" id="attachments" multiple>
                                        <small class="text-muted">Upload specifications, quotes, or other supporting documents</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-light me-2">Save as Draft</button>
                                    <button type="submit" class="btn btn-primary">Submit Request</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Requisition List -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Requisition List</h4>
                <div class="d-flex gap-2">
                    <button class="btn btn-light" type="button" data-bs-toggle="collapse" data-bs-target="#filterSection">
                        <i class="ri-filter-3-line"></i> Filters
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Export
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">PDF</a></li>
                            <li><a class="dropdown-item" href="#">Excel</a></li>
                            <li><a class="dropdown-item" href="#">CSV</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="collapse" id="filterSection">
                <div class="card-body border-bottom">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="searchQuery" placeholder=" ">
                                <label for="searchQuery">Search</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <select class="form-select" id="filterStatus">
                                    <option value="">All Status</option>
                                    <option value="draft">Draft</option>
                                    <option value="submitted">Submitted</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                                <label for="filterStatus">Status</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="startDate" placeholder=" ">
                                <label for="startDate">Start Date</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="endDate" placeholder=" ">
                                <label for="endDate">End Date</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-centered table-striped dt-responsive nowrap w-100" id="requisition-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Department</th>
                                <th>Requestor</th>
                                <th>Date</th>
                                <th>Total Cost</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Requisition Details Modal -->
    <div class="modal fade" id="requisitionDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Requisition Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Request Information</h6>
                            <p><strong>Title:</strong> <span id="modal-title"></span></p>
                            <p><strong>Department:</strong> <span id="modal-department"></span></p>
                            <p><strong>Requestor:</strong> <span id="modal-requestor"></span></p>
                            <p><strong>Date:</strong> <span id="modal-date"></span></p>
                            <p><strong>Priority:</strong> <span id="modal-priority"></span></p>
                        </div>
                        <div class="col-md-6">
                            <h6>Budget Information</h6>
                            <p><strong>Budget Code:</strong> <span id="modal-budget-code"></span></p>
                            <p><strong>Total Cost:</strong> <span id="modal-total-cost"></span></p>
                            <p><strong>Status:</strong> <span id="modal-status"></span></p>
                        </div>

                        <!-- Items Table -->
                        <div class="col-12 mt-4">
                            <h6>Requested Items</h6>
                            <div class="table-responsive">
                                <table class="table table-sm" id="modal-items">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Items will be populated dynamically -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Approval Timeline -->
                        <div class="col-12 mt-4">
                            <h6>Approval Timeline</h6>
                            <div class="approval-timeline" id="approval-timeline">
                                <!-- Timeline items will be populated dynamically -->
                            </div>
                        </div>

                        <!-- Justification -->
                        <div class="col-12 mt-4">
                            <h6>Justification</h6>
                            <p id="modal-justification"></p>
                        </div>

                        <!-- Attachments -->
                        <div class="col-12 mt-4">
                            <h6>Attachments</h6>
                            <ul class="list-unstyled" id="modal-attachments">
                                <!-- Attachments will be listed here -->
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Approve</button>
                    <button type="button" class="btn btn-danger">Reject</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @vite(['node_modules/datatables.net/js/jquery.dataTables.min.js', 'node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js'])

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#requisition-table').DataTable({
                pageLength: 10,
                order: [[4, 'desc']],
                columns: [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    { orderable: false }
                ]
            });

            // Handle add item button
            $('#addItem').click(function() {
                const newItem = $('.item-row').first().clone();
                newItem.find('input').val('');
                $('#itemsContainer').append(newItem);
            });

            // Handle remove item button
            $(document).on('click', '.remove-item', function() {
                if ($('.item-row').length > 1) {
                    $(this).closest('.item-row').remove();
                }
            });

            // Calculate total cost
            $(document).on('input', '.item-quantity, .item-price', function() {
                const row = $(this).closest('.item-row');
                const quantity = parseFloat(row.find('.item-quantity').val()) || 0;
                const price = parseFloat(row.find('.item-price').val()) || 0;
                row.find('.item-total').val((quantity * price).toFixed(2));
                
                // Update total budget
                let total = 0;
                $('.item-total').each(function() {
                    total += parseFloat($(this).val()) || 0;
                });
                $('#totalBudget').val(total.toFixed(2));
            });

            // Handle requisition form submission
            $('#requisitionForm').on('submit', function(e) {
                e.preventDefault();
                // Add your form submission logic here
            });

            // Handle requisition details modal
            $('.view-requisition').on('click', function() {
                // Add your modal population logic here
                $('#requisitionDetailsModal').modal('show');
            });
        });
    </script>
@endsection
