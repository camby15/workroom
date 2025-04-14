@extends('layouts.vertical', ['page_title' => 'Product Configuration'])

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

        /* Product card styling */
        .product-card {
            background: var(--#{$prefix}card-bg);
            border: 1px solid var(--#{$prefix}border-color);
            border-radius: 0.5rem;
            padding: 1.25rem;
            transition: all 0.3s ease;
        }

        [data-bs-theme="dark"] .product-card {
            background: var(--#{$prefix}dark);
            border-color: var(--#{$prefix}gray-700);
        }

        .product-card:hover {
            transform: translateY(-2px);
            border-color: var(--#{$prefix}primary);
            box-shadow: 0 3px 10px rgba(var(--#{$prefix}dark-rgb), 0.1);
        }

        /* Loading placeholder */
        .placeholder-wave {
            mask: linear-gradient(130deg, #000 55%, rgba(0, 0, 0, 0.8) 75%, #000 95%) right/300% 100%;
            animation: shimmer 2s infinite;
            background: var(--#{$prefix}gray-200);
        }

        [data-bs-theme="dark"] .placeholder-wave {
            background: var(--#{$prefix}gray-700);
        }

        @keyframes shimmer {
            100% { mask-position: left }
        }

        /* Status indicators */
        .status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-badge.active {
            background: rgba(var(--#{$prefix}success-rgb), 0.1);
            color: var(--#{$prefix}success);
        }

        .status-badge.inactive {
            background: rgba(var(--#{$prefix}danger-rgb), 0.1);
            color: var(--#{$prefix}danger);
        }

        [data-bs-theme="dark"] .status-badge {
            filter: brightness(1.2);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 2rem;
            border: 2px dashed var(--#{$prefix}border-color);
            border-radius: 0.5rem;
            margin: 1rem 0;
        }

        [data-bs-theme="dark"] .empty-state {
            border-color: var(--#{$prefix}gray-700);
        }

        /* Form group improvements */
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
        .product-card {
            border-radius: 10px;
            transition: all 0.3s;
            background-color: var(--#{$prefix}card-bg);
            border: 1px solid var(--#{$prefix}border-color);
            padding: 1.25rem;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(var(--#{$prefix}dark-rgb), 0.1);
        }
        .product-item {
            padding: 1rem;
            margin-bottom: 0.5rem;
            border: 1px solid var(--#{$prefix}border-color);
            border-radius: 0.5rem;
            background: var(--#{$prefix}card-bg);
        }
        .product-item.featured {
            border-left: 4px solid var(--#{$prefix}primary);
        }
        .product-item.variant {
            margin-left: 2rem;
            border-left: 4px solid var(--#{$prefix}success);
        }
        .placeholder-item {
            border: 2px dashed var(--#{$prefix}primary);
            border-radius: 0.5rem;
            margin: 0.5rem 0;
            padding: 1rem;
            background: var(--#{$prefix}tertiary-bg);
        }
        .form-switch .form-check-input {
            width: 2.5em;
            margin-left: -2.9em;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%280, 0, 0, 0.25%29'/%3e%3c/svg%3e");
            background-position: left center;
            border-radius: 2em;
            transition: background-position .15s ease-in-out;
        }
        /* Add hover state for form controls */
        .form-floating input.form-control:hover ~ label,
        .form-floating select.form-select:hover ~ label {
            color: #000;
        }
        /* Ensure text is black when input has content */
        .form-floating input.form-control,
        .form-floating select.form-select {
            color: #000;
        }
        /* Style placeholder text */
        .form-floating input.form-control::placeholder {
            color: rgba(0, 0, 0, 0.5);
        }
        .form-floating input.form-control:hover::placeholder {
            color: #000;
        }
        .config-card {
            border-radius: 15px;
            margin-bottom: 1.5rem;
            transition: transform 0.3s;
        }
        .config-card:hover {
            transform: translateY(-5px);
        }
        .workflow-step {
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-bottom: 1rem;
            position: relative;
        }
        .workflow-step .step-number {
            position: absolute;
            top: -10px;
            left: -10px;
            width: 25px;
            height: 25px;
            background: #033c42;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }
        .checklist-item {
            padding: 0.5rem;
            border-bottom: 1px solid #eee;
        }
        .notification-toggle {
            padding: 1rem;
            border-radius: 10px;
            background: #f8f9fa;
            margin-bottom: 0.5rem;
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
                            <li class="breadcrumb-item">Products</li>
                            <li class="breadcrumb-item active">Product Configuration</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Product Configuration</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Document Generation Configuration -->
            <div class="col-xl-6">
                <div class="card config-card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Document Generation</h4>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="enableDocGen">
                            <label class="form-check-label" for="enableDocGen">Enable Document Generation</label>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#documentConfigModal">
                                <i class="ri-settings-4-line me-1"></i> Configure Documents
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Requirements Checklist -->
            <div class="col-xl-6">
                <div class="card config-card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Requirements Checklist</h4>
                        <div class="checklist-container">
                            <div id="checklistItems">
                                <!-- Checklist items will be dynamically added here -->
                            </div>
                            <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#checklistModal">
                                <i class="ri-add-line me-1"></i> Manage Requirements
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Workflow Configuration -->
            <div class="col-12">
                <div class="card config-card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Workflow Configuration</h4>
                        <div class="workflow-container">
                            <div id="workflowSteps">
                                <!-- Workflow steps will be dynamically added here -->
                            </div>
                            <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#workflowModal">
                                <i class="ri-flow-chart me-1"></i> Modify Workflow
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification Configuration -->
            <div class="col-12">
                <div class="card config-card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Notification Settings</h4>
                        <div class="notification-container">
                            <div class="notification-toggle">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="emailNotif">
                                    <label class="form-check-label" for="emailNotif">Email Notifications</label>
                                </div>
                            </div>
                            <div class="notification-toggle">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="smsNotif">
                                    <label class="form-check-label" for="smsNotif">SMS Notifications</label>
                                </div>
                            </div>
                            <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#notificationConfigModal">
                                <i class="ri-notification-4-line me-1"></i> Configure Notifications
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Document Configuration Modal -->
    <div class="modal fade" id="documentConfigModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Document Configuration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="documentConfigForm">
                        <div class="mb-3">
                            <label class="form-label">Document Templates</label>
                            <select class="form-select" multiple id="documentTemplates">
                                <option value="template1">Invoice Template</option>
                                <option value="template2">Receipt Template</option>
                                <option value="template3">Contract Template</option>
                            </select>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="outputPath" placeholder=" ">
                            <label for="outputPath">Output Directory Path</label>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="autoGenerate">
                            <label class="form-check-label" for="autoGenerate">Auto-generate on completion</label>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Configuration</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Checklist Configuration Modal -->
    <div class="modal fade" id="checklistModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage Requirements Checklist</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="checklistForm">
                        <div id="checklistBuilder">
                            <div class="checklist-item mb-2">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Requirement description">
                                    <button type="button" class="btn btn-danger"><i class="ri-delete-bin-line"></i></button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm mt-2" id="addChecklistItem">
                            <i class="ri-add-line"></i> Add Requirement
                        </button>
                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Checklist</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Workflow Configuration Modal -->
    <div class="modal fade" id="workflowModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Workflow Configuration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="workflowForm">
                        <div id="workflowBuilder">
                            <div class="workflow-step">
                                <span class="step-number">1</span>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" placeholder=" ">
                                            <label>Step Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-2">
                                            <select class="form-select">
                                                <option value="">Select Assignee</option>
                                                <option value="role1">Manager</option>
                                                <option value="role2">Supervisor</option>
                                            </select>
                                            <label>Assignee</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm mt-2" id="addWorkflowStep">
                            <i class="ri-add-line"></i> Add Step
                        </button>
                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Workflow</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Configuration Modal -->
    <div class="modal fade" id="notificationConfigModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Configure Notifications</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="notificationConfigForm">
                        <!-- Email Configuration -->
                        <div class="mb-3">
                            <h6>Email Notifications</h6>
                            <div class="form-floating mb-2">
                                <input type="email" class="form-control" id="emailRecipients" placeholder=" ">
                                <label for="emailRecipients">Recipients (comma-separated)</label>
                            </div>
                            <div class="form-floating">
                                <textarea class="form-control" id="emailTemplate" style="height: 100px" placeholder=" "></textarea>
                                <label for="emailTemplate">Email Template</label>
                            </div>
                        </div>

                        <!-- SMS Configuration -->
                        <div class="mb-3">
                            <h6>SMS Notifications</h6>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" id="phoneNumbers" placeholder=" ">
                                <label for="phoneNumbers">Phone Numbers (comma-separated)</label>
                            </div>
                            <div class="form-floating">
                                <textarea class="form-control" id="smsTemplate" style="height: 100px" placeholder=" "></textarea>
                                <label for="smsTemplate">SMS Template</label>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Add Checklist Item
            $('#addChecklistItem').click(function() {
                const newItem = `
                    <div class="checklist-item mb-2">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Requirement description">
                            <button type="button" class="btn btn-danger"><i class="ri-delete-bin-line"></i></button>
                        </div>
                    </div>
                `;
                $('#checklistBuilder').append(newItem);
            });

            // Add Workflow Step
            $('#addWorkflowStep').click(function() {
                const stepCount = $('.workflow-step').length + 1;
                const newStep = `
                    <div class="workflow-step">
                        <span class="step-number">${stepCount}</span>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" placeholder=" ">
                                    <label>Step Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-2">
                                    <select class="form-select">
                                        <option value="">Select Assignee</option>
                                        <option value="role1">Manager</option>
                                        <option value="role2">Supervisor</option>
                                    </select>
                                    <label>Assignee</label>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                $('#workflowBuilder').append(newStep);
            });

            // Remove Checklist Item
            $(document).on('click', '.checklist-item .btn-danger', function() {
                $(this).closest('.checklist-item').remove();
            });

            // Form Submissions
            $('#documentConfigForm, #checklistForm, #workflowForm, #notificationConfigForm').on('submit', function(e) {
                e.preventDefault();
                // Add your form submission logic here
                $(this).closest('.modal').modal('hide');
            });
        });
    </script>
@endsection
