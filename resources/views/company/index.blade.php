@extends('layouts.vertical', ['page_title' => 'Dashboard - Company', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/daterangepicker/daterangepicker.css', 'node_modules/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css'])
    <link href="{{ asset('css/vendor/quill.core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/vendor/quill.snow.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/vendor/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .dashboard-card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
        }
        .stat-value {
            font-size: 1.75rem;
            font-weight: 600;
            margin: 0.5rem 0;
        }
        .progress {
            height: 6px;
            border-radius: 3px;
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }
        .notification-item {
            transition: background-color 0.2s ease;
        }
        .notification-item:hover {
            background-color: #f8f9fa;
        }
        .timeline-alt .timeline-item {
            position: relative;
            padding-left: 45px;
            margin-bottom: 20px;
        }
        .timeline-icon {
            position: absolute;
            left: 0;
            top: 0;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Title & Date Range -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <form class="d-flex">
                            <div class="input-group">
                                <input type="text" class="form-control shadow-none border" id="dash-daterange">
                                <span class="input-group-text bg-primary border-primary text-white">
                                    <i class="ri-calendar-todo-fill fs-13"></i>
                                </span>
                            </div>
                            <a href="javascript: void(0);" class="btn btn-primary ms-2">
                                <i class="ri-refresh-line"></i>
                            </a>
                        </form>
                    </div>
                    <h4 class="page-title mb-0">Company Dashboard</h4>
                </div>
            </div>
        </div>

        <!-- Quick Stats Row -->
        <div class="row">
            <!-- Budget vs Target -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted text-uppercase fs-13 mt-0">Budget vs Target</h6>
                                <h3 class="stat-value">85%</h3>
                                <div class="progress mb-2">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mb-0 text-muted">
                                    <span class="text-success me-2"><i class="ri-arrow-up-line"></i> 7.8%</span>
                                    <span class="text-nowrap">vs last period</span>
                                </p>
                            </div>
                            <div class="stat-icon bg-success-subtle">
                                <i class="ri-bar-chart-box-line font-24 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Sales -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted text-uppercase fs-13 mt-0">Total Sales</h6>
                                <h3 class="stat-value">₵48,254</h3>
                                <p class="mb-0 text-muted">
                                    <span class="text-success me-2"><i class="ri-arrow-up-line"></i> 5.2%</span>
                                    <span class="text-nowrap">vs last month</span>
                                </p>
                            </div>
                            <div class="stat-icon bg-primary-subtle">
                                <i class="ri-shopping-cart-2-line font-24 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Tasks -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted text-uppercase fs-13 mt-0">Pending Tasks</h6>
                                <h3 class="stat-value">21</h3>
                                <p class="mb-0 text-muted">
                                    <span class="text-danger me-2"><i class="ri-arrow-down-line"></i> 2</span>
                                    <span class="text-nowrap">tasks added today</span>
                                </p>
                            </div>
                            <div class="stat-icon bg-info-subtle">
                                <i class="ri-task-line font-24 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Unread Messages -->
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted text-uppercase fs-13 mt-0">Unread Messages</h6>
                                <h3 class="stat-value">8</h3>
                                <p class="mb-0 text-muted">
                                    <span class="text-success me-2"><i class="ri-message-2-line"></i></span>
                                    <span class="text-nowrap">3 new messages</span>
                                </p>
                            </div>
                            <div class="stat-icon bg-warning-subtle">
                                <i class="ri-message-2-line font-24 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row">
            <!-- Left Column -->
            <div class="col-xl-8">
                <!-- Request Tray -->
                <div class="card dashboard-card">
                    <div class="card-header d-flex justify-content-between align-items-center py-3">
                        <h5 class="header-title mb-0">Request Tray</h5>
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="ri-filter-2-line me-1"></i> Filter by: All
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#"><i class="ri-error-warning-line text-danger me-1"></i>High Priority</a>
                                <a class="dropdown-item" href="#"><i class="ri-alert-line text-warning me-1"></i>Medium Priority</a>
                                <a class="dropdown-item" href="#"><i class="ri-information-line text-info me-1"></i>Low Priority</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-centered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">Request ID</th>
                                        <th class="border-top-0">Title</th>
                                        <th class="border-top-0">Priority</th>
                                        <th class="border-top-0">Status</th>
                                        <th class="border-top-0">Due Date</th>
                                        <th class="border-top-0">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <span class="fw-semibold">#REQ-001</span>
                                        </td>
                                        <td>System Update Request</td>
                                        <td><span class="badge bg-danger-subtle text-danger">High</span></td>
                                        <td><span class="badge bg-warning-subtle text-warning">Pending</span></td>
                                        <td>2025-01-20</td>
                                        <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="javascript:void(0);" class="dropdown-item text-success">
                                                        <i class="ri-check-line me-1"></i>Accept
                                                    </a>
                                                    <a href="javascript:void(0);" class="dropdown-item text-danger">
                                                        <i class="ri-close-line me-1"></i>Reject
                                                    </a>
                                                    <a href="javascript:void(0);" class="dropdown-item text-primary">
                                                        <i class="ri-share-forward-line me-1"></i>Forward
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Sales Statistics -->
                <div class="card dashboard-card">
                    <div class="card-header d-flex justify-content-between align-items-center py-3">
                        <h5 class="header-title mb-0">Sales Statistics</h5>
                        <div class="d-flex align-items-center">
                            <div class="btn-group me-2">
                                <button type="button" class="btn btn-sm btn-light">Daily</button>
                                <button type="button" class="btn btn-sm btn-primary">Monthly</button>
                                <button type="button" class="btn btn-sm btn-light">Yearly</button>
                            </div>
                            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#sales-statistics-modal">
                                <i class="ri-fullscreen-line"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-1">₵48,254</h4>
                                        <p class="text-muted mb-0">Total Sales</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div id="total-sales-sparkline" class="apex-charts" data-colors="#3e60d5"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-1">1,248</h4>
                                        <p class="text-muted mb-0">Orders</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div id="total-orders-sparkline" class="apex-charts" data-colors="#47ad77"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-1">+5.27%</h4>
                                        <p class="text-muted mb-0">Growth</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div id="sales-growth-sparkline" class="apex-charts" data-colors="#fa5c7c"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="sales-statistics" class="apex-charts" data-colors="#3e60d5,#47ad77" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-xl-4">
                <!-- Notifications -->
                <div class="card dashboard-card">
                    <div class="card-header d-flex justify-content-between align-items-center py-3">
                        <h5 class="header-title mb-0">Notifications</h5>
                        <a href="javascript:void(0);" class="btn btn-sm btn-link text-muted">
                            View All <i class="ri-arrow-right-line align-middle"></i>
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action notification-item">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm bg-primary-subtle rounded">
                                            <i class="ri-file-text-line text-primary font-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">New document requires approval</h6>
                                        <p class="text-muted mb-0 fs-13">
                                            <i class="ri-time-line me-1"></i>2 mins ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Tasks -->
                <div class="card dashboard-card">
                    <div class="card-header d-flex justify-content-between align-items-center py-3">
                        <h5 class="header-title mb-0">Quick Tasks</h5>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add-task-modal">
                            Add Task
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="todo-list">
                            <div class="todo-item d-flex align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="task1">
                                </div>
                                <label class="form-check-label ms-2 flex-grow-1" for="task1">
                                    Review quarterly report
                                </label>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown">
                                        <i class="ri-more-2-fill"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Edit</a>
                                        <a class="dropdown-item" href="#">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Widget -->
                <div class="card dashboard-card">
                    <div class="card-header d-flex justify-content-between align-items-center py-3">
                        <h5 class="header-title mb-0">Team Chat</h5>
                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#new-chat-modal">
                            New Chat
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="chat-widget" style="height: 350px; overflow-y: auto;">
                            <div class="chat-message-list">
                                <div class="chat-message-left pb-4">
                                    <div>
                                        <img src="{{ asset('images/users/avatar-1.jpg') }}" class="rounded-circle avatar-sm" alt="user">
                                        <div class="mt-2">
                                            <small class="text-muted">Stephen Ameyaw, 10:00</small>
                                            <div class="bg-light rounded p-2 mt-1">
                                                Hi team, how's the progress on the STARK ?
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-input mt-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Type your message...">
                                <button class="btn btn-primary" type="button">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics & Reports Row -->
        <div class="row">
            <!-- Revenue Analytics -->
            <div class="col-12">
                <div class="card dashboard-card">
                    <div class="card-header d-flex justify-content-between align-items-center py-3">
                        <h5 class="header-title mb-0">Revenue Analytics</h5>
                        <div class="d-flex align-items-center">
                            <div class="dropdown me-2">
                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="ri-filter-2-line me-1"></i> Filter
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Last 7 Days</a>
                                    <a class="dropdown-item" href="#">Last 30 Days</a>
                                    <a class="dropdown-item" href="#">Last 90 Days</a>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#revenue-analytics-modal">
                                <i class="ri-fullscreen-line"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-1">₵142,364</h4>
                                        <p class="text-muted mb-0">Total Revenue</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div id="total-revenue-sparkline" class="apex-charts" data-colors="#3e60d5"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-1">₵92,536</h4>
                                        <p class="text-muted mb-0">Direct Sales</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div id="direct-revenue-sparkline" class="apex-charts" data-colors="#47ad77"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-1">₵49,828</h4>
                                        <p class="text-muted mb-0">Online Sales</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div id="online-revenue-sparkline" class="apex-charts" data-colors="#fa5c7c"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="revenue-analytics" class="apex-charts" data-colors="#3e60d5,#47ad77,#fa5c7c" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar & Activities Row -->
        <div class="row">
            <!-- Calendar -->
            <div class="col-xl-8">
                <div class="card dashboard-card">
                    <div class="card-header d-flex justify-content-between align-items-center py-3">
                        <h5 class="header-title mb-0">Calendar</h5>
                        <div>
                            <button type="button" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#add-event-modal">
                                Add Event
                            </button>
                            <button type="button" class="btn btn-sm btn-light">
                                <i class="ri-calendar-2-line"></i> Sync
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="col-xl-4">
                <div class="card dashboard-card">
                    <div class="card-header d-flex justify-content-between align-items-center py-3">
                        <h5 class="header-title mb-0">Recent Activities</h5>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown">
                                <i class="ri-more-2-fill"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" class="dropdown-item">Refresh</a>
                                <a href="javascript:void(0);" class="dropdown-item">Export</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="timeline-alt pb-0">
                            <div class="timeline-item">
                                <i class="ri-user-add-line bg-info-subtle text-info timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <a href="#" class="text-info fw-bold mb-1 d-block">New client registered</a>
                                    <small>15 minutes ago</small>
                                    <p class="mb-0 pb-2">
                                        <small class="text-muted">Client ID: #CLT458</small>
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <i class="ri-file-text-line bg-primary-subtle text-primary timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <a href="#" class="text-primary fw-bold mb-1 d-block">New order received</a>
                                    <small>45 minutes ago</small>
                                    <p class="mb-0 pb-2">
                                        <small class="text-muted">Order ID: #ORD789</small>
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <i class="ri-money-dollar-circle-line bg-success-subtle text-success timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <a href="#" class="text-success fw-bold mb-1 d-block">Payment received</a>
                                    <small>1 hour ago</small>
                                    <p class="mb-0 pb-2">
                                        <small class="text-muted">Transaction ID: #TRX123</small>
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <i class="ri-truck-line bg-warning-subtle text-warning timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <a href="#" class="text-warning fw-bold mb-1 d-block">Order shipped</a>
                                    <small>2 hours ago</small>
                                    <p class="mb-0 pb-2">
                                        <small class="text-muted">Order ID: #ORD456</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Management Row -->
        <div class="row">
            <div class="col-12">
                <div class="card dashboard-card">
                    <div class="card-header d-flex justify-content-between align-items-center py-3">
                        <h5 class="header-title mb-0">Document Management</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#upload-document-modal">
                            Upload Document
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>Document</th>
                                        <th>Assigned By</th>
                                        <th>Status</th>
                                        <th>Due Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <i class="ri-file-text-line text-primary font-18 me-1"></i>
                                            Q4 Financial Report.pdf
                                        </td>
                                        <td>Camby Omori</td>
                                        <td><span class="badge bg-warning-subtle text-warning">Pending Review</span></td>
                                        <td>2025-01-20</td>
                                        <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="javascript:void(0);" class="dropdown-item">Download</a>
                                                    <a href="javascript:void(0);" class="dropdown-item">Approve</a>
                                                    <a href="javascript:void(0);" class="dropdown-item">Reject</a>
                                                </div>
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

    <!-- Modals -->
    <!-- Add Task Modal -->
    <div class="modal fade" id="add-task-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Task Title</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Priority</label>
                            <select class="form-select">
                                <option>High</option>
                                <option>Medium</option>
                                <option>Low</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Due Date</label>
                            <input type="date" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Add Task</button>
                </div>
            </div>
        </div>
    </div>

    <!-- New Chat Modal -->
    <div class="modal fade" id="new-chat-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Start New Chat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Select Recipients</label>
                            <select class="form-select" multiple>
                                <option>Camby Omori</option>
                                <option>Stephen Ameyaw</option>
                                <option>John Doe</option>
                                <option>Jane Smith</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" rows="3" placeholder="Type your message..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Attachments</label>
                            <input type="file" class="form-control" multiple>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Start Chat</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Event Modal -->
    <div class="modal fade" id="add-event-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Event Title</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Event Description</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="datetime-local" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="datetime-local" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Event Color</label>
                            <select class="form-select">
                                <option value="#0acf97">Green</option>
                                <option value="#39afd1">Blue</option>
                                <option value="#ffbc00">Yellow</option>
                                <option value="#fa5c7c">Red</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="allDay">
                                <label class="form-check-label" for="allDay">All Day Event</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Add Event</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Document Modal -->
    <div class="modal fade" id="view-document-modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Document Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="document-preview bg-light p-3 rounded" style="height: 400px;">
                                <iframe src="" width="100%" height="100%" frameborder="0"></iframe>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="mb-2">Document Information</h6>
                            <div class="mb-3">
                                <small class="text-muted">Uploaded By</small>
                                <p class="mb-1">Camby Omori</p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Upload Date</small>
                                <p class="mb-1">2025-01-20</p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">File Size</small>
                                <p class="mb-1">2.5 MB</p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Status</small>
                                <p class="mb-1"><span class="badge bg-warning-subtle text-warning">Pending Review</span></p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Comments</small>
                                <div class="mt-2">
                                    <textarea class="form-control" rows="3" placeholder="Add a comment..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Approve</button>
                    <button type="button" class="btn btn-danger">Reject</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Settings Modal -->
    <div class="modal fade" id="profile-settings-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Profile Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="text-center mb-3">
                            <img src="{{ asset('images/users/avatar-1.jpg') }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                            <div class="mt-2">
                                <button type="button" class="btn btn-light btn-sm">Change Photo</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" value="Camby Omori">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="camby@example.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" value="+1234567890">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" value="Administrator" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bio</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <h6 class="mb-3">Change Password</h6>
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Settings Modal -->
    <div class="modal fade" id="notification-settings-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Notification Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6 class="mb-3">Email Notifications</h6>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="emailNewOrder" checked>
                            <label class="form-check-label" for="emailNewOrder">New Order</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="emailTaskAssigned" checked>
                            <label class="form-check-label" for="emailTaskAssigned">Task Assigned</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="emailMentions">
                            <label class="form-check-label" for="emailMentions">Mentions</label>
                        </div>
                    </div>
                    
                    <h6 class="mb-3 mt-4">Push Notifications</h6>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="pushNewMessage" checked>
                            <label class="form-check-label" for="pushNewMessage">New Message</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="pushNewComment" checked>
                            <label class="form-check-label" for="pushNewComment">New Comment</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="pushReminders">
                            <label class="form-check-label" for="pushReminders">Reminders</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Document Modal -->
    <div class="modal fade" id="upload-document-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Document Title</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select">
                                <option>Financial Report</option>
                                <option>Contract</option>
                                <option>Invoice</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Assign To</label>
                            <select class="form-select" multiple>
                                <option>Camby Omori</option>
                                <option>Stephen Ameyaw</option>
                                <option>John Doe</option>
                                <option>Jane Smith</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Due Date</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Priority</label>
                            <select class="form-select">
                                <option>High</option>
                                <option>Medium</option>
                                <option>Low</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File</label>
                            <input type="file" class="form-control" required>
                            <small class="text-muted">Supported formats: PDF, DOC, DOCX, XLS, XLSX (Max size: 10MB)</small>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="notifyAssignees">
                                <label class="form-check-label" for="notifyAssignees">Notify Assignees</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Statistics Modal -->
    <div class="modal fade" id="sales-statistics-modal" tabindex="-1" aria-labelledby="sales-statistics-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sales-statistics-modal-label">Sales Statistics</h5>
                    <div class="btn-group mx-3">
                        <button type="button" class="btn btn-sm btn-light">Daily</button>
                        <button type="button" class="btn btn-sm btn-primary">Monthly</button>
                        <button type="button" class="btn btn-sm btn-light">Yearly</button>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card border-0 shadow-none">
                                <div class="card-body">
                                    <h6 class="text-muted text-uppercase fs-13 mt-0">Total Sales</h6>
                                    <h3 class="mb-3">₵48,254</h3>
                                    <div class="progress mb-2" style="height: 6px;">
                                        <div class="progress-bar bg-success" style="width: 75%"></div>
                                    </div>
                                    <p class="text-muted mb-0">
                                        <span class="text-success me-2"><i class="ri-arrow-up-line"></i> 5.27%</span>
                                        <span>vs last period</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div id="sales-statistics-modal-chart" class="apex-charts" data-colors="#3e60d5,#47ad77" style="height: 400px;"></div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-centered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                            <th>Growth</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Product A</td>
                                            <td>234</td>
                                            <td>₵12,456</td>
                                            <td><span class="badge bg-success-subtle text-success">+8.3%</span></td>
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

    <!-- Revenue Analytics Modal -->
    <div class="modal fade" id="revenue-analytics-modal" tabindex="-1" aria-labelledby="revenue-analytics-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="revenue-analytics-modal-label">Revenue Analytics</h5>
                    <div class="dropdown mx-3">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="ri-filter-2-line me-1"></i> Filter
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Last 7 Days</a>
                            <a class="dropdown-item" href="#">Last 30 Days</a>
                            <a class="dropdown-item" href="#">Last 90 Days</a>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card border-0 shadow-none">
                                <div class="card-body">
                                    <h6 class="text-muted text-uppercase fs-13 mt-0">Total Revenue</h6>
                                    <h3 class="mb-3">₵142,364</h3>
                                    <div class="progress mb-2" style="height: 6px;">
                                        <div class="progress-bar bg-primary" style="width: 68%"></div>
                                    </div>
                                    <p class="text-muted mb-0">
                                        <span class="text-primary me-2"><i class="ri-arrow-up-line"></i> 12.5%</span>
                                        <span>vs last month</span>
                                    </p>
                                </div>
                            </div>
                            <div class="card border-0 shadow-none mt-3">
                                <div class="card-body">
                                    <h6 class="text-muted text-uppercase fs-13 mt-0">Revenue Sources</h6>
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Direct Sales</span>
                                            <span>65%</span>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-success" style="width: 65%"></div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Online Sales</span>
                                            <span>35%</span>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-info" style="width: 35%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div id="revenue-analytics-modal-chart" class="apex-charts" data-colors="#3e60d5,#47ad77,#fa5c7c" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @vite(['resources/js/pages/demo.dashboard.js'])
    <script src="{{ asset('js/vendor/quill.min.js') }}"></script>
    <script src="{{ asset('js/vendor/fullcalendar.min.js') }}"></script>
    <script>
        // Initialize Calendar
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [
                    {
                        title: 'Team Meeting',
                        start: '2025-01-24',
                        color: '#0acf97'
                    },
                    {
                        title: 'Project Deadline',
                        start: '2025-01-28',
                        color: '#fa5c7c'
                    }
                ],
                editable: true,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true
            });
            calendar.render();
        });

        // Initialize Quill Editor for Chat
        var quill = new Quill('#chat-editor', {
            theme: 'snow',
            placeholder: 'Type your message...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    ['link', 'blockquote'],
                    [{ list: 'ordered' }, { list: 'bullet' }]
                ]
            }
        });
    </script>
@endsection
