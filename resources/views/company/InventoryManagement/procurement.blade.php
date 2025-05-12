@extends('layouts.vertical', ['page_title' => 'Procurement Management'])

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

        /* Procurement card styling */
        .procurement-card {
            background: var(--#{$prefix}card-bg);
            border: 1px solid var(--#{$prefix}border-color);
            border-radius: 0.5rem;
            padding: 1.25rem;
            transition: all 0.3s ease;
        }

        [data-bs-theme="dark"] .procurement-card {
            background: var(--#{$prefix}dark);
            border-color: var(--#{$prefix}gray-700);
        }

        .procurement-card:hover {
            transform: translateY(-2px);
            border-color: var(--#{$prefix}primary);
            box-shadow: 0 3px 10px rgba(var(--#{$prefix}dark-rgb), 0.1);
        }

        /* Loading states */
        .loading-placeholder {
            background: linear-gradient(
                90deg,
                var(--#{$prefix}gray-200) 25%,
                var(--#{$prefix}gray-300) 37%,
                var(--#{$prefix}gray-200) 63%
            );
            background-size: 400% 100%;
            animation: loading 1.4s ease infinite;
        }

        [data-bs-theme="dark"] .loading-placeholder {
            background: linear-gradient(
                90deg,
                var(--#{$prefix}gray-700) 25%,
                var(--#{$prefix}gray-600) 37%,
                var(--#{$prefix}gray-700) 63%
            );
        }

        @keyframes loading {
            0% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0 50%;
            }
        }

        /* Status indicators */
        .status-indicator {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-indicator::before {
            content: '';
            display: inline-block;
            width: 0.5rem;
            height: 0.5rem;
            margin-right: 0.5rem;
            border-radius: 50%;
        }

        .status-indicator.pending {
            background: rgba(var(--#{$prefix}warning-rgb), 0.1);
            color: var(--#{$prefix}warning);
        }

        .status-indicator.pending::before {
            background-color: var(--#{$prefix}warning);
        }

        .status-indicator.approved {
            background: rgba(var(--#{$prefix}success-rgb), 0.1);
            color: var(--#{$prefix}success);
        }

        .status-indicator.approved::before {
            background-color: var(--#{$prefix}success);
        }

        .status-indicator.rejected {
            background: rgba(var(--#{$prefix}danger-rgb), 0.1);
            color: var(--#{$prefix}danger);
        }

        .status-indicator.rejected::before {
            background-color: var(--#{$prefix}danger);
        }

        [data-bs-theme="dark"] .status-indicator {
            filter: brightness(1.2);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 2rem;
            border: 2px dashed var(--#{$prefix}border-color);
            border-radius: 0.5rem;
            margin: 1rem 0;
            color: var(--#{$prefix}gray-600);
        }

        [data-bs-theme="dark"] .empty-state {
            border-color: var(--#{$prefix}gray-700);
            color: var(--#{$prefix}gray-400);
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

        /* Timeline styling */
        .timeline-item {
            padding-left: 2rem;
            position: relative;
            border-left: 2px solid var(--#{$prefix}border-color);
            margin-bottom: 1.5rem;
        }

        [data-bs-theme="dark"] .timeline-item {
            border-left-color: var(--#{$prefix}gray-700);
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -0.5rem;
            top: 0;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            background: var(--#{$prefix}primary);
            border: 2px solid var(--#{$prefix}body-bg);
        }

        [data-bs-theme="dark"] .timeline-item::before {
            border-color: var(--#{$prefix}dark);
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
        .procurement-card {
            border-radius: 10px;
            transition: all 0.3s;
            background-color: var(--#{$prefix}card-bg);
            border: 1px solid var(--#{$prefix}border-color);
            padding: 1.25rem;
        }
        .procurement-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(var(--#{$prefix}dark-rgb), 0.1);
        }
        .procurement-item {
            padding: 1rem;
            margin-bottom: 0.5rem;
            border: 1px solid var(--#{$prefix}border-color);
            border-radius: 0.5rem;
            background: var(--#{$prefix}card-bg);
        }
        .procurement-item.urgent {
            border-left: 4px solid var(--#{$prefix}danger);
        }
        .procurement-item.normal {
            border-left: 4px solid var(--#{$prefix}success);
        }
        .placeholder-item {
            border: 2px dashed var(--#{$prefix}primary);
            border-radius: 0.5rem;
            margin: 0.5rem 0;
            padding: 1rem;
            background: var(--#{$prefix}tertiary-bg);
        }
        .procurement-timeline {
            position: relative;
            padding-left: 30px;
        }
        .procurement-timeline::before {
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
                            <li class="breadcrumb-item active">Procurement</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Procurement Management</h4>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Total Requests</h5>
                        <h3>245</h3>
                        <p class="mb-0 text-muted">Last 30 days</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Pending Approval</h5>
                        <h3>18</h3>
                        <p class="mb-0 text-warning">Requires attention</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Budget Utilized</h5>
                        <h3>75%</h3>
                        <p class="mb-0 text-success">Within limits</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Completed</h5>
                        <h3>189</h3>
                        <p class="mb-0 text-info">This month</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Procurement Request Form -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Procurement Request</h4>
                    </div>
                    <div class="card-body">
                        <form id="procurementForm">
                            <!-- Basic Information -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="title" placeholder=" ">
                                        <label for="title">Procurement Title</label>
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
                                                <input type="text" class="form-control" placeholder=" ">
                                                <label>Item Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" placeholder=" ">
                                                <label>Quantity</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" placeholder=" ">
                                                <label>Unit Price</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <select class="form-select">
                                                    <option value="">Select Category</option>
                                                    <option value="office">Office Supplies</option>
                                                    <option value="it">IT Equipment</option>
                                                    <option value="services">Services</option>
                                                </select>
                                                <label>Category</label>
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

                            <!-- Vendor Section -->
                            <div class="row g-3 mt-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="vendor">
                                            <option value="">Select Vendor</option>
                                            <!-- Vendors will be populated dynamically -->
                                        </select>
                                        <label for="vendor">Vendor</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="vendorContact" placeholder=" ">
                                        <label for="vendorContact">Vendor Contact</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes and Attachments -->
                            <div class="row g-3 mt-4">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="notes" placeholder=" "></textarea>
                                        <label for="notes">Notes/Requirements</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Attachments</label>
                                        <input type="file" class="form-control" id="attachments" multiple>
                                        <small class="text-muted">Upload specifications, quotes, or other relevant documents</small>
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

        <!-- Procurement List -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Procurement Requests</h4>
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
                                    <option value="completed">Completed</option>
                                </select>
                                <label for="filterStatus">Status</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <select class="form-select" id="filterDepartment">
                                    <option value="">All Departments</option>
                                    <option value="it">IT</option>
                                    <option value="hr">HR</option>
                                    <option value="finance">Finance</option>
                                    <option value="operations">Operations</option>
                                </select>
                                <label for="filterDepartment">Department</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <select class="form-select" id="filterPriority">
                                    <option value="">All Priorities</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                                <label for="filterPriority">Priority</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-centered table-striped dt-responsive nowrap w-100" id="procurement-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Department</th>
                                <th>Requestor</th>
                                <th>Date</th>
                                <th>Priority</th>
                                <th>Total Amount</th>
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

    <!-- Procurement Details Modal -->
    <div class="modal fade" id="procurementDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Procurement Details</h5>
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
                            <h6>Vendor Information</h6>
                            <p><strong>Vendor:</strong> <span id="modal-vendor"></span></p>
                            <p><strong>Contact:</strong> <span id="modal-contact"></span></p>
                            <p><strong>Total Amount:</strong> <span id="modal-amount"></span></p>
                        </div>

                        <!-- Items Table -->
                        <div class="col-12 mt-4">
                            <h6>Items</h6>
                            <div class="table-responsive">
                                <table class="table table-sm" id="modal-items">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Category</th>
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

                        <!-- Approval Workflow -->
                        <div class="col-12 mt-4">
                            <h6>Approval Workflow</h6>
                            <div id="approval-steps">
                                <!-- Approval steps will be populated dynamically -->
                            </div>
                        </div>

                        <!-- Attachments -->
                        <div class="col-12 mt-4">
                            <h6>Attachments</h6>
                            <ul class="list-unstyled" id="modal-attachments">
                                <!-- Attachments will be listed here -->
                            </ul>
                        </div>

                        <!-- Notes -->
                        <div class="col-12 mt-4">
                            <h6>Notes</h6>
                            <p id="modal-notes"></p>
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
            $('#procurement-table').DataTable({
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
                newItem.find('select').prop('selectedIndex', 0);
                $('#itemsContainer').append(newItem);
            });

            // Handle remove item button
            $(document).on('click', '.remove-item', function() {
                if ($('.item-row').length > 1) {
                    $(this).closest('.item-row').remove();
                }
            });

            // Handle procurement form submission
            $('#procurementForm').on('submit', function(e) {
                e.preventDefault();
                // Add your form submission logic here
            });

            // Handle procurement details modal
            $('.view-procurement').on('click', function() {
                // Add your modal population logic here
                $('#procurementDetailsModal').modal('show');
            });
        });
    </script>
@endsection
