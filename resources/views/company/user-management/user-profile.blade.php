@extends('layouts.vertical', ['page_title' => 'User Profiles'])

@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css'])
    <style>
        .profile-card {
            border-left: 4px solid #727cf5;
            transition: transform 0.2s;
        }
        .profile-card:hover {
            transform: translateY(-3px);
        }
        .menu-item {
            padding: 8px;
            margin: 4px 0;
            border-radius: 4px;
            background-color: #f8f9fa;
        }
        .menu-item:hover {
            background-color: #e9ecef;
        }
        .profile-search {
            border-radius: 20px;
            padding-left: 20px;
        }

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
        .form-floating input.form-control:focus ~ label::before,
        .form-floating input.form-control:not(:placeholder-shown) ~ label::before,
        .form-floating select.form-select:focus ~ label::before,
        .form-floating select.form-select:not([value='']) ~ label::before,
        .form-floating textarea.form-control:focus ~ label::before,
        .form-floating textarea.form-control:not(:placeholder-shown) ~ label::before {
            content: '';
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
        [data-bs-theme='dark'] .form-floating input.form-control,
        [data-bs-theme='dark'] .form-floating select.form-select,
        [data-bs-theme='dark'] .form-floating textarea.form-control {
            border-color: #6c757d;
            color: #e9ecef;
        }

        [data-bs-theme='dark'] .form-floating label {
            color: #adb5bd;
        }

        [data-bs-theme='dark'] .form-floating input.form-control:focus,
        [data-bs-theme='dark'] .form-floating input.form-control:not(:placeholder-shown),
        [data-bs-theme='dark'] .form-floating select.form-select:focus,
        [data-bs-theme='dark'] .form-floating select.form-select:not([value='']),
        [data-bs-theme='dark'] .form-floating textarea.form-control:focus,
        [data-bs-theme='dark'] .form-floating textarea.form-control:not(:placeholder-shown) {
            border-color: #0dcaf0;
        }

        [data-bs-theme='dark'] .form-floating input.form-control:focus ~ label::before,
        [data-bs-theme='dark'] .form-floating input.form-control:not(:placeholder-shown) ~ label::before,
        [data-bs-theme='dark'] .form-floating select.form-select:focus ~ label::before,
        [data-bs-theme='dark'] .form-floating select.form-select:not([value='']) ~ label::before,
        [data-bs-theme='dark'] .form-floating textarea.form-control:focus ~ label::before,
        [data-bs-theme='dark'] .form-floating textarea.form-control:not(:placeholder-shown) ~ label::before {
            background: #0dcaf0;
        }

        [data-bs-theme='dark'] select.form-select option {
            background-color: #212529;
            color: #e9ecef;
        }

        /* Reset and simplify select styles */
        .form-floating select.form-select {
            display: block;
            width: 100%;
            height: 50px;
            padding: 1rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #2f2f2f;
            background-color: transparent;
            border: 1px solid #2f2f2f;
            border-radius: 10px;
            transition: all 0.8s;
            appearance: none;
            background: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'><path fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/></svg>")
                no-repeat right 0.75rem center/16px 12px;
        }

        [data-bs-theme='dark'] .form-floating select.form-select {
            background: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'><path fill='none' stroke='%23adb5bd' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/></svg>")
                no-repeat right 0.75rem center/16px 12px;
            background-color: transparent;
        }

        .form-floating select.form-select:focus {
            border-color: #033c42;
            outline: 0;
            box-shadow: none;
        }

        .form-floating select.form-select ~ label {
            padding: 1rem 0.75rem;
        }

        .modal-body {
            background: none;
            padding: 1.5rem;
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
                            <li class="breadcrumb-item active">User Profiles</li>
                        </ol>
                    </div>
                    <h4 class="page-title">User Profiles</h4>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <!-- Left Sidebar - Profile List -->
            <div class="col-xl-3 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="header-title mb-0">User Profiles</h4>
                            <button
                                type="button"
                                class="btn btn-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#addProfileModal">
                                <i class="ri-add-line"></i>
                                Add Profile
                            </button>
                        </div>

                        <div class="form-floating mb-3">
                            <input
                                type="text"
                                class="form-control"
                                id="searchProfiles"
                                placeholder="Search profiles..." />
                            <label for="searchProfiles">Search Profiles</label>
                        </div>

                        <div class="profile-list">
                            @if (isset($error))
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endif

                            @forelse ($profiles ?? collect() as $profile)
                                <div
                                    class="profile-card p-3 mb-2 cursor-pointer border rounded"
                                    data-profile-id="{{ $profile->id }}">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm">
                                            <span
                                                class="avatar-title rounded-circle {{ $profile->status === 'active' ? 'bg-primary-subtle text-primary' : 'bg-info-subtle text-info' }}">
                                                {{ strtoupper(substr($profile->profile_name, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div class="ms-2 flex-grow-1">
                                            <h5 class="mb-1">{{ $profile->profile_name }}</h5>
                                            <p class="text-muted mb-0 small">
                                                <i class="ri-user-line me-1"></i>
                                                {{ $profile->users_count }}
                                                {{ Str::plural('User', $profile->users_count) }}
                                            </p>
                                        </div>
                                        <div class="ms-2 d-flex align-items-center">
                                            <span
                                                class="badge {{ $profile->status === 'active' ? 'bg-success' : 'bg-warning' }} me-2">
                                                {{ ucfirst($profile->status) }}
                                            </span>
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-danger"
                                                onclick="deleteProfile(event, {{ $profile->id }}, '{{ $profile->profile_name }}')"
                                                title="Delete Profile">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @if ($profile->description)
                                        <p class="text-muted small mt-2 mb-0">
                                            {{ Str::limit($profile->description, 100) }}
                                        </p>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="ri-folder-user-line h1 text-muted"></i>
                                    <p class="mt-2">No profiles found</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Content - Profile Details -->
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-bordered mb-3">
                            <li class="nav-item">
                                <a
                                    href="#profile-details"
                                    data-bs-toggle="tab"
                                    aria-expanded="true"
                                    class="nav-link active">
                                    <i class="ri-user-settings-line d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Profile Details</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#menu-access" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                    <i class="ri-menu-line d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Menu Access</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#assigned-users" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                    <i class="ri-team-line d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Assigned Users</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <!-- Profile Details Tab -->
                            <div class="tab-pane show active" id="profile-details">
                                <form id="updateProfileForm" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <select
                                                    class="form-select"
                                                    id="profileSelect"
                                                    name="profile_id"
                                                    required>
                                                    <option value="">Select Profile</option>
                                                    @foreach ($profiles as $profile)
                                                        <option
                                                            value="{{ $profile->id }}"
                                                            data-description="{{ $profile->description }}"
                                                            data-status="{{ $profile->status }}">
                                                            {{ $profile->profile_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="profileSelect">Select Profile</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <select class="form-select" id="editStatus" name="status" required>
                                                    <option value="">Select Status</option>
                                                    <option value="active">Active</option>
                                                    <option value="inactive">Inactive</option>
                                                </select>
                                                <label for="editStatus">Status</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <textarea
                                            class="form-control"
                                            id="editDescription"
                                            name="description"
                                            placeholder=" "
                                            rows="3"
                                            style="height: 100px"></textarea>
                                        <label for="editDescription">Description</label>
                                    </div>

                                    <div class="text-end mt-3">
                                        <button type="button" id="resetForm" class="btn btn-light me-2">Cancel</button>
                                        <button type="submit" class="btn btn-success">Update Profile</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Menu Access Tab -->
                            <div class="tab-pane" id="menu-access">
                                <form id="menuAccessForm" method="POST">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select
                                                    class="form-select"
                                                    id="menuProfileSelect"
                                                    name="profile_id"
                                                    required>
                                                    <option value="">Select Profile</option>
                                                    @foreach ($profiles as $profile)
                                                        <option value="{{ $profile->id }}">
                                                            {{ $profile->profile_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="menuProfileSelect">Select Profile</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select class="form-select" id="copyFromProfile">
                                                    <option value="">Select a profile to copy from...</option>
                                                    @foreach ($profiles as $profile)
                                                        <option value="{{ $profile->id }}">
                                                            {{ $profile->profile_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="copyFromProfile">Copy Access From Profile</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="menu-list mt-4">
                                        <!-- Navigation -->
                                        <h5 class="mb-3">Navigation</h5>

                                        <!-- Dashboards -->
                                        <div class="menu-section mb-4">
                                            <div class="menu-item">
                                                <div class="form-check">
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input menu-parent"
                                                        id="menu_dashboards"
                                                        data-key="dashboards"
                                                        data-name="Dashboards"
                                                        data-icon="ri-home-4-line" />
                                                    <label class="form-check-label" for="menu_dashboards">
                                                        <i class="ri-home-4-line me-1"></i>
                                                        Dashboards
                                                    </label>
                                                </div>
                                                <div class="ms-4 mt-2 submenu">
                                                    <div class="form-check">
                                                        <input
                                                            type="checkbox"
                                                            class="form-check-input menu-child"
                                                            id="menu_analytics"
                                                            data-key="analytics"
                                                            data-name="Analytics"
                                                            data-parent="dashboards"
                                                            data-route="{{ route('any', 'analytics') }}" />
                                                        <label class="form-check-label" for="menu_analytics">
                                                            Analytics
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            type="checkbox"
                                                            class="form-check-input menu-child"
                                                            id="menu_ecommerce"
                                                            data-key="ecommerce"
                                                            data-name="Ecommerce"
                                                            data-parent="dashboards"
                                                            data-route="{{ route('any', 'index') }}" />
                                                        <label class="form-check-label" for="menu_ecommerce">
                                                            Ecommerce
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- User Management -->
                                        <div class="menu-section mb-4">
                                            <div class="menu-item">
                                                <div class="form-check">
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input menu-parent"
                                                        id="menu_user_management"
                                                        data-key="user_management"
                                                        data-name="User Management"
                                                        data-icon="ri-user-settings-line" />
                                                    <label class="form-check-label" for="menu_user_management">
                                                        <i class="ri-user-settings-line me-1"></i>
                                                        User Management
                                                    </label>
                                                </div>
                                                <div class="ms-4 mt-2 submenu">
                                                    <div class="form-check">
                                                        <input
                                                            type="checkbox"
                                                            class="form-check-input menu-child"
                                                            id="menu_users"
                                                            data-key="users"
                                                            data-name="Users"
                                                            data-parent="user_management"
                                                            data-route="{{ route('company-sub-users.index') }}" />
                                                        <label class="form-check-label" for="menu_users">Users</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            type="checkbox"
                                                            class="form-check-input menu-child"
                                                            id="menu_user_profiles"
                                                            data-key="user_profiles"
                                                            data-name="User Profiles"
                                                            data-parent="user_management"
                                                            data-route="{{ route('company.user-profiles.index') }}" />
                                                        <label class="form-check-label" for="menu_user_profiles">
                                                            User Profiles
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            type="checkbox"
                                                            class="form-check-input menu-child"
                                                            id="menu_partners"
                                                            data-key="partners"
                                                            data-name="Partners"
                                                            data-parent="user_management"
                                                            data-route="{{ route('any', 'company/user-management/partners') }}" />
                                                        <label class="form-check-label" for="menu_partners">
                                                            Partners
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            type="checkbox"
                                                            class="form-check-input menu-child"
                                                            id="menu_user_category"
                                                            data-key="user_category"
                                                            data-name="User Category"
                                                            data-parent="user_management"
                                                            data-route="{{ route('any', 'company/user-management/user-category') }}" />
                                                        <label class="form-check-label" for="menu_user_category">
                                                            User Category
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Single Menu Items -->
                                        <div class="menu-section mb-4">
                                            <div class="menu-item">
                                                <div class="form-check">
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input menu-single"
                                                        id="menu_departments"
                                                        data-key="departments"
                                                        data-name="Manage Department"
                                                        data-icon="ri-building-line"
                                                        data-route="{{ route('any', 'company/manage-departments') }}" />
                                                    <label class="form-check-label" for="menu_departments">
                                                        <i class="ri-building-line me-1"></i>
                                                        Manage Department
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="menu-item mt-2">
                                                <div class="form-check">
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input menu-single"
                                                        id="menu_branches"
                                                        data-key="branches"
                                                        data-name="Manage Branches"
                                                        data-icon="ri-git-branch-line"
                                                        data-route="{{ route('any', 'company/manage-branches') }}" />
                                                    <label class="form-check-label" for="menu_branches">
                                                        <i class="ri-git-branch-line me-1"></i>
                                                        Manage Branches
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end mt-3">
                                        <button type="button" id="resetMenuAccess" class="btn btn-light me-2">
                                            Reset
                                        </button>
                                        <button type="submit" class="btn btn-success">Save Menu Access</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Assigned Users Tab -->
                            <div class="tab-pane" id="assigned-users">
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="searchUsers"
                                                placeholder="Search users..." />
                                            <label for="searchUsers">Search Users</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-centered table-hover" id="subUsersTable">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Assigned Profile</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subUsers as $user)
                                                <tr>
                                                    <td>{{ $user->fullname }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>
                                                        <div class="form-floating">
                                                            <select
                                                                class="form-select profile-select"
                                                                id="profile_{{ $user->id }}"
                                                                data-user-id="{{ $user->id }}">
                                                                <option value="">Select Profile</option>
                                                                @foreach ($profiles as $profile)
                                                                    <option
                                                                        value="{{ $profile->id }}"
                                                                        {{ $user->profile_id == $profile->id ? 'selected' : '' }}>
                                                                        {{ $profile->profile_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <label for="profile_{{ $user->id }}">Assign Profile</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-info view-access"
                                                            data-user-id="{{ $user->id }}"
                                                            data-user-name="{{ $user->fullname }}">
                                                            <i class="ri-eye-line"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Profile Modal -->
    <div class="modal fade" id="addProfileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="min-height: 350px">
                    <form
                        id="addProfileForm"
                        class="mt-3"
                        method="POST"
                        action="{{ route('company.user-profiles.store') }}">
                        @csrf
                        <div class="form-floating mb-4">
                            <input
                                type="text"
                                class="form-control"
                                id="profileName"
                                name="profile_name"
                                placeholder=" "
                                required />
                            <label for="profileName">Profile Name</label>
                        </div>
                        <div class="form-floating mb-4">
                            <textarea
                                class="form-control"
                                id="description"
                                name="description"
                                placeholder=" "
                                rows="3"
                                style="height: 100px"></textarea>
                            <label for="description">Description</label>
                        </div>
                        <div class="form-floating">
                            <select class="form-select" id="role" name="status" required>
                                <option value="">Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="locked">Lock</option>
                            </select>
                            <label for="role">Status</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="addProfileForm" class="btn btn-primary">Create Profile</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Remove any existing event listeners
        document.removeEventListener('DOMContentLoaded', initializeProfileForm);

        function initializeProfileForm() {
            const addProfileForm = document.getElementById('addProfileForm');

            if (addProfileForm) {
                // Remove any existing submit handlers
                const newForm = addProfileForm.cloneNode(true);
                addProfileForm.parentNode.replaceChild(newForm, addProfileForm);

                newForm.addEventListener('submit', async function (e) {
                    e.preventDefault();

                    // Disable the submit button to prevent double submission
                    const submitButton = document.querySelector('button[type="submit"]');
                    if (submitButton) submitButton.disabled = true;

                    try {
                        const response = await fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                Accept: 'application/json',
                            },
                            body: new FormData(this),
                        });

                        const data = await response.json();
                        console.log('Response:', { status: response.status, data }); // Debug log

                        if (response.status === 201 || response.status === 200) {
                            // Success case
                            const modal = bootstrap.Modal.getInstance(document.getElementById('addProfileModal'));
                            if (modal) modal.hide();

                            await Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1500,
                            });

                            window.location.reload();
                            return;
                        }

                        if (response.status === 422) {
                            // Validation error case
                            const errors = data.errors;
                            const errorMessages = Object.values(errors).flat();

                            await Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                html: errorMessages.join('<br>'),
                            });
                            return;
                        }

                        throw new Error(data.message || 'An error occurred');
                    } catch (error) {
                        console.error('Error:', error);
                        await Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: error.message || 'An error occurred while creating the profile',
                        });
                    } finally {
                        // Re-enable the submit button
                        if (submitButton) submitButton.disabled = false;
                    }
                });

                // Reset form when modal is hidden
                const addProfileModal = document.getElementById('addProfileModal');
                if (addProfileModal) {
                    addProfileModal.addEventListener('hidden.bs.modal', function () {
                        newForm.reset();
                    });
                }
            }
        }

        // Add the event listener
        document.addEventListener('DOMContentLoaded', initializeProfileForm);
    </script>

    <script>
        // Profile update functionality
        document.addEventListener('DOMContentLoaded', function () {
            const profileSelect = document.getElementById('profileSelect');
            const editStatus = document.getElementById('editStatus');
            const editDescription = document.getElementById('editDescription');
            const updateProfileForm = document.getElementById('updateProfileForm');
            const resetFormButton = document.getElementById('resetForm');

            // Handle profile selection
            profileSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    editStatus.value = selectedOption.dataset.status;
                    editDescription.value = selectedOption.dataset.description || '';
                    updateProfileForm.action = `${window.location.origin}/company/user-profiles/${selectedOption.value}`;
                } else {
                    resetForm();
                }
            });

            // Handle form reset
            resetFormButton.addEventListener('click', resetForm);

            function resetForm() {
                profileSelect.value = '';
                editStatus.value = '';
                editDescription.value = '';
                updateProfileForm.action = '';
            }

            // Handle form submission
            updateProfileForm.addEventListener('submit', function (e) {
                e.preventDefault();

                if (!this.action) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Please select a profile to update.',
                    });
                    return;
                }

                const formData = new FormData(this);

                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        Accept: 'application/json',
                    },
                    body: formData,
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1500,
                            }).then(() => {
                                // Update the profile card in the list
                                const profileCard = document.querySelector(
                                    `[data-profile-id="${profileSelect.value}"]`
                                );
                                if (profileCard) {
                                    const statusBadge = profileCard.querySelector('.badge');
                                    statusBadge.className = `badge ${editStatus.value === 'active' ? 'bg-success' : 'bg-warning'} me-2`;
                                    statusBadge.textContent =
                                        editStatus.value.charAt(0).toUpperCase() + editStatus.value.slice(1);

                                    // Update description if it exists
                                    const description = profileCard.querySelector('p.text-muted.small.mt-2');
                                    if (description) {
                                        description.textContent = editDescription.value;
                                    } else if (editDescription.value) {
                                        profileCard.insertAdjacentHTML(
                                            'beforeend',
                                            `<p class="text-muted small mt-2 mb-0">${editDescription.value}</p>`
                                        );
                                    }
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.message,
                            });
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An error occurred while updating the profile.',
                        });
                    });
            });
        });
    </script>

    <script>
        // Menu Access functionality
        document.addEventListener('DOMContentLoaded', function () {
            const menuProfileSelect = document.getElementById('menuProfileSelect');
            const copyFromProfile = document.getElementById('copyFromProfile');
            const menuAccessForm = document.getElementById('menuAccessForm');
            const resetMenuAccess = document.getElementById('resetMenuAccess');

            // Handle parent menu checkboxes
            document.querySelectorAll('.menu-parent').forEach((parent) => {
                parent.addEventListener('change', function () {
                    const submenu = this.closest('.menu-item').querySelector('.submenu');
                    if (submenu) {
                        submenu.querySelectorAll('.menu-child').forEach((child) => {
                            child.checked = this.checked;
                        });
                    }
                });
            });

            // Handle child menu checkboxes
            document.querySelectorAll('.menu-child').forEach((child) => {
                child.addEventListener('change', function () {
                    const parent = this.closest('.menu-item').querySelector('.menu-parent');
                    if (parent) {
                        const siblings = this.closest('.submenu').querySelectorAll('.menu-child');
                        const allUnchecked = Array.from(siblings).every((sibling) => !sibling.checked);
                        parent.checked = !allUnchecked;
                    }
                });
            });

            // Handle profile selection
            menuProfileSelect.addEventListener('change', function () {
                if (this.value) {
                    // Fetch menu access for selected profile
                    fetch(`${window.location.origin}/company/user-profiles/${this.value}/menu-access`)
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                resetCheckboxes();
                                data.menu_access.forEach((menu) => {
                                    const checkbox = document.querySelector(`[data-key="${menu.menu_key}"]`);
                                    if (checkbox) {
                                        checkbox.checked = menu.is_active;
                                        // If it's a child menu, check parent status
                                        if (checkbox.classList.contains('menu-child')) {
                                            updateParentStatus(checkbox);
                                        }
                                    }
                                });
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to load menu access.',
                            });
                        });

                    menuAccessForm.action = `${window.location.origin}/company/user-profiles/${this.value}/menu-access`;
                } else {
                    resetCheckboxes();
                    menuAccessForm.action = '';
                }
            });

            // Handle copy from profile
            copyFromProfile.addEventListener('change', function () {
                if (this.value && this.value !== menuProfileSelect.value) {
                    fetch(`${window.location.origin}/company/user-profiles/${this.value}/menu-access`)
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                resetCheckboxes();
                                data.menu_access.forEach((menu) => {
                                    const checkbox = document.querySelector(`[data-key="${menu.menu_key}"]`);
                                    if (checkbox) {
                                        checkbox.checked = menu.is_active;
                                        if (checkbox.classList.contains('menu-child')) {
                                            updateParentStatus(checkbox);
                                        }
                                    }
                                });
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to copy menu access.',
                            });
                        });
                }
            });

            // Handle form submission
            menuAccessForm.addEventListener('submit', function (e) {
                e.preventDefault();

                if (!this.action) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Please select a profile first.',
                    });
                    return;
                }

                // Collect all checked menu items
                const menuAccess = [];

                // Add parent menus
                document.querySelectorAll('.menu-parent').forEach((parent) => {
                    menuAccess.push({
                        menu_key: parent.dataset.key,
                        menu_name: parent.dataset.name,
                        menu_icon: parent.dataset.icon,
                        is_active: parent.checked,
                    });
                });

                // Add child menus
                document.querySelectorAll('.menu-child').forEach((child) => {
                    menuAccess.push({
                        menu_key: child.dataset.key,
                        menu_name: child.dataset.name,
                        menu_route: child.dataset.route,
                        parent_menu: child.dataset.parent,
                        is_active: child.checked,
                    });
                });

                // Add single menus
                document.querySelectorAll('.menu-single').forEach((single) => {
                    menuAccess.push({
                        menu_key: single.dataset.key,
                        menu_name: single.dataset.name,
                        menu_icon: single.dataset.icon,
                        menu_route: single.dataset.route,
                        is_active: single.checked,
                    });
                });

                // Send the data
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                    },
                    body: JSON.stringify({ menu_access: menuAccess }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1500,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.message,
                            });
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to save menu access.',
                        });
                    });
            });

            // Handle reset
            resetMenuAccess.addEventListener('click', function () {
                resetCheckboxes();
                menuProfileSelect.value = '';
                copyFromProfile.value = '';
                menuAccessForm.action = '';
            });

            function resetCheckboxes() {
                document.querySelectorAll('.menu-parent, .menu-child, .menu-single').forEach((checkbox) => {
                    checkbox.checked = false;
                });
            }

            function updateParentStatus(childCheckbox) {
                const parent = childCheckbox.closest('.menu-item').querySelector('.menu-parent');
                if (parent) {
                    const siblings = childCheckbox.closest('.submenu').querySelectorAll('.menu-child');
                    const allUnchecked = Array.from(siblings).every((sibling) => !sibling.checked);
                    parent.checked = !allUnchecked;
                }
            }
        });
    </script>

    <script>
        $(document).ready(function () {
            // Handle profile selection change
            $('.profile-select').change(function () {
                const userId = $(this).data('user-id');
                const profileId = $(this).val();
                const userName = $(this).closest('tr').find('td:first').text();

                if (profileId) {
                    Swal.fire({
                        title: 'Confirm Profile Assignment',
                        text: `Are you sure you want to assign this profile to ${userName}?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, assign it',
                        cancelButtonText: 'No, cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading state
                            Swal.fire({
                                title: 'Assigning Profile',
                                text: 'Please wait...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                            });

                            // Make the AJAX request
                            $.ajax({
                                url: '{{ route('company.user-profiles.assign-profile', ['userId' => ':userId']) }}'.replace(
                                    ':userId',
                                    userId
                                ),
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                },
                                data: {
                                    profile_id: profileId,
                                },
                                success: function (response) {
                                    if (response.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success!',
                                            text: response.message,
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error!',
                                            text: response.message || 'Failed to assign profile.',
                                        });
                                    }
                                },
                                error: function (xhr) {
                                    console.error('Error:', xhr);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'Failed to assign profile. Please try again.',
                                    });
                                },
                            });
                        } else {
                            // Reset the select to its previous value if user cancels
                            $(this).val($(this).find('option[selected]').val() || '');
                        }
                    });
                }
            });

            // Handle view access button click
            $('.view-access').click(function () {
                const userId = $(this).data('user-id');
                const userName = $(this).data('user-name');

                // Show loading state
                Swal.fire({
                    title: 'Loading Menu Access',
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });

                // Make the AJAX request
                $.ajax({
                    url: '{{ route('company.user-profiles.menu-access', ['userId' => ':userId']) }}'.replace(
                        ':userId',
                        userId
                    ),
                    method: 'GET',
                    success: function (response) {
                        if (response.success) {
                            // Format the menu access data for display
                            let menuAccessHtml = '<div class="menu-access-list">';
                            if (response.menuAccess && response.menuAccess.length > 0) {
                                // Group menu items by parent
                                const menuGroups = {};
                                const parentMenus = [];

                                // First pass: organize menus
                                response.menuAccess.forEach(function (menu) {
                                    if (!menu.parent_key) {
                                        parentMenus.push(menu);
                                    } else {
                                        if (!menuGroups[menu.parent_key]) {
                                            menuGroups[menu.parent_key] = [];
                                        }
                                        menuGroups[menu.parent_key].push(menu);
                                    }
                                });

                                // Second pass: display parent menus and their children
                                parentMenus.forEach(function (parentMenu) {
                                    menuAccessHtml += `
                                        <div class="menu-group mb-4">
                                            <div class="menu-parent">
                                                <h5>
                                                    <i class="${parentMenu.icon}"></i>
                                                    ${parentMenu.menu_name}
                                                </h5>
                                                <p class="text-muted">Access: ${parentMenu.access_type}</p>
                                            </div>
                                    `;

                                    // Add child menus if any
                                    const childMenus = menuGroups[parentMenu.menu_key] || [];
                                    if (childMenus.length > 0) {
                                        menuAccessHtml += '<div class="menu-children ps-4 mt-2">';
                                        childMenus.forEach(function (childMenu) {
                                            menuAccessHtml += `
                                                <div class="menu-item mb-2">
                                                    <h6>
                                                        <i class="${childMenu.icon}"></i>
                                                        ${childMenu.menu_name}
                                                    </h6>
                                                    <p class="text-muted mb-0">Access: ${childMenu.access_type}</p>
                                                </div>
                                            `;
                                        });
                                        menuAccessHtml += '</div>';
                                    }

                                    menuAccessHtml += '</div>';
                                });

                                // Add any remaining menus that don't have a parent
                                const standaloneMenus = response.menuAccess.filter(
                                    (menu) => !menu.parent_key && !parentMenus.find((p) => p.menu_key === menu.menu_key)
                                );

                                if (standaloneMenus.length > 0) {
                                    menuAccessHtml += '<div class="menu-standalone mt-4">';
                                    standaloneMenus.forEach(function (menu) {
                                        menuAccessHtml += `
                                            <div class="menu-item mb-3">
                                                <h5>
                                                    <i class="${menu.icon}"></i>
                                                    ${menu.menu_name}
                                                </h5>
                                                <p class="text-muted mb-0">Access: ${menu.access_type}</p>
                                            </div>
                                        `;
                                    });
                                    menuAccessHtml += '</div>';
                                }
                            } else {
                                menuAccessHtml += '<p class="text-muted">No menu access assigned.</p>';
                            }

                            menuAccessHtml += '</div>';

                            Swal.fire({
                                title: `Menu Access for ${userName}`,
                                html: menuAccessHtml,
                                width: '600px',
                                customClass: {
                                    container: 'menu-access-modal',
                                    popup: 'menu-access-popup',
                                },
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Failed to load menu access.',
                            });
                        }
                    },
                    error: function (xhr) {
                        console.error('Error:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to load menu access. Please try again.',
                        });
                    },
                });
            });
        });
    </script>

    <script>
        function deleteProfile(event, profileId, profileName) {
            event.stopPropagation();

            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to delete the profile "${profileName}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send delete request
                    fetch(`${window.location.origin}/company/user-profiles/${profileId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            Accept: 'application/json',
                        },
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 1500,
                                }).then(() => {
                                    // Remove the profile card from the DOM
                                    const profileCard = document.querySelector(`[data-profile-id="${profileId}"]`);
                                    if (profileCard) {
                                        profileCard.remove();
                                    }

                                    // If no profiles left, show the empty state
                                    const profileList = document.querySelector('.profile-list');
                                    if (!profileList.querySelector('.profile-card')) {
                                        profileList.innerHTML = `
                                        <div class="text-center py-4">
                                            <i class="ri-folder-user-line h1 text-muted"></i>
                                            <p class="mt-2">No profiles found</p>
                                        </div>
                                    `;
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: data.message,
                                });
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'An error occurred while deleting the profile.',
                            });
                        });
                }
            });
        }
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500,
            });
        </script>
    @endif
@endsection
