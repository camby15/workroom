@extends('layouts.vertical', ['page_title' => 'Supplier Management'])

@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css'])
    <style>
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
            height: auto;
            min-height: 100px;
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
        .form-floating select.form-select:not([value='']),
        .form-floating textarea.form-control:focus,
        .form-floating textarea.form-control:not(:placeholder-shown) {
            border-color: #033c42;
            box-shadow: none;
        }
        .form-floating input.form-control:focus ~ label,
        .form-floating input.form-control:not(:placeholder-shown) ~ label,
        .form-floating select.form-select:focus ~ label,
        .form-floating select.form-select:not([value='']) ~ label,
        .form-floating textarea.form-control:focus ~ label,
        .form-floating textarea.form-control:not(:placeholder-shown) ~ label {
            height: auto;
            padding: 0 0.5rem;
            transform: translateY(-50%) translateX(0.5rem) scale(0.85);
            color: white;
            border-radius: 5px;
            z-index: 5;
        }
        .modal-body {
            background: none;
        }
        .modal-content {
            background: var(--bs-modal-bg);
        }
    </style>
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">Supplier Management</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Supplier Management</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Add Supplier Button -->
                        <div class="mb-3">
                            <button
                                type="button"
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#addSupplierModal">
                                <i class="ri-add-line me-1"></i>
                                Add New Supplier
                            </button>
                        </div>

                        <!-- Suppliers Table -->
                        <div class="table-responsive">
                            <table
                                class="table table-centered table-striped dt-responsive nowrap w-100"
                                id="suppliers-datatable">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Contact Person</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Product Category</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>ShrinQ Ghana Ltd</td>
                                        <td>Camby Omori</td>
                                        <td>camby@shrinq.com</td>
                                        <td>0546657584</td>
                                        <td>Electronics</td>
                                        <td>123 Business Street, Accra</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>
                                            <button
                                                type="button"
                                                class="btn btn-info btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editSupplierModal"
                                                title="Edit Supplier">
                                                <i class="ri-edit-line"></i>
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-warning btn-sm"
                                                title="Suspend Supplier">
                                                <i class="ri-pause-circle-line"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" title="Delete Supplier">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Supplier Modal -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSupplierForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="companyName" placeholder=" " required />
                                    <label for="companyName">Company Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="contactPerson"
                                        placeholder=" "
                                        required />
                                    <label for="contactPerson">Contact Person</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email" placeholder=" " required />
                                    <label for="email">Email Address</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="tel" class="form-control" id="phone" placeholder=" " required />
                                    <label for="phone">Phone Number</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input
                                        type="tel"
                                        class="form-control"
                                        id="Product Category"
                                        placeholder=" "
                                        required />
                                    <label for="Product Category">Product Category</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="address" placeholder=" " required />
                            <label for="address">Address</label>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="notes" placeholder=" " style="height: 100px"></textarea>
                            <label for="notes">Additional Notes</label>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Supplier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Supplier Modal (Similar structure to Add Modal) -->
    <div class="modal fade" id="editSupplierModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Similar form structure as Add Supplier Modal -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @vite(['node_modules/datatables.net/js/jquery.dataTables.min.js', 'node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js'])

    <script>
        $(document).ready(function () {
            $('#suppliers-datatable').DataTable();
        });
    </script>
@endsection
