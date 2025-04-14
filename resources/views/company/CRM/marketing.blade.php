<div class="row">
    <!-- Campaign Overview -->
    <div class="row mb-4">
        <div class="col-12 mb-3">
            <button type="button" class="btn btn-primary btn-floating" data-bs-toggle="modal" data-bs-target="#addCampaignModal" style="position: absolute; top: 20px; right: 20px;">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card sales">
                <i class="stat-icon fas fa-users"></i>
                <div class="stat-title">Total Campaigns</div>
                <div class="stat-value">{{ $campaigns->count() }}</div>
                <div class="stat-change">
                    <i class="fas fa-arrow-up"></i>
                    <span>${{ number_format($campaigns->sum('budget'), 2) }} Total Budget</span>
                </div>
            </div>
        </div> 
    
        <div class="col-xl-3 col-md-6">
            <div class="stat-card conversion">
                <i class="stat-icon fas fa-building"></i>
                <div class="stat-title">Active Campaigns</div>
                <div class="stat-value">{{$campaigns->where('status','active')->count()}}</div>
                <div class="stat-change">
                    <i class="fas fa-chart-pie"></i>
                    <span>{{ number_format(($campaigns->where('customer_type', 'corporate')->count() / max(1, $campaigns->count())) * 100, 1) }}% of total</span>
                </div>
            </div>
        </div>
    
        <div class="col-xl-3 col-md-6">
            <div class="stat-card pipeline">
                <i class="stat-icon fas fa-user"></i>
                <div class="stat-title">Completed Campaigns</div>
                <div class="stat-value">{{$campaigns->where('status','completed')->count()}}</div>
                <div class="stat-change">
                    <i class="fas fa-chart-pie"></i>
                    <span>{{ number_format(($campaigns->where('customer_type', 'individual')->count() / max(1, $campaigns->count())) * 100, 1) }}% of total</span>
                </div>
            </div>
        </div>
    
        <div class="col-xl-3 col-md-6">
            <div class="stat-card deal">
                <i class="stat-icon fas fa-dollar-sign"></i>
                <div class="stat-title">Drafted Campaigns</div>
                <div class="stat-value">{{$campaigns->where('status','draft')->count()}}</div>
                <div class="stat-change">
                    <i class="fas fa-arrow-up"></i>
                    <span>{{ number_format(($campaigns->sum('value') / max(1, $campaigns->sum('value') - 1)) * 100 - 100, 1) }}% vs last month</span>
                </div>
            </div>
        </div>
    </div>

    {{-- <div>
        {{-- <div class="col-xl-4 col-lg-6 mb-3">
            <div class="card crm-card">
                <div class="card-body">
                    <div class="marketing-card-header" style="margin-bottom: 10px">
                        <h4 class="header-title">Campaign Overview</h4>
                    </div>
                    <div class="campaign-stats">
                        <div class="row g-2 p-t">
                            <div class="col-6">
                                <a href="#" class="stat-item rounded border p-4 d-flex flex-column align-items-center justify-content-center text-white bg-primary shadow-sm text-decoration-none"
                                data-bs-toggle="modal" data-bs-target="#addCampaignModal" style="border-radius: 8px;">
                                    <i class="fas fa-plus fa-2x mb-2"></i> 
                                    <span class="fw-bold">New Campaign</span>
                                </a>
                            </div>
                    
                            <div class="col-6">
                                <div class="stat-item rounded border text-center p-4">
                                    <h3 class="mb-1">{{$campaigns->where('status','active')->count()}}</h3>
                                    <p class="text-muted">ACTIVE</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item rounded border text-center p-4">
                                    <h3 class="mb-1">{{$campaigns->where('status','draft')->count()}}</h3>
                                    <p class="text-muted">DRAFTED</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item rounded border text-center p-4">
                                    <h3 class="mb-1">{{$campaigns->where('status','completed')->count()}}</h3>
                                    <p class="text-muted">COMPLETED</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Email Performance -->
        {{-- <div class="col-xl-4 col-lg-6 mb-3">
            <div class="card crm-card">
                <div class="card-body">
                    <div class="marketing-card-header">
                        <h4 class="header-title">Email Performance</h4>
                        <div class="btn-container">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEmailModal">
                                <i class="fas fa-envelope"></i>
                                Create Email
                            </button>
                        </div>
                    </div>
                    <div class="marketing-chart-container">
                        <div id="emailPerformanceChart"></div>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- <div class="col-xl-4 col-lg-6 mb-3">
            <div class="card crm-card">
                <div class="card-body">
                    <div class="marketing-card-header" style="margin-bottom: 10px">
                        <h4 class="header-title">Email Overview</h4>
                    </div>
                    
                    <div class="campaign-stats">
                        <div class="row g-2 p-t">
                            <div class="col-6">
                                <a href="#" class="stat-item rounded border p-4 d-flex flex-column align-items-center justify-content-center text-white bg-warning shadow-sm text-decoration-none"
                                data-bs-toggle="modal" data-bs-target="#createEmailModal" style="border-radius: 8px;">
                                    <i class="fas fa-envelope fa-2x mb-2"></i> 
                                    <span class="fw-bold">Compose Email</span>
                                </a>
                            </div>
                    
                            <div class="col-6">
                                <div class="stat-item rounded border text-center p-4">
                                    <h3 class="mb-1">85</h3>
                                    <p class="text-muted">SENT</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item rounded border text-center p-4">
                                    <h3 class="mb-1">24</h3>
                                    <p class="text-muted">DRAFT</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item rounded border text-center p-4">
                                    <h3 class="mb-1">12.5k</h3>
                                    <p class="text-muted">REPLIED</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div> --}}

        <!-- Lead Sources -->
        {{-- <div class="col-xl-4 col-lg-12 mb-3">
            <div class="card crm-card">
                <div class="card-body">
                    <div class="marketing-card-header">
                        <h4 class="header-title">Lead Sources</h4>
                        <div class="btn-container">
                            <button class="btn btn-light" id="toggleLeadSources">
                                <i class="fas fa-chart-pie"></i>
                                Toggle View
                            </button>
                        </div>
                    </div>
                    <div class="marketing-chart-container">
                        <div id="leadSourcesChart"></div>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- <div class="col-xl-4 col-lg-6 mb-3">
            <div class="card crm-card">
                <div class="card-body">
                    <div class="marketing-card-header" style="margin-bottom: 10px">
                        <h4 class="header-title">Lead Sources</h4>
                    </div>
                    
                    <div class="campaign-stats">
                        <div class="row g-2 p-t">
                            <div class="col-6">
                                <a href="#" class="stat-item rounded border p-4 d-flex flex-column align-items-center justify-content-center text-white bg-success shadow-sm text-decoration-none"
                                data-bs-toggle="modal" data-bs-target="#addCampaignModal" style="border-radius: 8px;">
                                    <i class="fas fa-comment fa-2x mb-2"></i> 
                                    <span class="fw-bold">Lead Sources</span>
                                </a>
                            </div>
                    
                            <div class="col-6">
                                <div class="stat-item rounded border text-center p-4">
                                    <h3 class="mb-1">85%</h3>
                                    <p class="text-muted">Avg. Open Rate</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item rounded border text-center p-4">
                                    <h3 class="mb-1">24%</h3>
                                    <p class="text-muted">Conversion Rate</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item rounded border text-center p-4">
                                    <h3 class="mb-1">$12.5k</h3>
                                    <p class="text-muted">Revenue Generated</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div> 
    </div> --}}
    
    {{-- campaign list --}}
    <div class="col-12">
        <div class="card crm-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="header-title mb-0">Campaigns</h4>
                    <div class="btn-container flex-grow-1 d-flex" style="margin-right: 10px">
                        <button class="btn btn-primary ms-auto form-control-sm" style="height: 59px;" data-bs-toggle="modal" data-bs-target="#addCampaignModal">
                            <i class="fas fa-plus"></i> New Campaign
                        </button>
                    </div>
                    <div class="campaign-filters d-flex gap-2">
                        <div class="form-floating">
                            <input type="text" id="search-input" class="form-control form-control-sm" placeholder="Search..">
                            <label for="search-input">Search Campaigns</label>
                        </div>
                    </div>
                </div>
                @php
                    $campaigns = $campaigns ?? collect();
                @endphp

             
         
                    <div class="table-responsive">
                        <table class="table table-centered table-hover dt-responsive nowrap w-100" id="campaigns-table">
                            <thead>
                                <tr>
                                    <th>Campaign Name</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Budget</th>
                                    <th>Performance</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                             
                            </tbody>
                        </table>

                        <nav aria-label="Page navigation example">
                            <ul class="pagination" id="marketingpagination">
                        
                            </ul>
                        </nav>
                    </div>
           
                {{-- Pagination --}}
                <style>
                    .pagination {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }

                    .pagination a, .pagination span {
                        font-size: 16px; /* Adjust the font size of pagination links */
                        padding: 6px 12px; /* Add padding around the pagination links */
                        margin: 0 4px; /* Add some space between the icons */
                        border-radius: 4px; /* Optional: to round the corners */
                        display: inline-block; /* Ensure the elements are inline-block for better alignment */
                    }

                    .pagination a:hover, .pagination span:hover {
                        background-color: #f0f0f0; /* Optional: Add hover effect */
                    }

                    .pagination .active {
                        font-weight: bold; /* Optional: Highlight the active page */
                    }

                    .pagination i {
                        font-size: 18px; /* Adjust icon size */
                        margin: 0; /* Remove margin if needed */
                    }

                </style>
                <div class="pagination" >
                    {{ $campaigns->links() }}
                </div>
            </div>
        </div>
    </div>    
</div>

<!-- Add Campaign Modal -->
<div class="modal fade" id="addCampaignModal" tabindex="-1" aria-labelledby="addCampaignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCampaignModalLabel">Create New Campaign</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="campaignForm" action="{{ route('company.campaigns.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <input type="hidden" name="status" value="draft"> 
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="name" id="campaignName"  placeholder="Campaign Name"    required>
                                <label for="campaignName">Campaign Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="type" id="campaignType" required>
                                    <option value="">Select Type</option>
                                    <option value="email">Email Campaign</option>
                                    <option value="social">Social Media</option>
                                    <option value="ppc">PPC Advertising</option>
                                    <option value="content">Content Marketing</option>
                                </select>
                                <label for="campaignType">Campaign Type</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" name="start_date" id="startDate" required>
                                <label for="startDate">Start Date</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" name="end_date" id="endDate" required>
                                <label for="endDate">End Date</label>
                            </div>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" name="budget" id="budget" placeholder="Budget" required>
                                <label for="budget">Budget</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select select2-multiple" name="target_audience[]" id="targetAudience" multiple required>
                                    <option value="b2b">B2B Companies</option>
                                    <option value="b2c">B2C Consumers</option>
                                    <option value="tech">Technology & Software</option>
                                    <option value="retail">Retail & E-commerce</option>
                                    <option value="healthcare">Healthcare & Medical</option>
                                    <option value="finance">Financial Services</option>
                                    <option value="manufacturing">Manufacturing</option>
                                    <option value="automotive">Automotive</option>
                                    <option value="construction">Construction & Real Estate</option>
                                    <option value="education">Education</option>
                                    <option value="government">Government & Public Sector</option>
                                    <option value="nonprofit">Non-Profit Organizations</option>
                                    <option value="media">Media & Entertainment</option>
                                    <option value="travel">Travel & Hospitality</option>
                                    <option value="telecom">Telecommunications</option>
                                    <option value="energy">Energy & Utilities</option>
                                    <option value="legal">Legal Services</option>
                                    <option value="consulting">Consulting & Professional Services</option>
                                    <option value="sports">Sports & Fitness</option>
                                    <option value="food">Food & Beverage</option>
                                    <option value="fashion">Fashion & Apparel</option>
                                    <option value="beauty">Beauty & Personal Care</option>
                                    <option value="other">Other</option>
                                </select>
                                <label for="targetAudience">Target Audience</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="campaign_goals" id="campaignGoals" rows="5" placeholder="Describe the campaign objectives..."></textarea>
                            <label for="campaignGoals">Campaign Goals</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">KPIs</label>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" name="kpi_lead_goal" id="kpiLeadGoal" placeholder="Lead Goal">
                                    <label for="kpiLeadGoal">Lead Goal</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" name="kpi_conversion_goal" id="kpiConversionGoal" placeholder="Conversion Goal (%)">
                                    <label for="kpiConversionGoal">Conversion Goal (%)</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" name="kpi_roi_goal" id="kpiRoiGoal" placeholder="ROI Goal (%)">
                                    <label for="kpiRoiGoal">ROI Goal (%)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Campaign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Campaign Modal -->
@foreach ($campaigns as $campaign)
    <div class="modal fade" id="viewModal-{{ $campaign->id }}" tabindex="-1" aria-labelledby="viewModalLabel-{{ $campaign->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel-{{ $campaign->id }}">View Campaign</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <h5 class="modal-title" id="viewModalLabel">{{ $campaign->name ?? 'Campaign Details' }}</h5>

                    <div class="row">
                        <!-- Campaign Details Tile -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Campaign Name</h6>
                                    <p class="card-text">{{ $campaign->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Campaign Type</h6>
                                    <p class="card-text">{{ $campaign->type ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        <!-- Campaign Date Tile -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Start Date</h6>
                                    <p class="card-text">{{ optional($campaign)->start_date ? date('Y-m-d', strtotime($campaign->start_date)) : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">End Date</h6>
                                    <p class="card-text">{{ optional($campaign)->end_date ? date('Y-m-d', strtotime($campaign->end_date)) : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        <!-- Budget and Target Audience Tiles -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Budget</h6>
                                    <p class="card-text">${{ number_format($campaign->budget ?? 0, 2) }}</p>
                                </div>
                            </div>
                        </div>
                
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Target Audience</h6>
                                    <p class="card-text">{{ implode(', ', $campaign->target_audience ?? []) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        <!-- Campaign Goals Tile -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Campaign Goals</h6>
                                    <p class="card-text">{{ trim($campaign->campaignDetails->goals ?? 'N/A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $kpis = json_decode(optional($campaign->campaignDetails)->kpis, true) ?? [];
                    @endphp
                    <div class="row g-3">
                        <!-- KPIs Tiles -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Lead Goal</h6>
                                    <p class="card-text">{{ $kpis['lead_goal'] ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Conversion Goal (%)</h6>
                                    <p class="card-text">{{ $kpis['conversion_goal'] ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">ROI Goal (%)</h6>
                                    <p class="card-text">{{ $kpis['roi_goal'] ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        <!-- Status Tile -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Status</h6>
                                    <p class="card-text">{{ ucfirst($campaign->status) ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>                    
                    
            </div>
        </div>
    </div>
@endforeach

<!-- Edit Campaign Modal -->
@foreach ($campaigns as $campaign)
    <div class="modal fade" id="editModal-{{ $campaign->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $campaign->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel-{{ $campaign->id }}">Edit Campaign</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('company.campaigns.update', $campaign->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="name" value="{{ $campaign->name }}" required>
                                    <label for="campaignName">Campaign Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select select2" name="type" required>
                                        <option value="email" {{ $campaign->type == 'email' ? 'selected' : '' }}>Email Campaign</option>
                                        <option value="social" {{ $campaign->type == 'social' ? 'selected' : '' }}>Social Media</option>
                                        <option value="ppc" {{ $campaign->type == 'ppc' ? 'selected' : '' }}>PPC Advertising</option>
                                        <option value="content" {{ $campaign->type == 'content' ? 'selected' : '' }}>Content Marketing</option>
                                    </select>
                                    <label for="campaignType">Campaign Type</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" name="start_date" 
                                           value="{{ optional($campaign)->start_date ? date('Y-m-d', strtotime($campaign->start_date)) : '' }}" 
                                           required>
                                    <label for="startDate">Start Date</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" name="end_date" 
                                           value="{{ optional($campaign)->end_date ? date('Y-m-d', strtotime($campaign->end_date)) : '' }}" 
                                           required>
                                    <label for="endDate">End Date</label>
                                </div>
                            </div>
                        </div>
                        

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" name="budget" value="{{ $campaign->budget }}" required>
                                    <label for="budget">Budget</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select select2-multiple" name="target_audience[]" multiple required>
                                        <option value="b2b" {{ in_array('b2b', $campaign->target_audience ?? []) ? 'selected' : '' }}>B2B Companies</option>
                                        <option value="b2c" {{ in_array('b2c', $campaign->target_audience ?? []) ? 'selected' : '' }}>B2C Consumers</option>
                                        <option value="tech" {{ in_array('tech', $campaign->target_audience ?? []) ? 'selected' : '' }}>Technology & Software</option>
                                        <option value="retail" {{ in_array('retail', $campaign->target_audience ?? []) ? 'selected' : '' }}>Retail & E-commerce</option>
                                        <option value="healthcare" {{ in_array('healthcare', $campaign->target_audience ?? []) ? 'selected' : '' }}>Healthcare & Medical</option>
                                        <option value="finance" {{ in_array('finance', $campaign->target_audience ?? []) ? 'selected' : '' }}>Financial Services</option>
                                        <option value="manufacturing" {{ in_array('manufacturing', $campaign->target_audience ?? []) ? 'selected' : '' }}>Manufacturing</option>
                                        <option value="automotive" {{ in_array('automotive', $campaign->target_audience ?? []) ? 'selected' : '' }}>Automotive</option>
                                        <option value="construction" {{ in_array('construction', $campaign->target_audience ?? []) ? 'selected' : '' }}>Construction & Real Estate</option>
                                        <option value="education" {{ in_array('education', $campaign->target_audience ?? []) ? 'selected' : '' }}>Education</option>
                                        <option value="government" {{ in_array('government', $campaign->target_audience ?? []) ? 'selected' : '' }}>Government & Public Sector</option>
                                        <option value="nonprofit" {{ in_array('nonprofit', $campaign->target_audience ?? []) ? 'selected' : '' }}>Non-Profit Organizations</option>
                                        <option value="media" {{ in_array('media', $campaign->target_audience ?? []) ? 'selected' : '' }}>Media & Entertainment</option>
                                        <option value="travel" {{ in_array('travel', $campaign->target_audience ?? []) ? 'selected' : '' }}>Travel & Hospitality</option>
                                        <option value="telecom" {{ in_array('telecom', $campaign->target_audience ?? []) ? 'selected' : '' }}>Telecommunications</option>
                                        <option value="energy" {{ in_array('energy', $campaign->target_audience ?? []) ? 'selected' : '' }}>Energy & Utilities</option>
                                        <option value="legal" {{ in_array('legal', $campaign->target_audience ?? []) ? 'selected' : '' }}>Legal Services</option>
                                        <option value="consulting" {{ in_array('consulting', $campaign->target_audience ?? []) ? 'selected' : '' }}>Consulting & Professional Services</option>
                                        <option value="sports" {{ in_array('sports', $campaign->target_audience ?? []) ? 'selected' : '' }}>Sports & Fitness</option>
                                        <option value="food" {{ in_array('food', $campaign->target_audience ?? []) ? 'selected' : '' }}>Food & Beverage</option>
                                        <option value="fashion" {{ in_array('fashion', $campaign->target_audience ?? []) ? 'selected' : '' }}>Fashion & Apparel</option>
                                        <option value="beauty" {{ in_array('beauty', $campaign->target_audience ?? []) ? 'selected' : '' }}>Beauty & Personal Care</option>
                                        <option value="other" {{ in_array('other', $campaign->target_audience ?? []) ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <label for="targetAudience">Target Audience</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" name="campaign_goals" rows="5">{{ trim($campaign->campaignDetails->goals ?? '') }}</textarea>
                                <label for="campaignGoals">Campaign Goals</label>
                            </div>
                        </div>
                        
                        @php
                            $kpis = json_decode(optional($campaign->campaignDetails)->kpis, true) ?? [];
                        @endphp

                        <div class="mb-3">
                            <label class="form-label">KPIs</label>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" name="kpi_lead_goal" 
                                            value="{{ $kpis['lead_goal'] ?? '' }}" placeholder="Lead Goal">
                                        <label for="kpiLeadGoal">Lead Goal</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" name="kpi_conversion_goal" 
                                            value="{{ $kpis['conversion_goal'] ?? '' }}" placeholder="Conversion Goal (%)">
                                        <label for="kpiConversionGoal">Conversion Goal (%)</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" name="kpi_roi_goal" 
                                            value="{{ $kpis['roi_goal'] ?? '' }}" placeholder="ROI Goal (%)">
                                        <label for="kpiRoiGoal">ROI Goal (%)</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <select class="form-select" name="status" required>
                            <option value="draft"     {{ old('status', $campaign->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active"    {{ old('status', $campaign->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="paused"    {{ old('status', $campaign->status) == 'paused' ? 'selected' : '' }}>Paused</option>
                            <option value="completed" {{ old('status', $campaign->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', $campaign->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Notes Modal -->
@foreach ($campaigns as $campaign)
<div class="modal fade" id="noteModal-{{ $campaign->id }}" tabindex="-1" aria-labelledby="noteModalLabel-{{ $campaign->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="noteModalLabel-{{ $campaign->id }}">Add Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('company.campaigns.update', $campaign->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Inline buttons for adding notes and documents -->
                    <div class="d-flex gap-2 mb-3">
                        <button type="button" class="btn btn-success" id="add-note-{{ $campaign->id }}">Add Note</button>
                        <button type="button" class="btn btn-primary" id="add-document-{{ $campaign->id }}">Add Document</button>
                    </div>
                    
                    <!-- Notes Container -->
                    <div id="notes-container-{{ $campaign->id }}" class="mb-3">
                        <!-- Dynamic notes will be added here -->
                    </div>
                    
                    <!-- Documents Container -->
                    <div id="documents-container-{{ $campaign->id }}" class="mb-3">
                        <!-- Dynamic document inputs will be added here -->
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- delete modal --}}
@foreach ($campaigns as $campaign)
    <div class="modal fade" id="deleteModal-{{ $campaign->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $campaign->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel-{{ $campaign->id }}">Delete Campaign</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the campaign "<strong>{{ $campaign->name }}</strong>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="{{ route('company.campaigns.destroy', $campaign->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach


<!-- Create Email Modal -->
{{-- <div class="modal fade" id="createEmailModal" tabindex="-1" aria-labelledby="createEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEmailModalLabel">Create Email Campaign</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="emailForm">
                    <div class="mb-3">
                        <label for="emailSubject" class="form-label">Email Subject</label>
                        <input type="text" class="form-control" id="emailSubject" name="email_subject" required>
                    </div>

                    <div class="mb-3">
                        <label for="recipientList" class="form-label">Recipient List</label>
                        <select class="form-select select2-multiple" id="recipientList" name="recipient_list[]" multiple required>
                            <option value="all">All Contacts</option>
                            <option value="leads">New Leads</option>
                            <option value="customers">Existing Customers</option>
                            <option value="inactive">Inactive Customers</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="emailTemplate" class="form-label">Email Template</label>
                        <select class="form-select select2" id="emailTemplate" name="email_template">
                            <option value="">Select Template</option>
                            <option value="newsletter">Newsletter</option>
                            <option value="promotion">Promotional</option>
                            <option value="welcome">Welcome Email</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="emailEditor" class="form-label">Email Content</label>
                        <div id="emailEditor" style="height: 300px;"></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="scheduleSend" class="form-label">Schedule Send</label>
                            <input type="datetime-local" class="form-control" id="scheduleSend" name="schedule_send">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Track Analytics</label>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="trackAnalytics" name="track_analytics" checked>
                                <label class="form-check-label" for="trackAnalytics">Enable email tracking</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-info" id="saveDraft">Save Draft</button>
                <button type="submit" class="btn btn-primary" id="sendEmail">Send Email</button>
            </div>
        </div>
    </div>
</div> --}}
<!-- Pause Modal -->
{{-- <div class="modal fade" id="pauseModal" tabindex="-1" aria-labelledby="pauseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pauseModalLabel">Pause Campaign</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Pause confirmation goes here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger">Confirm Pause</button>
            </div>
        </div>
    </div>
</div> --}}


<div class="container">
    <!-- Include the Swal CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Display SweetAlert Notification -->
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif
</div>
<!-- Add custom styles -->
<style>
    .analytics-card {
        background: #fff;
        padding: 1.25rem;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 1rem;
    }

    .analytics-card h6 {
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .analytics-card h2 {
        margin-bottom: 0.75rem;
        font-weight: 600;
    }

    .chart-container {
        background: #fff;
        padding: 1.25rem;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .engagement-breakdown {
        background: #fff;
        padding: 1.25rem;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .stat-item {
        padding: 1rem;
        text-align: center;
        transition: transform 0.2s;
    }

    .stat-item:hover {
        transform: translateY(-3px);
    }

    .marketing-chart-container {
        height: 300px;
        margin-top: 1rem;
    }

    .campaign-filters {
        display: flex;
        gap: 0.5rem;
    }
</style>

<!-- Add necessary JavaScript -->
{{-- @section('script') --}}
    <script>

function fetchMarketingData(page = 1) {

    
    $.ajax({
        url: `/company/campaigns/all?page=${page}`, 
        method: 'POST',
   
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // console.log(response);
            let tableBody = '';
            
            if (response.data.length === 0) {
                tableBody = `<tr>
                    <td colspan="8" class="text-center">No campaigns found</td>
                </tr>`;
            } else {
                response.data.forEach(campaign => {
                    // Determine badge classes
                    let typeBadgeClass = '';
                    switch(campaign.type) {
                        case 'email': 
                            typeBadgeClass = 'bg-primary'; 
                            break;
                        case 'social': 
                            typeBadgeClass = 'bg-info'; 
                            break;
                        case 'ppc': 
                            typeBadgeClass = 'bg-danger'; 
                            break;
                        default: 
                            typeBadgeClass = 'bg-secondary';
                    }
                    
                    let statusBadgeClass = '';
                    switch(campaign.status) {
                        case 'active': 
                            statusBadgeClass = 'bg-success'; 
                            break;
                        case 'paused': 
                            statusBadgeClass = 'bg-warning'; 
                            break;
                        case 'completed': 
                            statusBadgeClass = 'bg-secondary'; 
                            break;
                        case 'draft': 
                            statusBadgeClass = 'bg-dark'; 
                            break;
                        default: 
                            statusBadgeClass = 'bg-light text-dark';
                    }
                    
                    // Format dates
                    let startDate = campaign.start_date ? 
                        new Date(campaign.start_date).toLocaleDateString('en-US', {
                            month: 'short', 
                            day: 'numeric', 
                            year: 'numeric'
                        }) : 'N/A';
                    
                    let endDate = campaign.end_date ? 
                        new Date(campaign.end_date).toLocaleDateString('en-US', {
                            month: 'short', 
                            day: 'numeric', 
                            year: 'numeric'
                        }) : 'N/A';
                    
                    // Generate random performance if not provided
                    let performance = campaign.performance || Math.floor(Math.random() * 100) + 1;
                    
                    tableBody += `<tr>
                        <td>${campaign.name}</td>
                        <td>
                            <span class="badge ${typeBadgeClass}">
                                ${campaign.type.charAt(0).toUpperCase() + campaign.type.slice(1)}
                            </span>
                        </td>
                        <td>
                            <span class="badge ${statusBadgeClass}">
                                ${campaign.status.charAt(0).toUpperCase() + campaign.status.slice(1)}
                            </span>
                        </td>
                        <td>${startDate}</td>
                        <td>${endDate}</td>
                        <td>$${parseFloat(campaign.budget).toFixed(2)}</td>
                        <td>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-success" style="width: ${performance}%"></div>
                            </div>
                            <small class="text-muted">${performance}% Goal</small>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-light btn-sm" title="View" 
                                    data-bs-toggle="modal" data-bs-target="#viewModal-${campaign.id}">
                                    <i class="fas fa-eye text-success"></i>
                                </button>
                                <button type="button" class="btn btn-light btn-sm" title="Edit" 
                                    data-bs-toggle="modal" data-bs-target="#editModal-${campaign.id}">
                                    <i class="fas fa-edit text-primary"></i>
                                </button>
                                <button type="button" class="btn btn-light btn-sm" title="Notes" 
                                    data-bs-toggle="modal" data-bs-target="#noteModal-${campaign.id}">
                                    <i class="fas fa-sticky-note text-warning"></i>
                                </button>
                                <button type="button" class="btn btn-light btn-sm text-danger" title="Delete" 
                                    data-bs-toggle="modal" data-bs-target="#deleteModal-${campaign.id}">
                                    <i class="fas fa-trash text-danger"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`;
                });
            }

            $('#campaigns-table tbody').html(tableBody);

            // Generate Pagination
            let paginationHtml = '';
            
            // if (response.pagination.last_page > 1) {
                paginationHtml = `<li class="page-item ${response.pagination.prev_page_url ? '' : 'disabled'}">
                    <a class="page-link" href="#" onclick="return changePageMarketing(event, ${response.pagination.current_page - 1})">Previous</a>
                </li>`;

                for (let i = 1; i <= response.pagination.last_page; i++) {
                    paginationHtml += `<li class="page-item ${i === response.pagination.current_page ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="return changePageMarketing(event, ${i})">${i}</a>
                    </li>`;
                }

                paginationHtml += `<li class="page-item ${response.pagination.next_page_url ? '' : 'disabled'}">
                    <a class="page-link" href="#" onclick="return changePageMarketing(event, ${response.pagination.current_page + 1})">Next</a>
                </li>`;
            // }

            $('#marketingpagination').html(paginationHtml);
            
            // Initialize tooltips for action buttons
            $('[title]').tooltip();
        },
        error: function(xhr, status, error) {
            console.error("Error:", status, error, xhr.responseText);
            // Show error message to user
            alert('Failed to load marketing campaigns data. Please try again.');
        }
    });
}

// Page change function
function changePageMarketing(event, page) {
    event.preventDefault();
    fetchMarketingData(page);
    return false;
}



// Initial Call
fetchMarketingData();




        document.addEventListener("DOMContentLoaded", function () {
            document.body.addEventListener("click", function (event) {
                // Add Note - Only trigger when the actual button is clicked, not its children
                if (event.target.matches("[id^=add-note-]") || event.target.closest("[id^=add-note-]")) {
                    // Get the actual button element
                    const button = event.target.matches("[id^=add-note-]") ? 
                        event.target : event.target.closest("[id^=add-note-]");
                    
                    // Extract campaign ID from button ID
                    let campaignId = button.id.split("-")[2];
                    let notesContainer = document.querySelector("#notes-container-" + campaignId);

                    if (notesContainer) {
                        let noteEntry = document.createElement("div");
                        noteEntry.classList.add("mb-2", "note-entry", "d-flex", "align-items-center");
                        noteEntry.innerHTML = `
                            <input type="text" name="notes[${campaignId}][]" class="form-control me-2" placeholder="Enter note">
                            <button type="button" class="btn btn-sm btn-danger remove-note">
                                <i class="fas fa-trash"></i>
                            </button>
                        `;
                        notesContainer.appendChild(noteEntry);
                    }
                }

                // Add Document - Only trigger when the actual button is clicked, not its children
                if (event.target.matches("[id^=add-document-]") || event.target.closest("[id^=add-document-]")) {
                    // Get the actual button element
                    const button = event.target.matches("[id^=add-document-]") ? 
                        event.target : event.target.closest("[id^=add-document-]");
                    
                    // Extract campaign ID from button ID
                    let campaignId = button.id.split("-")[2];
                    let docsContainer = document.querySelector("#documents-container-" + campaignId);

                    if (docsContainer) {
                        let existingInputs = docsContainer.querySelectorAll("input[type='file']").length;
                        if (existingInputs >= 5) { // Prevent excessive inputs (adjust as needed)
                            alert("You can only upload up to 5 documents.");
                            return;
                        }

                        let docEntry = document.createElement("div");
                        docEntry.classList.add("mb-2", "doc-entry", "d-flex", "align-items-center");
                        docEntry.innerHTML = `
                            <input type="file" name="documents[${campaignId}][]" class="form-control me-2">
                            <button type="button" class="btn btn-sm btn-danger remove-document">
                                <i class="fas fa-trash"></i>
                            </button>
                        `;
                        docsContainer.appendChild(docEntry);
                    }
                }

                // Remove Note
                if (event.target.classList.contains("remove-note") || event.target.closest(".remove-note")) {
                    const button = event.target.classList.contains("remove-note") ?
                        event.target : event.target.closest(".remove-note");
                    button.closest(".note-entry").remove();
                }

                // Remove Document
                if (event.target.classList.contains("remove-document") || event.target.closest(".remove-document")) {
                    const button = event.target.classList.contains("remove-document") ?
                        event.target : event.target.closest(".remove-document");
                    button.closest(".doc-entry").remove();
                }
            });

            const searchInput = document.getElementById('search-input');
            const filterType = document.getElementById('filter-type');
            const filterStatus = document.getElementById('filter-status');
            const campaignsTableBody = document.querySelector('#campaigns-table tbody');

            function fetchCampaigns() {
                if (!campaignsTableBody) return;

                const searchText = searchInput?.value.trim() || '';
                const selectedType = filterType?.value || '';
                const selectedStatus = filterStatus?.value || '';

                $.ajax({
                    url: "{{ route('company.campaigns.filter') }}", // Laravel route helper
                    type: 'GET',
                    data: {
                        search: searchText,
                        type: selectedType,
                        status: selectedStatus
                    },
                    success: function (response) {
                        // Check if expected HTML exists
                        if (response.html) {
                            campaignsTableBody.innerHTML = response.html;
                        } else {
                            campaignsTableBody.innerHTML = `<tr><td colspan="5">No campaigns found.</td></tr>`;
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', error);
                        campaignsTableBody.innerHTML = `<tr><td colspan="5">Failed to load campaigns.</td></tr>`;
                    }
                    // console.log(response) 
                });
            }

            // Attach event listeners if elements exist
            if (searchInput) searchInput.addEventListener('input', fetchCampaigns);
            if (filterType) filterType.addEventListener('change', fetchCampaigns);
            if (filterStatus) filterStatus.addEventListener('change', fetchCampaigns);
        });

        // Ensure form submission includes files by setting the appropriate enctype
        document.addEventListener("DOMContentLoaded", function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                // Check if the form contains file inputs
                if (form.querySelector('input[type="file"]')) {
                    form.setAttribute('enctype', 'multipart/form-data');
                }
            });
        });
    </script>
{{-- @endsection --}}
