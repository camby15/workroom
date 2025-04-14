    @extends('layouts.vertical', ['page_title' => 'CRM Dashboard'])
    @section('css')
        @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
            'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
            'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css',
            'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'])
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

            /* Dashboard specific styles */
            .stat-card {
                border-radius: 15px;
                transition: transform 0.3s ease;
            }
            .stat-card:hover {
                transform: translateY(-5px);
            }
            .stat-icon {
                font-size: 2.5rem;
                opacity: 0.8;
            }
            .chart-container {
                height: 300px;
            }
            .activity-timeline {
                position: relative;
                padding-left: 30px;
            }
            .activity-timeline::before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                height: 100%;
                width: 2px;
                background: var(--bs-border-color);
            }
            .activity-item {
                position: relative;
                padding-bottom: 1.5rem;
            }
            .activity-item::before {
                content: '';
                position: absolute;
                left: -34px;
                top: 0;
                width: 10px;
                height: 10px;
                border-radius: 50%;
                background: var(--bs-primary);
            }
            /* Enhanced Kanban Board Styles */
            .kanban-board {
                display: flex;
                gap: 1.5rem;
                overflow-x: auto;
                padding: 1.5rem;
                min-height: 500px;
                scrollbar-width: thin;
                scrollbar-color: var(--bs-primary) var(--bs-light);
            }
            .kanban-board::-webkit-scrollbar {
                height: 8px;
            }
            .kanban-board::-webkit-scrollbar-track {
                background: var(--bs-light);
                border-radius: 4px;
            }
            .kanban-board::-webkit-scrollbar-thumb {
                background: var(--bs-primary);
                border-radius: 4px;
            }
            .kanban-column {
                min-width: 320px;
                background: var(--bs-light);
                border-radius: 10px;
                padding: 1rem;
                display: flex;
                flex-direction: column;
            }
            [data-bs-theme="dark"] .kanban-column {
                background: var(--bs-dark);
                border: 1px solid var(--bs-border-color);
            }
            .kanban-column-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1rem;
                padding-bottom: 0.5rem;
                border-bottom: 2px solid var(--bs-border-color);
            }
            .kanban-column-header h5 {
                margin: 0;
                font-weight: 600;
            }
            .column-badge {
                background: var(--bs-primary);
                color: white;
                padding: 0.25rem 0.75rem;
                border-radius: 15px;
                font-size: 0.875rem;
            }
            .task-cards-container {
                flex-grow: 1;
                min-height: 200px;
            }
            .task-card {
                background: var(--bs-body-bg);
                border-radius: 8px;
                padding: 1rem;
                margin-bottom: 0.75rem;
                cursor: pointer;
                border: 1px solid var(--bs-border-color);
                transition: all 0.3s ease;
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            }
            .task-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }
            .task-card.dragging {
                opacity: 0.5;
                transform: scale(0.95);
            }
            .task-card h6 {
                margin-bottom: 0.5rem;
                font-weight: 600;
            }
            .task-card-meta {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 0.75rem;
                font-size: 0.875rem;
            }
            .task-card-owner {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            .task-card-owner img {
                width: 24px;
                height: 24px;
                border-radius: 50%;
                object-fit: cover;
            }
            .add-deal-button {
                width: 100%;
                border: 2px dashed var(--bs-border-color);
                background: transparent;
                border-radius: 8px;
                padding: 0.75rem;
                color: var(--bs-primary);
                margin-top: 0.5rem;
                transition: all 0.3s ease;
            }
            .add-deal-button:hover {
                background: var(--bs-primary);
                color: white;
                border-style: solid;
            }
            .lead-sources-chart {
                height: 400px;
            }
            .sales-performance-card {
                min-height: 400px;
            }
            .sales-performance-card .card-body {
                min-height: 400px;
                display: flex;
                flex-direction: column;
            }
            .sales-performance-card .chart-container {
                flex: 1;
                min-height: 220px;
            }
        </style>
    @endsection

    @section('content')
        <div class="container-fluid">
            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">CRM Dashboard</h4>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Total Leads</h6>
                                    @php
                                        $totalLeads = \App\Models\CrmLeads::where('company_id', session('selected_company_id'))->count();
                                        $previousMonthLeadsCount = \App\Models\CrmLeads::where('company_id', session('selected_company_id'))
                                            ->whereMonth('created_at', now()->subMonth()->month)
                                            ->count();
                                        $leadsPercentageChange = number_format((($totalLeads / max(1, $previousMonthLeadsCount)) * 100) - 100, 1);
                                    @endphp
                                    <h3 class="mb-0">{{ $totalLeads }}</h3>
                                    <span class="badge bg-success">{{ $leadsPercentageChange }}% <i class="fas fa-arrow-up"></i></span>
                                </div>
                                <div class="stat-icon text-primary">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Deals Won</h6>
                                    @php
                                        $totalDeals = \App\Models\Opportunity::where('company_id', session('selected_company_id'))->count();
                                        $previousMonthDealsCount = \App\Models\Opportunity::where('company_id', session('selected_company_id'))
                                            ->whereMonth('created_at', now()->subMonth()->month)
                                            ->count();
                                        $dealsPercentageChange = number_format((($totalDeals / max(1, $previousMonthDealsCount)) * 100) - 100, 1);
                                    @endphp
                                    <h3 class="mb-0">{{ $totalDeals }}</h3>
                                    <span class="badge bg-success">{{ $dealsPercentageChange }}% <i class="fas fa-arrow-up"></i></span>
                                </div>
                                <div class="stat-icon text-success">
                                    <i class="fas fa-crown"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Total Sales</h6>
                                    @php
                                        $totalRevenue = \App\Models\crm_sales::where('company_id', session('selected_company_id'))
                                            ->where('deleted', 0)
                                            ->sum('deal_value');
                                        $previousMonthRevenue = \App\Models\crm_sales::where('company_id', session('selected_company_id'))
                                            ->where('deleted', 0)
                                            ->whereMonth('created_at', now()->subMonth()->month)
                                            ->sum('deal_value');
                                        $revenuePercentageChange = number_format((($totalRevenue / max(1, $previousMonthRevenue)) * 100) - 100, 1);
                                    @endphp
                                    <h3 class="mb-0">${{ number_format($totalRevenue, 2) }}</h3>
                                    <span class="badge bg-success">{{ $revenuePercentageChange }}% <i class="fas fa-arrow-up"></i></span>
                                </div>
                                <div class="stat-icon text-primary">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Total Customers</h6>
                                    @php
                                        $totalCustomers = \App\Models\Customer::where('company_id', session('selected_company_id'))->count();
                                        $previousMonthCount = \App\Models\Customer::where('company_id', session('selected_company_id'))
                                            ->whereMonth('created_at', now()->subMonth()->month)
                                            ->count();
                                        $percentageChange = number_format((($totalCustomers / max(1, $previousMonthCount)) * 100) - 100, 1);
                                    @endphp
                                    <h3 class="mb-0">{{ $totalCustomers }}</h3>
                                    <span class="badge bg-success">{{ $percentageChange }}% <i class="fas fa-arrow-up"></i></span>
                                </div>
                                <div class="stat-icon text-info">
                                    <i class="fas fa-smile"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row">
                <div class="col-xl-8">
                    <div class="card sales-performance-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h4 class="header-title mb-2">Sales Performance</h4>
                                    <div class="d-flex align-items-center">
                                        @php
                                            $totalRevenue = (float) \App\Models\crm_sales::where('company_id', session('selected_company_id'))
                                                ->where('deleted', 0)
                                                ->sum('deal_value');
                                            $totalCommission = (float) \App\Models\crm_sales::where('company_id', session('selected_company_id'))
                                                ->where('deleted', 0)
                                                ->sum('sales_commission');
                                            $totalDeals = (int) \App\Models\crm_sales::where('company_id', session('selected_company_id'))
                                                ->where('deleted', 0)
                                                ->count();
                                            $activeDeals = (int) \App\Models\crm_sales::where('company_id', session('selected_company_id'))
                                                ->where('stage', '!=', 'Closed Won')
                                                ->where('stage', '!=', 'Closed Lost')
                                                ->where('deleted', 0)
                                                ->count();
                                            $averageDealValue = $totalDeals > 0 ? number_format((float)($totalRevenue / $totalDeals), 2) : 0;
                                        @endphp
                                        <h2 class="mb-0">${{ number_format((float)$totalRevenue, 2) }}</h2>
                                        <span class="badge bg-success">Total Revenue</span>
                                    </div>
                                </div>
                                <div class="d-flex gap-2" style="display: none">
                                    <div  class="form-select form-select-sm" id="revenueTimeRange" style="display: none" >
                                     
                                    </div>
                                    <button class="btn btn-light btn-sm" id="downloadRevenueReport" style="display: none">
                                        <i class="fas fa-download me-1"></i> Export
                                    </button>
                                </div>
                            </div>
                            
                            <div class="row g-0 text-center mb-4">
                                <div class="col-4">
                                    <div class="p-3">
                                        <h5 class="mb-1">${{ number_format((float)$totalCommission, 2) }}</h5>
                                        <p class="text-muted mb-0">
                                            <i class="fas fa-arrow-up text-success me-1"></i>
                                            Total Commission
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3">
                                        <h5 class="mb-1">${{ $averageDealValue }}</h5>
                                        <p class="text-muted mb-0">
                                            <i class="fas fa-arrow-up text-success me-1"></i>
                                            Avg. Deal Value
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3">
                                        <h5 class="mb-0">{{ $activeDeals }}</h5>
                                        <p class="text-muted mb-0">
                                            <i class="fas fa-arrow-up text-success me-1"></i>
                                            Active Deals
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="chart-container">
                                <canvas id="revenueChart"></canvas>
                            </div>

                            <!--
                            <div class="row mt-4">
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-circle text-primary me-2"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Total Revenue</h6>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="fw-bold">100%</span>
                                        </div>
                                    </div>
                                    <div class="progress mb-3" style="height: 6px;">
                                        <div class="progress-bar bg-primary" style="width: 100%"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-circle text-info me-2"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Avg. Deal Value</h6>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="fw-bold">${{ $averageDealValue }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-circle text-dark me-2"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Active Deals</h6>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="fw-bold">{{ $activeDeals }}</span>
                                        </div>
                                    </div>
                                    <div class="progress mb-3" style="height: 6px;">
                                        <div class="progress-bar bg-dark" style="width: {{ number_format((float)($activeDeals / max(1, $totalDeals)) * 100, 1) }}%"></div>
                                    </div>
                                </div>
                            </div>  -->
                        </div>
                    </div>
                </div>


                
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Lead Sources</h4>
                            <div class="chart-container lead-sources-chart">
                                <canvas id="leadSourceChart"></canvas>
                            </div>
                            @php
                                $leadSources = \App\Models\CrmLeads::select('source', \DB::raw('count(*) as count'))
                                    ->where('company_id', session('selected_company_id'))
                                    ->whereNull('deleted_at') // Ensure we only count active leads
                                    ->groupBy('source')
                                    ->get();
                                $sources = $leadSources->pluck('source');
                                $counts = $leadSources->pluck('count');
                            @endphp
                            <script>
                                var ctx = document.getElementById('leadSourceChart').getContext('2d');
                                var leadSourceChart = new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: {{ json_encode($sources) }},
                                        datasets: [{
                                            data: {{ json_encode($counts) }},
                                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Leads Pipeline -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="header-title">Leads Pipeline</h4>
                            </div>
                            <div class="row g-4" style="max-height: 400px; overflow-y: auto;">
                                @php
                                    $companyId = Session::get('selected_company_id');
                                    $leads = \App\Models\CrmLeads::where('company_id', $companyId)
                                        ->with('assignedTo')
                                        ->whereNull('deleted_at')
                                        ->orderBy('created_at', 'desc')
                                        ->get();
                                @endphp
                                
                                @foreach($leads as $lead)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 shadow-sm" 
                                         style="background-color: {{
                                            match($lead->status) {
                                                'New' => '#e8f0fe',
                                                'Qualified' => '#e3f2fd',
                                                'Proposal' => '#fff3e0',
                                                'Negotiation' => '#fce4ec',
                                                'Closed Won' => '#e8f5e9',
                                                default => '#f8f9fa'
                                            }
                                        }}; 
                                        border-left: 4px solid {{
                                            match($lead->status) {
                                                'New' => '#64b5f6',
                                                'Qualified' => '#2196f3',
                                                'Proposal' => '#ff9800',
                                                'Negotiation' => '#e53935',
                                                'Closed Won' => '#4caf50',
                                                default => '#6c757d'
                                            }
                                        }};
                                        transition: all 0.3s ease;
                                        margin-bottom: 1rem;
                                        "
                                         onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.15)';"
                                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)';">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h5 class="card-title mb-0">
                                                <span class="badge bg-{{ $lead->status === 'Closed Won' ? 'success' : ($lead->status === 'Negotiation' ? 'danger' : ($lead->status === 'Proposal' ? 'warning' : 'info')) }} me-2">
                                                    {{ $lead->status }}
                                                </span>
                                                {{ $lead->name }}
                                            </h5>
                                            <div class="card-value">
                                                {{ $lead->email }}
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex flex-column mb-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-phone me-2 text-muted"></i>
                                                    <span class="text-truncate" style="max-width: 200px;">{{ $lead->phone }}</span>
                                                </div>
                                            </div>
                                            @if($lead->hasAppointment())
                                            <div class="appointment-info mb-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-calendar me-2 text-muted"></i>
                                                    <span>{{ $lead->appointment_date->format('M d') }}</span>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="lead-notes">
                                                <p class="mb-0 text-truncate" style="max-width: 300px;">
                                                    {{ Str::limit($lead->notes ?? 'No notes provided', 50) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent border-top">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    Created: {{ $lead->created_at->format('M d, Y') }}
                                                </small>
                                                <small class="text-muted">
                                                    Source: {{ $lead->source }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                        <!-- Leads Section -->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Recent Leads</h4>
                                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                            <table class="table table-hover align-middle">
                                                <thead class="table-light bg-primary text-white">
                                                    <tr>
                                                        <th class="col-2" >Name</th>
                                                        <th class="col-2" >Contact</th>
                                                        <th class="col-4" >Notes</th>
                                                        <th class="col-1" >Created</th>
                                                        <th class="col-2" >Source</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($leads as $lead)
                                                    <tr class="{{ $loop->even ? 'bg-light' : '' }}">
                                                        <td class="col-2">
                                                            <div class="d-flex align-items-center">
                                                           
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h6 class="mb-0" style="color: #{{ substr(md5($lead->name), 0, 6) }};">{{ $lead->name }}</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="col-2">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-phone text-success me-2"></i>
                                                                <span class="text-truncate" style="max-width: 180px; color: #6c757d;">{{ $lead->phone }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="col-4">
                                                            <p class="mb-0 text-truncate" style="max-width: 350px; color: #495057;">
                                                                {{ Str::limit($lead->notes ?? 'No notes provided', 80) }}
                                                            </p>
                                                        </td>
                                                        <td class="col-1">
                                                            <small class="text-muted" style="color: #868e96;">
                                                                {{ $lead->created_at->format('M d, Y') }}
                                                            </small>
                                                        </td>
                                                        <td class="col-2">
                                                            <small class="text-muted" style="color: #868e96;">
                                                                <span class="badge bg-{{ substr(md5($lead->source), 0, 6) }} text-dark">{{ $lead->source }}</span>
                                                            </small>
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

            <!-- Recent Activities and Tasks 
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Recent Activities</h4>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Time</th>
                                            <th>Activity</th>
                                            <th>User</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <small class="text-muted">2 hours ago</small>
                                            </td>
                                            <td>
                                                <p class="mb-0">Added a new lead</p>
                                            </td>
                                            <td>
                                                <span class="fw-bold">Sammy Addo</span>
                                            </td>
                                        </tr>
                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Recent Leads</h4>
                            <div class="table-responsive">
                                <table class="table table-centered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Company</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Value</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Mike Roach</td>
                                            <td>ShrinQ Ltd</td>
                                            <td>Mike@shrinq.com</td>
                                            <td><span class="badge bg-success">Qualified</span></td>
                                            <td>$25,000</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-light" onclick="editLead('1', 'Mike Roach', 'mike@shrinq.com', 'ShrinQ Ltd', 'Qualified', '25000')">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#deleteLeadModal">
                                                        <i class="fas fa-trash"></i>
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
        -->

    @endsection

    @section('script')
        @parent
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Revenue Chart
                const revenueCtx = document.getElementById('revenueChart').getContext('2d');
                const revenueChart = new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [
                            {
                                label: 'New Revenue',
                                data: [65, 59, 80, 81, 56, 55, 70, 75, 82, 85, 88, 90],
                                borderColor: '#727cf5',
                                backgroundColor: 'rgba(114, 124, 245, 0.1)',
                                tension: 0.3,
                                fill: true,
                                pointBackgroundColor: '#727cf5',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6
                            },
                            {
                                label: 'Recurring Revenue',
                                data: [40, 45, 42, 41, 48, 50, 55, 52, 56, 58, 60, 62],
                                borderColor: '#0acf97',
                                backgroundColor: 'rgba(10, 207, 151, 0.1)',
                                tension: 0.3,
                                fill: true,
                                pointBackgroundColor: '#0acf97',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6
                            },
                            {
                                label: 'Expenses',
                                data: [20, 22, 25, 18, 20, 24, 22, 25, 23, 24, 26, 28],
                                borderColor: '#fa5c7c',
                                backgroundColor: 'rgba(250, 92, 124, 0.1)',
                                tension: 0.3,
                                fill: true,
                                pointBackgroundColor: '#fa5c7c',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                usePointStyle: true,
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': $' + context.parsed.y + 'K';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    borderDash: [2, 2],
                                    drawBorder: false
                                },
                                ticks: {
                                    callback: function(value) {
                                        return '$' + value + 'K';
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });

                // Handle time range changes
                document.getElementById('revenueTimeRange').addEventListener('change', function(e) {
                    // You can implement the logic to update the chart data based on the selected time range
                    const timeRange = e.target.value;
                    // Update chart data accordingly
                    showToast('info', 'Updating chart for ' + timeRange + ' view...');
                });

                // Handle export button
                document.getElementById('downloadRevenueReport').addEventListener('click', function() {
                    // Implement export functionality
                    showToast('success', 'Downloading revenue report...');
                });

                // Lead Source Chart
                const sourceCtx = document.getElementById('leadSourceChart').getContext('2d');
                var leadSourceChart = new Chart(sourceCtx, {
                    type: 'pie',
                    data: {
                        labels: {!! json_encode($sources) !!},
                        datasets: [{
                            data: {!! json_encode($counts) !!},
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    }
                });

                // Make task cards draggable within the Kanban board
                const taskCards = document.querySelectorAll('.task-card');
                const kanbanColumns = document.querySelectorAll('.kanban-column');

                taskCards.forEach(card => {
                    card.addEventListener('click', function() {
                        // Open deal details modal when clicking on a card
                        const dealModal = new bootstrap.Modal(document.getElementById('dealDetailsModal'));
                        dealModal.show();
                    });

                    card.setAttribute('draggable', true);
                    card.addEventListener('dragstart', function(e) {
                        e.dataTransfer.setData('text/plain', e.target.id);
                        e.target.classList.add('dragging');
                    });

                    card.addEventListener('dragend', function(e) {
                        e.target.classList.remove('dragging');
                    });
                });

                kanbanColumns.forEach(column => {
                    column.addEventListener('dragover', function(e) {
                        e.preventDefault();
                        const draggingCard = document.querySelector('.dragging');
                        if (draggingCard) {
                            const cards = [...column.querySelectorAll('.task-card:not(.dragging)')];
                            const afterCard = cards.reduce((closest, card) => {
                                const box = card.getBoundingClientRect();
                                const offset = e.clientY - box.top - box.height / 2;
                                if (offset < 0 && offset > closest.offset) {
                                    return { offset: offset, element: card };
                                } else {
                                    return closest;
                                }
                            }, { offset: Number.NEGATIVE_INFINITY }).element;

                            if (afterCard) {
                                column.insertBefore(draggingCard, afterCard);
                            } else {
                                column.appendChild(draggingCard);
                            }
                        }
                    });
                });

                // Function to edit lead
                window.editLead = function(id, name, email, company, status, value) {
                    document.getElementById('editLeadId').value = id;
                    document.getElementById('editLeadName').value = name;
                    document.getElementById('editLeadEmail').value = email;
                    document.getElementById('editLeadCompany').value = company;
                    document.getElementById('editLeadStatus').value = status;
                    document.getElementById('editLeadValue').value = value;

                    const editModal = new bootstrap.Modal(document.getElementById('editLeadModal'));
                    editModal.show();
                };

                // Add success/error toast notifications
                function showToast(icon, title) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });

                    Toast.fire({
                        icon: icon,
                        title: title
                    });
                }
            });
        </script>
    @endsection
