@extends('layouts.vertical', ['page_title' => 'Category Management'])

@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css'])
    <style>
        .form-floating {
            position: relative;
            margin-bottom: 1rem;
        }
        .form-floating input.form-control,
        .form-floating select.form-select {
            height: 50px;
            border: 1px solid #2f2f2f;
            border-radius: 10px;
            background-color: transparent;
            font-size: 1rem;
            padding: 1rem 0.75rem;
            transition: all 0.8s;
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
        .form-floating select.form-select:not([value=""]) {
            border-color: #033c42;
            box-shadow: none;
        }
        .form-floating input.form-control:focus ~ label,
        .form-floating input.form-control:not(:placeholder-shown) ~ label,
        .form-floating select.form-select:focus ~ label,
        .form-floating select.form-select:not([value=""]) ~ label {
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
                            <li class="breadcrumb-item active">Category Management</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Category Management</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Main Categories -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMainCategoryModal">
                                <i class="ri-add-line me-1"></i> Add Main Category
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-striped dt-responsive nowrap w-100" id="main-categories-datatable">
                                <thead>
                                    <tr>
                                        <th>Category Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Electronics</td>
                                        <td>Electronic devices and accessories</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editMainCategoryModal" title="Edit Category">
                                                <i class="ri-edit-line"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" title="Delete Category">
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

        <!-- Sub Categories -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubCategoryModal">
                                <i class="ri-add-line me-1"></i> Add Sub Category
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-striped dt-responsive nowrap w-100" id="sub-categories-datatable">
                                <thead>
                                    <tr>
                                        <th>Sub Category Name</th>
                                        <th>Parent Category</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Smartphones</td>
                                        <td>Electronics</td>
                                        <td>Mobile phones and accessories</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editSubCategoryModal" title="Edit Sub Category">
                                                <i class="ri-edit-line"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" title="Delete Sub Category">
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

    <!-- Add Main Category Modal -->
    <div class="modal fade" id="addMainCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Main Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addMainCategoryForm">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="mainCategoryName" placeholder=" ">
                            <label for="mainCategoryName">Category Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="mainCategoryDescription" style="height: 100px" placeholder=" "></textarea>
                            <label for="mainCategoryDescription">Description</label>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Sub Category Modal -->
    <div class="modal fade" id="addSubCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Sub Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSubCategoryForm">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="parentCategory" placeholder=" ">
                                <option value="">Select a parent category</option>
                            </select>
                            <label for="parentCategory">Parent Category</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="subCategoryName" placeholder=" ">
                            <label for="subCategoryName">Sub Category Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="subCategoryDescription" style="height: 100px" placeholder=" "></textarea>
                            <label for="subCategoryDescription">Description</label>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Sub Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit modals will be similar to add modals -->
@endsection

@section('script')
    @vite(['node_modules/datatables.net/js/jquery.dataTables.min.js', 'node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js'])

    <script>
        $(document).ready(function() {
            $('#main-categories-datatable').DataTable();
            $('#sub-categories-datatable').DataTable();
        });
    </script>
@endsection
