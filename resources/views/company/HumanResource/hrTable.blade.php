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
        #v-pills-leaves-tab i { color: #ffc107; } /* Yellow */
        #v-pills-payroll-tab i { color: #dc3545; } /* Red */
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
                    <button class="nav-link" id="v-pills-payroll-tab" data-bs-toggle="pill" data-bs-target="#v-pills-payroll" type="button" role="tab" aria-controls="v-pills-payroll" aria-selected="false">
                        <i class="fas fa-money-bill-wave me-2"></i>Payroll
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
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Attendance</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#attendanceModal">
                                    <i class="fas fa-plus me-2"></i>Mark Attendance
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Date</th>
                                                <th>Clock In</th>
                                                <th>Clock Out</th>
                                                <th>Hours</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>John Doe</td>
                                                <td>2025-04-04</td>
                                                <td>09:00 AM</td>
                                                <td>06:00 PM</td>
                                                <td>9.00</td>
                                                <td><span class="badge bg-success">Present</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editAttendanceModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAttendanceModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewAttendanceModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jane Smith</td>
                                                <td>2025-04-04</td>
                                                <td>09:30 AM</td>
                                                <td>05:30 PM</td>
                                                <td>8.00</td>
                                                <td><span class="badge bg-warning">Late</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editAttendanceModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAttendanceModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewAttendanceModal" title="View Details">
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

                    <!-- Payroll Tab -->
                    <div class="tab-pane fade" id="v-pills-payroll" role="tabpanel" aria-labelledby="v-pills-payroll-tab">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Payroll</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#payrollModal">
                                    <i class="fas fa-plus me-2"></i>Process Payroll
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Month</th>
                                                <th>Basic Salary</th>
                                                <th>Allowances</th>
                                                <th>Deductions</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>John Doe</td>
                                                <td>April 2025</td>
                                                <td>$5000</td>
                                                <td>$500</td>
                                                <td>$200</td>
                                                <td><span class="badge bg-success">Processed</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editPayrollModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletePayrollModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewPayrollModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#generatePayslipModal" title="Generate Payslip">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jane Smith</td>
                                                <td>April 2025</td>
                                                <td>$6000</td>
                                                <td>$700</td>
                                                <td>$300</td>
                                                <td><span class="badge bg-warning">Pending</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editPayrollModal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletePayrollModal" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewPayrollModal" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#generatePayslipModal" title="Generate Payslip">
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
                <div class="modal-header">
                    <h5 class="modal-title" id="attendanceModalLabel">Mark Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="attendanceForm">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Attendance Details</h6>
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" onclick="submitAttendanceForm(event)">Save Attendance</button>
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

    <!-- Payroll Modal -->
    <div class="modal fade" id="payrollModal" tabindex="-1" aria-labelledby="payrollModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="payrollModalLabel">Generate Payroll</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="payrollForm">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Payroll Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="payrollDepartment" required>
                                                <option value="">Select Department</option>
                                                <option value="hr">Human Resources</option>
                                                <option value="it">Information Technology</option>
                                                <option value="finance">Finance</option>
                                                <option value="marketing">Marketing</option>
                                                <option value="operations">Operations</option>
                                            </select>
                                            <label for="payrollDepartment">Department</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="payrollMonth" required>
                                                <option value="">Select Month</option>
                                                <!-- Month options will be populated via JavaScript -->
                                            </select>
                                            <label for="payrollMonth">Month</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="payrollYear" required>
                                                <option value="">Select Year</option>
                                                <!-- Year options will be populated via JavaScript -->
                                            </select>
                                            <label for="payrollYear">Year</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Employee Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="payrollEmployee" required>
                                                <option value="">Select Employee</option>
                                                <!-- Employee options will be populated via AJAX -->
                                            </select>
                                            <label for="payrollEmployee">Employee</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="payrollEmployeeType" required>
                                                <option value="">Select Type</option>
                                                <option value="full-time">Full Time</option>
                                                <option value="part-time">Part Time</option>
                                                <option value="contract">Contract</option>
                                            </select>
                                            <label for="payrollEmployeeType">Employee Type</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="payrollEmployeeLocation" placeholder="Work Location">
                                            <label for="payrollEmployeeLocation">Work Location</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Compensation Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="basicSalary" placeholder="0" required>
                                            <label for="basicSalary">Basic Salary</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="allowances" placeholder="0">
                                            <label for="allowances">Allowances</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="deductions" placeholder="0">
                                            <label for="deductions">Deductions</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="bonus" placeholder="0">
                                            <label for="bonus">Bonus</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="overtime" placeholder="0">
                                            <label for="overtime">Overtime</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="tax" placeholder="0">
                                            <label for="tax">Tax</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Leave and Attendance</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="presentDays" placeholder="0" required>
                                            <label for="presentDays">Present Days</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="absentDays" placeholder="0">
                                            <label for="absentDays">Absent Days</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="leaveDays" placeholder="0">
                                            <label for="leaveDays">Leave Days</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" onclick="generatePayroll(event)">Generate Payroll</button>
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
            // Add your attendance form submission logic here
        }

        function submitLeaveRequestForm(event) {
            event.preventDefault();
            // Add your leave request form submission logic here
        }

        function generatePayroll(event) {
            event.preventDefault();
            // Add your payroll generation logic here
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
                'payroll': showPayrollModal,
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

        function showPayrollModal() {
            var modal = new bootstrap.Modal(document.getElementById('payrollModal'));
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
        document.addEventListener('DOMContentLoaded', loadEmployeeTable);
    </script>
@endsection