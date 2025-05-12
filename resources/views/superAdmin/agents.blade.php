@extends('layouts.vertical', ['page_title' => 'Manage Agents'])
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
            transform: translateY(-50%) translateX(0.5rem) scale(0.85);
            color: white;
            border-radius: 5px;
            z-index: 5;
        }
        .form-floating input.form-control:focus ~ label::before,
        .form-floating input.form-control:not(:placeholder-shown) ~ label::before,
        .form-floating select.form-select:focus ~ label::before,
        .form-floating select.form-select:not([value=""]) ~ label::before,
        .form-floating textarea.form-control:focus ~ label::before,
        .form-floating textarea.form-control:not(:placeholder-shown) ~ label::before {
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

        /* Dark mode table styles */
        [data-bs-theme="dark"] .table {
            color: #e9ecef;
            border-color: #495057;
        }

        [data-bs-theme="dark"] .table-light {
            background-color: #343a40;
            color: #e9ecef;
        }

        [data-bs-theme="dark"] .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.05);
            color: #e9ecef;
        }

        [data-bs-theme="dark"] .modal-content {
            background-color: #212529;
            color: #e9ecef;
        }

        [data-bs-theme="dark"] .modal-header {
            border-bottom-color: #495057;
        }

        [data-bs-theme="dark"] .modal-footer {
            border-top-color: #495057;
        }

        [data-bs-theme="dark"] .nav-tabs .nav-link {
            color: #adb5bd;
        }

        [data-bs-theme="dark"] .nav-tabs .nav-link.active {
            color: #e9ecef;
            background-color: #343a40;
            border-color: #495057;
        }

        [data-bs-theme="dark"] .card {
            background-color: #2c3034;
            border-color: #495057;
        }

        [data-bs-theme="dark"] .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        .agent-profile-link img {
            border: 2px solid #dee2e6;
            transition: box-shadow 0.2s;
        }
        .agent-profile-link:hover img {
            box-shadow: 0 0 0 2px #0d6efd;
        }
        .modal .form-floating > label {
            left: 0.75rem;
        }
        .modal .form-select {
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
        }
        .skill-badge {
            margin-right: 5px;
            margin-bottom: 5px;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-bordered mb-3" id="managementTabs">
                        <li class="nav-item">
                            <a href="#agents-tab" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                <i class="bi bi-people me-1"></i> Agents Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tickets-tab" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <i class="bi bi-ticket-detailed me-1"></i> Support Tickets
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane show active" id="agents-tab">
                            <h4 class="header-title mb-3">Agents Management</h4>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0" id="agentsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Skills</th>
                                    <th>Current Load</th>
                                    <th>Status</th>
                                    <th>Last Active</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example row -->
                                <tr>
                                    <td>
                                        <a href="#" class="agent-profile-link" data-bs-toggle="modal" data-bs-target="#agentProfileModal" data-name="Jane Smith" data-email="jane@example.com" data-skills="Technical Support,Customer Service" data-status="Available" data-lastactive="2025-05-07">
                                            Nelson Ojuelegba
                                        </a>
                                    </td>
                                    <td>nelson@shrinq.com</td>
                                    <td>
                                        <span class="badge bg-info skill-badge">Technical Support</span>
                                        <span class="badge bg-info skill-badge">Customer Service</span>
                                        <span class="badge bg-info skill-badge">Marketing</span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 15px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">3/10</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch d-inline-block">
                                            <input class="form-check-input agent-status-toggle" type="checkbox" checked>
                                            <label class="form-check-label">Available</label>
                                        </div>
                                    </td>
                                    <td>2025-05-07</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editAgentModal">Edit</button>
                                        <button class="btn btn-sm btn-danger btn-delete-agent">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 d-flex flex-wrap gap-2">
                        <button class="btn btn-primary btn-sm" id="addAgentBtn" data-bs-toggle="modal" data-bs-target="#addAgentModal">Add Agent</button>
                        <button class="btn btn-secondary btn-sm" id="importAgentsBtn">Import Agents</button>
                        <button class="btn btn-outline-secondary btn-sm" id="exportAgentsBtn">Export Agents</button>
                    </div>
                </div>

                        <div class="tab-pane" id="tickets-tab">
                            <h4 class="header-title mb-3">Support Tickets</h4>
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap mb-0" id="ticketsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Ticket ID</th>
                                            <th>Subject</th>
                                            <th>Customer</th>
                                            <th>Priority</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Example row -->
                                        <tr>
                                            <td>#1234</td>
                                            <td>
                                                <a href="#" class="text-body" data-bs-toggle="modal" data-bs-target="#viewTicketModal">
                                                    Technical Issue with Login
                                                </a>
                                            </td>
                                            <td>John Customer</td>
                                            <td><span class="badge bg-danger">High</span></td>
                                            <td><span class="badge bg-warning">Open</span></td>
                                            <td>2025-05-08</td>
                                            <td>
                                                <button class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#viewTicketModal">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-ticket" data-ticket-id="1234">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3 d-flex flex-wrap gap-2">
                                <button class="btn btn-primary btn-sm" id="refreshTicketsBtn">
                                    <i class="bi bi-arrow-clockwise me-1"></i> Refresh Tickets
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" id="exportTicketsBtn">
                                    <i class="bi bi-download me-1"></i> Export Tickets
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Agent Modal -->
<div class="modal fade" id="addAgentModal" tabindex="-1" aria-labelledby="addAgentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAgentModalLabel">Add New Agent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAgentForm">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="addAgentName" placeholder="Name" required>
                        <label for="addAgentName">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="addAgentEmail" placeholder="Email" required>
                        <label for="addAgentEmail">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="addAgentSkills" multiple required>
                            <option value="technical_support">Technical Support</option>
                            <option value="customer_service">Customer Service</option>
                            <option value="billing">Billing Support</option>
                            <option value="product_specialist">Product Specialist</option>
                        </select>
                        <label for="addAgentSkills">Skills</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="addAgentStatus" required>
                            <option value="available">Available</option>
                            <option value="busy">Busy</option>
                            <option value="offline">Offline</option>
                        </select>
                        <label for="addAgentStatus">Status</label>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Agent Modal -->
<div class="modal fade" id="editAgentModal" tabindex="-1" aria-labelledby="editAgentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAgentModalLabel">Edit Agent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAgentForm">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="editAgentName" placeholder="Name" required>
                        <label for="editAgentName">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="editAgentEmail" placeholder="Email" required>
                        <label for="editAgentEmail">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="editAgentSkills" multiple required>
                            <option value="technical_support">Technical Support</option>
                            <option value="customer_service">Customer Service</option>
                            <option value="billing">Billing Support</option>
                            <option value="product_specialist">Product Specialist</option>
                        </select>
                        <label for="editAgentSkills">Skills</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="editAgentStatus" required>
                            <option value="available">Available</option>
                            <option value="busy">Busy</option>
                            <option value="offline">Offline</option>
                        </select>
                        <label for="editAgentStatus">Status</label>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            <div class="modal-header">
                <h5 class="modal-title" id="viewTicketModalLabel">View Ticket Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ticket-details">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Ticket ID:</strong> <span id="viewTicketId">#1234</span></p>
                            <p><strong>Subject:</strong> <span id="viewTicketSubject">Technical Issue with Login</span></p>
                            <p><strong>Status:</strong> <span id="viewTicketStatus" class="badge bg-warning">Open</span></p>
                            <p><strong>Priority:</strong> <span id="viewTicketPriority" class="badge bg-danger">High</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Customer:</strong> <span id="viewTicketCustomer">Nelson Ojuelegba</span></p>
                            <p><strong>Created:</strong> <span id="viewTicketCreated">2025-05-08</span></p>
                            <p><strong>Assigned To:</strong> <span id="viewTicketAssigned">Unassigned</span></p>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h6>Description</h6>
                        <div class="border rounded p-3 bg-light" id="viewTicketDescription">
                            Customer is unable to log in to their account. They have tried resetting their password but are still experiencing issues.
                        </div>
                    </div>

                    <div class="mt-3">
                        <h6>Ticket History</h6>
                        <div class="ticket-timeline" id="viewTicketTimeline">
                            <div class="timeline-item border-start border-2 ps-3 pb-3">
                                <div class="text-muted small">2025-05-08 10:00 AM</div>
                                <div>Ticket created by customer</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignTicketModal">
                    Assign Ticket
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Agent Profile Quick View Modal -->
<div class="modal fade" id="agentProfileModal" tabindex="-1" aria-labelledby="agentProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agentProfileModalLabel">Agent Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="agentProfileContent">
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
        // Global state for metrics and caching
        const state = {
            agents: new Map(),
            teams: new Map(),
            tickets: new Map(),
            eventSource: null
        };

        // Initialize real-time updates
        function initializeRealTimeUpdates() {
            if (state.eventSource) {
                state.eventSource.close();
            }

            state.eventSource = new EventSource('/api/agent-status-updates');
            
            state.eventSource.onmessage = function(event) {
                const { agentId, status, currentLoad, metrics } = JSON.parse(event.data);
                updateAgentStatus(agentId, status, currentLoad);
                if (metrics) {
                    updateAgentMetrics(agentId, metrics);
                }
            };

            state.eventSource.onerror = function() {
                console.error('SSE Connection lost. Retrying in 5s...');
                setTimeout(initializeRealTimeUpdates, 5000);
            };
        }

        // Update agent status in UI
        function updateAgentStatus(agentId, status, currentLoad) {
            const agentRow = document.querySelector(`tr[data-agent-id="${agentId}"]`);
            if (agentRow) {
                const statusBadge = agentRow.querySelector('.status-badge');
                const loadBar = agentRow.querySelector('.progress-bar');
                
                statusBadge.className = `badge bg-${status === 'Available' ? 'success' : 'secondary'} status-badge`;
                statusBadge.textContent = status;
                
                loadBar.style.width = `${currentLoad}%`;
                loadBar.textContent = `${currentLoad}/100`;
                loadBar.className = `progress-bar bg-${currentLoad > 80 ? 'danger' : currentLoad > 60 ? 'warning' : 'success'}`;
            }
        }

        // Smart agent assignment algorithm
        function suggestBestAgent(ticketDetails) {
            const availableAgents = Array.from(document.querySelectorAll('tr[data-agent-id]'))
                .filter(row => row.querySelector('.status-badge').textContent === 'Available');

            return availableAgents.reduce((best, current) => {
                const currentSkills = current.dataset.skills.split(',');
                const skillMatch = currentSkills.filter(skill => 
                    ticketDetails.requiredSkills.includes(skill)
                ).length;
                const workload = parseInt(current.dataset.workload);
                const metrics = state.agents.get(current.dataset.agentId)?.metrics || {};
                
                // Calculate score based on multiple factors
                const score = (
                    (skillMatch * 10) + // Skills match
                    ((100 - workload) * 0.5) + // Inverse workload
                    (metrics.customerSatisfaction || 0) * 5 + // Customer satisfaction
                    (100 - (metrics.averageResolutionTime || 0)) * 0.3 // Speed of resolution
                );
                
                return score > best.score ? {agent: current, score} : best;
            }, {agent: null, score: -1}).agent;
        }

        // Team load balancing
        function assignTicketToTeam(teamId, ticketId) {
            const team = state.teams.get(teamId);
            if (!team) return null;

            const leastLoadedAgent = team.members.reduce((min, agent) => {
                const agentData = state.agents.get(agent.id);
                return (!min || agentData.currentLoad < min.currentLoad) ? 
                    {id: agent.id, currentLoad: agentData.currentLoad} : min;
            }, null);

            if (leastLoadedAgent) {
                return assignTicketToAgent(leastLoadedAgent.id, ticketId);
            }
            return null;
        }

        // Priority-based queue management
        function updateTicketQueue() {
            const tickets = Array.from(document.querySelectorAll('#ticketsTable tbody tr'));
            const priorityMap = { urgent: 4, high: 3, medium: 2, low: 1 };
            
            tickets.sort((a, b) => {
                const aPriority = priorityMap[a.dataset.priority];
                const bPriority = priorityMap[b.dataset.priority];
                const aAge = new Date(a.dataset.created);
                const bAge = new Date(b.dataset.created);
                
                return (bPriority - aPriority) || (aAge - bAge);
            });
            
            const tbody = document.querySelector('#ticketsTable tbody');
            tickets.forEach(ticket => tbody.appendChild(ticket));
        }

        // Performance metrics tracking
        function updateAgentMetrics(agentId, metrics) {
            const agent = state.agents.get(agentId);
            if (agent) {
                agent.metrics = metrics;
                
                // Update UI if agent profile is open
                const profileContent = document.getElementById('agentProfileContent');
                if (profileContent && profileContent.dataset.agentId === agentId) {
                    const metricsHtml = `
                        <div class="mt-3">
                            <h6>Performance Metrics</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="border rounded p-2">
                                        <small class="text-muted">Avg. Resolution Time</small>
                                        <h6 class="mb-0">${metrics.averageResolutionTime}h</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-2">
                                        <small class="text-muted">Customer Satisfaction</small>
                                        <h6 class="mb-0">${metrics.customerSatisfaction}%</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    profileContent.insertAdjacentHTML('beforeend', metricsHtml);
                }
            }
        }

        // Auto-save functionality
        let saveTimeout;
        document.getElementById('assignmentNotes')?.addEventListener('input', function() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                const ticketId = document.getElementById('ticketId').value;
                localStorage.setItem(`draft_notes_${ticketId}`, this.value);
                
                // Visual feedback
                const saveIndicator = document.getElementById('saveIndicator') || 
                    this.insertAdjacentHTML('afterend', '<small id="saveIndicator" class="text-muted"></small>');
                saveIndicator.textContent = 'Draft saved';
                setTimeout(() => saveIndicator.textContent = '', 2000);
            }, 500);
        });

        // Skill-based routing
        function analyzeTicketContent(description) {
            const keywords = {
                technical: ['error', 'bug', 'crash', 'not working', 'failed'],
                billing: ['payment', 'charge', 'invoice', 'subscription', 'price'],
                account: ['login', 'password', 'access', 'account', 'permission'],
                product: ['how to', 'feature', 'functionality', 'use', 'documentation']
            };
            
            const detectedCategories = Object.entries(keywords).filter(([category, words]) => 
                words.some(word => description.toLowerCase().includes(word))
            ).map(([category]) => category);
            
            return detectedCategories.length > 0 ? detectedCategories : ['general'];
        }

        // Initialize everything
        document.addEventListener('DOMContentLoaded', function() {
            initializeRealTimeUpdates();
            updateTicketQueue();

            // Restore any saved drafts
            const ticketId = document.getElementById('ticketId')?.value;
            if (ticketId) {
                const savedNotes = localStorage.getItem(`draft_notes_${ticketId}`);
                if (savedNotes) {
                    document.getElementById('assignmentNotes').value = savedNotes;
                }
            }
        });

        // Clean up on page unload
        window.addEventListener('beforeunload', function() {
            if (state.eventSource) {
                state.eventSource.close();
            }
        });

        // Enhanced ticket assignment form handling
        document.getElementById('assignTicketForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const ticketId = document.getElementById('ticketId').value;
            const assignmentType = document.getElementById('assignmentType').value;
            const ticketDetails = state.tickets.get(ticketId);

            let assignedTo;
            if (assignmentType === 'agent') {
                if (!document.getElementById('assignedAgent').value) {
                    const suggestedAgent = suggestBestAgent(ticketDetails);
                    if (suggestedAgent) {
                        const result = await Swal.fire({
                            title: 'Agent Suggestion',
                            html: `Based on current workload and skills, we suggest assigning this ticket to <strong>${suggestedAgent.dataset.name}</strong>. Would you like to proceed?`,
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, assign',
                            cancelButtonText: 'No, let me choose'
                        });
                        
                        if (result.isConfirmed) {
                            assignedTo = suggestedAgent.dataset.agentId;
                        } else {
                            return; // Let user select manually
                        }
                    }
                } else {
                    assignedTo = document.getElementById('assignedAgent').value;
                }
            } else {
                assignedTo = document.getElementById('assignedTeam').value;
                const result = await assignTicketToTeam(assignedTo, ticketId);
                if (!result) {
                    Swal.fire('Error', 'Failed to assign ticket to team. Please try again.', 'error');
                    return;
                }
            }

            // Save assignment
            try {
                await saveTicketAssignment(ticketId, assignedTo, assignmentType);
                
                Swal.fire({
                    title: 'Ticket Assigned!',
                    text: `The ticket has been successfully assigned.`,
                    icon: 'success'
                }).then(() => {
                    $('#assignTicketModal').modal('hide');
                    updateTicketQueue();
                    localStorage.removeItem(`draft_notes_${ticketId}`);
                });
            } catch (error) {
                Swal.fire('Error', 'Failed to assign ticket. Please try again.', 'error');
            }
        });

        // Fetch and display agent tasks
        async function loadAgentTasks(agentEmail) {
            try {
                const response = await fetch(`/api/agent-tasks/${encodeURIComponent(agentEmail)}`);
                if (!response.ok) throw new Error('Failed to fetch tasks');
                
                const tasks = await response.json();
                const tasksHtml = tasks.length ? tasks.map(task => `
                    <div class="border-bottom py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>${task.ticketId}</strong>
                            <span class="badge bg-${task.priority === 'high' ? 'danger' : 'warning'}">
                                ${task.priority}
                            </span>
                        </div>
                        <div class="text-muted small">${task.subject}</div>
                        <div class="progress mt-1" style="height: 3px;">
                            <div class="progress-bar" role="progressbar" style="width: ${task.progress}%"></div>
                        </div>
                    </div>
                `).join('') : '<div class="text-muted">No active tasks</div>';

                document.getElementById('agentCurrentTasks').innerHTML = tasksHtml;

                // Delete ticket functionality
                document.querySelectorAll('.delete-ticket').forEach(button => {
                    button.addEventListener('click', async function() {
                        const ticketId = this.dataset.ticketId;
                        
                        const result = await Swal.fire({
                            title: 'Are you sure?',
                            text: 'This ticket will be permanently deleted!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!'
                        });

                        if (result.isConfirmed) {
                            try {
                                await deleteTicket(ticketId);
                                // Remove the row from the table
                                this.closest('tr').remove();
                                Swal.fire(
                                    'Deleted!',
                                    'The ticket has been deleted.',
            } catch (error) {
                document.getElementById('agentCurrentTasks').innerHTML = `
                    <div class="alert alert-danger">Failed to load tasks</div>
                `;
            }
        }

        // Delete ticket functionality
        document.querySelectorAll('.delete-ticket').forEach(button => {
            button.addEventListener('click', async function() {
                const ticketId = this.dataset.ticketId;
                
                const result = await Swal.fire({
                    title: 'Are you sure?',
                    text: 'This ticket will be permanently deleted!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                });

                if (result.isConfirmed) {
                    try {
                        await deleteTicket(ticketId);
                        // Remove the row from the table
                        this.closest('tr').remove();
                        Swal.fire(
                            'Deleted!',
                            'The ticket has been deleted.',
                            'success'
                        );
                    } catch (error) {
                        Swal.fire(
                            'Error!',
                            'Failed to delete the ticket.',
                            'error'
                        );
                    }
                }
            });
        });

        async function deleteTicket(ticketId) {
            const response = await fetch(`/api/tickets/${ticketId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (!response.ok) throw new Error('Failed to delete ticket');
            return response.json();
        }

        // Save ticket assignment
        async function saveTicketAssignment(ticketId, assignedTo, assignmentType) {
            const response = await fetch('/api/assign-ticket', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    ticketId,
                    assignedTo,
                    assignmentType,
                    notes: document.getElementById('assignmentNotes').value,
                    dueDate: document.getElementById('dueDate').value,
                    priority: document.getElementById('priority').value
                })
            });

            if (!response.ok) throw new Error('Failed to assign ticket');
            return response.json();
        }
    </script>
@endsection