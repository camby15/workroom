@extends('layouts.vertical', ['page_title' => 'Inventory Reports'])

@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css'])
    <style>
        /* Form control base styling */
        .form-floating {
            position: relative;
            margin-bottom: 1rem;
        }

        /* Input and Select styling */
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
            transition: all 0.3s ease;
        }

        /* Dark mode specific input styling */
        [data-bs-theme="dark"] .form-floating input.form-control,
        [data-bs-theme="dark"] .form-floating select.form-select,
        [data-bs-theme="dark"] .form-floating textarea.form-control {
            background-color: var(--#{$prefix}dark);
            border-color: var(--#{$prefix}gray-700);
            color: var(--#{$prefix}gray-200);
        }

        /* Placeholder styling */
        .form-control::placeholder,
        .form-select::placeholder {
            color: var(--#{$prefix}gray-500);
            opacity: 0.7;
        }

        /* Dark mode placeholder styling */
        [data-bs-theme="dark"] .form-control::placeholder,
        [data-bs-theme="dark"] .form-select::placeholder {
            color: var(--#{$prefix}gray-400);
            opacity: 0.8;
        }

        /* Label styling */
        .form-floating label {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            padding: 1rem 0.75rem;
            color: var(--#{$prefix}gray-600);
            transition: all 0.3s ease;
            pointer-events: none;
            z-index: 1;
        }

        /* Dark mode label styling */
        [data-bs-theme="dark"] .form-floating label {
            color: var(--#{$prefix}gray-400);
        }

        /* Focus and filled states */
        .form-floating input.form-control:focus,
        .form-floating input.form-control:not(:placeholder-shown),
        .form-floating select.form-select:focus,
        .form-floating select.form-select:not([value=""]),
        .form-floating textarea.form-control:focus,
        .form-floating textarea.form-control:not(:placeholder-shown) {
            border-color: var(--#{$prefix}primary);
            box-shadow: 0 0 0 0.15rem rgba(var(--#{$prefix}primary-rgb), 0.25);
        }

        /* Dark mode focus states */
        [data-bs-theme="dark"] .form-floating input.form-control:focus,
        [data-bs-theme="dark"] .form-floating select.form-select:focus,
        [data-bs-theme="dark"] .form-floating textarea.form-control:focus {
            background-color: var(--#{$prefix}dark);
            border-color: var(--#{$prefix}primary);
        }

        /* Label animation for focus and filled states */
        .form-floating input.form-control:focus ~ label,
        .form-floating input.form-control:not(:placeholder-shown) ~ label,
        .form-floating select.form-select:focus ~ label,
        .form-floating select.form-select:not([value=""]) ~ label,
        .form-floating textarea.form-control:focus ~ label {
            height: auto;
            padding: 0 0.5rem;
            transform: translateY(-50%) translateX(0.5rem) scale(0.85);
            color: var(--#{$prefix}primary);
            background-color: var(--#{$prefix}body-bg);
            border-radius: 5px;
            z-index: 5;
        }

        /* Dark mode label animation */
        [data-bs-theme="dark"] .form-floating input.form-control:focus ~ label,
        [data-bs-theme="dark"] .form-floating select.form-select:focus ~ label,
        [data-bs-theme="dark"] .form-floating textarea.form-control:focus ~ label {
            background-color: var(--#{$prefix}dark);
            color: var(--#{$prefix}primary);
        }

        /* Status indicators */
        .status-in-stock { 
            color: var(--#{$prefix}success);
        }
        .status-low-stock { 
            color: var(--#{$prefix}warning);
        }
        .status-out-of-stock { 
            color: var(--#{$prefix}danger);
        }

        /* Metric card styling */
        .metric-card {
            border-radius: 10px;
            background-color: var(--#{$prefix}card-bg);
            border: 1px solid var(--#{$prefix}border-color);
            transition: all 0.3s ease;
        }

        .metric-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(var(--#{$prefix}dark-rgb), 0.1);
        }

        /* Dark mode metric card */
        [data-bs-theme="dark"] .metric-card {
            background-color: var(--#{$prefix}dark);
            border-color: var(--#{$prefix}gray-700);
        }

        [data-bs-theme="dark"] .metric-card:hover {
            border-color: var(--#{$prefix}primary);
            box-shadow: 0 5px 15px rgba(var(--#{$prefix}dark-rgb), 0.2);
        }

        /* Chart container */
        .chart-container {
            height: 300px;
            margin-bottom: 1.5rem;
            background-color: var(--#{$prefix}card-bg);
            border-radius: 10px;
            padding: 1rem;
        }

        /* Dark mode chart container */
        [data-bs-theme="dark"] .chart-container {
            background-color: var(--#{$prefix}dark);
        }

        /* Movement timeline */
        .movement-timeline {
            position: relative;
            padding-left: 30px;
        }

        .movement-timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--#{$prefix}border-color);
        }

        .movement-item {
            position: relative;
            padding-bottom: 1.5rem;
        }

        .movement-item::before {
            content: '';
            position: absolute;
            left: -21px;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--#{$prefix}card-bg);
            border: 2px solid var(--#{$prefix}primary);
        }

        /* Dark mode timeline */
        [data-bs-theme="dark"] .movement-timeline::before {
            background: var(--#{$prefix}gray-700);
        }

        [data-bs-theme="dark"] .movement-item::before {
            background: var(--#{$prefix}dark);
            border-color: var(--#{$prefix}primary);
        }

        /* Custom report field */
        .custom-report-field {
            padding: 0.5rem;
            margin: 0.25rem;
            background: var(--#{$prefix}gray-100);
            border-radius: 5px;
            cursor: move;
            transition: all 0.3s ease;
        }

        /* Dark mode custom report field */
        [data-bs-theme="dark"] .custom-report-field {
            background: var(--#{$prefix}gray-800);
        }

        .custom-report-field:hover {
            background: var(--#{$prefix}gray-200);
        }

        [data-bs-theme="dark"] .custom-report-field:hover {
            background: var(--#{$prefix}gray-700);
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
                            <li class="breadcrumb-item">Inventory</li>
                            <li class="breadcrumb-item active">Reports</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Inventory Reports</h4>
                </div>
            </div>
        </div>

        <!-- Inventory Overview -->
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card metric-card">
                    <div class="card-body">
                        <h5>Total Items</h5>
                        <h3>2,456</h3>
                        <p class="mb-0 text-muted">Across all categories</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card metric-card">
                    <div class="card-body">
                        <h5>Stock Value</h5>
                        <h3>$145,890</h3>
                        <p class="mb-0 text-success">+5.27% from last month</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card metric-card">
                    <div class="card-body">
                        <h5>Low Stock Items</h5>
                        <h3>48</h3>
                        <p class="mb-0 text-warning">Needs attention</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card metric-card">
                    <div class="card-body">
                        <h5>Out of Stock</h5>
                        <h3>12</h3>
                        <p class="mb-0 text-danger">Critical items</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Stock Distribution by Category</h5>
                        <div class="chart-container" id="categoryChart">
                            <!-- Chart will be rendered here -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Stock Level Trends</h5>
                        <div class="chart-container" id="trendChart">
                            <!-- Chart will be rendered here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="searchQuery" placeholder=" ">
                            <label for="searchQuery">Search Items</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <select class="form-select" id="categoryFilter">
                                <option value="">All Categories</option>
                                <option value="electronics">Electronics</option>
                                <option value="furniture">Furniture</option>
                                <option value="supplies">Office Supplies</option>
                            </select>
                            <label for="categoryFilter">Category</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <select class="form-select" id="stockStatus">
                                <option value="">All Status</option>
                                <option value="in_stock">In Stock</option>
                                <option value="low_stock">Low Stock</option>
                                <option value="out_of_stock">Out of Stock</option>
                            </select>
                            <label for="stockStatus">Stock Status</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <select class="form-select" id="supplier">
                                <option value="">All Suppliers</option>
                                <!-- Suppliers will be populated dynamically -->
                            </select>
                            <label for="supplier">Supplier</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventory List -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Inventory List</h4>
                <div class="d-flex gap-2">
                    <button class="btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#customReportModal">
                        <i class="ri-file-list-3-line"></i> Custom Report
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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-centered table-striped dt-responsive nowrap w-100" id="inventory-table">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>SKU</th>
                                <th>Category</th>
                                <th>Current Stock</th>
                                <th>Min. Level</th>
                                <th>Reorder Point</th>
                                <th>Unit Cost</th>
                                <th>Total Value</th>
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

    <!-- Stock Movement Modal -->
    <div class="modal fade" id="stockMovementModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Stock Movement History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Item Details</h6>
                            <p><strong>Name:</strong> <span id="modal-item-name"></span></p>
                            <p><strong>SKU:</strong> <span id="modal-sku"></span></p>
                            <p><strong>Category:</strong> <span id="modal-category"></span></p>
                        </div>
                        <div class="col-md-6">
                            <h6>Stock Information</h6>
                            <p><strong>Current Stock:</strong> <span id="modal-current-stock"></span></p>
                            <p><strong>Min Level:</strong> <span id="modal-min-level"></span></p>
                            <p><strong>Value:</strong> <span id="modal-value"></span></p>
                        </div>
                    </div>

                    <h6>Movement History</h6>
                    <div class="movement-timeline">
                        <!-- Movement history will be populated dynamically -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Export History</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Report Modal -->
    <div class="modal fade" id="customReportModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Custom Report Builder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Fields</label>
                        <div class="custom-report-fields">
                            <div class="custom-report-field">Item Name</div>
                            <div class="custom-report-field">SKU</div>
                            <div class="custom-report-field">Category</div>
                            <div class="custom-report-field">Current Stock</div>
                            <div class="custom-report-field">Unit Cost</div>
                            <div class="custom-report-field">Total Value</div>
                            <div class="custom-report-field">Supplier</div>
                            <div class="custom-report-field">Last Updated</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Report Format</label>
                        <select class="form-select">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Generate Report</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @vite(['node_modules/datatables.net/js/jquery.dataTables.min.js', 'node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#inventory-table').DataTable({
                pageLength: 10,
                order: [[0, 'asc']],
                columns: [
                    null,
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

            // Initialize Category Distribution Chart
            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            new Chart(categoryCtx, {
                type: 'pie',
                data: {
                    labels: ['Electronics', 'Furniture', 'Office Supplies', 'Others'],
                    datasets: [{
                        data: [30, 25, 35, 10],
                        backgroundColor: ['#727cf5', '#0acf97', '#ffc35a', '#fa5c7c']
                    }]
                }
            });

            // Initialize Stock Level Trends Chart
            const trendCtx = document.getElementById('trendChart').getContext('2d');
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Stock Level',
                        data: [1200, 1900, 1500, 2100, 1800, 2300],
                        borderColor: '#727cf5',
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Handle stock movement modal
            $('.view-movement').on('click', function() {
                $('#stockMovementModal').modal('show');
            });

            // Make custom report fields draggable
            $('.custom-report-field').draggable({
                containment: 'parent',
                cursor: 'move'
            });
        });
    </script>
@endsection
