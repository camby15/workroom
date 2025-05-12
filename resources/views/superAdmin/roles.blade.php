@extends('layouts.vertical', ['page_title' => 'Roles & Permissions'])
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Roles & Permissions</h4>
                    <!-- Search & Filter Bar -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" id="roleSearch" class="form-control" placeholder="Search roles by name or module...">
                        </div>
                        <div class="col-md-3">
                            <select id="moduleFilter" class="form-select">
                                <option value="">All Modules</option>
                                <option value="CRM">CRM</option>
                                <option value="HR">HR</option>
                                <option value="Inventory">Inventory</option>
                                <option value="Accounting">Accounting</option>
                                <option value="Projects">Projects</option>
                                <option value="Support">Support</option>
                                <option value="Super Admin Tools">Super Admin Tools</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="statusFilter" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0" id="rolesTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Role</th>
                                    <th>Description</th>
                                    <th>Module Access</th>
                                    <th>Status</th>
                                    <th>Users</th>
                                    <th>Created/Modified</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example row -->
                                <tr>
                                    <td>
                                        Super Admin
                                        <span class="ms-1" data-bs-toggle="tooltip" title="Full access to all features."><i class="ri-information-line"></i></span>
                                    </td>
                                    <td>Full access to all features</td>
                                    <td>
                                        <span class="badge bg-primary">CRM</span>
                                        <span class="badge bg-info">HR</span>
                                        <span class="badge bg-warning text-dark">Inventory</span>
                                        <span class="badge bg-success">Accounting</span>
                                    </td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td><a href="#" class="link-primary">12 Users</a></td>
                                    <td>
                                        <small>Created: 2025-04-01<br>By: Alice</small><br>
                                        <small>Modified: 2025-04-20<br>By: Bob</small>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editRoleModal">Edit</button>
                                        <button class="btn btn-sm btn-danger btn-delete-role">Delete</button>
                                    </td>
                                </tr>
                                <!-- More rows here; in production, loop through roles and display dynamic info -->
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal">Add New Role</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Role Modal with Enhanced Fields and Section Headers -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addRoleForm" method="POST" action=""> <!-- Replace with your form action -->
                @csrf
                <div class="modal-body">
                    <h6 class="border-bottom pb-2 mb-3">Role Info</h6>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="role_name" name="role_name" placeholder="Role Name" required>
                        <label for="role_name">Role Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="description" name="description" placeholder="Description"></textarea>
                        <label for="description">Description</label>
                    </div>
                    <h6 class="border-bottom pb-2 mb-3 mt-4">Module Permissions</h6>
                    <div class="mb-3">
                        <div class="row g-2">
                            @php
                                $modules = ['CRM', 'HR', 'Inventory', 'Accounting', 'Projects', 'Support', 'Super Admin Tools'];
                                $crud = ['View', 'Create', 'Edit', 'Delete'];
                            @endphp
                            @foreach($modules as $module)
                            <div class="col-12 mb-2">
                                <div class="fw-bold mb-1">{{ $module }}</div>
                                <div class="d-flex flex-wrap gap-2 flex-column flex-md-row">
                                    @foreach($crud as $action)
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="permissions[{{ $module }}][]" value="{{ $action }}" id="perm_{{ Str::slug($module) }}_{{ strtolower($action) }}">
                                        <label class="form-check-label" for="perm_{{ Str::slug($module) }}_{{ strtolower($action) }}">{{ $action }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <h6 class="border-bottom pb-2 mb-3 mt-4">Status</h6>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div id="addRoleError" class="alert alert-danger d-none mt-2"></div>
                    <div id="addRoleSuccess" class="alert alert-success d-none mt-2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="addRoleSubmitBtn">
                        <span class="spinner-border spinner-border-sm d-none" id="addRoleSpinner"></span> Add Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Role Modal with Enhanced Fields and Section Headers -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editRoleForm">
                <div class="modal-body">
                    <h6 class="border-bottom pb-2 mb-3">Role Info</h6>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="editRoleName" placeholder="Role Name" required>
                        <label for="editRoleName">Role Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="editRoleDesc" placeholder="Description"></textarea>
                        <label for="editRoleDesc">Description</label>
                    </div>
                    <h6 class="border-bottom pb-2 mb-3 mt-4">Module Permissions</h6>
                    <div class="mb-3">
                        <div class="row g-2">
                            @php
                                $modules = ['CRM', 'HR', 'Inventory', 'Accounting', 'Projects', 'Support', 'Super Admin Tools'];
                                $crud = ['View', 'Create', 'Edit', 'Delete'];
                            @endphp
                            @foreach($modules as $module)
                            <div class="col-12 mb-2">
                                <div class="fw-bold mb-1">{{ $module }}</div>
                                <div class="d-flex flex-wrap gap-2 flex-column flex-md-row">
                                    @foreach($crud as $action)
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="edit_permissions[{{ $module }}][]" value="{{ $action }}" id="edit_perm_{{ Str::slug($module) }}_{{ strtolower($action) }}">
                                        <label class="form-check-label" for="edit_perm_{{ Str::slug($module) }}_{{ strtolower($action) }}">{{ $action }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <h6 class="border-bottom pb-2 mb-3 mt-4">Status</h6>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" name="edit_status" id="edit_status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div id="editRoleError" class="alert alert-danger d-none mt-2"></div>
                    <div id="editRoleSuccess" class="alert alert-success d-none mt-2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="editRoleSubmitBtn">
                        <span class="spinner-border spinner-border-sm d-none" id="editRoleSpinner"></span> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
@parent
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Tooltip for info icons
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Search & Filter functionality (front-end only)
    document.getElementById('roleSearch')?.addEventListener('input', function() {
        filterRoles();
    });
    document.getElementById('moduleFilter')?.addEventListener('change', function() {
        filterRoles();
    });
    document.getElementById('statusFilter')?.addEventListener('change', function() {
        filterRoles();
    });
    function filterRoles() {
        let search = document.getElementById('roleSearch').value.toLowerCase();
        let module = document.getElementById('moduleFilter').value;
        let status = document.getElementById('statusFilter').value;
        let rows = document.querySelectorAll('#rolesTable tbody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            let show = true;
            if (search && !text.includes(search)) show = false;
            if (module && !text.includes(module.toLowerCase())) show = false;
            if (status && !text.includes(status.toLowerCase())) show = false;
            row.style.display = show ? '' : 'none';
        });
    }

    // Add Role
    document.getElementById('addRoleForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        var btn = document.getElementById('addRoleSubmitBtn');
        var spinner = document.getElementById('addRoleSpinner');
        btn.disabled = true;
        spinner.classList.remove('d-none');
        setTimeout(function() {
            btn.disabled = false;
            spinner.classList.add('d-none');
            document.getElementById('addRoleSuccess').classList.remove('d-none');
            document.getElementById('addRoleSuccess').innerText = 'Role successfully added!';
        }, 1500);
    });

    // Edit Role
    document.getElementById('editRoleForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        var btn = document.getElementById('editRoleSubmitBtn');
        var spinner = document.getElementById('editRoleSpinner');
        btn.disabled = true;
        spinner.classList.remove('d-none');
        setTimeout(function() {
            btn.disabled = false;
            spinner.classList.add('d-none');
            document.getElementById('editRoleSuccess').classList.remove('d-none');
            document.getElementById('editRoleSuccess').innerText = 'Role successfully updated!';
        }, 1500);
    });

    console.log('Custom script loaded');
    console.log('Swal is', typeof Swal !== 'undefined' ? 'defined' : 'undefined');
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOMContentLoaded event fired');
        document.querySelectorAll('.btn-delete-role').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Delete button clicked');
                if(typeof Swal === 'undefined') {
                    alert('Swal is not defined!');
                    return;
                }
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Deleted!', 'The role has been deleted.', 'success');
                    }
                });
            });
        });
    });
</script>
@endsection
