@extends('layouts.vertical', ['page_title' => 'Manage Users'])
@section('head')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (optional, for icons) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Custom styles for user table and modals */
        .user-profile-link img {
            border: 2px solid #dee2e6;
            transition: box-shadow 0.2s;
        }
        .user-profile-link:hover img {
            box-shadow: 0 0 0 2px #0d6efd;
        }
        .modal .form-floating > label {
            left: 0.75rem;
        }
        .modal .form-select {
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
        }
    </style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Users Management</h4>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0" id="usersTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Last Login</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example row -->
                                <tr>
                                    <td>
                                        <a href="#" class="user-profile-link d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#userProfileModal" data-name="John Doe" data-email="john@example.com" data-role="Admin" data-status="Active" data-avatar="/images/avatar.jpg" data-lastlogin="2025-04-20">
                                            <img src="/images/avatar.jpg" alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                                            John Doe
                                        </a>
                                    </td>
                                    <td>john@example.com</td>
                                    <td>
                                        <select class="form-select form-select-sm user-role-select">
                                            <option selected>Admin</option>
                                            <option>Manager</option>
                                            <option>User</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch d-inline-block">
                                            <input class="form-check-input user-status-toggle" type="checkbox" checked>
                                            <label class="form-check-label">Active</label>
                                        </div>
                                    </td>
                                    <td>2025-04-20</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editUserModal">Edit</button>
                                        <button class="btn btn-sm btn-secondary btn-user-activity">Activity</button>
                                        <button class="btn btn-sm btn-danger btn-delete-user">Delete</button>
                                    </td>
                                </tr>
                                <!-- More rows here -->
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 d-flex flex-wrap gap-2">
                        <button class="btn btn-primary btn-sm" id="inviteUserBtn">Invite User</button>
                        <button class="btn btn-secondary btn-sm" id="importUsersBtn">Import Users</button>
                        <button class="btn btn-outline-secondary btn-sm" id="exportUsersBtn">Export Users</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="addUserName" placeholder="Name" required>
                        <label for="addUserName">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="addUserEmail" placeholder="Email" required>
                        <label for="addUserEmail">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="addUserRole" placeholder="Role" required>
                        <label for="addUserRole">Role</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="addUserStatus" required>
                            <option value="">Select Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <label for="addUserStatus">Status</label>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="editUserName" placeholder="Name" required>
                        <label for="editUserName">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="editUserEmail" placeholder="Email" required>
                        <label for="editUserEmail">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="editUserRole" placeholder="Role" required>
                        <label for="editUserRole">Role</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="editUserStatus" required>
                            <option value="">Select Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <label for="editUserStatus">Status</label>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- User Profile Quick View Modal -->
<div class="modal fade" id="userProfileModal" tabindex="-1" aria-labelledby="userProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userProfileModalLabel">User Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="userProfileContent">
                <!-- Profile content will be injected via JS -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <!-- Bootstrap JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 for alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @parent
    <script>
        // User Profile Quick View
        document.querySelectorAll('.user-profile-link').forEach(function(link) {
            link.addEventListener('click', function() {
                const name = this.dataset.name;
                const email = this.dataset.email;
                const role = this.dataset.role;
                const status = this.dataset.status;
                const avatar = this.dataset.avatar;
                const lastLogin = this.dataset.lastlogin;
                document.getElementById('userProfileContent').innerHTML = `
                    <div class='text-center mb-3'>
                        <img src='${avatar}' class='rounded-circle mb-2' width='80' height='80'>
                        <h5>${name}</h5>
                        <span class='badge bg-primary'>${role}</span>
                        <span class='badge bg-${status === 'Active' ? 'success' : 'secondary'} ms-2'>${status}</span>
                    </div>
                    <ul class='list-group text-start'>
                        <li class='list-group-item'><strong>Email:</strong> ${email}</li>
                        <li class='list-group-item'><strong>Last Login:</strong> ${lastLogin}</li>
                    </ul>
                `;
            });
        });
        // Inline Status Toggle
        document.querySelectorAll('.user-status-toggle').forEach(function(toggle) {
            toggle.addEventListener('change', function() {
                const label = this.closest('td').querySelector('.form-check-label');
                label.textContent = this.checked ? 'Active' : 'Inactive';
            });
        });
        // Inline Role Change
        document.querySelectorAll('.user-role-select').forEach(function(select) {
            select.addEventListener('change', function() {
                alert('Role changed to: ' + this.value);
            });
        });
        // User Activity Button
        document.querySelectorAll('.btn-user-activity').forEach(function(btn) {
            btn.addEventListener('click', function() {
                alert('Show user activity log (to be implemented)');
            });
        });
        // Invite/Import/Export
        document.getElementById('inviteUserBtn')?.addEventListener('click', function() {
            alert('Invite user dialog (to be implemented)');
        });
        document.getElementById('importUsersBtn')?.addEventListener('click', function() {
            alert('Import users dialog (to be implemented)');
        });
        document.getElementById('exportUsersBtn')?.addEventListener('click', function() {
            alert('Export users as CSV (to be implemented)');
        });
        // Delete User Button with SweetAlert2 Confirmation
        document.querySelectorAll('.btn-delete-user').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete user!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If there's a form for deletion, submit it here
                        // For now, just show a success alert
                        Swal.fire('Deleted!', 'The user has been deleted.', 'success');
                        // TODO: Add actual delete logic here
                    }
                });
            });
        });
    </script>
@endsection
