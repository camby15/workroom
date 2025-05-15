@extends('layouts.vertical', ['page_title' => 'Human Resource Management'])

@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
           'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
           'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css',
           'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" (https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css") rel="stylesheet">
    <style>
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

        /* Tab Menu Styles */
        .nav-pills {
            border-right: 1px solid #dee2e6;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow-y: auto;
        }
        .nav-pills .nav-link {
            padding: 1.25rem 1rem;
            color: #2f2f2f;
            border-radius: 0;
            transition: all 0.3s;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            width: 100%;
            justify-content: flex-start;
        }
        .nav-pills .nav-link:hover {
            background-color: #f8f9fa;
        }
        .nav-pills .nav-link.active {
            background-color: #2f2f2f;
            color: #fff;
        }
        .nav-pills .nav-link i {
            width: 24px;
            text-align: center;
            font-size: 1.25rem;
            transition: all 0.3s;
            border-radius: 5px;
            padding: 0.25rem;
        }
        
        /* Icon Colors */
        #v-pills-employees-tab i { color: #198754; } /* Green */
        #v-pills-attendance-tab i { color: #0d6efd; } /* Blue */
        #v-pills-leaves-tab i { color: #fd7e14; } /* Orange */
        #v-pills-performance-tab i { color: #6c757d; } /* Gray */
        #v-pills-training-tab i { color: #03586a; } /* Cyan */
        #v-pills-benefits-tab i { color: #6610f2; } /* Purple */
        #v-pills-relations-tab i { color: #fd7e14; } /* Orange */
        #v-pills-recruitment-tab i { color: #20c997; } /* Teal */
        #v-pills-documentation-tab i { color: #6f42c1; } /* Indigo */
        #v-pills-jobs-tab i { color: #dc3545; } /* Red */
        #v-pills-exit-tab i { color: #d63384; } /* Pink */
        #v-pills-compliance-tab i { color: #20c997; } /* Teal */

        .nav-pills .nav-link.active i {
            color: #fff;
        }

        /* Tab Content Styles */
        .tab-content {
            padding: 20px;
            height: calc(100vh - 120px);
            overflow-y: auto;
        }
        .card {
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        .card-header h5 {
            margin: 0;
            font-size: 1.1rem;
        }
        .card-header .btn {
            padding: 0.5rem 1rem;
        }

        /* Dark mode styles */
        [data-bs-theme="dark"] .nav-pills .nav-link {
            color: #adb5bd;
        }
        [data-bs-theme="dark"] .nav-pills .nav-link:hover {
            background-color: #343a40;
        }
        [data-bs-theme="dark"] .nav-pills .nav-link.active {
            background-color: #0dcaf0;
            color: #1a1e21;
        }
        [data-bs-theme="dark"] .card-header {
            background-color: #2c3034;
            border-bottom-color: #343a40;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Human Resource Management</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">Human Resource Management</li>
                        </ol>
                    </div
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Tab Menu -->
            <div class="col-md-3 col-lg-2">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="v-pills-employees-tab" data-bs-toggle="pill" data-bs-target="#v-pills-employees" type="button" role="tab" aria-controls="v-pills-employees" aria-selected="true">
                        <i class="fas fa-users me-2"></i>Employee Database 
                    </button>
                    <button class="nav-link" id="v-pills-attendance-tab" data-bs-toggle="pill" data-bs-target="#v-pills-attendance" type="button" role="tab" aria-controls="v-pills-attendance" aria-selected="false">
                        <i class="fas fa-calendar-check me-2"></i>Attendance
                    </button>
                    <button class="nav-link" id="v-pills-leaves-tab" data-bs-toggle="pill" data-bs-target="#v-pills-leaves" type="button" role="tab" aria-controls="v-pills-leaves" aria-selected="false">
                        <i class="fas fa-umbrella-beach me-2"></i>Leaves
                    </button>

                    <button class="nav-link" id="v-pills-performance-tab" data-bs-toggle="pill" data-bs-target="#v-pills-performance" type="button" role="tab" aria-controls="v-pills-performance" aria-selected="false">
                        <i class="fas fa-chart-line me-2"></i>Performance
                    </button>
                    <button class="nav-link" id="v-pills-training-tab" data-bs-toggle="pill" data-bs-target="#v-pills-training" type="button" role="tab" aria-controls="v-pills-training" aria-selected="false">
                        <i class="fas fa-graduation-cap me-2"></i>Training & Development
                    </button>
                    <button class="nav-link" id="v-pills-benefits-tab" data-bs-toggle="pill" data-bs-target="#v-pills-benefits" type="button" role="tab" aria-controls="v-pills-benefits" aria-selected="false">
                        <i class="fas fa-gift me-2"></i>Benefits
                    </button>
                    <button class="nav-link" id="v-pills-relations-tab" data-bs-toggle="pill" data-bs-target="#v-pills-relations" type="button" role="tab" aria-controls="v-pills-relations" aria-selected="false">
                        <i class="fas fa-handshake me-2"></i>Employee Relations
                    </button>
                    <button class="nav-link" id="v-pills-recruitment-tab" data-bs-toggle="pill" data-bs-target="#v-pills-recruitment" type="button" role="tab" aria-controls="v-pills-recruitment" aria-selected="false">
                        <i class="fas fa-search me-2"></i>Recruitment
                    </button>
                    <button class="nav-link" id="v-pills-documentation-tab" data-bs-toggle="pill" data-bs-target="#v-pills-documentation" type="button" role="tab" aria-controls="v-pills-documentation" aria-selected="false">
                        <i class="fas fa-file-alt me-2"></i>Documentation
                    </button>
                    <button class="nav-link" id="v-pills-jobs-tab" data-bs-toggle="pill" data-bs-target="#v-pills-jobs" type="button" role="tab" aria-controls="v-pills-jobs" aria-selected="false">
                        <i class="fas fa-briefcase me-2"></i>Jobs
                    </button>
                    <button class="nav-link" id="v-pills-exit-tab" data-bs-toggle="pill" data-bs-target="#v-pills-exit" type="button" role="tab" aria-controls="v-pills-exit" aria-selected="false">
                        <i class="fas fa-sign-out-alt me-2"></i>Exit
                    </button>
                    <button class="nav-link" id="v-pills-compliance-tab" data-bs-toggle="pill" data-bs-target="#v-pills-compliance" type="button" role="tab" aria-controls="v-pills-compliance" aria-selected="false">
                        <i class="fas fa-shield-alt me-2"></i>Compliance
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="col-md-9 col-lg-10">
                <div class="tab-content" id="v-pills-tabContent">
                    <!-- Employees Tab -->
                    <div class="tab-pane fade show active" id="v-pills-employees" role="tabpanel" aria-labelledby="v-pills-employees-tab">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Employee Database</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                                    <i class="fas fa-plus me-2"></i>Add Employee
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Employee ID</th>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Department</th>
                                                <th>Join Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>EMP001</td>
                                                <td>John Doe</td>
                                                <td>Senior Developer</td>
                                                <td>IT</td>
                                                <td>2023-01-15</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editEmployeeModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#terminateEmployeeModal" title="Terminate">
                                                            <i class="fas fa-user-times"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewEmployeeModal" title="View Profile">
                                                            <i class="fas fa-user"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>EMP002</td>
                                                <td>Jane Smith</td>
                                                <td>Marketing Manager</td>
                                                <td>Marketing</td>
                                                <td>2022-06-20</td>
                                                <td><span class="badge bg-info">On Leave</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editEmployeeModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#terminateEmployeeModal" title="Terminate">
                                                            <i class="fas fa-user-times"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewEmployeeModal" title="View Profile">
                                                            <i class="fas fa-user"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Tab -->
                    <div class="tab-pane fade" id="v-pills-attendance" role="tabpanel" aria-labelledby="v-pills-attendance-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="fw-bold text-primary"><i class="fas fa-calendar-check me-2"></i>Attendance Management</h4>
                            <div class="d-flex align-items-center gap-2">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search attendance records..." id="attendance-search">
                                    <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                                </div>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#attendanceModal">
                                    <i class="fas fa-plus me-2"></i>Mark Attendance
                                </button>
                            </div>
                        </div>
                        
                        <!-- Device Sync Card -->
                        <div class="card mb-4 shadow-sm border-0 rounded-3 overflow-hidden">
                            <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center py-3">
                                <h5 class="mb-0 fw-bold"><i class="fas fa-wifi me-2"></i>Attendance Device Integration</h5>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-light btn-sm" onclick="syncAttendanceDevice()">
                                        <i class="fas fa-sync-alt me-1"></i>Sync Now
                                    </button>
                                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#deviceSettingsModal">
                                        <i class="fas fa-cog me-1"></i>Settings
                                    </button>
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-file-export me-1"></i>Export
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="exportDropdown">
                                            <li><a class="dropdown-item" href="#" onclick="exportAttendance('csv')"><i class="fas fa-file-csv me-2 text-success"></i>CSV</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="exportAttendance('excel')"><i class="fas fa-file-excel me-2 text-success"></i>Excel</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="exportAttendance('pdf')"><i class="fas fa-file-pdf me-2 text-danger"></i>PDF</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#emailReportModal"><i class="fas fa-envelope me-2 text-primary"></i>Email Report</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body py-4">
                                <div class="row g-3">
                                    <div class="col-md-6 col-lg-3">
                                        <div class="card h-100 bg-light border-0 rounded-3 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="p-2 rounded-circle me-3 bg-primary bg-opacity-10">
                                                        <i class="fas fa-history text-primary"></i>
                                                    </div>
                                                    <h6 class="card-title mb-0 text-primary">Last Sync</h6>
                                                </div>
                                                <h5 class="fw-bold mb-1" id="lastSyncStatus">Not synced yet</h5>
                                                <p class="card-text small text-muted" id="lastSyncTime">Never</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="card h-100 bg-light border-0 rounded-3 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="p-2 rounded-circle me-3 bg-success bg-opacity-10">
                                                        <i class="fas fa-check-circle text-success"></i>
                                                    </div>
                                                    <h6 class="card-title mb-0 text-success">Device Status</h6>
                                                </div>
                                                <h5 class="fw-bold mb-1" id="deviceStatus">Offline</h5>
                                                <p class="card-text small text-muted" id="deviceInfo">No device connected</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="card h-100 bg-light border-0 rounded-3 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="p-2 rounded-circle me-3 bg-info bg-opacity-10">
                                                        <i class="fas fa-users text-info"></i>
                                                    </div>
                                                    <h6 class="card-title mb-0 text-info">Today's Attendance</h6>
                                                </div>
                                                <h5 class="fw-bold mb-1" id="todayAttendanceCount">0/0</h5>
                                                <p class="card-text small text-muted">Employees present</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="card h-100 bg-light border-0 rounded-3 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="p-2 rounded-circle me-3 bg-warning bg-opacity-10">
                                                        <i class="fas fa-exclamation-triangle text-warning"></i>
                                                    </div>
                                                    <h6 class="card-title mb-0 text-warning">Anomalies</h6>
                                                </div>
                                                <h5 class="fw-bold mb-1" id="attendanceAnomalies">0</h5>
                                                <p class="card-text small text-muted">Issues detected</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Attendance Records Card -->
                        <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                                <h5 class="mb-0 fw-bold"><i class="fas fa-clipboard-list me-2 text-primary"></i>Attendance Records</h5>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="btn-group" role="group">
                                        <input type="radio" class="btn-check" name="attendanceFilter" id="today" autocomplete="off" checked>
                                        <label class="btn btn-outline-primary btn-sm" for="today">Today</label>
                                        
                                        <input type="radio" class="btn-check" name="attendanceFilter" id="thisWeek" autocomplete="off">
                                        <label class="btn btn-outline-primary btn-sm" for="thisWeek">This Week</label>
                                        
                                        <input type="radio" class="btn-check" name="attendanceFilter" id="thisMonth" autocomplete="off">
                                        <label class="btn btn-outline-primary btn-sm" for="thisMonth">This Month</label>
                                        
                                        <input type="radio" class="btn-check" name="attendanceFilter" id="custom" autocomplete="off">
                                        <label class="btn btn-outline-primary btn-sm" for="custom">Custom</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="ps-4">Employee</th>
                                                <th>Date</th>
                                                <th>Clock In</th>
                                                <th>Clock Out</th>
                                                <th>Hours</th>
                                                <th>Status</th>
                                                <th class="text-end pe-4">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-sm me-2 bg-primary text-white rounded-circle">
                                                            <span>JD</span>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">John Doe</h6>
                                                            <small class="text-muted">ID: EMP001</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-nowrap">2025-04-04</span>
                                                </td>
                                                <td>
                                                    <span class="text-nowrap"><i class="fas fa-sign-in-alt text-success me-1"></i>09:00 AM</span>
                                                </td>
                                                <td>
                                                    <span class="text-nowrap"><i class="fas fa-sign-out-alt text-danger me-1"></i>06:00 PM</span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold">9.00</span>
                                                </td>
                                                <td>
                                                    <div class="d-inline-block px-3 py-1 rounded-pill bg-success bg-opacity-10 text-success fw-bold small">Present</div>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editAttendanceModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAttendanceModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewAttendanceModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-sm me-2 bg-info text-white rounded-circle">
                                                            <span>JS</span>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">Jane Smith</h6>
                                                            <small class="text-muted">ID: EMP002</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-nowrap">2025-04-04</span>
                                                </td>
                                                <td>
                                                    <span class="text-nowrap"><i class="fas fa-sign-in-alt text-warning me-1"></i>09:30 AM</span>
                                                </td>
                                                <td>
                                                    <span class="text-nowrap"><i class="fas fa-sign-out-alt text-danger me-1"></i>05:30 PM</span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold">8.00</span>
                                                </td>
                                                <td>
                                                    <div class="d-inline-block px-3 py-1 rounded-pill bg-warning bg-opacity-10 text-warning fw-bold small">Late</div>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editAttendanceModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAttendanceModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewAttendanceModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-between align-items-center p-3 border-top">
                                    <div class="small text-muted">Showing 2 of 2 records</div>
                                    <nav aria-label="Attendance pagination">
                                        <ul class="pagination pagination-sm mb-0">
                                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Leaves Tab -->
                    <div class="tab-pane fade" id="v-pills-leaves" role="tabpanel" aria-labelledby="v-pills-leaves-tab">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Leaves</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leaveModal">
                                    <i class="fas fa-plus me-2"></i>Apply Leave
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Leave Type</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>John Doe</td>
                                                <td>Vacation</td>
                                                <td>2025-04-10</td>
                                                <td>2025-04-15</td>
                                                <td><span class="badge bg-warning">Pending</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#approveLeaveModal" title="Approve">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectLeaveModal" title="Reject">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewLeaveModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jane Smith</td>
                                                <td>Sick Leave</td>
                                                <td>2025-04-05</td>
                                                <td>2025-04-06</td>
                                                <td><span class="badge bg-success">Approved</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#approveLeaveModal" title="Approve">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectLeaveModal" title="Reject">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewLeaveModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Tab -->
                    <div class="tab-pane fade" id="v-pills-performance" role="tabpanel" aria-labelledby="v-pills-performance-tab">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Performance</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#performanceModal">
                                    <i class="fas fa-plus me-2"></i>Add Review
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Review Period</th>
                                                <th>Rating</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>John Doe</td>
                                                <td>Q1 2025</td>
                                                <td><span class="badge bg-success">Excellent</span></td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editPerformanceModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletePerformanceModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewPerformanceModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#generateReportModal" title="Generate Report">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jane Smith</td>
                                                <td>Q1 2025</td>
                                                <td><span class="badge bg-warning">Good</span></td>
                                                <td><span class="badge bg-warning">In Progress</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editPerformanceModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletePerformanceModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewPerformanceModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#generateReportModal" title="Generate Report">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Training & Development Tab -->
                    <div class="tab-pane fade" id="v-pills-training" role="tabpanel" aria-labelledby="v-pills-training-tab">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Training & Development</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#trainingModal">
                                    <i class="fas fa-plus me-2"></i>Add Training Program
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Training Title</th>
                                                <th>Type</th>
                                                <th>Start Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Leadership Development Program</td>
                                                <td>Blended</td>
                                                <td>2025-04-01</td>
                                                <td><span class="badge bg-success">In Progress</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#trainingModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTrainingModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#trainingDetailsModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Digital Marketing Workshop</td>
                                                <td>Online</td>
                                                <td>2025-04-15</td>
                                                <td><span class="badge bg-warning">Planned</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#trainingModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTrainingModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#trainingDetailsModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Benefits & Perks Tab -->
                    <div class="tab-pane fade" id="v-pills-benefits" role="tabpanel" aria-labelledby="v-pills-benefits-tab">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Benefits</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#benefitsModal">
                                    <i class="fas fa-plus me-2"></i>Add Benefit
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Benefit Name</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Frequency</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Health Insurance</td>
                                                <td>Health</td>
                                                <td>$500</td>
                                                <td>Monthly</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#benefitsModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBenefitModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#benefitDetailsModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Retirement Plan</td>
                                                <td>Retirement</td>
                                                <td>$1000</td>
                                                <td>Annual</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#benefitsModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBenefitModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#benefitDetailsModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employee Relations Tab -->
                    <div class="tab-pane fade" id="v-pills-relations" role="tabpanel" aria-labelledby="v-pills-relations-tab">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Employee Relations</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#relationsModal">
                                    <i class="fas fa-plus me-2"></i>Handle Grievance
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Priority</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>John Doe</td>
                                                <td>Workplace Issues</td>
                                                <td><span class="badge bg-warning">In Progress</span></td>
                                                <td><span class="badge bg-info">Medium</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#relationsModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteGrievanceModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#grievanceDetailsModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jane Smith</td>
                                                <td>Compensation</td>
                                                <td><span class="badge bg-success">Resolved</span></td>
                                                <td><span class="badge bg-danger">High</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#relationsModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteGrievanceModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#grievanceDetailsModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recruitment Tab -->
                    <div class="tab-pane fade" id="v-pills-recruitment" role="tabpanel" aria-labelledby="v-pills-recruitment-tab">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Recruitment</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#recruitmentModal">
                                    <i class="fas fa-plus me-2"></i>New Recruitment
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Job Title</th>
                                                <th>Department</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Senior Developer</td>
                                                <td>IT</td>
                                                <td>Full Time</td>
                                                <td><span class="badge bg-info">Active</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#recruitmentModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteJobModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#jobDetailsModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Marketing Manager</td>
                                                <td>Marketing</td>
                                                <td>Full Time</td>
                                                <td><span class="badge bg-warning">Paused</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#recruitmentModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteJobModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#jobDetailsModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documentation Tab -->
                    <div class="tab-pane fade" id="v-pills-documentation" role="tabpanel" aria-labelledby="v-pills-documentation-tab">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Documentation</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#documentationModal">
                                    <i class="fas fa-plus me-2"></i>Add Document
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Document Title</th>
                                                <th>Category</th>
                                                <th>Access Level</th>
                                                <th>Department</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Employee Handbook</td>
                                                <td>Policies</td>
                                                <td><span class="badge bg-success">Public</span></td>
                                                <td>All Departments</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#documentationModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteDocumentModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#documentDetailsModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#downloadDocumentModal" title="Download">
                                                            <i class="fas fa-download"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Performance Review Template</td>
                                                <td>Templates</td>
                                                <td><span class="badge bg-warning">Internal</span></td>
                                                <td>HR</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#documentationModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteDocumentModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#documentDetailsModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#downloadDocumentModal" title="Download">
                                                            <i class="fas fa-download"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jobs Tab -->
                    <div class="tab-pane fade" id="v-pills-jobs" role="tabpanel" aria-labelledby="v-pills-jobs-tab">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Jobs</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#jobsModal">
                                    <i class="fas fa-plus me-2"></i>Post Job Opening
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Job Title</th>
                                                <th>Department</th>
                                                <th>Location</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Senior Developer</td>
                                                <td>IT</td>
                                                <td>Remote</td>
                                                <td><span class="badge bg-info">Active</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#jobsModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteJobModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#jobDetailsModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Marketing Manager</td>
                                                <td>Marketing</td>
                                                <td>Office</td>
                                                <td><span class="badge bg-warning">Paused</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#jobsModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteJobModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#jobDetailsModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Exit Tab -->
                    <div class="tab-pane fade" id="v-pills-exit" role="tabpanel" aria-labelledby="v-pills-exit-tab">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Exit</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exitProcessModal">
                                    <i class="fas fa-plus me-2"></i>Process Employee Exit
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Exit Date</th>
                                                <th>Reason</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>John Doe</td>
                                                <td>2025-04-04</td>
                                                <td>Resignation</td>
                                                <td><span class="badge bg-success">Processed</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exitProcessModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteExitModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#exitDetailsModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jane Smith</td>
                                                <td>2025-04-04</td>
                                                <td>Termination</td>
                                                <td><span class="badge bg-warning">Pending</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exitProcessModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteExitModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#exitDetailsModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Compliance Tab -->
                    <div class="tab-pane fade" id="v-pills-compliance" role="tabpanel" aria-labelledby="v-pills-compliance-tab">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Compliance</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#complianceModal">
                                    <i class="fas fa-plus me-2"></i>Conduct Compliance Audit
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Audit Type</th>
                                                <th>Audit Date</th>
                                                <th>Department</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Internal</td>
                                                <td>2025-04-04</td>
                                                <td>HR</td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#complianceModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteComplianceModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#complianceDetailsModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>External</td>
                                                <td>2025-04-04</td>
                                                <td>Finance</td>
                                                <td><span class="badge bg-warning">Pending</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#complianceModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteComplianceModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#complianceDetailsModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
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
        </div>
    </div>

    <!-- Modals -->
    
    <!-- Add Employee Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmployeeModalLabel">Add New Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addEmployeeForm">
                        <!-- Personal Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Personal Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required>
                                            <label for="firstName">First Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required>
                                            <label for="lastName">Last Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                                            <label for="email"> Personal Email</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone Number" required>
                                            <label for="phone">Phone Number</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="gender" name="gender" required>
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                            <label for="gender">Gender</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="dob" name="dob" required>
                                            <label for="dob">Date of Birth</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="maritalStatus" name="maritalStatus" required>
                                                <option value="">Select Status</option>
                                                <option value="single">Single</option>
                                                <option value="married">Married</option>
                                                <option value="divorced">Divorced</option>
                                                <option value="widowed">Widowed</option>
                                            </select>
                                            <label for="maritalStatus">Marital Status</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Employment Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Employment Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="employeeId" name="employeeId" readonly>
                                            <label for="employeeId">Employee ID</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="department" name="department" required>
                                                <option value="">Select Department</option>
                                                <option value="hr">Human Resources</option>
                                                <option value="it">Information Technology</option>
                                                <option value="finance">Finance</option>
                                                <option value="marketing">Marketing</option>
                                                <option value="operations">Operations</option>
                                            </select>
                                            <label for="department">Department</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" required>
                                            <label for="designation">Designation</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="joiningDate" name="joiningDate" required>
                                            <label for="joiningDate">Joining Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="employeeType" name="employeeType" required>
                                                <option value="">Select Type</option>
                                                <option value="full-time">Full Time</option>
                                                <option value="part-time">Part Time</option>
                                                <option value="contract">Contract</option>
                                                <option value="intern">Intern</option>
                                            </select>
                                            <label for="employeeType">Employee Type</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="salary" name="salary" placeholder="0" required>
                                            <label for="salary">Monthly Salary</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="location" name="location" placeholder="Work Location" required>
                                            <label for="location">Work Location</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Emergency Contact</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="emergencyName" name="emergencyName" placeholder="Name" required>
                                            <label for="emergencyName">Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="emergencyRelation" name="emergencyRelation" placeholder="Relationship" required>
                                            <label for="emergencyRelation">Relationship</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control" id="emergencyPhone" name="emergencyPhone" placeholder="Phone Number" required>
                                            <label for="emergencyPhone">Phone Number</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="emergencyEmail" name="emergencyEmail" placeholder="name@example.com">
                                            <label for="emergencyEmail">Email</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Documents -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Documents</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="file" class="form-control" id="resume" name="resume" accept=".pdf,.doc,.docx">
                                            <label for="resume">Resume</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="file" class="form-control" id="idProof" name="idProof" accept=".pdf,.jpg,.jpeg,.png">
                                            <label for="idProof">ID Proof</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="file" class="form-control" id="addressProof" name="addressProof" accept=".pdf,.jpg,.jpeg,.png">
                                            <label for="addressProof">Address Proof</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="file" class="form-control" id="otherDocuments" name="otherDocuments" multiple>
                                            <label for="otherDocuments">Other Documents</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="generateEmployeeId()">Generate ID</button>
                            <button type="button" class="btn btn-success" onclick="submitEmployeeForm()">Save Employee</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Modal -->
    <div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="attendanceModalLabel"><i class="fas fa-calendar-check me-2"></i>Mark Attendance</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="attendanceForm">
                        <div class="card mb-4 shadow-sm border-0 rounded-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-bold"><i class="fas fa-info-circle me-2 text-primary"></i>Attendance Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="employeeId" required>
                                                <option value="">Select Employee</option>
                                                <!-- Employee options will be populated via AJAX -->
                                            </select>
                                            <label for="employeeId">Employee</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="attendanceDate" required>
                                            <label for="attendanceDate">Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="attendanceStatus" required>
                                                <option value="">Select Status</option>
                                                <option value="present">Present</option>
                                                <option value="absent">Absent</option>
                                                <option value="half-day">Half Day</option>
                                                <option value="leave">Leave</option>
                                            </select>
                                            <label for="attendanceStatus">Status</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="time" class="form-control" id="checkInTime">
                                            <label for="checkInTime">Check-in Time</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="time" class="form-control" id="checkOutTime">
                                            <label for="checkOutTime">Check-out Time</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Cancel</button>
                            <button type="submit" class="btn btn-primary" onclick="submitAttendanceForm(event)"><i class="fas fa-save me-2"></i>Save Attendance</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Attendance Modal -->
    <div class="modal fade" id="editAttendanceModal" tabindex="-1" aria-labelledby="editAttendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editAttendanceModalLabel"><i class="fas fa-edit me-2"></i>Edit Attendance</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAttendanceForm">
                        <input type="hidden" id="editAttendanceId">
                        <div class="card mb-4 shadow-sm border-0 rounded-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-bold"><i class="fas fa-info-circle me-2 text-primary"></i>Attendance Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="editEmployeeId" required disabled>
                                                <!-- Employee options will be populated via AJAX -->
                                            </select>
                                            <label for="editEmployeeId">Employee</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="editAttendanceDate" required>
                                            <label for="editAttendanceDate">Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="editAttendanceStatus" required>
                                                <option value="">Select Status</option>
                                                <option value="present">Present</option>
                                                <option value="absent">Absent</option>
                                                <option value="half-day">Half Day</option>
                                                <option value="leave">Leave</option>
                                            </select>
                                            <label for="editAttendanceStatus">Status</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="time" class="form-control" id="editCheckInTime">
                                            <label for="editCheckInTime">Check-in Time</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="time" class="form-control" id="editCheckOutTime">
                                            <label for="editCheckOutTime">Check-out Time</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Cancel</button>
                            <button type="submit" class="btn btn-primary" onclick="updateAttendanceForm(event)"><i class="fas fa-save me-2"></i>Update Attendance</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- View Attendance Modal -->
    <div class="modal fade" id="viewAttendanceModal" tabindex="-1" aria-labelledby="viewAttendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="viewAttendanceModalLabel"><i class="fas fa-eye me-2"></i>Attendance Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card shadow-sm border-0 rounded-3 mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <div class="avatar avatar-lg bg-primary text-white rounded-circle me-3">
                                    <span id="viewEmployeeInitials">JD</span>
                                </div>
                                <div>
                                    <h5 class="mb-0" id="viewEmployeeName">John Doe</h5>
                                    <p class="text-muted mb-0" id="viewEmployeeId">EMP001</p>
                                </div>
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-light">
                                        <h6 class="text-muted mb-1">Date</h6>
                                        <p class="mb-0 fw-bold" id="viewAttendanceDate">2025-04-04</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-light">
                                        <h6 class="text-muted mb-1">Status</h6>
                                        <div id="viewAttendanceStatus"><span class="badge bg-success">Present</span></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-light">
                                        <h6 class="text-muted mb-1">Check In</h6>
                                        <p class="mb-0 fw-bold" id="viewCheckInTime">09:00 AM</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-light">
                                        <h6 class="text-muted mb-1">Check Out</h6>
                                        <p class="mb-0 fw-bold" id="viewCheckOutTime">06:00 PM</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 border rounded bg-light">
                                        <h6 class="text-muted mb-1">Total Hours</h6>
                                        <p class="mb-0 fw-bold" id="viewTotalHours">9.00 hours</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Close</button>
                        <button type="button" class="btn btn-outline-primary" onclick="openEditAttendanceModal()"><i class="fas fa-edit me-2"></i>Edit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Attendance Modal -->
    <div class="modal fade" id="deleteAttendanceModal" tabindex="-1" aria-labelledby="deleteAttendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteAttendanceModalLabel"><i class="fas fa-trash me-2"></i>Delete Attendance</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="deleteAttendanceId">
                    <div class="text-center mb-4">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 5rem;"></i>
                        <h4 class="mt-3">Confirm Deletion</h4>
                        <p>Are you sure you want to delete this attendance record? This action cannot be undone.</p>
                    </div>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="deleteAttendance()"><i class="fas fa-trash me-2"></i>Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Device Settings Modal -->
    <div class="modal fade" id="deviceSettingsModal" tabindex="-1" aria-labelledby="deviceSettingsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="deviceSettingsModalLabel"><i class="fas fa-cog me-2"></i>Attendance Device Settings</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="deviceSettingsForm">
                        <div class="card shadow-sm border-0 rounded-3 mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-bold"><i class="fas fa-server me-2 text-primary"></i>Device Connection</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="deviceIp" placeholder="192.168.1.100">
                                            <label for="deviceIp">Device IP Address</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="devicePort" placeholder="8000">
                                            <label for="devicePort">Port</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="deviceUsername" placeholder="admin">
                                            <label for="deviceUsername">Username</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="devicePassword" placeholder="password">
                                            <label for="devicePassword">Password</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card shadow-sm border-0 rounded-3 mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-bold"><i class="fas fa-sync-alt me-2 text-primary"></i>Sync Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="syncFrequency">
                                                <option value="0">Manual Only</option>
                                                <option value="15">Every 15 minutes</option>
                                                <option value="30">Every 30 minutes</option>
                                                <option value="60">Every hour</option>
                                                <option value="360">Every 6 hours</option>
                                                <option value="720">Every 12 hours</option>
                                                <option value="1440">Once daily</option>
                                            </select>
                                            <label for="syncFrequency">Sync Frequency</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="time" class="form-control" id="dailySyncTime">
                                            <label for="dailySyncTime">Daily Sync Time</label>
                                            <small class="text-muted">Only applies if frequency is set to "Once daily"</small>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="autoSyncEnabled">
                                            <label class="form-check-label" for="autoSyncEnabled">Enable Automatic Sync</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="saveDeviceSettings()"><i class="fas fa-save me-2"></i>Save Settings</button>
                            <button type="button" class="btn btn-success" onclick="testDeviceConnection()"><i class="fas fa-plug me-2"></i>Test Connection</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Email Report Modal -->
    <div class="modal fade" id="emailReportModal" tabindex="-1" aria-labelledby="emailReportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="emailReportModalLabel"><i class="fas fa-envelope me-2"></i>Email Attendance Report</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="emailReportForm">
                        <div class="card shadow-sm border-0 rounded-3 mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-bold"><i class="fas fa-file-export me-2 text-primary"></i>Report Parameters</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="reportType">
                                                <option value="daily">Daily Report</option>
                                                <option value="weekly">Weekly Report</option>
                                                <option value="monthly">Monthly Report</option>
                                                <option value="custom">Custom Date Range</option>
                                            </select>
                                            <label for="reportType">Report Type</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="reportFormat">
                                                <option value="pdf">PDF</option>
                                                <option value="excel">Excel</option>
                                                <option value="csv">CSV</option>
                                            </select>
                                            <label for="reportFormat">Format</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 date-range-inputs" style="display: none;">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="reportStartDate">
                                            <label for="reportStartDate">Start Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 date-range-inputs" style="display: none;">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="reportEndDate">
                                            <label for="reportEndDate">End Date</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card shadow-sm border-0 rounded-3 mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-bold"><i class="fas fa-envelope-open-text me-2 text-primary"></i>Email Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="recipientEmail" placeholder="email@example.com" required>
                                            <label for="recipientEmail">Recipient Email</label>
                                            <small class="text-muted">Use comma to separate multiple emails</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="emailSubject" placeholder="Attendance Report">
                                            <label for="emailSubject">Subject</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="emailMessage" style="height: 100px"></textarea>
                                            <label for="emailMessage">Message (Optional)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="sendAttendanceReport()"><i class="fas fa-paper-plane me-2"></i>Send Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Request Modal -->
    <div class="modal fade" id="leaveRequestModal" tabindex="-1" aria-labelledby="leaveRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leaveRequestModalLabel">Request Leave</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="leaveRequestForm">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Leave Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="leaveEmployeeId" required>
                                                <option value="">Select Employee</option>
                                                <!-- Employee options will be populated via AJAX -->
                                            </select>
                                            <label for="leaveEmployeeId">Employee</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="leaveStartDate" required>
                                            <label for="leaveStartDate">Start Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="leaveEndDate" required>
                                            <label for="leaveEndDate">End Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="leaveType" required>
                                                <option value="">Select Type</option>
                                                <option value="casual">Casual Leave</option>
                                                <option value="sick">Sick Leave</option>
                                                <option value="vacation">Vacation</option>
                                                <option value="maternity">Maternity Leave</option>
                                            </select>
                                            <label for="leaveType">Leave Type</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="leaveReason" rows="3" required></textarea>
                                            <label for="leaveReason">Reason for Leave</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" onclick="submitLeaveRequestForm(event)">Submit Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Review Modal -->
    <div class="modal fade" id="performanceReviewModal" tabindex="-1" aria-labelledby="performanceReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="performanceReviewModalLabel">Conduct Performance Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="performanceReviewForm">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Employee Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="reviewEmployeeId" required>
                                                <option value="">Select Employee</option>
                                                <!-- Employee options will be populated via AJAX -->
                                            </select>
                                            <label for="reviewEmployeeId">Employee</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="reviewDepartment" required>
                                                <option value="">Select Department</option>
                                                <option value="hr">Human Resources</option>
                                                <option value="it">Information Technology</option>
                                                <option value="finance">Finance</option>
                                                <option value="marketing">Marketing</option>
                                                <option value="operations">Operations</option>
                                            </select>
                                            <label for="reviewDepartment">Department</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="reviewPosition" required>
                                                <option value="">Select Position</option>
                                                <!-- Position options will be populated via AJAX -->
                                            </select>
                                            <label for="reviewPosition">Position</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Review Period</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="reviewPeriod" required>
                                                <option value="">Select Period</option>
                                                <option value="monthly">Monthly</option>
                                                <option value="quarterly">Quarterly</option>
                                                <option value="annual">Annual</option>
                                            </select>
                                            <label for="reviewPeriod">Review Period</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="reviewStartDate" required>
                                            <label for="reviewStartDate">Start Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="reviewEndDate" required>
                                            <label for="reviewEndDate">End Date</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Performance Metrics</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="qualityScore" min="0" max="100" required>
                                            <label for="qualityScore">Quality Score (%)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="productivityScore" min="0" max="100" required>
                                            <label for="productivityScore">Productivity Score (%)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="teamworkScore" min="0" max="100" required>
                                            <label for="teamworkScore">Teamwork Score (%)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="initiativeScore" min="0" max="100" required>
                                            <label for="initiativeScore">Initiative Score (%)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="communicationScore" min="0" max="100" required>
                                            <label for="communicationScore">Communication Score (%)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="overallScore" min="0" max="100" required>
                                            <label for="overallScore">Overall Score (%)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Review Comments</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="strengths" rows="3" required></textarea>
                                            <label for="strengths">Strengths</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="areasForImprovement" rows="3" required></textarea>
                                            <label for="areasForImprovement">Areas for Improvement</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="developmentPlan" rows="3" required></textarea>
                                            <label for="developmentPlan">Development Plan</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="goalsForNextPeriod" rows="3" required></textarea>
                                            <label for="goalsForNextPeriod">Goals for Next Period</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Supporting Documents</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <input type="file" class="form-control" id="reviewDocuments" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                            <label for="reviewDocuments">Upload Supporting Documents</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" onclick="submitPerformanceReview(event)">Submit Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Posting Modal -->
    <div class="modal fade" id="jobPostingModal" tabindex="-1" aria-labelledby="jobPostingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobPostingModalLabel">Post New Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="jobPostingForm">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Job Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="jobTitle" placeholder="Job Title" required>
                                            <label for="jobTitle">Job Title</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="jobDepartment" required>
                                                <option value="">Select Department</option>
                                                <option value="hr">Human Resources</option>
                                                <option value="it">Information Technology</option>
                                                <option value="finance">Finance</option>
                                                <option value="marketing">Marketing</option>
                                                <option value="operations">Operations</option>
                                            </select>
                                            <label for="jobDepartment">Department</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="jobType" required>
                                                <option value="">Select Type</option>
                                                <option value="full-time">Full Time</option>
                                                <option value="part-time">Part Time</option>
                                                <option value="contract">Contract</option>
                                                <option value="intern">Intern</option>
                                            </select>
                                            <label for="jobType">Job Type</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="jobSalary" placeholder="0" required>
                                            <label for="jobSalary">Salary Range</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="jobLocation" placeholder="Work Location" required>
                                            <label for="jobLocation">Work Location</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="jobDescription" rows="4" required></textarea>
                                            <label for="jobDescription">Job Description</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" onclick="postJob(event)">Post Job</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Exit Process Modal -->
    <div class="modal fade" id="exitProcessModal" tabindex="-1" aria-labelledby="exitProcessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exitProcessModalLabel">Process Employee Exit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="exitProcessForm">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Exit Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="exitEmployeeId" required>
                                                <option value="">Select Employee</option>
                                                <!-- Employee options will be populated via AJAX -->
                                            </select>
                                            <label for="exitEmployeeId">Employee</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="exitDate" required>
                                            <label for="exitDate">Exit Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="exitReason" required>
                                                <option value="">Select Reason</option>
                                                <option value="resignation">Resignation</option>
                                                <option value="termination">Termination</option>
                                                <option value="retirement">Retirement</option>
                                                <option value="layoff">Layoff</option>
                                            </select>
                                            <label for="exitReason">Reason for Exit</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="exitComments" rows="4"></textarea>
                                            <label for="exitComments">Exit Comments</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" onclick="processExit(event)">Process Exit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Compliance Modal -->
    <div class="modal fade" id="complianceModal" tabindex="-1" aria-labelledby="complianceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="complianceModalLabel">Conduct Compliance Audit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="complianceForm">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Audit Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="auditType" required>
                                                <option value="">Select Audit Type</option>
                                                <option value="internal">Internal Audit</option>
                                                <option value="external">External Audit</option>
                                                <option value="regulatory">Regulatory Audit</option>
                                            </select>
                                            <label for="auditType">Audit Type</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="auditDate" required>
                                            <label for="auditDate">Audit Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="auditDepartment" required>
                                                <option value="">Select Department</option>
                                                <option value="hr">Human Resources</option>
                                                <option value="it">Information Technology</option>
                                                <option value="finance">Finance</option>
                                                <option value="marketing">Marketing</option>
                                                <option value="operations">Operations</option>
                                                <option value="legal">Legal</option>
                                            </select>
                                            <label for="auditDepartment">Department</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="auditFindings" rows="4" required></textarea>
                                            <label for="auditFindings">Audit Findings</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <input type="file" class="form-control" id="auditDocuments" multiple>
                                            <label for="auditDocuments">Audit Documents</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" onclick="submitComplianceAudit(event)">Submit Audit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Training Modal -->
    <div class="modal fade" id="trainingModal" tabindex="-1" aria-labelledby="trainingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="trainingModalLabel">Add Training Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="trainingForm">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Training Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="trainingTitle" required>
                                            <label for="trainingTitle">Training Title</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="trainingType" required>
                                                <option value="">Select Type</option>
                                                <option value="online">Online</option>
                                                <option value="in-person">In-Person</option>
                                                <option value="blended">Blended</option>
                                            </select>
                                            <label for="trainingType">Training Type</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="trainingStartDate" required>
                                            <label for="trainingStartDate">Start Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="trainingEndDate">
                                            <label for="trainingEndDate">End Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="trainingDuration" required>
                                            <label for="trainingDuration">Duration (Hours)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="trainingStatus" required>
                                                <option value="">Select Status</option>
                                                <option value="planned">Planned</option>
                                                <option value="in-progress">In Progress</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                            <label for="trainingStatus">Status</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Training Content</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="trainingDescription" rows="3" required></textarea>
                                            <label for="trainingDescription">Description</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="trainingObjectives" rows="3" required></textarea>
                                            <label for="trainingObjectives">Learning Objectives</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="trainingMaterials" rows="3"></textarea>
                                            <label for="trainingMaterials">Training Materials</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Target Audience</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="trainingDepartment" required>
                                                <option value="">Select Department</option>
                                                <option value="hr">Human Resources</option>
                                                <option value="it">Information Technology</option>
                                                <option value="finance">Finance</option>
                                                <option value="marketing">Marketing</option>
                                                <option value="operations">Operations</option>
                                            </select>
                                            <label for="trainingDepartment">Department</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="trainingLevel" required>
                                                <option value="">Select Level</option>
                                                <option value="entry">Entry Level</option>
                                                <option value="intermediate">Intermediate</option>
                                                <option value="advanced">Advanced</option>
                                            </select>
                                            <label for="trainingLevel">Training Level</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="maxParticipants" required>
                                            <label for="maxParticipants">Maximum Participants</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Training</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Benefits Modal -->
    <div class="modal fade" id="benefitsModal" tabindex="-1" aria-labelledby="benefitsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="benefitsModalLabel">Add Benefit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="benefitsForm">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Benefit Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="benefitName" required>
                                            <label for="benefitName">Benefit Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="benefitType" required>
                                                <option value="">Select Type</option>
                                                <option value="health">Health Insurance</option>
                                                <option value="retirement">Retirement Plan</option>
                                                <option value="leave">Leave Benefits</option>
                                                <option value="other">Other</option>
                                            </select>
                                            <label for="benefitType">Benefit Type</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="benefitAmount" step="0.01">
                                            <label for="benefitAmount">Amount ($)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="benefitFrequency" required>
                                                <option value="">Select Frequency</option>
                                                <option value="monthly">Monthly</option>
                                                <option value="annual">Annual</option>
                                                <option value="one-time">One-time</option>
                                            </select>
                                            <label for="benefitFrequency">Frequency</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Benefit Description</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="benefitDescription" rows="3" required></textarea>
                                            <label for="benefitDescription">Description</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="benefitTerms" rows="3" required></textarea>
                                            <label for="benefitTerms">Terms & Conditions</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Eligibility</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="benefitDepartment" required>
                                                <option value="">Select Department</option>
                                                <option value="all">All Departments</option>
                                                <option value="hr">Human Resources</option>
                                                <option value="it">Information Technology</option>
                                                <option value="finance">Finance</option>
                                                <option value="marketing">Marketing</option>
                                                <option value="operations">Operations</option>
                                            </select>
                                            <label for="benefitDepartment">Department</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="benefitEmployeeType" required>
                                                <option value="">Select Employee Type</option>
                                                <option value="all">All Employees</option>
                                                <option value="full-time">Full Time</option>
                                                <option value="part-time">Part Time</option>
                                                <option value="contract">Contract</option>
                                            </select>
                                            <label for="benefitEmployeeType">Employee Type</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="minimumService" required>
                                            <label for="minimumService">Minimum Service (Months)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Benefit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Relations Modal -->
    <div class="modal fade" id="relationsModal" tabindex="-1" aria-labelledby="relationsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="relationsModalLabel">Handle Grievance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="relationsForm">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Grievance Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="grievanceEmployee" required>
                                                <option value="">Select Employee</option>
                                                <!-- Employee options will be populated via AJAX -->
                                            </select>
                                            <label for="grievanceEmployee">Employee</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="grievanceType" required>
                                                <option value="">Select Type</option>
                                                <option value="workplace">Workplace Issues</option>
                                                <option value="harassment">Harassment</option>
                                                <option value="compensation">Compensation</option>
                                                <option value="other">Other</option>
                                            </select>
                                            <label for="grievanceType">Grievance Type</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="grievanceDate" required>
                                            <label for="grievanceDate">Date</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Grievance Description</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="grievanceDescription" rows="4" required></textarea>
                                            <label for="grievanceDescription">Description</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="grievanceResolution" rows="4"></textarea>
                                            <label for="grievanceResolution">Resolution Plan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Status</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="grievanceStatus" required>
                                                <option value="">Select Status</option>
                                                <option value="pending">Pending</option>
                                                <option value="in-progress">In Progress</option>
                                                <option value="resolved">Resolved</option>
                                                <option value="closed">Closed</option>
                                            </select>
                                            <label for="grievanceStatus">Status</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="grievancePriority" required>
                                                <option value="">Select Priority</option>
                                                <option value="low">Low</option>
                                                <option value="medium">Medium</option>
                                                <option value="high">High</option>
                                            </select>
                                            <label for="grievancePriority">Priority</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit Grievance</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Recruitment Modal -->
    <div class="modal fade" id="recruitmentModal" tabindex="-1" aria-labelledby="recruitmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="recruitmentModalLabel">New Recruitment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="recruitmentForm">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Job Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="jobTitle" required>
                                            <label for="jobTitle">Job Title</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="jobDepartment" required>
                                                <option value="">Select Department</option>
                                                <option value="hr">Human Resources</option>
                                                <option value="it">Information Technology</option>
                                                <option value="finance">Finance</option>
                                                <option value="marketing">Marketing</option>
                                                <option value="operations">Operations</option>
                                            </select>
                                            <label for="jobDepartment">Department</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="jobType" required>
                                                <option value="">Select Type</option>
                                                <option value="full-time">Full Time</option>
                                                <option value="part-time">Part Time</option>
                                                <option value="contract">Contract</option>
                                            </select>
                                            <label for="jobType">Job Type</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Requirements</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="minExperience" required>
                                            <label for="minExperience">Minimum Experience (Years)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="minEducation" required>
                                            <label for="minEducation">Minimum Education Level</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="salaryRangeMin" required>
                                            <label for="salaryRangeMin">Salary Range (Min)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="salaryRangeMax" required>
                                            <label for="salaryRangeMax">Salary Range (Max)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Job Description</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="jobDescription" rows="4" required></textarea>
                                            <label for="jobDescription">Job Description</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="jobResponsibilities" rows="4" required></textarea>
                                            <label for="jobResponsibilities">Key Responsibilities</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="jobRequirements" rows="4" required></textarea>
                                            <label for="jobRequirements">Qualifications & Requirements</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Recruitment Timeline</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="applicationDeadline" required>
                                            <label for="applicationDeadline">Application Deadline</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="interviewStart">
                                            <label for="interviewStart">Interview Start Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="interviewEnd">
                                            <label for="interviewEnd">Interview End Date</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Post Job</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Documentation Modal -->
    <div class="modal fade" id="documentationModal" tabindex="-1" aria-labelledby="documentationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="documentationModalLabel">Add Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="documentationForm">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Document Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="documentTitle" required>
                                            <label for="documentTitle">Document Title</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="documentCategory" required>
                                                <option value="">Select Category</option>
                                                <option value="policies">Policies</option>
                                                <option value="procedures">Procedures</option>
                                                <option value="forms">Forms</option>
                                                <option value="templates">Templates</option>
                                                <option value="records">Records</option>
                                            </select>
                                            <label for="documentCategory">Category</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="documentDate" required>
                                            <label for="documentDate">Date</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Document Content</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="documentDescription" rows="3" required></textarea>
                                            <label for="documentDescription">Description</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <input type="file" class="form-control" id="documentFile" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx" required>
                                            <label for="documentFile">Upload Document</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Access Control</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="documentAccess" required>
                                                <option value="">Select Access Level</option>
                                                <option value="public">Public</option>
                                                <option value="internal">Internal</option>
                                                <option value="confidential">Confidential</option>
                                            </select>
                                            <label for="documentAccess">Access Level</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="documentDepartment" required>
                                                <option value="">Select Department</option>
                                                <option value="all">All Departments</option>
                                                <option value="hr">Human Resources</option>
                                                <option value="it">Information Technology</option>
                                                <option value="finance">Finance</option>
                                                <option value="marketing">Marketing</option>
                                                <option value="operations">Operations</option>
                                            </select>
                                            <label for="documentDepartment">Department</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="requireApproval">
                                            <label class="form-check-label" for="requireApproval">
                                                Require Approval for Access
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Upload Document</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jobs Modal -->
    <div class="modal fade" id="jobsModal" tabindex="-1" aria-labelledby="jobsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobsModalLabel">Post Job Opening</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="jobsForm">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Job Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="jobTitle" required>
                                            <label for="jobTitle">Job Title</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="jobDepartment" required>
                                                <option value="">Select Department</option>
                                                <option value="hr">Human Resources</option>
                                                <option value="it">Information Technology</option>
                                                <option value="finance">Finance</option>
                                                <option value="marketing">Marketing</option>
                                                <option value="operations">Operations</option>
                                            </select>
                                            <label for="jobDepartment">Department</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="jobLocation" required>
                                                <option value="">Select Location</option>
                                                <option value="remote">Remote</option>
                                                <option value="office">Office</option>
                                                <option value="hybrid">Hybrid</option>
                                            </select>
                                            <label for="jobLocation">Location</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Job Description</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="jobDescription" rows="4" required></textarea>
                                            <label for="jobDescription">Job Description</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="jobRequirements" rows="4" required></textarea>
                                            <label for="jobRequirements">Requirements</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Compensation & Benefits</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="salaryRangeMin" required>
                                            <label for="salaryRangeMin">Minimum Salary</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="salaryRangeMax" required>
                                            <label for="salaryRangeMax">Maximum Salary</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="salaryType" required>
                                                <option value="">Select Salary Type</option>
                                                <option value="monthly">Monthly</option>
                                                <option value="annual">Annual</option>
                                            </select>
                                            <label for="salaryType">Salary Type</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" onclick="postJob(event)">Post Job</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Compliance Modal -->
    <div class="modal fade" id="complianceModal" tabindex="-1" aria-labelledby="complianceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="complianceModalLabel">Compliance Audit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="complianceForm">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Audit Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="auditType" required>
                                                <option value="">Select Audit Type</option>
                                                <option value="internal">Internal</option>
                                                <option value="external">External</option>
                                                <option value="regulatory">Regulatory</option>
                                            </select>
                                            <label for="auditType">Audit Type</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="auditDate" required>
                                            <label for="auditDate">Audit Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="department" required>
                                                <option value="">Select Department</option>
                                                <option value="hr">Human Resources</option>
                                                <option value="it">Information Technology</option>
                                                <option value="finance">Finance</option>
                                                <option value="marketing">Marketing</option>
                                                <option value="operations">Operations</option>
                                            </select>
                                            <label for="department">Department</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Audit Findings</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="auditFindings" rows="4" required></textarea>
                                            <label for="auditFindings">Audit Findings</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="recommendations" rows="4"></textarea>
                                            <label for="recommendations">Recommendations</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Documents</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <input type="file" class="form-control" id="auditDocuments" multiple>
                                            <label for="auditDocuments">Audit Documents</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" onclick="submitComplianceAudit(event)">Submit Audit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add resizable functionality to all modals -->
    <script>
        // Initialize resizable modals
        document.addEventListener('DOMContentLoaded', function() {
            // Get all modals
            const modals = document.querySelectorAll('.modal');
            
            // Initialize each modal
            modals.forEach(modalElement => {
                const modal = new bootstrap.Modal(modalElement);
                
                // Add resize functionality
                let isResizing = false;
                let startX, startY, startWidth, startHeight;

                modalElement.addEventListener('mousedown', function(e) {
                    if (e.target.classList.contains('modal-content')) {
                        isResizing = true;
                        startX = e.clientX;
                        startY = e.clientY;
                        startWidth = modal._element.offsetWidth;
                        startHeight = modal._element.offsetHeight;
                    }
                });

                document.addEventListener('mousemove', function(e) {
                    if (isResizing) {
                        const width = startWidth + (e.clientX - startX);
                        const height = startHeight + (e.clientY - startY);
                        
                        modal._element.style.width = width + 'px';
                        modal._element.style.height = height + 'px';
                    }
                });

                document.addEventListener('mouseup', function() {
                    isResizing = false;
                });
            });
        });

        // Form submission handlers
        function submitAttendanceForm(event) {
            event.preventDefault();
            
            // Gather form data
            const employeeId = document.getElementById('employeeId').value;
            const attendanceDate = document.getElementById('attendanceDate').value;
            const attendanceStatus = document.getElementById('attendanceStatus').value;
            const checkInTime = document.getElementById('checkInTime').value;
            const checkOutTime = document.getElementById('checkOutTime').value;
            
            // Validate form
            if (!employeeId || !attendanceDate || !attendanceStatus) {
                Swal.fire({
                    icon: 'error',
                    title: 'Required Fields Missing',
                    text: 'Please fill in all required fields.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }
            
            // Create payload
            const attendanceData = {
                employee_id: employeeId,
                date: attendanceDate,
                status: attendanceStatus,
                check_in: checkInTime,
                check_out: checkOutTime
            };
            
            // Show loading state
            const submitButton = event.target;
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            submitButton.disabled = true;
            
            // Send to server (mock API call)
            setTimeout(() => {
                // This is a mock - replace with actual fetch/AJAX call
                /*
                fetch('/api/attendance', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(attendanceData)
                })
                .then(response => response.json())
                .then(data => {
                    handleAttendanceResponse(data, 'created');
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorAlert();
                })
                .finally(() => {
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                });
                */
                
                // Mock success response
                const mockResponse = { success: true };
                handleAttendanceResponse(mockResponse, 'created');
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }, 1500);
        }
        
        function updateAttendanceForm(event) {
            event.preventDefault();
            
            // Gather form data
            const attendanceId = document.getElementById('editAttendanceId').value;
            const attendanceDate = document.getElementById('editAttendanceDate').value;
            const attendanceStatus = document.getElementById('editAttendanceStatus').value;
            const checkInTime = document.getElementById('editCheckInTime').value;
            const checkOutTime = document.getElementById('editCheckOutTime').value;
            
            // Validate form
            if (!attendanceDate || !attendanceStatus) {
                Swal.fire({
                    icon: 'error',
                    title: 'Required Fields Missing',
                    text: 'Please fill in all required fields.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }
            
            // Create payload
            const attendanceData = {
                id: attendanceId,
                date: attendanceDate,
                status: attendanceStatus,
                check_in: checkInTime,
                check_out: checkOutTime
            };
            
            // Show loading state
            const submitButton = event.target;
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            submitButton.disabled = true;
            
            // Send to server (mock API call)
            setTimeout(() => {
                // Mock success response
                const mockResponse = { success: true };
                handleAttendanceResponse(mockResponse, 'updated');
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }, 1500);
        }
        
        function handleAttendanceResponse(data, action) {
            if (data.success) {
                // Close modal
                const modals = ['attendanceModal', 'editAttendanceModal'];
                modals.forEach(modalId => {
                    const modalElement = document.getElementById(modalId);
                    if (modalElement) {
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        if (modal) modal.hide();
                    }
                });
                
                // Reset form
                document.getElementById('attendanceForm').reset();
                if (document.getElementById('editAttendanceForm')) {
                    document.getElementById('editAttendanceForm').reset();
                }
                
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: `Attendance ${action} successfully.`,
                    confirmButtonColor: '#3085d6'
                });
                
                // Refresh attendance data
                refreshAttendanceTable();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data.message || `Failed to ${action} attendance record.`,
                    confirmButtonColor: '#3085d6'
                });
            }
        }
        
        function refreshAttendanceTable() {
            // This would typically fetch updated data from the server
            console.log('Refreshing attendance table...');
            // For demo purposes, we'll just simulate an update
            document.getElementById('todayAttendanceCount').textContent = '2/5';
        }
        
        function openEditAttendanceModal() {
            // Close view modal
            const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewAttendanceModal'));
            if (viewModal) viewModal.hide();
            
            // Open edit modal
            setTimeout(() => {
                const editModal = new bootstrap.Modal(document.getElementById('editAttendanceModal'));
                editModal.show();
            }, 500);
        }
        
        function deleteAttendance() {
            const attendanceId = document.getElementById('deleteAttendanceId').value;
            
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait while we process your request.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Mock API call
            setTimeout(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'Attendance record has been deleted successfully.',
                    confirmButtonColor: '#3085d6'
                });
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteAttendanceModal'));
                if (modal) modal.hide();
                
                // Refresh attendance data
                refreshAttendanceTable();
            }, 1500);
        }
        
        function saveDeviceSettings() {
            // Gather form data
            const deviceIp = document.getElementById('deviceIp').value;
            const devicePort = document.getElementById('devicePort').value;
            const deviceUsername = document.getElementById('deviceUsername').value;
            const devicePassword = document.getElementById('devicePassword').value;
            const syncFrequency = document.getElementById('syncFrequency').value;
            const dailySyncTime = document.getElementById('dailySyncTime').value;
            const autoSyncEnabled = document.getElementById('autoSyncEnabled').checked;
            
            // Validate required fields
            if (!deviceIp) {
                Swal.fire({
                    icon: 'error',
                    title: 'Required Fields Missing',
                    text: 'Please enter the device IP address.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }
            
            // Create settings object
            const settings = {
                ip: deviceIp,
                port: devicePort,
                username: deviceUsername,
                password: devicePassword,
                syncFrequency: syncFrequency,
                dailySyncTime: dailySyncTime,
                autoSyncEnabled: autoSyncEnabled
            };
            
            // Save to localStorage for demo purposes
            localStorage.setItem('attendanceDeviceSettings', JSON.stringify(settings));
            
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Settings Saved',
                text: 'Device settings have been saved successfully.',
                confirmButtonColor: '#3085d6'
            });
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('deviceSettingsModal'));
            if (modal) modal.hide();
            
            // Update device info
            updateDeviceInfo();
        }
        
        function testDeviceConnection() {
            const deviceIp = document.getElementById('deviceIp').value;
            const devicePort = document.getElementById('devicePort').value;
            
            if (!deviceIp) {
                Swal.fire({
                    icon: 'error',
                    title: 'Required Fields Missing',
                    text: 'Please enter the device IP address.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }
            
            // Show testing message
            Swal.fire({
                title: 'Testing Connection',
                text: `Connecting to device at ${deviceIp}${devicePort ? ':'+devicePort : ''}...`,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Mock connection test
            setTimeout(() => {
                // Randomly succeed or fail for demo purposes
                const success = Math.random() > 0.3;
                
                if (success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Connection Successful',
                        text: 'Successfully connected to the attendance device.',
                        confirmButtonColor: '#3085d6'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Connection Failed',
                        text: 'Could not connect to the attendance device. Please check the settings and try again.',
                        confirmButtonColor: '#3085d6'
                    });
                }
            }, 2000);
        }
        
        function updateDeviceInfo() {
            // Get settings from localStorage
            const settings = JSON.parse(localStorage.getItem('attendanceDeviceSettings') || '{}');
            
            // Update UI
            if (settings.ip) {
                document.getElementById('deviceInfo').textContent = `${settings.ip}${settings.port ? ':'+settings.port : ''}`;
                document.getElementById('deviceStatus').textContent = settings.autoSyncEnabled ? 'Connected' : 'Configured';
                
                // Update form fields when opening modal
                document.getElementById('deviceIp').value = settings.ip || '';
                document.getElementById('devicePort').value = settings.port || '';
                document.getElementById('deviceUsername').value = settings.username || '';
                document.getElementById('devicePassword').value = settings.password || '';
                document.getElementById('syncFrequency').value = settings.syncFrequency || '0';
                document.getElementById('dailySyncTime').value = settings.dailySyncTime || '';
                document.getElementById('autoSyncEnabled').checked = settings.autoSyncEnabled || false;
            }
        }
        
        function sendAttendanceReport() {
            // Gather form data
            const reportType = document.getElementById('reportType').value;
            const reportFormat = document.getElementById('reportFormat').value;
            const recipientEmail = document.getElementById('recipientEmail').value;
            const emailSubject = document.getElementById('emailSubject').value || 'Attendance Report';
            
            // Validate required fields
            if (!recipientEmail) {
                Swal.fire({
                    icon: 'error',
                    title: 'Required Fields Missing',
                    text: 'Please enter recipient email address.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }
            
            // Show sending message
            Swal.fire({
                title: 'Sending Report',
                text: 'Please wait while we generate and send the report...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Mock sending report
            setTimeout(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Report Sent',
                    text: `The attendance report has been sent to ${recipientEmail} successfully.`,
                    confirmButtonColor: '#3085d6'
                });
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('emailReportModal'));
                if (modal) modal.hide();
                
                // Reset form
                document.getElementById('emailReportForm').reset();
            }, 3000);
        }
        
        // Load settings when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize attendance date with current date
            const today = new Date().toISOString().split('T')[0];
            if (document.getElementById('attendanceDate')) {
                document.getElementById('attendanceDate').value = today;
            }
            
            // Load device settings
            updateDeviceInfo();
            
            // Set up report type change handler
            const reportTypeSelect = document.getElementById('reportType');
            if (reportTypeSelect) {
                reportTypeSelect.addEventListener('change', function() {
                    const dateRangeInputs = document.querySelectorAll('.date-range-inputs');
                    if (this.value === 'custom') {
                        dateRangeInputs.forEach(el => el.style.display = 'block');
                    } else {
                        dateRangeInputs.forEach(el => el.style.display = 'none');
                    }
                });
            }
            
            // Initialize todays attendance count
            document.getElementById('todayAttendanceCount').textContent = '2/5';
            
            // For demo purposes, set a random number for anomalies
            document.getElementById('attendanceAnomalies').textContent = Math.floor(Math.random() * 3);
        });
        
        function syncAttendanceDevice() {
            Swal.fire({
                title: 'Syncing with Device',
                text: 'Please wait while we sync with the attendance device...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Mock sync process
            setTimeout(() => {
                // Update last sync info
                const now = new Date();
                document.getElementById('lastSyncTime').textContent = now.toLocaleString();
                document.getElementById('lastSyncStatus').textContent = 'Synced successfully';
                
                Swal.fire({
                    icon: 'success',
                    title: 'Sync Complete',
                    text: 'Attendance data has been synchronized successfully.',
                    confirmButtonColor: '#3085d6'
                });
                
                // Update attendance count for demo purposes
                document.getElementById('todayAttendanceCount').textContent = '5/5';
            }, 2500);
        }
        
        function exportAttendance(format) {
            Swal.fire({
                title: `Exporting as ${format.toUpperCase()}`,
                text: 'Please wait while we generate your file...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Mock export process
            setTimeout(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Export Complete',
                    text: `Attendance data has been exported as ${format.toUpperCase()}.`,
                    confirmButtonColor: '#3085d6'
                });
            }, 2000);
        }

        function submitLeaveRequestForm(event) {
            event.preventDefault();
            // Add your leave request form submission logic here
        }



        function submitPerformanceReview(event) {
            event.preventDefault();
            // Add your performance review submission logic here
        }

        function postJob(event) {
            event.preventDefault();
            // Add your job posting logic here
        }

        function processExit(event) {
            event.preventDefault();
            // Add your exit process logic here
        }

        function submitComplianceAudit(event) {
            event.preventDefault();
            // Add your compliance audit submission logic here
        }
    </script>
@endsection

<!-- Device Settings Modal -->
<div class="modal fade" id="deviceSettingsModal" tabindex="-1" aria-labelledby="deviceSettingsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deviceSettingsModalLabel">Attendance Device Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="deviceSettingsForm">
                    <div class="mb-3">
                        <label for="deviceIp" class="form-label">Device IP Address</label>
                        <input type="text" class="form-control" id="deviceIp" required>
                    </div>
                    <div class="mb-3">
                        <label for="devicePort" class="form-label">Port</label>
                        <input type="number" class="form-control" id="devicePort" required>
                    </div>
                    <div class="mb-3">
                        <label for="deviceModel" class="form-label">Device Model</label>
                        <select class="form-select" id="deviceModel" required>
                            <option value="">Select Device Model</option>
                            <option value="zk">ZKTeco</option>
                            <option value="anviz">Anviz</option>
                            <option value="hikvision">Hikvision</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="syncInterval" class="form-label">Auto-Sync Interval (minutes)</label>
                        <input type="number" class="form-control" id="syncInterval" min="5" value="15">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveDeviceSettings()">Save Settings</button>
            </div>
        </div>
    </div>
</div>

<!-- Email Report Modal -->
<div class="modal fade" id="emailReportModal" tabindex="-1" aria-labelledby="emailReportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailReportModalLabel">Email Attendance Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="emailReportForm">
                    <div class="mb-3">
                        <label for="reportEmail" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="reportEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="reportFormat" class="form-label">Report Format</label>
                        <select class="form-select" id="reportFormat" required>
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="dateRange" class="form-label">Date Range</label>
                        <select class="form-select" id="dateRange" required>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                    <div id="customDateRange" class="row d-none">
                        <div class="col-md-6 mb-3">
                            <label for="startDate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="startDate">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="endDate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="endDate">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="sendEmailReport()">Send Report</button>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        // Handle navigation and modal interactions
        function handleNavigation(sectionId) {
            // Remove active class from all buttons
            document.querySelectorAll('.nav-button').forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            document.querySelector(`[data-section="${sectionId}"]`).classList.add('active');
            
            // Hide all sections
            document.querySelectorAll('.hr-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Show the selected section
            document.getElementById(sectionId).classList.add('active');

            // Show appropriate modal if it exists
            const modalFunction = {
                'employee-management': showAddEmployeeModal,
                'attendance': showAttendanceModal,
                'leave-requests': showLeaveRequestModal,

                'performance': showPerformanceReviewModal,
                'job-postings': showJobPostingModal,
                'exit-process': showExitProcessModal,
                'compliance': showComplianceModal
            }[sectionId];

            if (modalFunction) {
                modalFunction();
            }
        }

        // Initialize modals
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all modals
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                new bootstrap.Modal(modal);
            });
        });

        // Modal show functions
        function showAddEmployeeModal() {
            var modal = new bootstrap.Modal(document.getElementById('addEmployeeModal'));
            modal.show();
        }

        function showAttendanceModal() {
            var modal = new bootstrap.Modal(document.getElementById('attendanceModal'));
            modal.show();
        }

        function showLeaveRequestModal() {
            var modal = new bootstrap.Modal(document.getElementById('leaveRequestModal'));
            modal.show();
        }



        function showPerformanceReviewModal() {
            var modal = new bootstrap.Modal(document.getElementById('performanceReviewModal'));
            modal.show();
        }

        function showJobPostingModal() {
            var modal = new bootstrap.Modal(document.getElementById('jobPostingModal'));
            modal.show();
        }

        function showExitProcessModal() {
            var modal = new bootstrap.Modal(document.getElementById('exitProcessModal'));
            modal.show();
        }

        function showComplianceModal() {
            var modal = new bootstrap.Modal(document.getElementById('complianceModal'));
            modal.show();
        }

        // Form submission handlers
        function submitEmployeeForm() {
            const formData = new FormData();
            
            // Personal Information
            formData.append('firstName', $('#firstName').val());
            formData.append('lastName', $('#lastName').val());
            formData.append('email', $('#email').val());
            formData.append('phone', $('#phone').val());
            formData.append('gender', $('#gender').val());
            formData.append('dob', $('#dob').val());
            formData.append('maritalStatus', $('#maritalStatus').val());
            
            // Employment Information
            formData.append('employeeId', $('#employeeId').val());
            formData.append('department', $('#department').val());
            formData.append('designation', $('#designation').val());
            formData.append('joiningDate', $('#joiningDate').val());
            formData.append('employeeType', $('#employeeType').val());
            formData.append('salary', $('#salary').val());
            formData.append('location', $('#location').val());
            
            // Emergency Contact
            formData.append('emergencyName', $('#emergencyName').val());
            formData.append('emergencyRelation', $('#emergencyRelation').val());
            formData.append('emergencyPhone', $('#emergencyPhone').val());
            formData.append('emergencyEmail', $('#emergencyEmail').val());
            
            // Documents
            formData.append('resume', $('#resume')[0].files[0]);
            formData.append('idProof', $('#idProof')[0].files[0]);
            formData.append('addressProof', $('#addressProof')[0].files[0]);
            Array.from($('#otherDocuments')[0].files).forEach((file, index) => {
                formData.append('otherDocuments[]', file);
            });
            
            // Submit the form
            fetch('/hr/employees', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Employee added successfully',
                    });
                    
                    // Refresh the table
                    loadEmployeeTable();
                    
                    // Close the modal
                    const modal = new bootstrap.Modal(document.getElementById('addEmployeeModal'));
                    modal.hide();
                    
                    // Reset form
                    $('#addEmployeeForm')[0].reset();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message,
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while adding the employee',
                });
            });
        }

        // Initialize resizable modal
        document.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal(document.getElementById('addEmployeeModal'));
            
            // Add resize functionality
            let isResizing = false;
            let startX, startY, startWidth, startHeight;

            document.getElementById('addEmployeeModal').addEventListener('mousedown', function(e) {
                if (e.target.classList.contains('modal-content')) {
                    isResizing = true;
                    startX = e.clientX;
                    startY = e.clientY;
                    startWidth = modal._element.offsetWidth;
                    startHeight = modal._element.offsetHeight;
                }
            });

            document.addEventListener('mousemove', function(e) {
                if (isResizing) {
                    const width = startWidth + (e.clientX - startX);
                    const height = startHeight + (e.clientY - startY);
                    
                    modal._element.style.width = width + 'px';
                    modal._element.style.height = height + 'px';
                }
            });

            document.addEventListener('mouseup', function() {
                isResizing = false;
            });
        });

        function generateEmployeeId() {
            // Get current date
            const date = new Date();
            const year = date.getFullYear().toString().slice(-2);
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            
            // Generate random 3-digit number
            const random = Math.floor(100 + Math.random() * 900);
            
            // Format the ID
            const employeeId = `EMP${year}${month}${random}`;
            
            // Set the value in the input field
            document.getElementById('employeeId').value = employeeId;
        }

        function loadEmployeeTable() {
            // Fetch employee data and update the table
            fetch('/hr/employees')
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#v-pills-employees .table tbody');
                tbody.innerHTML = '';
                
                data.forEach(employee => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${employee.employeeId}</td>
                        <td>${employee.firstName} ${employee.lastName}</td>
                        <td>${employee.position}</td>
                        <td>${employee.department}</td>
                        <td>${employee.joinDate}</td>
                        <td><span class="badge bg-${employee.status === 'Active' ? 'success' : 'info'}">${employee.status}</span></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editEmployeeModal" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#terminateEmployeeModal" title="Terminate">
                                    <i class="fas fa-user-times"></i>
                                </button>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewEmployeeModal" title="View Profile">
                                    <i class="fas fa-user"></i>
                                </button>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Load table on page load
        document.addEventListener('DOMContentLoaded', () => {
            loadEmployeeTable();
            initializeAttendanceSync();
        });

        // Attendance Device Integration
        let syncInterval;

        function initializeAttendanceSync() {
            // Load saved device settings
            const settings = JSON.parse(localStorage.getItem('attendanceDeviceSettings') || '{}');
            if (settings.deviceIp) {
                document.getElementById('deviceIp').value = settings.deviceIp;
                document.getElementById('devicePort').value = settings.devicePort;
                document.getElementById('deviceModel').value = settings.deviceModel;
                document.getElementById('syncInterval').value = settings.syncInterval;
                
                // Update device info display
                updateDeviceInfo(settings);
                
                // Start auto-sync if interval is set
                if (settings.syncInterval) {
                    startAutoSync(settings.syncInterval);
                }
            }
        }

        function saveDeviceSettings() {
            const settings = {
                deviceIp: document.getElementById('deviceIp').value,
                devicePort: document.getElementById('devicePort').value,
                deviceModel: document.getElementById('deviceModel').value,
                syncInterval: parseInt(document.getElementById('syncInterval').value)
            };

            localStorage.setItem('attendanceDeviceSettings', JSON.stringify(settings));
            updateDeviceInfo(settings);
            startAutoSync(settings.syncInterval);
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('deviceSettingsModal'));
            modal.hide();
            
            // Show success message
            showToast('Settings saved successfully', 'success');
        }

        function updateDeviceInfo(settings) {
            document.getElementById('deviceInfo').textContent = 
                `${settings.deviceModel.toUpperCase()} - ${settings.deviceIp}:${settings.devicePort}`;
            checkDeviceConnection(settings);
        }

        function startAutoSync(interval) {
            // Clear existing interval if any
            if (syncInterval) {
                clearInterval(syncInterval);
            }
            
            // Set new interval
            if (interval) {
                syncInterval = setInterval(() => syncAttendanceDevice(), interval * 60 * 1000);
            }
        }

        async function checkDeviceConnection(settings) {
            try {
                const response = await fetch('/api/attendance/check-device', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(settings)
                });

                const data = await response.json();
                document.getElementById('deviceStatus').textContent = 
                    data.connected ? 'Online' : 'Offline';
                document.getElementById('deviceStatus').className = 
                    `text-${data.connected ? 'success' : 'danger'}`;
            } catch (error) {
                console.error('Error checking device connection:', error);
                document.getElementById('deviceStatus').textContent = 'Error';
                document.getElementById('deviceStatus').className = 'text-danger';
            }
        }

        async function syncAttendanceDevice() {
            const settings = JSON.parse(localStorage.getItem('attendanceDeviceSettings') || '{}');
            if (!settings.deviceIp) {
                showToast('Please configure device settings first', 'warning');
                return;
            }

            try {
                document.getElementById('lastSyncStatus').textContent = 'Syncing...';
                
                const response = await fetch('/api/attendance/sync-device', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(settings)
                });

                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('lastSyncStatus').textContent = 
                        `Successfully synced ${data.recordsCount} records`;
                    document.getElementById('lastSyncTime').textContent = 
                        new Date().toLocaleString();
                    showToast('Sync completed successfully', 'success');
                } else {
                    throw new Error(data.message || 'Sync failed');
                }
            } catch (error) {
                console.error('Error syncing attendance:', error);
                document.getElementById('lastSyncStatus').textContent = 
                    `Sync failed: ${error.message}`;
                showToast('Failed to sync with attendance device', 'error');
            }
        }

        // Export attendance data
        async function exportAttendance(format) {
            try {
                const response = await fetch(`/api/attendance/export/${format}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) {
                    throw new Error('Export failed');
                }

                // Handle different response types
                if (format === 'csv' || format === 'excel') {
                    const blob = await response.blob();
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `attendance_report.${format === 'excel' ? 'xlsx' : 'csv'}`;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    a.remove();
                } else if (format === 'pdf') {
                    const blob = await response.blob();
                    const url = window.URL.createObjectURL(blob);
                    window.open(url, '_blank');
                }

                showToast(`Successfully exported attendance data as ${format.toUpperCase()}`, 'success');
            } catch (error) {
                console.error('Error exporting attendance:', error);
                showToast(`Failed to export attendance data: ${error.message}`, 'error');
            }
        }

        // Handle date range selection
        document.getElementById('dateRange')?.addEventListener('change', function() {
            const customRange = document.getElementById('customDateRange');
            if (this.value === 'custom') {
                customRange.classList.remove('d-none');
            } else {
                customRange.classList.add('d-none');
            }
        });

        // Send email report
        async function sendEmailReport() {
            const email = document.getElementById('reportEmail').value;
            const format = document.getElementById('reportFormat').value;
            const dateRange = document.getElementById('dateRange').value;
            let startDate = null;
            let endDate = null;

            if (dateRange === 'custom') {
                startDate = document.getElementById('startDate').value;
                endDate = document.getElementById('endDate').value;
                if (!startDate || !endDate) {
                    showToast('Please select both start and end dates', 'warning');
                    return;
                }
            }

            try {
                const response = await fetch('/api/attendance/email-report', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        email,
                        format,
                        dateRange,
                        startDate,
                        endDate
                    })
                });

                const data = await response.json();
                if (data.success) {
                    showToast('Report has been sent to your email', 'success');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('emailReportModal'));
                    modal.hide();
                } else {
                    throw new Error(data.message || 'Failed to send report');
                }
            } catch (error) {
                console.error('Error sending email report:', error);
                showToast(`Failed to send report: ${error.message}`, 'error');
            }
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;
            
            document.body.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            // Remove toast after it's hidden
            toast.addEventListener('hidden.bs.toast', () => toast.remove());
        }
    </script>
@endsection