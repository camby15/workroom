@extends('layouts.vertical', ['page_title' => 'Department Management'])

@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css'])
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
                            <li class="breadcrumb-item active">Department Management</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Department Management</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Company Selection for Multi-company Setup -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <select class="form-select" id="companySelect">
                                    <option value="">Select Company</option>
                                    <!-- Populate dynamically -->
                                </select>
                            </div>
                            <div class="col-md-8">
                                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
                                    <i class="ri-add-line me-1"></i> Add New Department
                                </button>
                            </div>
                        </div>

                        <!-- Departments Table -->
                        <div class="table-responsive">
                            <table class="table table-centered table-striped dt-responsive nowrap w-100" id="departments-datatable">
                                <thead>
                                    <tr>
                                        <th>Department Code</th>
                                        <th>Department Name</th>
                                        <th>Parent Department</th>
                                        <th>Head of Department</th>
                                        <th>Employee Count</th>
                                        <th>Budget</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Populated dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Department Modal -->
        <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Department</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addDepartmentForm">
                            <!-- Basic Information -->
                            <div class="row g-2">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Department Name</label>
                                    <input type="text" class="form-control" name="department_name" placeholder="Enter department name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Department Code</label>
                                    <input type="text" class="form-control" name="department_code" placeholder="Enter department code" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Parent Department</label>
                                    <select class="form-select" name="parent_department">
                                        <option value="">Select Parent Department</option>
                                        <!-- Populate dynamically -->
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Department Head</label>
                                    <select class="form-select" name="department_head">
                                        <option value="">Select Department Head</option>
                                        <!-- Populate dynamically -->
                                    </select>
                                </div>
                            </div>

                            <!-- Description and Purpose -->
                            <div class="row g-2">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="3" placeholder="Enter department description"></textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Purpose</label>
                                    <textarea class="form-control" name="purpose" rows="2" placeholder="Enter department purpose"></textarea>
                                </div>
                            </div>

                            <!-- Budget and Resources -->
                            <div class="row g-2">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Annual Budget</label>
                                    <input type="number" class="form-control" name="budget" placeholder="Enter annual budget">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Currency</label>
                                    <select class="form-select" name="currency">
                                        <!-- Populate with currencies -->
                                    </select>
                                </div>
                            </div>

                            <!-- Custom Fields -->
                            <div class="row g-2">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Custom Fields</label>
                                    <div id="customFieldsContainer">
                                        <!-- Dynamic custom fields -->
                                    </div>
                                    <button type="button" class="btn btn-link p-0" id="addCustomField">
                                        <i class="ri-add-line"></i> Add Custom Field
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveDepartmentBtn">Save Department</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Department Modal -->
        <div class="modal fade" id="editDepartmentModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Department</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Similar form as Add Department but with id="editDepartmentForm" -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateDepartmentBtn">Update Department</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Department Members Modal -->
        <div class="modal fade" id="departmentMembersModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Department Members</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-centered table-striped" id="department-members-table">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Position</th>
                                        <th>Email</th>
                                        <th>Join Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Populated dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Department Documents Modal -->
        <div class="modal fade" id="departmentDocumentsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Department Documents</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="documentUploadForm">
                            <div class="mb-3">
                                <label class="form-label">Document Type</label>
                                <select class="form-select" name="document_type" required>
                                    <option value="policy">Department Policy</option>
                                    <option value="procedure">Standard Procedure</option>
                                    <option value="minutes">Meeting Minutes</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Document Title</label>
                                <input type="text" class="form-control" name="document_title" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Document File</label>
                                <input type="file" class="form-control" name="document_file" required>
                            </div>
                        </form>
                        <div class="mt-3">
                            <h6>Uploaded Documents</h6>
                            <div id="documentsList">
                                <!-- Populated dynamically -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="uploadDocumentBtn">Upload Document</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- container -->
@endsection

@section('script')
    @vite(['node_modules/datatables.net/js/jquery.dataTables.min.js', 'node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js'])
    
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#departments-datatable').DataTable({
                // Add DataTable configuration here
            });

            // Add your custom JavaScript for department management functionality
        });
    </script>
@endsection
