@extends('layouts.vertical', ['page_title' => 'Payroll Management'])

@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
           'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
           'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css',
           'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Reuse the form-floating and dark mode styles from users.blade.php */
        @import url('{{ asset('resources/views/company/user-management/users.blade.php') }}');
        
        /* Professional Payroll-specific Styles */
        :root {
            --primary-color: #0dcaf0;
            --primary-color-light: rgba(13, 202, 240, 0.1);
            --primary-color-medium: rgba(13, 202, 240, 0.2);
            --primary-color-border: rgba(13, 202, 240, 0.3);
            --success-color: #198754;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --card-border-radius: 0.75rem;
            --transition-speed: 0.3s;
        }
        
        .page-header {
            padding: 1.5rem 0;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        [data-bs-theme="dark"] .page-header {
            border-bottom-color: rgba(255, 255, 255, 0.05);
        }
        
        .payroll-card {
            border-radius: var(--card-border-radius);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all var(--transition-speed) ease;
            overflow: hidden;
            height: 100%;
        }
        
        .payroll-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        
        .payroll-card .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 1.25rem;
        }
        
        [data-bs-theme="dark"] .payroll-card .card-header {
            border-bottom-color: rgba(255, 255, 255, 0.05);
        }
        
        .payroll-stat-card {
            background-color: var(--primary-color-light);
            border: 1px solid var(--primary-color-border);
            border-radius: var(--card-border-radius);
            padding: 1.25rem;
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            transition: all var(--transition-speed) ease;
        }
        
        .payroll-stat-card:hover {
            background-color: var(--primary-color-medium);
        }
        
        .payroll-stat-card h5 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .payroll-stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0;
        }
        
        .payroll-stat-card .stat-icon {
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
            color: var(--primary-color);
        }
        
        [data-bs-theme="dark"] .payroll-stat-card {
            background-color: var(--primary-color-medium);
            border-color: var(--primary-color-border);
        }
        
        .action-btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
            margin-right: 0.25rem;
        }
        
        .action-btn:last-child {
            margin-right: 0;
        }
        
        .action-btn i {
            font-size: 0.875rem;
        }
        
        .quick-action-card {
            border-radius: var(--card-border-radius);
            transition: all var(--transition-speed) ease;
            border-left: 4px solid var(--primary-color);
        }
        
        .quick-action-card:hover {
            transform: translateX(3px);
        }
        
        .quick-action-card.ssnit {
            border-left-color: var(--danger-color);
        }
        
        .quick-action-card.benefits {
            border-left-color: var(--success-color);
        }
        
        .quick-action-card.audit {
            border-left-color: var(--primary-color);
        }
        
        .quick-action-card.employee {
            border-left-color: var(--warning-color);
        }
        
        .schedule-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .schedule-item:last-child {
            border-bottom: none;
        }
        
        [data-bs-theme="dark"] .schedule-item {
            border-bottom-color: rgba(255, 255, 255, 0.05);
        }
        
        .table-payroll thead th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }
        
        .table-payroll tbody td {
            vertical-align: middle;
        }
        
        .btn-icon-text i {
            margin-right: 0.5rem;
        }
        
        .badge-pill {
            padding-right: 0.6em;
            padding-left: 0.6em;
            border-radius: 10rem;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-auto">
                    <h4 class="page-title mb-1">Payroll Management</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Human Resources</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Payroll</li>
                        </ol>
                    </nav>
                </div>
                <div class="col text-end">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary btn-icon-text" data-bs-toggle="modal" data-bs-target="#processPayrollModal">
                            <i class="fa-solid fa-calculator"></i> Process Payroll
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-icon-text" data-bs-toggle="modal" data-bs-target="#generateReportModal">
                            <i class="fa-solid fa-file-invoice"></i> Reports
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-icon-text" data-bs-toggle="modal" data-bs-target="#importPayrollDataModal">
                            <i class="fa-solid fa-upload"></i> Import
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Overview -->
        <div class="row mb-4">
            <!-- Payroll Statistics -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="payroll-stat-card">
                    <div class="stat-icon">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>
                    <h5>Total Payroll</h5>
                    <p class="stat-value">$250,000</p>
                    <small class="text-muted">Current pay period</small>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="payroll-stat-card">
                    <div class="stat-icon">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h5>Average Salary</h5>
                    <p class="stat-value">$5,200</p>
                    <small class="text-muted">Per employee</small>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="payroll-stat-card">
                    <div class="stat-icon">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <h5>Tax Deductions</h5>
                    <p class="stat-value">$35,000</p>
                    <small class="text-muted">SSNIT & PAYE</small>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="payroll-stat-card">
                    <div class="stat-icon">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                    <h5>Net Payable</h5>
                    <p class="stat-value">$215,000</p>
                    <small class="text-muted">After deductions</small>
                </div>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="row mb-4">
            <!-- Left Column: Payroll Data & Schedule -->
            <div class="col-lg-8 mb-3">
                <!-- Payroll Schedule Card -->
                <div class="card payroll-card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fa-solid fa-calendar-alt me-2 text-primary"></i> Payroll Schedule
                        </h5>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#payrollCalendarModal">
                            <i class="fa-solid fa-calendar-week me-1"></i> View Calendar
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="schedule-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fa-solid fa-calendar-check text-success me-2"></i>
                                <span class="fw-medium">Next Payroll Date</span>
                            </div>
                            <div>
                                <span class="badge bg-light text-dark me-2">15 days left</span>
                                <strong>May 30, 2025</strong>
                            </div>
                        </div>
                        <div class="schedule-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fa-solid fa-clock text-warning me-2"></i>
                                <span class="fw-medium">Processing Deadline</span>
                            </div>
                            <div>
                                <span class="badge bg-light text-dark me-2">13 days left</span>
                                <strong>May 28, 2025</strong>
                            </div>
                        </div>
                        <div class="schedule-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fa-solid fa-file-invoice-dollar text-info me-2"></i>
                                <span class="fw-medium">SSNIT Filing Due</span>
                            </div>
                            <div>
                                <span class="badge bg-light text-dark me-2">31 days left</span>
                                <strong>June 15, 2025</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Quick Actions -->
            <div class="col-lg-4 mb-3">
                <div class="card payroll-card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fa-solid fa-bolt me-2 text-warning"></i> Quick Actions
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action quick-action-card primary p-3" data-bs-toggle="modal" data-bs-target="#payrollProcessingModal">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fa-solid fa-money-bill-wave text-primary fa-lg"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1 fw-semibold">Payroll Processing</h6>
                                            <span class="badge bg-primary badge-pill">Run</span>
                                        </div>
                                        <small>Calculate and process employee payroll</small>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action quick-action-card ssnit p-3" data-bs-toggle="modal" data-bs-target="#taxManagementModal">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fa-solid fa-receipt text-danger fa-lg"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1 fw-semibold">Tax Management</h6>
                                            <span class="badge bg-danger badge-pill">SSNIT</span>
                                        </div>
                                        <small>Configure tax settings and SSNIT integration</small>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action quick-action-card benefits p-3" data-bs-toggle="modal" data-bs-target="#benefitsManagementModal">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fa-solid fa-hand-holding-medical text-success fa-lg"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1 fw-semibold">Benefits & Deductions</h6>
                                            <span class="badge bg-success badge-pill">New</span>
                                        </div>
                                        <small>Manage employee benefits and deductions</small>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action quick-action-card audit p-3" data-bs-toggle="modal" data-bs-target="#auditTrailModal">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fa-solid fa-history text-info fa-lg"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1 fw-semibold">Audit Trail</h6>
                                            <span class="badge bg-info badge-pill">5 new</span>
                                        </div>
                                        <small>View payroll change history</small>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action quick-action-card employee p-3" data-bs-toggle="modal" data-bs-target="#employeeSelfServiceModal">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fa-solid fa-users-gear text-warning fa-lg"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1 fw-semibold">Employee Self-Service</h6>
                                            <span class="badge bg-warning badge-pill">Portal</span>
                                        </div>
                                        <small>Configure employee access and permissions</small>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action quick-action-card reports p-3" data-bs-toggle="modal" data-bs-target="#payrollReportsModal">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fa-solid fa-chart-line text-info fa-lg"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1 fw-semibold">Payroll Reports</h6>
                                            <span class="badge bg-info badge-pill">Analytics</span>
                                        </div>
                                        <small>View and generate payroll reports</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payroll Data Table Section -->
        <div class="row">
            <div class="col-12">
                <div class="card payroll-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="fa-solid fa-users me-2 text-primary"></i> Employee Payroll Data
                            </h5>
                            <p class="text-muted small mb-0">May 2025 Pay Period</p>
                        </div>
                        <div class="d-flex">
                            <div class="dropdown me-2">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="payrollFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-filter me-1"></i> Filter
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="payrollFilterDropdown">
                                    <li><a class="dropdown-item" href="#">All Departments</a></li>
                                    <li><a class="dropdown-item" href="#">Finance</a></li>
                                    <li><a class="dropdown-item" href="#">HR</a></li>
                                    <li><a class="dropdown-item" href="#">IT</a></li>
                                    <li><a class="dropdown-item" href="#">Sales</a></li>
                                    <li><a class="dropdown-item" href="#">Marketing</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Custom Filter...</a></li>
                                </ul>
                            </div>
                            <button class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-plus me-1"></i> Add Employee
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="payroll-table" class="table table-payroll table-hover dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Employee Name</th>
                                        <th>Department</th>
                                        <th>Basic Salary</th>
                                        <th>Allowances</th>
                                        <th>Deductions</th>
                                        <th>Net Pay</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="fw-medium">EMP001</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar avatar-xs me-2 bg-soft-primary text-primary rounded-circle">
                                                        <span>JD</span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    John Doe
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-soft-info text-info">Finance</span></td>
                                        <td>$5,000.00</td>
                                        <td><span class="text-success">$1,200.00</span></td>
                                        <td><span class="text-danger">$800.00</span></td>
                                        <td><span class="fw-bold">$5,400.00</span></td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-info action-btn view-payroll-details" 
                                                        data-employee-id="EMP001"
                                                        title="View Details">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-warning action-btn edit-payroll"
                                                        data-employee-id="EMP001"
                                                        title="Edit Payroll">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-primary action-btn generate-payslip"
                                                        data-employee-id="EMP001"
                                                        title="Generate Payslip">
                                                    <i class="fa-solid fa-file-invoice-dollar"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="fw-medium">EMP002</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar avatar-xs me-2 bg-soft-success text-success rounded-circle">
                                                        <span>JS</span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    Jane Smith
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-soft-primary text-primary">HR</span></td>
                                        <td>$4,800.00</td>
                                        <td><span class="text-success">$1,000.00</span></td>
                                        <td><span class="text-danger">$700.00</span></td>
                                        <td><span class="fw-bold">$5,100.00</span></td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-info action-btn view-payroll-details" 
                                                        data-employee-id="EMP002"
                                                        title="View Details">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-warning action-btn edit-payroll"
                                                        data-employee-id="EMP002"
                                                        title="Edit Payroll">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-primary action-btn generate-payslip"
                                                        data-employee-id="EMP002"
                                                        title="Generate Payslip">
                                                    <i class="fa-solid fa-file-invoice-dollar"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="fw-medium">EMP003</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar avatar-xs me-2 bg-soft-danger text-danger rounded-circle">
                                                        <span>MJ</span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    Mike Johnson
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-soft-danger text-danger">IT</span></td>
                                        <td>$6,000.00</td>
                                        <td><span class="text-success">$1,500.00</span></td>
                                        <td><span class="text-danger">$1,000.00</span></td>
                                        <td><span class="fw-bold">$6,500.00</span></td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-info action-btn view-payroll-details" 
                                                        data-employee-id="EMP003"
                                                        title="View Details">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-warning action-btn edit-payroll"
                                                        data-employee-id="EMP003"
                                                        title="Edit Payroll">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-primary action-btn generate-payslip"
                                                        data-employee-id="EMP003"
                                                        title="Generate Payslip">
                                                    <i class="fa-solid fa-file-invoice-dollar"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="fw-medium">EMP004</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar avatar-xs me-2 bg-soft-warning text-warning rounded-circle">
                                                        <span>SW</span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    Sarah Williams
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-soft-success text-success">Sales</span></td>
                                        <td>$5,200.00</td>
                                        <td><span class="text-success">$1,300.00</span></td>
                                        <td><span class="text-danger">$900.00</span></td>
                                        <td><span class="fw-bold">$5,600.00</span></td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-info action-btn view-payroll-details" 
                                                        data-employee-id="EMP004"
                                                        title="View Details">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-warning action-btn edit-payroll"
                                                        data-employee-id="EMP004"
                                                        title="Edit Payroll">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-primary action-btn generate-payslip"
                                                        data-employee-id="EMP004"
                                                        title="Generate Payslip">
                                                    <i class="fa-solid fa-file-invoice-dollar"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="fw-medium">EMP005</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar avatar-xs me-2 bg-soft-info text-info rounded-circle">
                                                        <span>DB</span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    David Brown
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-soft-warning text-warning">Marketing</span></td>
                                        <td>$4,900.00</td>
                                        <td><span class="text-success">$1,100.00</span></td>
                                        <td><span class="text-danger">$750.00</span></td>
                                        <td><span class="fw-bold">$5,250.00</span></td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-info action-btn view-payroll-details" 
                                                        data-employee-id="EMP005"
                                                        title="View Details">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-warning action-btn edit-payroll"
                                                        data-employee-id="EMP005"
                                                        title="Edit Payroll">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-primary action-btn generate-payslip"
                                                        data-employee-id="EMP005"
                                                        title="Generate Payslip">
                                                    <i class="fa-solid fa-file-invoice-dollar"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <span class="text-muted">Showing 5 of 48 employees</span>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <button class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fa-solid fa-file-excel me-1"></i> Export
                                </button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fa-solid fa-print me-1"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Process Payroll Modal -->
    <div class="modal fade" id="processPayrollModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Process Payroll</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="payroll-period" required>
                                        <option value="">Select Payroll Period</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="quarterly">Quarterly</option>
                                        <option value="annual">Annual</option>
                                    </select>
                                    <label for="payroll-period">Payroll Period</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="payroll-date" placeholder="Payroll Date" required>
                                    <label for="payroll-date">Payroll Date</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="department" multiple required>
                                        <option value="all">All Departments</option>
                                        <option value="hr">Human Resources</option>
                                        <option value="finance">Finance</option>
                                        <option value="it">IT</option>
                                        <option value="sales">Sales</option>
                                    </select>
                                    <label for="department">Select Departments</label>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Process Payroll</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Generate Report Modal -->
    <div class="modal fade" id="generateReportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate Payroll Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="report-type" required>
                                        <option value="">Select Report Type</option>
                                        <option value="summary">Summary Report</option>
                                        <option value="detailed">Detailed Report</option>
                                        <option value="tax">Tax Report</option>
                                    </select>
                                    <label for="report-type">Report Type</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="report-format" required>
                                        <option value="">Select Format</option>
                                        <option value="pdf">PDF</option>
                                        <option value="excel">Excel</option>
                                        <option value="csv">CSV</option>
                                    </select>
                                    <label for="report-format">Report Format</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="start-date" placeholder="Start Date" required>
                                    <label for="start-date">Start Date</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="end-date" placeholder="End Date" required>
                                    <label for="end-date">End Date</label>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Generate Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Payroll Data Modal -->
    <div class="modal fade" id="importPayrollDataModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Payroll Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-floating mb-3">
                            <input type="file" class="form-control" id="payroll-file" placeholder="Upload Payroll File" accept=".csv,.xlsx" required>
                            <label for="payroll-file">Upload Payroll File</label>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Import Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tax Management Modal -->
    <div class="modal fade" id="taxManagementModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-light py-2">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-receipt me-2 text-danger"></i> Tax Management
                    </h5>
                    <div class="d-flex align-items-center ms-auto me-2">
                        <div class="btn-group btn-group-sm me-3">
                            <button type="button" class="btn btn-outline-primary active">
                                <i class="fa-solid fa-file-invoice me-1"></i> SSNIT
                            </button>
                            <button type="button" class="btn btn-outline-primary">
                                <i class="fa-solid fa-money-bill-transfer me-1"></i> PAYE
                            </button>
                            <button type="button" class="btn btn-outline-primary">
                                <i class="fa-solid fa-chart-pie me-1"></i> Reports
                            </button>
                        </div>
                        <div class="input-group input-group-sm me-3" style="width: 200px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa-solid fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search tax records...">
                        </div>
                        <button type="button" class="btn btn-sm btn-danger">
                            <i class="fa-solid fa-plus me-1"></i> New Filing
                        </button>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="taxTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tax-settings-tab" data-bs-toggle="tab" data-bs-target="#tax-settings" type="button" role="tab" aria-controls="tax-settings" aria-selected="true">Tax Settings</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tax-brackets-tab" data-bs-toggle="tab" data-bs-target="#tax-brackets" type="button" role="tab" aria-controls="tax-brackets" aria-selected="false">Tax Brackets</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="ssnit-integration-tab" data-bs-toggle="tab" data-bs-target="#ssnit-integration" type="button" role="tab" aria-controls="ssnit-integration" aria-selected="false">SSNIT Integration</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tax-compliance-tab" data-bs-toggle="tab" data-bs-target="#tax-compliance" type="button" role="tab" aria-controls="tax-compliance" aria-selected="false">Compliance</button>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="taxTabsContent">
                        <div class="tab-pane fade show active" id="tax-settings" role="tabpanel" aria-labelledby="tax-settings-tab">
                            <form>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="tax-system" required>
                                                <option value="">Select Tax System</option>
                                                <option value="ssnit" selected>SSNIT System</option>
                                                <option value="paye">PAYE</option>
                                                <option value="custom">Custom</option>
                                            </select>
                                            <label for="tax-system">Tax System</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="tax-id" placeholder="Tax ID" value="SSNIT-12345-EMP" required>
                                            <label for="tax-id">Company SSNIT ID</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="tax-filing-frequency" required>
                                                <option value="">Select Filing Frequency</option>
                                                <option value="monthly" selected>Monthly</option>
                                                <option value="quarterly">Quarterly</option>
                                                <option value="annually">Annually</option>
                                            </select>
                                            <label for="tax-filing-frequency">Filing Frequency</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="next-filing-date" placeholder="Next Filing Date" value="2025-06-15" required>
                                            <label for="next-filing-date">Next Filing Date</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" id="tax-notes" placeholder="Tax Notes" style="height: 100px">Company is registered under the SSNIT system with full compliance requirements.</textarea>
                                    <label for="tax-notes">Tax Notes</label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="auto-calculate" checked>
                                    <label class="form-check-label" for="auto-calculate">Automatically calculate taxes</label>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Save Tax Settings</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="tax-brackets" role="tabpanel" aria-labelledby="tax-brackets-tab">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Income Range</th>
                                            <th>Tax Rate</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>$0 - $1,200</td>
                                            <td>0%</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>$1,201 - $2,500</td>
                                            <td>5%</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>$2,501 - $5,000</td>
                                            <td>10%</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>$5,001 - $10,000</td>
                                            <td>17.5%</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>$10,001+</td>
                                            <td>25%</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-end mt-3">
                                <button class="btn btn-success"><i class="fa-solid fa-plus"></i> Add Tax Bracket</button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ssnit-integration" role="tabpanel" aria-labelledby="ssnit-integration-tab">
                            <div class="alert alert-info">
                                <i class="fa-solid fa-info-circle me-2"></i> Configure API integration with the SSNIT platform for direct filing and data synchronization.
                            </div>
                            
                            <form>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="ssnit-api-key" placeholder="API Key" value="sk_ssnit_*****************************" required>
                                            <label for="ssnit-api-key">SSNIT API Key</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="ssnit-api-environment" required>
                                                <option value="">Select Environment</option>
                                                <option value="sandbox">Sandbox (Testing)</option>
                                                <option value="production" selected>Production</option>
                                            </select>
                                            <label for="ssnit-api-environment">API Environment</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="ssnit-api-endpoint" placeholder="API Endpoint" value="https://api.ssnit.gov.gh/v1/contributions" required>
                                            <label for="ssnit-api-endpoint">API Endpoint</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="ssnit-api-version" required>
                                                <option value="">Select API Version</option>
                                                <option value="v1" selected>Version 1.0</option>
                                                <option value="v2">Version 2.0 (Beta)</option>
                                            </select>
                                            <label for="ssnit-api-version">API Version</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <h6 class="mb-3">Integration Features</h6>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="feature-auto-filing" checked>
                                            <label class="form-check-label" for="feature-auto-filing">Automatic Filing</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="feature-data-sync" checked>
                                            <label class="form-check-label" for="feature-data-sync">Data Synchronization</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="feature-employee-verification" checked>
                                            <label class="form-check-label" for="feature-employee-verification">Employee Verification</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="feature-rate-updates" checked>
                                            <label class="form-check-label" for="feature-rate-updates">Rate Updates</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="feature-compliance-alerts" checked>
                                            <label class="form-check-label" for="feature-compliance-alerts">Compliance Alerts</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="feature-payment-integration">
                                            <label class="form-check-label" for="feature-payment-integration">Payment Integration</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">API Connection Status</label>
                                    <div class="d-flex align-items-center">
                                        <div class="spinner-grow text-success me-2" role="status" style="width: 1rem; height: 1rem;">
                                            <span class="visually-hidden">Connected</span>
                                        </div>
                                        <span class="text-success">Connected to SSNIT API</span>
                                        <button class="btn btn-sm btn-outline-primary ms-auto">Test Connection</button>
                                    </div>
                                </div>
                                
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Save API Settings</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="tax-compliance" role="tabpanel" aria-labelledby="tax-compliance-tab">
                            <div class="alert alert-info">
                                <i class="fa-solid fa-info-circle me-2"></i> Tax compliance documents and filings are managed through the SSNIT system.
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Compliance Status</label>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Compliant</div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Document</th>
                                            <th>Status</th>
                                            <th>Due Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Monthly SSNIT Contribution</td>
                                            <td><span class="badge bg-success">Filed</span></td>
                                            <td>April 15, 2025</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-download"></i></button>
                                                <button class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Quarterly Pension Report</td>
                                            <td><span class="badge bg-success">Filed</span></td>
                                            <td>March 31, 2025</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-download"></i></button>
                                                <button class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Annual SSNIT Summary</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                            <td>December 31, 2025</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-file-arrow-up"></i></button>
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

    <!-- Audit Trail Modal -->
    <div class="modal fade" id="auditTrailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-light py-2">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-history me-2 text-info"></i> Payroll Audit Trail
                    </h5>
                    <div class="d-flex align-items-center ms-auto me-2">
                        <div class="btn-group btn-group-sm me-3">
                            <button type="button" class="btn btn-outline-primary active">
                                <i class="fa-solid fa-list me-1"></i> All Activities
                            </button>
                            <button type="button" class="btn btn-outline-primary">
                                <i class="fa-solid fa-user-edit me-1"></i> Changes
                            </button>
                            <button type="button" class="btn btn-outline-primary">
                                <i class="fa-solid fa-file-invoice-dollar me-1"></i> Payments
                            </button>
                        </div>
                        <div class="input-group input-group-sm me-3" style="width: 200px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa-solid fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search audit logs...">
                        </div>
                        <button type="button" class="btn btn-sm btn-info">
                            <i class="fa-solid fa-download me-1"></i> Export Logs
                        </button>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select" id="audit-filter-type">
                                    <option value="all" selected>All Activities</option>
                                    <option value="salary">Salary Changes</option>
                                    <option value="deduction">Deduction Changes</option>
                                    <option value="tax">Tax Adjustments</option>
                                    <option value="benefit">Benefit Changes</option>
                                </select>
                                <label for="audit-filter-type">Activity Type</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="audit-date-from" value="2025-05-01">
                                <label for="audit-date-from">From Date</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="audit-date-to" value="2025-05-15">
                                <label for="audit-date-to">To Date</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Date & Time</th>
                                    <th>User</th>
                                    <th>Activity</th>
                                    <th>Employee</th>
                                    <th>Details</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>May 15, 2025 10:23 AM</td>
                                    <td>Admin User</td>
                                    <td><span class="badge bg-warning">Salary Change</span></td>
                                    <td>John Doe</td>
                                    <td>Base salary updated from $4,800 to $5,000</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>May 14, 2025 3:45 PM</td>
                                    <td>HR Manager</td>
                                    <td><span class="badge bg-info">Benefit Added</span></td>
                                    <td>Jane Smith</td>
                                    <td>Added transportation allowance of $150/month</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>May 14, 2025 11:30 AM</td>
                                    <td>Payroll Officer</td>
                                    <td><span class="badge bg-danger">Tax Adjustment</span></td>
                                    <td>Mike Johnson</td>
                                    <td>Updated tax exemption status</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>May 13, 2025 2:15 PM</td>
                                    <td>Finance Director</td>
                                    <td><span class="badge bg-success">Payroll Approved</span></td>
                                    <td>All Employees</td>
                                    <td>May 2025 payroll approved for processing</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>May 12, 2025 9:10 AM</td>
                                    <td>HR Manager</td>
                                    <td><span class="badge bg-primary">Deduction Added</span></td>
                                    <td>Sarah Williams</td>
                                    <td>Added loan repayment deduction of $200/month</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <span class="text-muted">Showing 5 of 127 records</span>
                        </div>
                        <div>
                            <button class="btn btn-outline-primary">Export Audit Log</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payroll Calendar Modal - Timeline View -->
    <div class="modal fade" id="payrollCalendarModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-light py-2">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-timeline me-2 text-primary"></i> Payroll Timeline
                    </h5>
                    <div class="d-flex align-items-center ms-auto me-2">
                        <div class="btn-group btn-group-sm me-3">
                            <button type="button" class="btn btn-outline-primary active" id="timelineView3Month">
                                <i class="fa-solid fa-calendar-week me-1"></i> 3 Months
                            </button>
                            <button type="button" class="btn btn-outline-primary" id="timelineView6Month">
                                <i class="fa-solid fa-calendar-alt me-1"></i> 6 Months
                            </button>
                            <button type="button" class="btn btn-outline-primary" id="timelineViewYear">
                                <i class="fa-solid fa-calendar me-1"></i> Year
                            </button>
                        </div>
                        <div class="input-group input-group-sm me-3" style="width: 200px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa-solid fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search events...">
                        </div>
                        <button type="button" class="btn btn-sm btn-primary" id="addTimelineEvent">
                            <i class="fa-solid fa-plus me-1"></i> Add Event
                        </button>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="d-flex h-100">
                        <!-- Timeline Controls Sidebar -->
                        <div class="timeline-sidebar bg-light border-end" style="width: 280px; height: calc(100vh - 120px); overflow-y: auto;">
                            <div class="p-3">
                                <h6 class="text-uppercase text-muted small fw-bold mb-3">Timeline Controls</h6>
                                
                                <!-- Date Navigation -->
                                <div class="mb-4">
                                    <label class="form-label small">Date Range</label>
                                    <div class="d-flex align-items-center mb-2">
                                        <button class="btn btn-sm btn-outline-secondary px-2 py-1">
                                            <i class="fa-solid fa-chevron-left"></i>
                                        </button>
                                        <div class="mx-2 text-center flex-grow-1">
                                            <span class="fw-bold">May - Jul 2025</span>
                                        </div>
                                        <button class="btn btn-sm btn-outline-secondary px-2 py-1">
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </button>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary w-100">
                                        <i class="fa-regular fa-calendar me-1"></i> Jump to Today
                                    </button>
                                </div>
                                
                                <!-- Event Filters -->
                                <div class="mb-4">
                                    <label class="form-label small d-flex justify-content-between align-items-center">
                                        <span>Event Categories</span>
                                        <a href="#" class="text-decoration-none small">Reset</a>
                                    </label>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="showPayrollProcessing" checked>
                                        <label class="form-check-label d-flex align-items-center" for="showPayrollProcessing">
                                            <span class="badge bg-primary me-2">•</span> Payroll Processing
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="showPaymentDates" checked>
                                        <label class="form-check-label d-flex align-items-center" for="showPaymentDates">
                                            <span class="badge bg-success me-2">•</span> Payment Dates
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="showTaxDeadlines" checked>
                                        <label class="form-check-label d-flex align-items-center" for="showTaxDeadlines">
                                            <span class="badge bg-info me-2">•</span> Tax Deadlines
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="showHolidays" checked>
                                        <label class="form-check-label d-flex align-items-center" for="showHolidays">
                                            <span class="badge bg-danger me-2">•</span> Holidays
                                        </label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="showMilestones" checked>
                                        <label class="form-check-label d-flex align-items-center" for="showMilestones">
                                            <span class="badge bg-warning me-2">•</span> Milestones
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Team Filters -->
                                <div class="mb-4">
                                    <label class="form-label small d-flex justify-content-between align-items-center">
                                        <span>Team Members</span>
                                        <a href="#" class="text-decoration-none small">All</a>
                                    </label>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="teamMember1" checked>
                                        <label class="form-check-label" for="teamMember1">
                                            HR Manager
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="teamMember2" checked>
                                        <label class="form-check-label" for="teamMember2">
                                            Finance Director
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="teamMember3" checked>
                                        <label class="form-check-label" for="teamMember3">
                                            Payroll Administrator
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Upcoming Events -->
                                <div class="mb-4">
                                    <label class="form-label small">Upcoming Events</label>
                                    <div class="list-group list-group-flush small">
                                        <div class="list-group-item px-0 py-2 border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="badge bg-primary me-2">•</div>
                                                <div>
                                                    <div class="fw-bold">May Payroll Processing</div>
                                                    <div class="text-muted">May 15, 2025</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item px-0 py-2 border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="badge bg-warning me-2">•</div>
                                                <div>
                                                    <div class="fw-bold">Processing Deadline</div>
                                                    <div class="text-muted">May 28, 2025</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item px-0 py-2 border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="badge bg-success me-2">•</div>
                                                <div>
                                                    <div class="fw-bold">May Payroll Date</div>
                                                    <div class="text-muted">May 30, 2025</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Main Timeline Area -->
                        <div class="timeline-main flex-grow-1" style="height: calc(100vh - 120px); overflow-y: auto;">
                            <!-- Timeline Header -->
                            <div class="timeline-header bg-white border-bottom sticky-top">
                                <div class="d-flex align-items-center p-2">
                                    <div class="timeline-zoom-controls me-3">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-secondary" title="Zoom Out">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" title="Zoom In">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" title="Reset Zoom">
                                                <i class="fa-solid fa-arrows-left-right-to-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="timeline-view-options me-3">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-secondary active" title="Timeline View">
                                                <i class="fa-solid fa-timeline"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" title="Gantt View">
                                                <i class="fa-solid fa-bars-progress"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" title="List View">
                                                <i class="fa-solid fa-list"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="timeline-display-options">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-secondary" title="Show Dependencies">
                                                <i class="fa-solid fa-diagram-project"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" title="Show Milestones">
                                                <i class="fa-solid fa-flag"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" title="Show Critical Path">
                                                <i class="fa-solid fa-route"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="ms-auto">
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-download me-1"></i> Export
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline Visualization -->
                            <div class="timeline-visualization p-3">
                                <!-- Month Headers -->
                                <div class="timeline-months d-flex border-bottom pb-2 mb-3">
                                    <div class="timeline-month flex-grow-1 text-center fw-bold border-end px-2">May 2025</div>
                                    <div class="timeline-month flex-grow-1 text-center fw-bold border-end px-2">June 2025</div>
                                    <div class="timeline-month flex-grow-1 text-center fw-bold px-2">July 2025</div>
                                </div>
                                
                                <!-- Timeline Grid -->
                                <div class="timeline-grid position-relative mb-4" style="height: 400px;">
                                    <!-- Time Axis -->
                                    <div class="timeline-axis d-flex position-relative mb-3" style="height: 30px;">
                                        <div class="timeline-tick position-absolute" style="left: 0%;">1</div>
                                        <div class="timeline-tick position-absolute" style="left: 10%;">5</div>
                                        <div class="timeline-tick position-absolute" style="left: 20%;">10</div>
                                        <div class="timeline-tick position-absolute" style="left: 30%;">15</div>
                                        <div class="timeline-tick position-absolute" style="left: 40%;">20</div>
                                        <div class="timeline-tick position-absolute" style="left: 50%;">25</div>
                                        <div class="timeline-tick position-absolute" style="left: 60%;">30</div>
                                        <div class="timeline-tick position-absolute" style="left: 66.6%;">5</div>
                                        <div class="timeline-tick position-absolute" style="left: 73.3%;">10</div>
                                        <div class="timeline-tick position-absolute" style="left: 80%;">15</div>
                                        <div class="timeline-tick position-absolute" style="left: 86.6%;">20</div>
                                        <div class="timeline-tick position-absolute" style="left: 93.3%;">25</div>
                                    </div>
                                    
                                    <!-- Today Marker -->
                                    <div class="timeline-today position-absolute bg-danger" style="width: 2px; height: 100%; left: 30%; top: 0; z-index: 10;"></div>
                                    
                                    <!-- Swim Lanes -->
                                    <div class="timeline-swimlanes">
                                        <!-- Payroll Processing Lane -->
                                        <div class="timeline-lane d-flex flex-column mb-4">
                                            <div class="lane-header d-flex align-items-center mb-2">
                                                <span class="badge bg-primary me-2">•</span>
                                                <span class="fw-bold">Payroll Processing</span>
                                            </div>
                                            <div class="lane-content position-relative" style="height: 60px;">
                                                <!-- Event Cards -->
                                                <div class="timeline-event position-absolute rounded bg-primary text-white p-2" style="left: 28%; width: 15%; top: 5px; height: 50px;">
                                                    <div class="small fw-bold">May Payroll Processing</div>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-user-tie me-1"></i>
                                                        <span class="small">HR Manager</span>
                                                    </div>
                                                </div>
                                                <div class="timeline-event position-absolute rounded bg-primary text-white p-2" style="left: 78%; width: 15%; top: 5px; height: 50px;">
                                                    <div class="small fw-bold">June Payroll Processing</div>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-user-tie me-1"></i>
                                                        <span class="small">HR Manager</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Payment Dates Lane -->
                                        <div class="timeline-lane d-flex flex-column mb-4">
                                            <div class="lane-header d-flex align-items-center mb-2">
                                                <span class="badge bg-success me-2">•</span>
                                                <span class="fw-bold">Payment Dates</span>
                                            </div>
                                            <div class="lane-content position-relative" style="height: 60px;">
                                                <!-- Event Cards -->
                                                <div class="timeline-event position-absolute rounded bg-success text-white p-2" style="left: 58%; width: 8%; top: 5px; height: 50px;">
                                                    <div class="small fw-bold">May Payroll</div>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-money-bill-wave me-1"></i>
                                                        <span class="small">$250,000</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Tax Deadlines Lane -->
                                        <div class="timeline-lane d-flex flex-column mb-4">
                                            <div class="lane-header d-flex align-items-center mb-2">
                                                <span class="badge bg-info me-2">•</span>
                                                <span class="fw-bold">Tax Deadlines</span>
                                            </div>
                                            <div class="lane-content position-relative" style="height: 60px;">
                                                <!-- Event Cards -->
                                                <div class="timeline-event position-absolute rounded bg-info text-white p-2" style="left: 28%; width: 12%; top: 5px; height: 50px;">
                                                    <div class="small fw-bold">SSNIT Filing</div>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-receipt me-1"></i>
                                                        <span class="small">May Contributions</span>
                                                    </div>
                                                </div>
                                                <div class="timeline-event position-absolute rounded bg-info text-white p-2" style="left: 80%; width: 12%; top: 5px; height: 50px;">
                                                    <div class="small fw-bold">SSNIT Filing</div>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-receipt me-1"></i>
                                                        <span class="small">June Contributions</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Milestones Lane -->
                                        <div class="timeline-lane d-flex flex-column mb-4">
                                            <div class="lane-header d-flex align-items-center mb-2">
                                                <span class="badge bg-warning me-2">•</span>
                                                <span class="fw-bold">Milestones</span>
                                            </div>
                                            <div class="lane-content position-relative" style="height: 60px;">
                                                <!-- Event Cards -->
                                                <div class="timeline-milestone position-absolute" style="left: 48%; top: 5px;">
                                                    <div class="milestone-icon bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                                        <i class="fa-solid fa-flag text-dark"></i>
                                                    </div>
                                                    <div class="milestone-label small fw-bold mt-1">Processing Deadline</div>
                                                </div>
                                                <div class="timeline-milestone position-absolute" style="left: 95%; top: 5px;">
                                                    <div class="milestone-icon bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                                        <i class="fa-solid fa-flag text-dark"></i>
                                                    </div>
                                                    <div class="milestone-label small fw-bold mt-1">Q2 End</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Dependencies (Arrows) -->
                                <svg class="timeline-dependencies position-absolute" style="top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 5;">
                                    <!-- These would be dynamically generated with JavaScript -->
                                    <!-- Example: <path d="M100,100 C150,100 150,200 200,200" stroke="#6c757d" stroke-width="2" fill="none" marker-end="url(#arrowhead)" /> -->
                                </svg>
                            </div>
                            
                            <!-- Timeline Details Panel -->
                            <div class="timeline-details border-top p-3">
                                <h6 class="mb-3">Selected Event Details</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header bg-primary text-white py-2">
                                                <h6 class="mb-0">May Payroll Processing</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-2">
                                                    <strong>Date:</strong> May 15, 2025
                                                </div>
                                                <div class="mb-2">
                                                    <strong>Duration:</strong> 3 days
                                                </div>
                                                <div class="mb-2">
                                                    <strong>Assigned to:</strong> HR Manager
                                                </div>
                                                <div class="mb-2">
                                                    <strong>Status:</strong> <span class="badge bg-success">Scheduled</span>
                                                </div>
                                                <div class="mb-3">
                                                    <strong>Description:</strong>
                                                    <p class="small mb-0">Process payroll for all employees for the month of May 2025. Includes calculating salaries, bonuses, deductions, and taxes.</p>
                                                </div>
                                                <div class="d-flex">
                                                    <button class="btn btn-sm btn-outline-primary me-2">
                                                        <i class="fa-solid fa-edit me-1"></i> Edit
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger">
                                                        <i class="fa-solid fa-trash me-1"></i> Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header bg-light py-2">
                                                <h6 class="mb-0">Dependencies & Notifications</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label small">Dependencies</label>
                                                    <div class="list-group list-group-flush small">
                                                        <div class="list-group-item px-0 py-2 border-0 d-flex align-items-center">
                                                            <i class="fa-solid fa-arrow-right me-2 text-muted"></i>
                                                            <div>
                                                                <div>Processing Deadline (May 28)</div>
                                                                <div class="text-muted">Must complete before</div>
                                                            </div>
                                                        </div>
                                                        <div class="list-group-item px-0 py-2 border-0 d-flex align-items-center">
                                                            <i class="fa-solid fa-arrow-right me-2 text-muted"></i>
                                                            <div>
                                                                <div>May Payroll (May 30)</div>
                                                                <div class="text-muted">Must complete before</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small">Notifications</label>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" id="notifyStart" checked>
                                                        <label class="form-check-label" for="notifyStart">
                                                            Notify when event starts
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" id="notifyComplete">
                                                        <label class="form-check-label" for="notifyComplete">
                                                            Notify when completed
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="notifyReminder" checked>
                                                        <label class="form-check-label" for="notifyReminder">
                                                            Send reminder 1 day before
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Self-Service Modal -->
    <div class="modal fade" id="employeeSelfServiceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-light py-2">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-users-gear me-2 text-warning"></i> Employee Self-Service Portal
                    </h5>
                    <div class="d-flex align-items-center ms-auto me-2">
                        <div class="btn-group btn-group-sm me-3">
                            <button type="button" class="btn btn-outline-primary active">
                                <i class="fa-solid fa-gear me-1"></i> Portal Settings
                            </button>
                            <button type="button" class="btn btn-outline-primary">
                                <i class="fa-solid fa-user-shield me-1"></i> Access Management
                            </button>
                            <button type="button" class="btn btn-outline-primary">
                                <i class="fa-solid fa-file-contract me-1"></i> Document Access
                            </button>
                        </div>
                        <div class="input-group input-group-sm me-3" style="width: 200px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa-solid fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search users...">
                        </div>
                        <button type="button" class="btn btn-sm btn-warning">
                            <i class="fa-solid fa-plus me-1"></i> Add User
                        </button>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="selfServiceTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="portal-settings-tab" data-bs-toggle="tab" data-bs-target="#portal-settings" type="button" role="tab" aria-controls="portal-settings" aria-selected="true">Portal Settings</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="access-management-tab" data-bs-toggle="tab" data-bs-target="#access-management" type="button" role="tab" aria-controls="access-management" aria-selected="false">Access Management</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="document-access-tab" data-bs-toggle="tab" data-bs-target="#document-access" type="button" role="tab" aria-controls="document-access" aria-selected="false">Document Access</button>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="selfServiceTabsContent">
                        <div class="tab-pane fade show active" id="portal-settings" role="tabpanel" aria-labelledby="portal-settings-tab">
                            <div class="alert alert-info">
                                <i class="fa-solid fa-info-circle me-2"></i> Configure the employee self-service portal settings and features.
                            </div>
                            
                            <form>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="portal-name" value="WorkyRoomie ESS Portal" required>
                                            <label for="portal-name">Portal Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="portal-theme" required>
                                                <option value="light">Light Theme</option>
                                                <option value="dark" selected>Dark Theme</option>
                                                <option value="custom">Custom Theme</option>
                                            </select>
                                            <label for="portal-theme">Portal Theme</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <h6 class="mb-3">Enabled Features</h6>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="feature-payslips" checked>
                                            <label class="form-check-label" for="feature-payslips">View Payslips</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="feature-tax-docs" checked>
                                            <label class="form-check-label" for="feature-tax-docs">Tax Documents</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="feature-benefits" checked>
                                            <label class="form-check-label" for="feature-benefits">Benefits Information</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="feature-personal-info" checked>
                                            <label class="form-check-label" for="feature-personal-info">Update Personal Info</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="feature-bank-info" checked>
                                            <label class="form-check-label" for="feature-bank-info">Update Bank Details</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="feature-time-attendance">
                                            <label class="form-check-label" for="feature-time-attendance">Time & Attendance</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <h6 class="mb-3">Security Settings</h6>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="session-timeout" required>
                                                <option value="15">15 minutes</option>
                                                <option value="30" selected>30 minutes</option>
                                                <option value="60">60 minutes</option>
                                            </select>
                                            <label for="session-timeout">Session Timeout</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="auth-method" required>
                                                <option value="password">Password Only</option>
                                                <option value="2fa" selected>Two-Factor Authentication</option>
                                                <option value="sso">Single Sign-On</option>
                                            </select>
                                            <label for="auth-method">Authentication Method</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Save Portal Settings</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="access-management" role="tabpanel" aria-labelledby="access-management-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Employee Portal Access</h6>
                                <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i> Add Employee</button>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Email</th>
                                            <th>Access Level</th>
                                            <th>Status</th>
                                            <th>Last Login</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>John Doe</td>
                                            <td>john.doe@example.com</td>
                                            <td>Standard</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>May 14, 2025 9:30 AM</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-key"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jane Smith</td>
                                            <td>jane.smith@example.com</td>
                                            <td>Standard</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>May 15, 2025 11:45 AM</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-key"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Mike Johnson</td>
                                            <td>mike.johnson@example.com</td>
                                            <td>Manager</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>May 15, 2025 8:15 AM</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-key"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sarah Williams</td>
                                            <td>sarah.williams@example.com</td>
                                            <td>Standard</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                            <td>Never</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-key"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>David Brown</td>
                                            <td>david.brown@example.com</td>
                                            <td>Standard</td>
                                            <td><span class="badge bg-secondary">Inactive</span></td>
                                            <td>April 30, 2025 2:20 PM</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-key"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="document-access" role="tabpanel" aria-labelledby="document-access-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Document Access Control</h6>
                                <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i> Add Document</button>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Document Type</th>
                                            <th>Description</th>
                                            <th>Access Level</th>
                                            <th>Self-Service</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Payslips</td>
                                            <td>Monthly salary statements</td>
                                            <td>Employee, Manager, Admin</td>
                                            <td><span class="badge bg-success">Enabled</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tax Forms</td>
                                            <td>Annual tax documents</td>
                                            <td>Employee, Manager, Admin</td>
                                            <td><span class="badge bg-success">Enabled</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Benefits Statements</td>
                                            <td>Employee benefits documentation</td>
                                            <td>Employee, Manager, Admin</td>
                                            <td><span class="badge bg-success">Enabled</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Salary History</td>
                                            <td>Historical salary information</td>
                                            <td>Manager, Admin</td>
                                            <td><span class="badge bg-danger">Disabled</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Performance Reviews</td>
                                            <td>Employee performance documents</td>
                                            <td>Manager, Admin</td>
                                            <td><span class="badge bg-danger">Disabled</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
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

    <!-- Benefits Management Modal -->
    <div class="modal fade" id="benefitsManagementModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-light py-2">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-hand-holding-medical me-2 text-success"></i> Benefits & Deductions Management
                    </h5>
                    <div class="d-flex align-items-center ms-auto me-2">
                        <div class="btn-group btn-group-sm me-3">
                            <button type="button" class="btn btn-outline-primary active">
                                <i class="fa-solid fa-heart-pulse me-1"></i> Health Benefits
                            </button>
                            <button type="button" class="btn btn-outline-primary">
                                <i class="fa-solid fa-piggy-bank me-1"></i> Retirement
                            </button>
                            <button type="button" class="btn btn-outline-primary">
                                <i class="fa-solid fa-calculator me-1"></i> Deductions
                            </button>
                        </div>
                        <div class="input-group input-group-sm me-3" style="width: 200px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa-solid fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search benefits...">
                        </div>
                        <button type="button" class="btn btn-sm btn-success">
                            <i class="fa-solid fa-plus me-1"></i> Add Benefit
                        </button>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="benefitsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="benefits-tab" data-bs-toggle="tab" data-bs-target="#benefits" type="button" role="tab" aria-controls="benefits" aria-selected="true">Benefits</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="deductions-tab" data-bs-toggle="tab" data-bs-target="#deductions" type="button" role="tab" aria-controls="deductions" aria-selected="false">Deductions</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="loan-advances-tab" data-bs-toggle="tab" data-bs-target="#loan-advances" type="button" role="tab" aria-controls="loan-advances" aria-selected="false">Loans & Advances</button>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="benefitsTabsContent">
                        <div class="tab-pane fade show active" id="benefits" role="tabpanel" aria-labelledby="benefits-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Available Benefits</h6>
                                <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i> Add Benefit</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Benefit Type</th>
                                            <th>Description</th>
                                            <th>Amount/Rate</th>
                                            <th>Taxable</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Health Insurance</td>
                                            <td>Comprehensive health coverage</td>
                                            <td>$200/month</td>
                                            <td><span class="badge bg-success">No</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Housing Allowance</td>
                                            <td>Monthly housing subsidy</td>
                                            <td>15% of base salary</td>
                                            <td><span class="badge bg-danger">Yes</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Transportation</td>
                                            <td>Transportation allowance</td>
                                            <td>$150/month</td>
                                            <td><span class="badge bg-danger">Yes</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Retirement Plan</td>
                                            <td>401(k) contribution</td>
                                            <td>5% match</td>
                                            <td><span class="badge bg-success">No</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="deductions" role="tabpanel" aria-labelledby="deductions-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Standard Deductions</h6>
                                <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i> Add Deduction</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Deduction Type</th>
                                            <th>Description</th>
                                            <th>Amount/Rate</th>
                                            <th>Mandatory</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Income Tax</td>
                                            <td>Standard income tax</td>
                                            <td>Based on tax brackets</td>
                                            <td><span class="badge bg-danger">Yes</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Social Security</td>
                                            <td>Social security contribution</td>
                                            <td>5.5% of gross salary</td>
                                            <td><span class="badge bg-danger">Yes</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Health Insurance Premium</td>
                                            <td>Employee portion of health insurance</td>
                                            <td>$50/month</td>
                                            <td><span class="badge bg-success">No</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Retirement Contribution</td>
                                            <td>Employee 401(k) contribution</td>
                                            <td>3% of gross salary</td>
                                            <td><span class="badge bg-success">No</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="loan-advances" role="tabpanel" aria-labelledby="loan-advances-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Active Loans & Advances</h6>
                                <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i> New Loan/Advance</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Monthly Deduction</th>
                                            <th>Remaining</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>John Doe</td>
                                            <td>Salary Advance</td>
                                            <td>$2,000</td>
                                            <td>$200</td>
                                            <td>$1,400</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jane Smith</td>
                                            <td>Personal Loan</td>
                                            <td>$5,000</td>
                                            <td>$300</td>
                                            <td>$3,800</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Mike Johnson</td>
                                            <td>Education Loan</td>
                                            <td>$3,500</td>
                                            <td>$250</td>
                                            <td>$2,750</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i></button>
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

@endsection

@section('script')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Simple event handlers for UI demonstration
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize DataTable with basic options
            $('#payroll-table').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf'
                ]
            });
            
            // Attach click handlers to action buttons
            attachActionHandlers();
            
            // Form submission handlers
            $('#processPayrollForm').on('submit', function(e) {
                e.preventDefault();
                showProcessingAlert('Processing Payroll', 'Calculating salaries and generating payroll...');
            });
            
            $('#generateReportForm').on('submit', function(e) {
                e.preventDefault();
                showProcessingAlert('Generating Report', 'Creating payroll report...');
            });
            
            $('#importPayrollDataForm').on('submit', function(e) {
                e.preventDefault();
                showProcessingAlert('Importing Data', 'Processing uploaded file...');
            });
        });
        
        function attachActionHandlers() {
            // View payroll details
            $('.view-payroll-details').on('click', function() {
                const employeeId = $(this).data('employee-id');
                showPayrollDetails(employeeId);
            });
            
            // Edit payroll
            $('.edit-payroll').on('click', function() {
                const employeeId = $(this).data('employee-id');
                showEditPayrollForm(employeeId);
            });
            
            // Generate payslip
            $('.generate-payslip').on('click', function() {
                const employeeId = $(this).data('employee-id');
                confirmPayslipGeneration(employeeId);
            });
        }
        
        function showPayrollDetails(employeeId) {
            // Static data for demo purposes
            const details = {
                employee_id: employeeId,
                employee_name: getEmployeeName(employeeId),
                department: getDepartment(employeeId),
                basic_salary: '5,000.00',
                allowances: '1,200.00',
                deductions: '800.00',
                net_pay: '5,400.00',
                tax_details: 'PAYE: $600.00, SSNIT: $200.00',
                payment_method: 'Direct Deposit',
                payment_date: '2025-05-30'
            };
            
            const detailsHtml = `
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="2" class="text-center bg-light">Employee Information</th>
                        </tr>
                        <tr>
                            <th width="40%">Employee ID</th>
                            <td>${details.employee_id}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>${details.employee_name}</td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td>${details.department}</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-center bg-light">Salary Details</th>
                        </tr>
                        <tr>
                            <th>Basic Salary</th>
                            <td>$${details.basic_salary}</td>
                        </tr>
                        <tr>
                            <th>Allowances</th>
                            <td>$${details.allowances}</td>
                        </tr>
                        <tr>
                            <th>Deductions</th>
                            <td>$${details.deductions}</td>
                        </tr>
                        <tr>
                            <th>Net Pay</th>
                            <td class="fw-bold text-success">$${details.net_pay}</td>
                        </tr>
                        <tr>
                            <th>Tax Details</th>
                            <td>${details.tax_details}</td>
                        </tr>
                        <tr>
                            <th>Payment Method</th>
                            <td>${details.payment_method}</td>
                        </tr>
                        <tr>
                            <th>Payment Date</th>
                            <td>${details.payment_date}</td>
                        </tr>
                    </table>
                </div>
            `;
            
            Swal.fire({
                title: `Payroll Details - ${details.employee_name}`,
                html: detailsHtml,
                width: '800px',
                confirmButtonText: 'Close'
            });
        }
        
        function showEditPayrollForm(employeeId) {
            const formHtml = `
                <form id="editPayrollForm" class="p-2">
                    <div class="mb-3">
                        <label class="form-label">Basic Salary</label>
                        <input type="number" class="form-control" name="basic_salary" value="5000" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Allowances</label>
                        <input type="number" class="form-control" name="allowances" value="1200" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deductions</label>
                        <input type="number" class="form-control" name="deductions" value="800" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select class="form-select" name="payment_method">
                            <option value="direct_deposit">Direct Deposit</option>
                            <option value="check">Check</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div>
                </form>
            `;
            
            Swal.fire({
                title: `Edit Payroll - ${getEmployeeName(employeeId)}`,
                html: formHtml,
                showCancelButton: true,
                confirmButtonText: 'Save Changes',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    // In a real app, this would validate and submit the form
                    return true;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Saved!', `Payroll updated for ${getEmployeeName(employeeId)}`, 'success');
                }
            });
        }
        
        function confirmPayslipGeneration(employeeId) {
            Swal.fire({
                title: 'Generate Payslip',
                text: `Generate payslip for ${getEmployeeName(employeeId)}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Generate',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Success!', 'Payslip has been generated and is ready for download.', 'success');
                }
            });
        }
        
        function showProcessingAlert(title, message) {
            Swal.fire({
                title: title,
                text: message,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                    setTimeout(() => {
                        Swal.fire('Success!', 'Operation completed successfully.', 'success');
                    }, 1500);
                }
            });
        }
        
        // Helper functions to get employee data
        function getEmployeeName(id) {
            const names = {
                'EMP001': 'John Doe',
                'EMP002': 'Jane Smith',
                'EMP003': 'Mike Johnson',
                'EMP004': 'Sarah Williams',
                'EMP005': 'David Brown'
            };
            return names[id] || 'Unknown Employee';
        }
        
        function getDepartment(id) {
            const departments = {
                'EMP001': 'Finance',
                'EMP002': 'HR',
                'EMP003': 'IT',
                'EMP004': 'Sales',
                'EMP005': 'Marketing'
            };
            return departments[id] || 'Unknown Department';
        }
    </script>

    <!-- Payroll Reports Modal -->
    <div class="modal fade" id="payrollReportsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-light py-2">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-chart-line me-2 text-info"></i> Payroll Reports
                    </h5>
                    <div class="d-flex align-items-center ms-auto me-2">
                        <div class="btn-group btn-group-sm me-3">
                            <button type="button" class="btn btn-outline-primary active">
                                <i class="fa-solid fa-table me-1"></i> Standard
                            </button>
                            <button type="button" class="btn btn-outline-primary">
                                <i class="fa-solid fa-chart-pie me-1"></i> Analytics
                            </button>
                            <button type="button" class="btn btn-outline-primary">
                                <i class="fa-solid fa-file-export me-1"></i> Export
                            </button>
                        </div>
                        <div class="input-group input-group-sm me-3" style="width: 200px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa-solid fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search reports...">
                        </div>
                        <button type="button" class="btn btn-sm btn-info">
                            <i class="fa-solid fa-plus me-1"></i> New Report
                        </button>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="d-flex h-100">
                        <!-- Sidebar -->
                        <div class="bg-light border-end" style="width: 280px; height: calc(100vh - 120px); overflow-y: auto;">
                            <div class="p-3">
                                <h6 class="text-uppercase text-muted small fw-bold mb-3">Report Categories</h6>
                                
                                <!-- Report Types -->
                                <div class="mb-4">
                                    <div class="list-group list-group-flush small">
                                        <a href="#" class="list-group-item list-group-item-action active px-0 py-2 border-0">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-solid fa-file-invoice-dollar me-2 text-info"></i>
                                                <span>Payroll Summary</span>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action px-0 py-2 border-0">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-solid fa-building-user me-2 text-info"></i>
                                                <span>Department Analysis</span>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action px-0 py-2 border-0">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-solid fa-receipt me-2 text-info"></i>
                                                <span>Tax Reports</span>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action px-0 py-2 border-0">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-solid fa-hand-holding-medical me-2 text-info"></i>
                                                <span>Benefits & Deductions</span>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action px-0 py-2 border-0">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-solid fa-clock me-2 text-info"></i>
                                                <span>Overtime Analysis</span>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action px-0 py-2 border-0">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-solid fa-chart-column me-2 text-info"></i>
                                                <span>Year-to-Date Summary</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Date Range -->
                                <div class="mb-3">
                                    <label class="form-label small">Date Range</label>
                                    <select class="form-select form-select-sm mb-2">
                                        <option>Current Month (May 2025)</option>
                                        <option>Previous Month (April 2025)</option>
                                        <option>Current Quarter (Q2 2025)</option>
                                        <option>Year to Date (2025)</option>
                                        <option>Custom Range</option>
                                    </select>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <input type="date" class="form-control form-control-sm" value="2025-05-01">
                                        </div>
                                        <div class="col-6">
                                            <input type="date" class="form-control form-control-sm" value="2025-05-31">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Export Options -->
                                <div class="mb-3">
                                    <label class="form-label small">Export Format</label>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-file-excel me-1"></i> Excel
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-file-pdf me-1"></i> PDF
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary">
                                            <i class="fa-solid fa-file-csv me-1"></i> CSV
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Main Content Area -->
                        <div class="flex-grow-1" style="height: calc(100vh - 120px); overflow-y: auto;">
                            <!-- Report Header -->
                            <div class="p-3 border-bottom">
                                <h5 class="mb-1">Payroll Summary Report</h5>
                                <p class="text-muted small mb-3">May 1-31, 2025 | Generated on May 15, 2025</p>
                                
                                <div class="row g-3 mb-3">
                                    <div class="col-md-3">
                                        <div class="card h-100">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="flex-shrink-0">
                                                        <i class="fa-solid fa-users text-primary fa-fw fa-lg"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0">Total Employees</h6>
                                                    </div>
                                                </div>
                                                <h3 class="mb-0">42</h3>
                                                <div class="text-muted small">Active employees</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card h-100">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="flex-shrink-0">
                                                        <i class="fa-solid fa-money-bill-wave text-success fa-fw fa-lg"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0">Total Payroll</h6>
                                                    </div>
                                                </div>
                                                <h3 class="mb-0">$250,000</h3>
                                                <div class="text-success small">+3.5% from last month</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card h-100">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="flex-shrink-0">
                                                        <i class="fa-solid fa-chart-simple text-info fa-fw fa-lg"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0">Average Salary</h6>
                                                    </div>
                                                </div>
                                                <h3 class="mb-0">$5,952</h3>
                                                <div class="text-info small">+2.1% from last month</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card h-100">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="flex-shrink-0">
                                                        <i class="fa-solid fa-receipt text-danger fa-fw fa-lg"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0">Total Taxes</h6>
                                                    </div>
                                                </div>
                                                <h3 class="mb-0">$35,000</h3>
                                                <div class="text-muted small">14% of gross payroll</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Report Content -->
                            <div class="p-3">
                                <!-- Department Breakdown Chart -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="card h-100">
                                            <div class="card-header py-2 bg-light">
                                                <h6 class="mb-0">Payroll by Department</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="chart-placeholder" style="height: 250px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 4px;">
                                                    <div class="text-center">
                                                        <i class="fa-solid fa-chart-pie fa-3x text-muted mb-2"></i>
                                                        <p class="mb-0">Pie Chart: Payroll Distribution by Department</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card h-100">
                                            <div class="card-header py-2 bg-light">
                                                <h6 class="mb-0">Monthly Payroll Trend</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="chart-placeholder" style="height: 250px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 4px;">
                                                    <div class="text-center">
                                                        <i class="fa-solid fa-chart-line fa-3x text-muted mb-2"></i>
                                                        <p class="mb-0">Line Chart: Payroll Trend (Last 6 Months)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Department Summary Table -->
                                <div class="card mb-4">
                                    <div class="card-header py-2 bg-light">
                                        <h6 class="mb-0">Department Summary</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Department</th>
                                                        <th>Employees</th>
                                                        <th>Gross Salary</th>
                                                        <th>Overtime</th>
                                                        <th>Benefits</th>
                                                        <th>Taxes</th>
                                                        <th>Net Payroll</th>
                                                        <th>Avg. Salary</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><span class="badge bg-soft-info text-info">Finance</span></td>
                                                        <td>8</td>
                                                        <td>$48,000</td>
                                                        <td>$2,500</td>
                                                        <td>$4,800</td>
                                                        <td>$7,200</td>
                                                        <td>$48,100</td>
                                                        <td>$6,013</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge bg-soft-primary text-primary">HR</span></td>
                                                        <td>6</td>
                                                        <td>$36,000</td>
                                                        <td>$1,200</td>
                                                        <td>$3,600</td>
                                                        <td>$5,400</td>
                                                        <td>$35,400</td>
                                                        <td>$5,900</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge bg-soft-danger text-danger">IT</span></td>
                                                        <td>12</td>
                                                        <td>$72,000</td>
                                                        <td>$4,800</td>
                                                        <td>$7,200</td>
                                                        <td>$10,800</td>
                                                        <td>$73,200</td>
                                                        <td>$6,100</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge bg-soft-success text-success">Sales</span></td>
                                                        <td>10</td>
                                                        <td>$55,000</td>
                                                        <td>$3,500</td>
                                                        <td>$5,500</td>
                                                        <td>$8,250</td>
                                                        <td>$55,750</td>
                                                        <td>$5,575</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge bg-soft-warning text-warning">Marketing</span></td>
                                                        <td>6</td>
                                                        <td>$39,000</td>
                                                        <td>$1,800</td>
                                                        <td>$3,900</td>
                                                        <td>$5,850</td>
                                                        <td>$38,850</td>
                                                        <td>$6,475</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot class="table-group-divider">
                                                    <tr class="fw-bold">
                                                        <td>Total</td>
                                                        <td>42</td>
                                                        <td>$250,000</td>
                                                        <td>$13,800</td>
                                                        <td>$25,000</td>
                                                        <td>$37,500</td>
                                                        <td>$251,300</td>
                                                        <td>$5,983</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info"><i class="fa-solid fa-print me-1"></i> Print Report</button>
                    <button type="button" class="btn btn-primary"><i class="fa-solid fa-download me-1"></i> Download</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payroll Processing Modal -->
    <div class="modal fade" id="payrollProcessingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-light py-2">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-money-bill-wave me-2 text-primary"></i> Payroll Processing
                    </h5>
                    <div class="d-flex align-items-center ms-auto me-2">
                        <div class="btn-group btn-group-sm me-3">
                            <button type="button" class="btn btn-outline-primary active">
                                <i class="fa-solid fa-calculator me-1"></i> Calculate
                            </button>
                            <button type="button" class="btn btn-outline-primary">
                                <i class="fa-solid fa-check-double me-1"></i> Verify
                            </button>
                            <button type="button" class="btn btn-outline-primary">
                                <i class="fa-solid fa-paper-plane me-1"></i> Disburse
                            </button>
                        </div>
                        <div class="input-group input-group-sm me-3" style="width: 200px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa-solid fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search employees...">
                        </div>
                        <button type="button" class="btn btn-sm btn-primary">
                            <i class="fa-solid fa-play me-1"></i> Run Payroll
                        </button>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="d-flex h-100">
                        <!-- Sidebar -->
                        <div class="bg-light border-end" style="width: 280px; height: calc(100vh - 120px); overflow-y: auto;">
                            <div class="p-3">
                                <h6 class="text-uppercase text-muted small fw-bold mb-3">Payroll Settings</h6>
                                
                                <!-- Pay Period -->
                                <div class="mb-3">
                                    <label class="form-label small">Pay Period</label>
                                    <select class="form-select form-select-sm">
                                        <option>May 1-31, 2025</option>
                                        <option>June 1-30, 2025</option>
                                        <option>July 1-31, 2025</option>
                                    </select>
                                </div>
                                
                                <!-- Pay Date -->
                                <div class="mb-3">
                                    <label class="form-label small">Pay Date</label>
                                    <input type="date" class="form-control form-control-sm" value="2025-05-30">
                                </div>
                                
                                <!-- Processing Options -->
                                <div class="mb-3">
                                    <label class="form-label small d-flex justify-content-between align-items-center">
                                        <span>Processing Options</span>
                                    </label>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="includeOvertime" checked>
                                        <label class="form-check-label" for="includeOvertime">
                                            Include Overtime
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="includeBonus" checked>
                                        <label class="form-check-label" for="includeBonus">
                                            Include Bonuses
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="autoTax" checked>
                                        <label class="form-check-label" for="autoTax">
                                            Auto-calculate Taxes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="autoDeductions" checked>
                                        <label class="form-check-label" for="autoDeductions">
                                            Auto-apply Deductions
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Department Filter -->
                                <div class="mb-3">
                                    <label class="form-label small d-flex justify-content-between align-items-center">
                                        <span>Departments</span>
                                        <a href="#" class="text-decoration-none small">All</a>
                                    </label>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="deptFinance" checked>
                                        <label class="form-check-label" for="deptFinance">
                                            Finance
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="deptHR" checked>
                                        <label class="form-check-label" for="deptHR">
                                            HR
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="deptIT" checked>
                                        <label class="form-check-label" for="deptIT">
                                            IT
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="deptSales" checked>
                                        <label class="form-check-label" for="deptSales">
                                            Sales
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="deptMarketing" checked>
                                        <label class="form-check-label" for="deptMarketing">
                                            Marketing
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Main Content Area -->
                        <div class="flex-grow-1" style="height: calc(100vh - 120px); overflow-y: auto;">
                            <!-- Payroll Summary -->
                            <div class="p-3 border-bottom">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div class="card h-100">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="flex-shrink-0">
                                                        <i class="fa-solid fa-users text-primary fa-fw fa-lg"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0">Employees</h6>
                                                    </div>
                                                </div>
                                                <h3 class="mb-0">42</h3>
                                                <div class="text-muted small">5 new this month</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card h-100">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="flex-shrink-0">
                                                        <i class="fa-solid fa-money-bill-wave text-success fa-fw fa-lg"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0">Gross Payroll</h6>
                                                    </div>
                                                </div>
                                                <h3 class="mb-0">$250,000</h3>
                                                <div class="text-success small">+3.5% from last month</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card h-100">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="flex-shrink-0">
                                                        <i class="fa-solid fa-receipt text-danger fa-fw fa-lg"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0">Tax Withholdings</h6>
                                                    </div>
                                                </div>
                                                <h3 class="mb-0">$35,000</h3>
                                                <div class="text-muted small">14% of gross</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card h-100">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="flex-shrink-0">
                                                        <i class="fa-solid fa-hand-holding-dollar text-info fa-fw fa-lg"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0">Net Payable</h6>
                                                    </div>
                                                </div>
                                                <h3 class="mb-0">$215,000</h3>
                                                <div class="text-muted small">Ready to disburse</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Payroll Table -->
                            <div class="p-3">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="selectAllEmployees">
                                                        <label class="form-check-label" for="selectAllEmployees"></label>
                                                    </div>
                                                </th>
                                                <th>Employee</th>
                                                <th>Department</th>
                                                <th>Basic Salary</th>
                                                <th>Overtime</th>
                                                <th>Allowances</th>
                                                <th>Deductions</th>
                                                <th>Tax</th>
                                                <th>Net Pay</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" checked>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <div class="avatar avatar-xs me-2 bg-soft-primary text-primary rounded-circle">
                                                                <span>JD</span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            John Doe
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-soft-info text-info">Finance</span></td>
                                                <td>$5,000.00</td>
                                                <td>$250.00</td>
                                                <td>$950.00</td>
                                                <td>$800.00</td>
                                                <td>$750.00</td>
                                                <td>$4,650.00</td>
                                                <td><span class="badge bg-success">Ready</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-outline-info"><i class="fa-solid fa-eye"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" checked>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <div class="avatar avatar-xs me-2 bg-soft-success text-success rounded-circle">
                                                                <span>JS</span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            Jane Smith
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-soft-primary text-primary">HR</span></td>
                                                <td>$4,800.00</td>
                                                <td>$0.00</td>
                                                <td>$1,000.00</td>
                                                <td>$700.00</td>
                                                <td>$720.00</td>
                                                <td>$4,380.00</td>
                                                <td><span class="badge bg-success">Ready</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-outline-info"><i class="fa-solid fa-eye"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" checked>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <div class="avatar avatar-xs me-2 bg-soft-warning text-warning rounded-circle">
                                                                <span>MJ</span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            Mike Johnson
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-soft-danger text-danger">IT</span></td>
                                                <td>$5,500.00</td>
                                                <td>$300.00</td>
                                                <td>$800.00</td>
                                                <td>$900.00</td>
                                                <td>$825.00</td>
                                                <td>$4,875.00</td>
                                                <td><span class="badge bg-warning">Review</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-outline-info"><i class="fa-solid fa-eye"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Process Payroll</button>
                </div>
            </div>
        </div>
    </div>

@endsection