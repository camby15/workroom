@extends('layouts.vertical', ['page_title' => 'Stock Management'])

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

        /* Dark mode label animation */
        [data-bs-theme="dark"] .form-floating input.form-control:focus ~ label,
        [data-bs-theme="dark"] .form-floating select.form-select:focus ~ label,
        [data-bs-theme="dark"] .form-floating textarea.form-control:focus ~ label {
            background-color: var(--#{$prefix}dark);
            color: var(--#{$prefix}primary);
        }

        /* Textarea specific styling */
        .form-floating textarea.form-control {
            height: auto;
            min-height: 100px;
        }

        /* Stock card styling */
        .stock-card {
            border-radius: 10px;
            background-color: var(--#{$prefix}card-bg);
            border: 1px solid var(--#{$prefix}border-color);
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .stock-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(var(--#{$prefix}dark-rgb), 0.1);
        }

        /* Dark mode stock card */
        [data-bs-theme="dark"] .stock-card {
            background-color: var(--#{$prefix}dark);
            border-color: var(--#{$prefix}gray-700);
        }

        [data-bs-theme="dark"] .stock-card:hover {
            border-color: var(--#{$prefix}primary);
            box-shadow: 0 5px 15px rgba(var(--#{$prefix}dark-rgb), 0.2);
        }

        /* Export dropdown styling */
        .export-dropdown .dropdown-menu {
            min-width: 100px;
            border-radius: 8px;
            background-color: var(--#{$prefix}card-bg);
            border-color: var(--#{$prefix}border-color);
            box-shadow: 0 2px 10px rgba(var(--#{$prefix}dark-rgb), 0.1);
        }

        /* Dark mode dropdown */
        [data-bs-theme="dark"] .export-dropdown .dropdown-menu {
            background-color: var(--#{$prefix}dark);
            border-color: var(--#{$prefix}gray-700);
        }

        .export-dropdown .dropdown-item {
            padding: 8px 15px;
            color: var(--#{$prefix}body-color);
        }

        .export-dropdown .dropdown-item:hover {
            background-color: rgba(var(--#{$prefix}primary-rgb), 0.1);
            color: var(--#{$prefix}primary);
        }

        .export-dropdown .dropdown-item i {
            margin-right: 8px;
            font-size: 16px;
        }

        /* Status badges */
        .status-badge {
            padding: 0.35em 0.65em;
            border-radius: 0.25rem;
            font-weight: 500;
        }

        .status-in-stock {
            background-color: rgba(var(--#{$prefix}success-rgb), 0.1);
            color: var(--#{$prefix}success);
        }

        .status-low-stock {
            background-color: rgba(var(--#{$prefix}warning-rgb), 0.1);
            color: var(--#{$prefix}warning);
        }

        .status-out-of-stock {
            background-color: rgba(var(--#{$prefix}danger-rgb), 0.1);
            color: var(--#{$prefix}danger);
        }

        /* Dark mode status badges */
        [data-bs-theme="dark"] .status-in-stock {
            background-color: rgba(var(--#{$prefix}success-rgb), 0.2);
        }

        [data-bs-theme="dark"] .status-low-stock {
            background-color: rgba(var(--#{$prefix}warning-rgb), 0.2);
        }

        [data-bs-theme="dark"] .status-out-of-stock {
            background-color: rgba(var(--#{$prefix}danger-rgb), 0.2);
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item">Inventory</li>
                            <li class="breadcrumb-item active">Stock Management</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Stock Management</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Action Buttons -->
                        <div class="mb-3 d-flex justify-content-between">
                            <button type="button" class="btn btn-glow" data-bs-toggle="modal" data-bs-target="#addStockModal">
                                <i class="ri-add-line me-1"></i> Add New Stock
                            </button>
                            <div class="dropdown export-dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="ri-download-2-line me-1"></i> Export
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"><i class="ri-file-excel-2-line"></i> Excel</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="ri-file-pdf-line"></i> PDF</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="ri-file-text-line"></i> CSV</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Stock Table -->
                        <div class="table-responsive">
                            <table class="table table-centered table-striped dt-responsive nowrap w-100" id="stocks-datatable">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="selectAll">
                                            </div>
                                        </th>
                                        <th>Product Name</th>
                                        <th>SKU</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Table content will be dynamically populated -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Stock Modal -->
    <div class="modal fade" id="addStockModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="stockForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="productName" placeholder=" ">
                                    <label for="productName">Product Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="sku" placeholder=" ">
                                    <label for="sku">SKU</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="category" name="category_id">
                                        <option value="">Select Category</option>
                                        @if(isset($categories) && !empty($categories))
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="category">Category</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="quantity" placeholder=" ">
                                    <label for="quantity">Quantity</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" step="0.01" class="form-control" id="unitPrice" placeholder=" ">
                                    <label for="unitPrice">Unit Price</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="reorderLevel" placeholder=" ">
                                    <label for="reorderLevel">Reorder Level</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="description" style="height: 100px" placeholder=" "></textarea>
                            <label for="description">Description</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Product Images</label>
                            <input type="file" class="form-control" id="productImages" multiple>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Stock</button>
                        </div>
                    </form>
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
            $('#stocks-datatable').DataTable({
                pageLength: 10,
                order: [[1, 'asc']],
                columns: [
                    { orderable: false },
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

            // Handle "Select All" checkbox
            $('#selectAll').change(function() {
                $('.stock-checkbox').prop('checked', $(this).prop('checked'));
            });

            // Stock form submission
            $('#stockForm').on('submit', function(e) {
                e.preventDefault();
                // Add your form submission logic here
                $(this).closest('.modal').modal('hide');
            });

            // Export functionality
            $('.export-dropdown .dropdown-item').click(function(e) {
                e.preventDefault();
                // Add your export logic here based on the clicked item
            });
        });
    </script>
@endsection
