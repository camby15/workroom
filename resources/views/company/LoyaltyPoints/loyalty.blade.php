@extends('layouts.vertical', ['page_title' => 'Loyalty Program'])

@section('css')
@vite([
'node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css',
'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'
])
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
    .form-floating input.form-control:focus,
    .form-floating input.form-control:not(:placeholder-shown),
    .form-floating select.form-select:focus,
    .form-floating select.form-select:not([value=""]),
    .form-floating textarea.form-control:focus,
    .form-floating textarea.form-control:not(:placeholder-shown) {
        border-color: #033c42;
        box-shadow: none;
    }
    .form-floating input.form-control:focus ~ label,
    .form-floating input.form-control:not(:placeholder-shown) ~ label,
    .form-floating select.form-select:focus ~ label,
    .form-floating select.form-select:not([value=""]) ~ label,
    .form-floating textarea.form-control:focus ~ label,
    .form-floating textarea.form-control:not(:placeholder-shown) ~ label {
        height: auto;
        padding: 0 0.5rem;
        transform: translateY(-60%) translateX(0.5rem) scale(0.85);
        color: white;
        border-radius: 5px;
        z-index: 5;
    }
    .form-floating input.form-control:focus~label::before,
    .form-floating input.form-control:not(:placeholder-shown)~label::before,
    .form-floating select.form-select:focus~label::before,
    .form-floating select.form-select:not([value=""])~label::before,
    .form-floating textarea.form-control:focus~label::before,
    .form-floating textarea.form-control:not(:placeholder-shown)~label::before {
            content: "";
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
    [data-bs-theme="dark"] .form-floating input.form-control,
    [data-bs-theme="dark"] .form-floating select.form-select,
    [data-bs-theme="dark"] .form-floating textarea.form-control {
        border-color: #6c757d;
        color: #e9ecef;
    }
    
    [data-bs-theme="dark"] .form-floating label {
        color: #adb5bd;
    }

    [data-bs-theme="dark"] .form-floating input.form-control:focus,
    [data-bs-theme="dark"] .form-floating input.form-control:not(:placeholder-shown),
    [data-bs-theme="dark"] .form-floating select.form-select:focus,
    [data-bs-theme="dark"] .form-floating select.form-select:not([value=""]),
    [data-bs-theme="dark"] .form-floating textarea.form-control:focus,
    [data-bs-theme="dark"] .form-floating textarea.form-control:not(:placeholder-shown) {
        border-color: #0dcaf0;
    }

    [data-bs-theme="dark"] .form-floating input.form-control:focus ~ label::before,
    [data-bs-theme="dark"] .form-floating input.form-control:not(:placeholder-shown) ~ label::before,
    [data-bs-theme="dark"] .form-floating select.form-select:focus ~ label::before,
    [data-bs-theme="dark"] .form-floating select.form-select:not([value=""]) ~ label::before,
    [data-bs-theme="dark"] .form-floating textarea.form-control:focus ~ label::before,
    [data-bs-theme="dark"] .form-floating textarea.form-control:not(:placeholder-shown) ~ label::before {
        background: #0dcaf0;
    }

    [data-bs-theme="dark"] select.form-select option {
        background-color: #212529;
        color: #e9ecef;
    }

    /* Action Button Styles */
    .action-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 10px;
        transition: transform 0.3s;
    }
    .action-btn i {
        font-size: 24px; /* Adjust icon size */
        color: #555; /* Default color */
    }
    .action-btn:hover i {
        transform: scale(1.2); /* Slightly enlarge the icon on hover */
    }
    .edit-btn i {
        color: #007bff; /* Blue for edit */
    }
    .view-btn i {
        color: #28a745; /* Green for view */
    }
    .delete-btn i {
        color: #dc3545; /* Red for delete */
    }
    .assign-btn i {
        color: #ff9900; /* Orange for assign */
    }
    /* Additional Loyalty-specific Styles */
    .tier-badge {
        padding: 0.35rem 0.65rem;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 500;
    }
    .program-card {
        border: 2px solid #033c42;
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    .program-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    }
    .stat-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px); /* Move the card up */
        box-shadow: 0 8px 16px rgba(0,0,0,0.2); /* Increase shadow for depth */
    }
    .stat-card h5 {
        margin-top: 12%;
    }
    .stat-card.active-members {
        background-color: #007bff; /* Sky Blue */
        
        color: white;
    }
    .stat-card.active-members {
        border-left: 4px solid #a687eb;
    }

    .stat-card.points-redeemed {
        background-color: #28a745; /* Lime Green */
        color: white;
    }
    .stat-card.points-redeemed {
        border-left: 4px solid #7aed7a;
    }

    .stat-card.active-programs {
        background-color: #db9f28; /* Gold */
        color: white;
    }
    .stat-card.active-programs {
        border-left: 4px solid #f4c93b;
    }

    .stat-card.clv-increase {
        background-color: #2b5f9c;
        color: white;
    }
    .stat-card.clv-increase {
        border-left: 4px solid #3d80e4;
    }
    
    .card-header i {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Shadow effect */
    }
    .form-check-input:checked {
        background-color: #28a745 !important; /* Green for active */
        border-color: #28a745 !important; /* Green border */
    }
    .form-check-input:not(:checked) {
        background-color: #e23535 !important; /* Red for inactive */
        border-color: #e71c31 !important; /* Red border */
    }
    /* Dark Mode Styles */
    body {
        background-color: #343a40;
        color: #ffffff;
    }
    .card {
        background-color: #495057;
        border-color: #6c757d;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }
    .btn-custom {
        background-color: #007bff;
        color: white;
        border-radius: 5px;
        padding: 10px 20px;
        transition: background-color 0.3s;
    }
    .btn-custom:hover {
        background-color: #0056b3;
    }
    .tier-card {
        border: 1px solid #6c757d;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    .btn-icon {
        background-color: transparent;
        border: none;
        color: #007bff;
        font-size: 1.5rem;
        margin-right: 10px;
        transition: color 0.3s;
    }

    .btn-icon:hover {
        color: #0056b3;
    }
    .btn-add-new {
        background-color: #007bff; /* Blue color */
        color: white;
        border: 2px solid #0056b3; /* Darker blue border */
        border-radius: 5px;
        padding: 10px 15px;
        font-size: 1rem;
        transition: background-color 0.3s, transform 0.3s;
    }

    .btn-add-new:hover {
        background-color: #0056b3; /* Darker blue on hover */
        transform: scale(1.05);
    }

    .btn-add-new i {
        margin-right: 5px; /* Space between icon and text */
    }
    .btn {
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    .btn-primary {
        background-color: #007bff;
        color: white;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
    }
    .btn-info {
        background-color: #28a745;
        color: white;
    }
    .btn-info:hover {
        background-color: #218838;
    }
    .btn-success {
        background-color: #28a745;
        color: white;
    }
    .btn-success:hover {
        background-color: #218838;
    }
    .btn-danger {
        background-color: #dc3545;
        color: white;
    }
    .btn-danger:hover {
        background-color: #c82333;
    }
    .btn-warning {
        background-color: #ff9900;
        color: white;
    }
    .btn-warning:hover {
        background-color: #cc7a00;
    }
    .btn-light {
        background-color: #f8f9fa;
        color: #333;
    }
    .btn-light:hover {
        background-color: #e2e6ea;
    }
    .btn-dark {
        background-color: #343a40;
        color: white;
    }
    .btn-dark:hover {
        background-color: #23272b;
    }
    .btn-link {
        background-color: transparent;
        color: #007bff;
    }
    .btn-link:hover {
        color: #0056b3;
    }
    .btn-sm {
        padding: 5px 10px;
        font-size: 0.875rem;
    }
    .btn-lg {
        padding: 15px 30px;
        font-size: 1.25rem;
    }
    .btn-block {
        width: 100%;
        padding: 10px 0;
        font-size: 1rem;
    }
    .btn-block + .btn-block {
        margin-top: 10px;
    }
</style>
@endsection

@section('content')
<!-- Container Fluid -->
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <!-- Page Title Right -->
                <div class="page-title-right">
                    <div class="d-flex">
                        <!-- Button Container -->
                        <div class="button-container">
                            <!-- New Program Button -->
                            <button type="button" class="btn btn-primary me-2" onclick="showGenericModal('Create New Loyalty Program', 'createProgramForm')">
                                <i class="fas fa-plus me-1"></i> New Program
                            </button>
                            <!-- Import Customers Button -->
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#importCustomersModal">
                                Import Customers
                            </button>
                            <!-- Generate Report Button -->
                            <button type="button" class="btn btn-info btn-custom" onclick="generateReport()">
                                <i class="fas fa-chart-bar me-1"></i> Generate Report
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Page Title -->
                <h1 class="page-title">Loyalty Program</h1>
            </div>
        </div>
    </div>

    <!-- Program Overview Cards -->
    <div class="row mb-4">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="stat-card active-members">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Active Members</h5>
                    <i class="fas fa-users fa-3x"></i> <!-- Increased size to 3x -->
                </div>
                <div class="card-body">
                    <p>Number of active members: 15,234</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="stat-card points-redeemed">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Points Redeemed</h5>
                    <i class="fas fa-gift fa-3x"></i> <!-- Increased size to 3x -->
                </div>
                <div class="card-body">
                    <p>Points redeemed: 2.1M</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="stat-card active-programs">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Active Programs</h5>
                    <i class="fas fa-star fa-3x"></i> <!-- Increased size to 3x -->
                </div>
                <div class="card-body">
                    <p>Active programs: 8</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="stat-card clv-increase">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>CLV Increase</h5>
                    <i class="fas fa-chart-line fa-3x"></i> <!-- Increased size to 3x -->
                </div>
                <div class="card-body">
                    <p>CLV increase: 34%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Program Management -->
    <div class="card program-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-hover" id="loyaltyProgramsTable">
                    <thead>
                        <tr>
                            <th scope="col">Program Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Active Members</th>
                            <th scope="col">Points Issued</th>
                            <th scope="col">Redemption Rate</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample Data -->
                        <tr>
                            <td>Premium Tier Rewards</td>
                            <td><span class="tier-badge bg-success">Tier-Based</span></td>
                            <td>2022-01-01</td>
                            <td>2023-12-31</td>
                            <td>4,321</td>
                            <td>1.2M</td>
                            <td>
                                <div class="progress-container">
                                    <div class="loyalty-progress bg-success" style="width: 65%"></div>
                                </div>
                                <small class="text-muted">65%</small>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="programStatus1" checked>
                                    <label class="form-check-label" for="programStatus1"></label>
                                </div>
                            </td>
                            <td>
                                <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#editLoyaltyProgramModal" onclick="editLoyaltyProgram(1)">
                                    <i class="fa-solid fa-edit text-primary"></i>
                                </button>
                                <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#viewLoyaltyProgramModal" onclick="viewLoyaltyProgram(1)">
                                    <i class="fa-solid fa-eye text-success"></i>
                                </button>
                                <button class="btn-icon delete-loyalty-program" data-id="1">
                                    <i class="fa-solid fa-trash text-danger"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Gold Rewards Program</td>
                            <td><span class="tier-badge bg-warning">Tier-Based</span></td>
                            <td>2022-01-01</td>
                            <td>2023-12-31</td>
                            <td>2,500</td>
                            <td>800K</td>
                            <td>
                                <div class="progress-container">
                                    <div class="loyalty-progress bg-danger" style="width: 15%"></div>
                                </div>
                                <small class="text-muted">15%</small>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="programStatus2" checked>
                                    <label class="form-check-label" for="programStatus2"></label>
                                </div>
                            </td>
                            <td>
                                <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#editLoyaltyProgramModal" onclick="editLoyaltyProgram(2)">
                                    <i class="fa-solid fa-edit text-primary"></i>
                                </button>
                                <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#viewLoyaltyProgramModal" onclick="viewLoyaltyProgram(2)">
                                    <i class="fa-solid fa-eye text-success"></i>
                                </button>
                                <button class="btn-icon delete-loyalty-program" data-id="2">
                                    <i class="fa-solid fa-trash text-danger"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Customer Segmentation Section -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Customer Segmentation</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="card reward-card">
                        <div class="card-body d-flex align-items-center">
                            <i class="fas fa-crown text-warning reward-card-icon me-3"></i>
                            <div>
                                <h6>Platinum Members</h6>
                                <p class="mb-1">1,234 customers</p>
                                <small class="text-muted">Top 5% spenders</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card reward-card">
                        <div class="card-body d-flex align-items-center">
                            <i class="fas fa-star text-success reward-card-icon me-3"></i>
                            <div>
                                <h6>Active Redeemers</h6>
                                <p class="mb-1">3,456 customers</p>
                                <small class="text-muted">Redeemed 3+ times</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card reward-card">
                        <div class="card-body d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle text-danger reward-card-icon me-3"></i>
                            <div>
                                <h6>At-Risk Members</h6>
                                <p class="mb-1">892 customers</p>
                                <small class="text-muted">No activity in 90 days</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tier Management Section -->
    <div class="card tier-card">
        <div class="card-header">
            <h3 class="card-title">Manage Customer Tiers</h3>
        </div>
        <div class="card-body">
            <table class="table table-centered">
                <thead>
                    <tr>
                        <th>Tier Name</th>
                        <th>Benefits</th>
                        <th>Criteria for Advancement</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Silver</td>
                        <td>5% Discount, Exclusive Offers</td>
                        <td>100 Points</td>
                        <td>
                            <button class="btn-icon" data-toggle="modal" data-target="#editTierModal" title="Edit">
                                <i  class="fa-solid fa-edit text-primary"></i>
                            </button>
                            <button class="btn-icon" title="Delete" onclick="deleteTier()">
                                <i class="fas fa-trash text-danger"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Gold</td>
                        <td>10% Discount, Early Access</td>
                        <td>500 Points</td>
                        <td>
                            <button class="btn-icon" data-toggle="modal" data-target="#editTierModal" title="Edit">
                                <i  class="fa-solid fa-edit text-primary"></i>
                            </button>
                            <button class="btn-icon" title="Delete" onclick="deleteTier()">
                                <i class="fas fa-trash text-danger"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Platinum</td>
                        <td>15% Discount, Free Gifts</td>
                        <td>1000 Points</td>
                        <td>
                            <button class="btn-icon" data-toggle="modal" data-target="#editTierModal" title="Edit">
                                <i  class="fa-solid fa-edit text-primary"></i>
                            </button>
                            <button class="btn-icon" title="Delete" onclick="deleteTier()">
                                <i class="fas fa-trash text-danger"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button class="btn btn-primary" data-toggle="modal" data-target="#addTierModal">
                <i class="fas fa-plus"></i> Add New Tier
            </button>
        </div>
    </div>

    <!-- Points Redemption Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Points Redemption</h5>
                </div>
                <div class="card-body">
                    <p>Available Points: <strong>{{ isset($availablePoints) ? $availablePoints : 0 }}</strong></p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pointsRedemptionModal">Redeem Points</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Personalized Offers Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Personalized Offers</h5>
                </div>
                <div class="card-body">
                    <p>Special offer for you: <strong>{{ isset($personalizedOffer) ? $personalizedOffer : 'No offers available' }}</strong></p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#personalizedOffersModal">View Offer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Referral Program Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Referral Program</h5>
                </div>
                <div class="card-body">
                    <p>Refer a friend and earn <strong>500 points</strong>!</p>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#referralProgramModal">Refer Now</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info">
                <strong>Notice:</strong> Your points will expire in <strong>30 days</strong>! Check your rewards.
            </div>
        </div>
    </div>

    <!-- Feedback Mechanism Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Feedback</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="feedback" class="form-label">Your Feedback</label>
                            <textarea class="form-control" id="feedback" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#feedbackModal">Submit Feedback</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add New Tier Modal -->
    <div class="modal fade" id="addTierModal" tabindex="-1" aria-labelledby="addTierModalLabel" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTierModalLabel">Add New Tier</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addTierForm">
                        <div class="mb-3">
                            <label for="tierName" class="form-label">Tier Name</label>
                            <input type="text" class="form-control" id="tierName" required>
                        </div>
                        <div class="mb-3">
                            <label for="tierBenefits" class="form-label">Benefits</label>
                            <input type="text" class="form-control" id="tierBenefits" required>
                        </div>
                        <div class="mb-3">
                            <label for="tierCriteria" class="form-label">Criteria for Advancement</label>
                            <input type="number" class="form-control" id="tierCriteria" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addTier()">Add Tier</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Tier Modal -->
    <div class="modal fade" id="editTierModal" tabindex="-1" aria-labelledby="editTierModalLabel" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTierModalLabel">Edit Tier</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editTierForm">
                        <div class="mb-3">
                            <label for="editTierName" class="form-label">Tier Name</label>
                            <input type="text" class="form-control" id="editTierName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editTierBenefits" class="form-label">Benefits</label>
                            <input type="text" class="form-control" id="editTierBenefits" required>
                        </div>
                        <div class="mb-3">
                            <label for="editTierCriteria" class="form-label">Criteria for Advancement</label>
                            <input type="number" class="form-control" id="editTierCriteria" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="editTier()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Customers Modal -->
    <div class="modal fade" id="importCustomersModal" tabindex="-1" role="dialog" aria-labelledby="importCustomersModalLabel" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importCustomersModalLabel">Import Customers</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="customerFile">Upload Customer File (CSV)</label>
                            <input type="file" class="form-control-file" id="customerFile" name="customerFile" accept=".csv" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Import Customers</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add New Program Modal -->
    <div class="modal fade" id="addProgramModal" tabindex="-1" aria-labelledby="addProgramModalLabel" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProgramModalLabel">Add New Loyalty Program</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createProgramForm">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="programName" placeholder="Program Name" required>
                            <label for="programName">Program Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="programType" placeholder="Program Type" required>
                            <label for="programType">Program Type</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="startDate" required>
                            <label for="startDate">Start Date</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="endDate" required>
                            <label for="endDate">End Date</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Program</button>
                    </form>
                    <div id="feedbackMessage" class="mt-3" style="display:none;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Loyalty Program Modal -->
    <div class="modal fade" id="editLoyaltyProgramModal" tabindex="-1" aria-labelledby="editLoyaltyProgramModalLabel" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLoyaltyProgramModalLabel">Edit Loyalty Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editLoyaltyProgramForm">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="programName" placeholder="Program Name" required>
                            <label for="programName">Program Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="programType" placeholder="Program Type" required>
                            <label for="programType">Program Type</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="startDate" required>
                            <label for="startDate">Start Date</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="endDate" required>
                            <label for="endDate">End Date</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="editLoyaltyProgram()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Loyalty Program Modal -->
    <div class="modal fade" id="viewLoyaltyProgramModal" tabindex="-1" aria-labelledby="viewLoyaltyProgramModalLabel" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewLoyaltyProgramModalLabel">View Loyalty Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="loyaltyProgramDetails">
                        <!-- Loyalty program details will be dynamically loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reusable Modal Template -->
    <div class="modal fade" id="genericModal" tabindex="-1" aria-hidden="true" aria-labelledby="genericModalLabel" aria-modal="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="genericModalLabel">Report Title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="genericForm" novalidate>
                        <div class="mb-3">
                            <label for="genericName" class="form-label">Program Name</label>
                            <input type="text" class="form-control" id="genericName" name="genericName" required>
                            <div class="invalid-feedback">Please enter the program name.</div>
                        </div>
                        <div class="mb-3">
                            <label for="genericType" class="form-label">Type</label>
                            <input class="form-control" id="genericType" name="genericType" required>
                            <div class="invalid-feedback">Please enter a type.</div>
                        </div>
                        <div class="mb-3">
                            <label for="genericStartDate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="genericStartDate" name="genericStartDate" required>
                            <div class="invalid-feedback">Please select a start date.</div>
                        </div>
                        <div class="mb-3">
                            <label for="genericEndDate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="genericEndDate" name="genericEndDate" required>
                            <div class="invalid-feedback">Please select an end date.</div>
                        </div>
                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Points Redemption Modal -->
    <div class="modal fade" id="pointsRedemptionModal" tabindex="-1" aria-labelledby="pointsRedemptionModalLabel" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pointsRedemptionModalLabel">Redeem Points</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to redeem your points?</p>
                    <p>Available Points: <strong>{{ isset($availablePoints) ? $availablePoints : 0 }}</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Confirm Redemption</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tier Management Modal -->
    <div class="modal fade" id="tierManagementModal" tabindex="-1" aria-labelledby="tierManagementModalLabel" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tierManagementModalLabel">Manage Customer Tiers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="tierName" class="form-label">Tier Name</label>
                            <input type="text" class="form-control" id="tierName" placeholder="Enter tier name">
                        </div>
                        <div class="mb-3">
                            <label for="tierBenefits" class="form-label">Benefits</label>
                            <textarea class="form-control" id="tierBenefits" rows="3" placeholder="Enter benefits"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Personalized Offers Modal -->
    <div class="modal fade" id="personalizedOffersModal" tabindex="-1" aria-labelledby="personalizedOffersModalLabel" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="personalizedOffersModalLabel">Personalized Offers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Your special offer: <strong>{{ isset($personalizedOffer) ? $personalizedOffer : 'No offers available' }}</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Redeem Offer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Referral Program Modal -->
    <div class="modal fade" id="referralProgramModal" tabindex="-1" aria-labelledby="referralProgramModalLabel" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="referralProgramModalLabel">Referral Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Refer a friend and earn <strong>{{ isset($referralPoints) ? $referralPoints : '500' }}</strong> points!</p>
                    <button class="btn btn-success">Copy Referral Link</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabel">Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="feedbackText" class="form-label">Your Feedback</label>
                            <textarea class="form-control" id="feedbackText" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Submit Feedback</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script>
        // Function to show the generic modal with dynamic title
        function showGenericModal(title, formId) {
            $('#genericModalLabel').text(title);
            $('#genericForm').attr('id', formId);
            $('#genericModal').modal('show');
        }

        // Function to generate report
        const generateReport = () => {
            console.log('Generate Report function called');
            $.ajax({
                type: 'GET',
                url: '/generate-report',
                success: function(response) {
                    Swal.fire('Success!', 'Report generated', 'success');
                }
            });
        };

        // Function to edit loyalty program
        function editLoyaltyProgram(id) {
            // Fetch current data for the loyalty program
            $.ajax({
                url: '/loyalty-programs/' + id,
                method: 'GET',
                success: function(data) {
                    // Populate the form fields in the edit modal
                    $('#editLoyaltyProgramForm').find('#programName').val(data.name);
                    $('#editLoyaltyProgramForm').find('#programDescription').val(data.description);
                    // Show the modal
                    $('#editLoyaltyProgramModal').modal('show');
                },
                error: function(error) {
                    console.log('Error fetching loyalty program data:', error);
                }
            });
        }

        // Function to view loyalty program
        function viewLoyaltyProgram(id) {
            // Fetch details for the loyalty program
            $.ajax({
                url: '/loyalty-programs/' + id,
                method: 'GET',
                success: function(data) {
                    // Display the data in the view modal
                    $('#viewLoyaltyProgramModal').find('.modal-body').html(data.details);
                    // Show the modal
                    $('#viewLoyaltyProgramModal').modal('show');
                },
                error: function(error) {
                    console.log('Error fetching loyalty program details:', error);
                }
            });
        }

        $(document).ready(function() {
            // Initialize DataTable
            $('#loyaltyProgramsTable').DataTable({
                responsive: true,
                dom: 'Bfrtip',
            });

            // Function to view rewards history
            window.viewRewardsHistory = function(rewardId) {
                // AJAX call to retrieve rewards history details
                $.ajax({
                    type: 'GET',
                    url: '/rewards-history/' + rewardId,
                    success: function(data) {
                        // Populate rewards history details
                        $('#rewardsHistoryDetails').html(data);
                        $('#viewRewardsHistoryModal').modal('show');
                    }
                });
            };
            // Function to delete program
            window.deleteProgram = function() {
                // AJAX call to delete program
                $.ajax({
                    type: 'DELETE',
                    url: '/loyalty-programs/',
                    success: function(response) {
                        Swal.fire('Success!', 'Loyalty program deleted', 'success');
                        // Reload the page to update the table
                        location.reload();
                    }
                });
            }
        });
    </script>
@endsection
@push('scripts')
    <script src="path/to/your/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush