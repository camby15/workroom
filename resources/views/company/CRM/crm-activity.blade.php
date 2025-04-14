<style>
    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        padding-left: 40px;
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-date {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .timeline-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 4px;
    }

    .deal-status-card {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .stat-card {
        transition: transform 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }
    /* Dashboard Cards */
.stat-card {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 20px;
    height: 100%;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    font-size: 24px;
    margin-bottom: 10px;
}

.sales .stat-icon { color: #6777ef; }
.conversion .stat-icon { color: #17a2b8; }
.deal .stat-icon { color: #ffc107; }
.pipeline .stat-icon { color: #28a745; }

.stat-title {
    font-size: 14px;
    color: #6c757d;
    margin-bottom: 5px;
    font-weight: 500;
}

.stat-value-sale {
    font-size: 24px;
    font-weight: 600;
    color: white;
    margin-bottom: 5px;
}

.stat-change {
    font-size: 12px;
    color: #6c757d;
}

.text-success { color: #28a745; }
.text-danger { color: #dc3545; }
.text-muted { color: #6c757d; }

/* Filter Section */
.dashboard-filter {
    margin-bottom: 20px;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.dashboard-filter .card-body {
    padding: 15px;
}

.stat-card {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.stat-icon {
    font-size: 24px;
    margin-bottom: 15px;
    display: inline-block;
    padding: 15px;
    border-radius: 50%;
    color: #fff;
}

.stat-card.tasks .stat-icon {
    background-color: #3b5de7;
}

.stat-card.calls .stat-icon {
    background-color: #45cb85;
}

.stat-card.meetings .stat-icon {
    background-color: #17a2b8;
}

.stat-card.events .stat-icon {
    background-color: #ffc107;
}

.stat-title {
    font-size: 14px;
    color: #6c757d;
    margin-bottom: 5px;
    font-weight: 500;
}

.stat-value {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 15px;
    color: #495057;
}

.stat-progress {
    margin-top: 10px;
}

.stat-progress small {
    font-size: 12px;
    color: #6c757d;
    display: block;
    margin-top: 5px;
}
#small{
    color: white !important;
}
</style>


<div class="row">
    <!-- Total Sales Card -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card sales">
            <i class="stat-icon fas fa-chart-line"></i>
            <div class="stat-title">Task</div>
            <div class="stat-value-sale" id="taskCount">0</div>

            <div class="stat-progress">
                <div class="progress" style="height: 5px;">
                    <div id="taskProgress" class="progress-bar bg-primary" style="width: 0%"></div>
                </div>
                <small id="small">Completion: <span id="taskCompletionRate">0</span>%</small>
            </div>
        </div>
    </div>

    <!-- Conversion Rate Card -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card conversion">
            <i class="stat-icon fas fa-percent"></i>
            <div class="stat-title">Calls</div>
            <div class="stat-value-sale" id="callCount">0</div>
            <div class="stat-progress">
                <div class="progress" style="height: 5px;">
                    <div id="callProgress" class="progress-bar bg-success" style="width: 0%"></div>
                </div>
                <small id="small">Completion: <span id="callCompletionRate">0</span>%</small>
            </div>
        </div>
    </div>

    <!-- Average Deal Size Card -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card deal">
            <i class="stat-icon fas fa-dollar-sign"></i>
            <div class="stat-title">Meeting</div>
            <div class="stat-value-sale" id="meetingCount">0</div>
            <div class="stat-progress">
                <div class="progress" style="height: 5px;">
                    <div id="meetingProgress" class="progress-bar bg-info" style="width: 0%"></div>
                </div>
                <small id="small">Completion: <span id="meetingCompletionRate">0</span>%</small>
            </div>
        </div>
    </div>

    <!-- Pipeline Value Card -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card pipeline">
            <i class="stat-icon fas fa-filter"></i>
            <div class="stat-title">Event</div>
            <div class="stat-value-sale" id="eventCount">0</div>
            <div class="stat-progress">
                <div class="progress" style="height: 5px;">
                    <div id="eventProgress" class="progress-bar bg-warning" style="width: 0%"></div>
                </div>
                <small id="small">Completion: <span id="eventCompletionRate">0</span>%</small>
            </div>
        </div>
    </div>
</div>




<div class="d-flex justify-content-end mb-3 my-3">
    <div class="btn-group">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
            <i class="fas fa-tasks me-1"></i> New Task
        </button>
        <button type="button" class="btn btn-success ms-2" data-bs-toggle="modal" data-bs-target="#scheduleCallModal">
            <i class="fas fa-phone-alt me-1"></i> Schedule Call
        </button>
        <button type="button" class="btn btn-info ms-2" data-bs-toggle="modal" data-bs-target="#scheduleMeetingModal">
            <i class="fas fa-video me-1"></i> Schedule Meeting
        </button>
        <button type="button" class="btn btn-secondary ms-2" data-bs-toggle="modal" data-bs-target="#addEventModal">
            <i class="fas fa-calendar me-1"></i> Add Event
        </button>
    </div>
</div>


<div class="row">



    <!-- Recent Activities -->
    <div class="col-12 mt-4">
        <div class="card crm-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="header-title mb-0">Recent Activities</h4>
                    <select class="form-select form-select-sm" style="width: 150px;">
                        <option value="all">All Activities</option>
                        <option value="tasks">Tasks</option>
                        <option value="calls">Calls</option>
                        <option value="meetings">Meetings</option>
                    </select>
                </div>
                <div class="table-responsive">
                    <table class="table table-centered table-hover" id="activities-table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Title</th>
                                <th>Related To</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination" id="activities-pagination">
                    
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Task Modal -->


{{-- <script>
document.addEventListener('DOMContentLoaded', function() {
    const activityForm = document.getElementById('addTaskForm');
    const relatedToName = document.getElementById('relatedToName');
    const relatedToId = document.getElementById('related_to');
    const relatedToType = document.getElementById('related_to_type');

    // Function to remove SweetAlert backdrop
    function removeSweetAlertBackdrop() {
        // Remove SweetAlert backdrop
        const sweetAlertBackdrop = document.querySelector('.swal2-backdrop');
        if (sweetAlertBackdrop) {
            sweetAlertBackdrop.remove();
        }
    }

    // Function to clean up SweetAlert backdrops and overlays
    function cleanupSweetAlert() {
        // Remove SweetAlert backdrop
        const backdrop = document.querySelector('.swal2-container.swal2-backdrop-show');
        if (backdrop) {
            backdrop.remove();
        }

        // Remove SweetAlert modal
        const modal = document.querySelector('.swal2-container.swal2-shown');
        if (modal) {
            modal.remove();
        }

        // Remove any remaining SweetAlert elements
        const swalElements = document.querySelectorAll('.swal2-container');
        swalElements.forEach(element => element.remove());

        // Remove any remaining modal backdrops
        const modalBackdrops = document.querySelectorAll('.modal-backdrop');
        modalBackdrops.forEach(backdrop => backdrop.remove());

        // Only remove SweetAlert-related styles from body
        const bodyStyle = document.body.style;
        if (bodyStyle.overflow === 'hidden') {
            bodyStyle.overflow = '';
        }
        if (bodyStyle.position === 'fixed') {
            bodyStyle.position = '';
        }
        if (bodyStyle.top === '0px') {
            bodyStyle.top = '';
        }
        if (bodyStyle.width === '100%') {
            bodyStyle.width = '';
        }
        if (bodyStyle.height === '100%') {
            bodyStyle.height = '';
        }
        if (bodyStyle.margin === '0px') {
            bodyStyle.margin = '';
        }
        if (bodyStyle.paddingRight === '0px' || bodyStyle.paddingRight === '17px') {
            bodyStyle.paddingRight = '';
        }

        // Force reflow
        document.body.offsetHeight;

        // Reset page layout
        document.body.style.overflowY = 'auto';
        document.documentElement.style.overflowY = 'auto';
    }

    // Add CSRF token to the form
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken;
    activityForm.appendChild(csrfInput);

    // Handle form submission
    activityForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Get the form data
        const formData = new FormData(activityForm);
        
        // Add related_to and related_to_type based on user input
        const contactName = relatedToName.value.trim();
        if (contactName) {
            // Set the related_to_type to 'Contact' since we're using contact name
            formData.set('related_to_type', 'Contact');
            
            // Find the contact ID from the name
            const contact = document.querySelector(`#contacts-list option[value="${contactName}"]`);
            if (contact) {
                formData.set('related_to', contact.value);
            } else {
                // If contact not found, create a new one
                formData.set('related_to', contactName);
            }
        }

        // Show loading alert
        const loadingAlert = Swal.fire({
            title: 'Creating Activity...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Send the form data
        fetch(activityForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Close loading alert
                loadingAlert.close();
                
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || 'Activity created successfully',
                    showConfirmButton: true,
                    allowOutsideClick: true,
                    allowEscapeKey: true,
                    backdrop: false,
                    customClass: {
                        container: 'swal2-container swal2-center',
                        popup: 'swal2-popup swal2-success swal2-icon-show',
                        overlay: 'swal2-overlay',
                        htmlContainer: 'swal2-html-container'
                    },
                    showClass: {
                        popup: 'swal2-noanimation',
                        overlay: 'swal2-noanimation'
                    },
                    preConfirm: () => {
                        // Clean up before closing
                        cleanupSweetAlert();
                        return true;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Get the modal instance
                        const modalElement = document.getElementById('addTaskModal');
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        
                        // Close the modal
                        if (modal) {
                            modal.hide();
                        }
                        
                        // Clear the form
                        activityForm.reset();
                        
                        // Refresh the activities table
                        fetch('/company/crm/activities/refresh', {
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            const tbody = document.querySelector('#activities-table tbody');
                            tbody.innerHTML = '';
                            
                            data.activities.forEach(activity => {
                                const newRow = tbody.insertRow();
                                newRow.innerHTML = `
                                    <td>
                                        <i class="fas @switch('${activity.type}')
                                            @case('task')
                                                fa-tasks text-primary
                                            @break
                                            @case('call')
                                                fa-phone-alt text-success
                                            @break
                                            @case('meeting')
                                                fa-video text-info
                                            @break
                                            @case('event')
                                                fa-calendar text-secondary
                                            @break
                                        @endswitch"></i>
                                    </td>
                                    <td>${activity.title}</td>
                                    <td>
                                        ${activity.related_to ? activity.related_to : 'N/A'}
                                    </td>
                                    <td>
                                        ${new Date(activity.start_date).toLocaleDateString()}
                                        ${activity.all_day ? '<span class="badge bg-secondary">All Day</span>' : ''}
                                    </td>
                                    <td>
                                        <span class="badge @switch('${activity.status}')
                                            @case('completed')
                                                bg-success
                                            @break
                                            @case('in_progress')
                                                bg-info
                                            @case('pending')
                                                bg-warning
                                            @default
                                                bg-danger
                                        @endswitch">
                                            ${activity.status.charAt(0).toUpperCase() + activity.status.slice(1)}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge @switch('${activity.priority}')
                                            @case('high')
                                                bg-danger
                                            @break
                                            @case('medium')
                                                bg-warning
                                            @case('low')
                                                bg-info
                                            @default
                                                bg-secondary
                                        @endswitch">
                                            ${activity.priority.charAt(0).toUpperCase() + activity.priority.slice(1)}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <i class="fas fa-edit text-primary me-3 edit-activity" 
                                               data-activity-id="${activity.id}"
                                               style="cursor: pointer; font-size: 1.5rem; transition: transform 0.2s;"
                                               onmouseover="this.style.transform='scale(1.1)'"></i>
                                            <i class="fas fa-check text-success me-3 complete-activity" 
                                               data-id="${activity.id}"
                                               style="cursor: pointer; font-size: 1.5rem; transition: transform 0.2s;"
                                               onmouseover="this.style.transform='scale(1.1)'"></i>
                                            <i class="fas fa-trash text-danger delete-activity" 
                                               data-id="${activity.id}"
                                               style="cursor: pointer; font-size: 1.5rem; transition: transform 0.2s;"
                                               onmouseover="this.style.transform='scale(1.1)'"></i>
                                        </div>
                                    </td>
                                `;
                            });
                        });
                    }
                 });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'An unexpected error occurred. Please try again.',
                showConfirmButton: true
            });
        });
    });
});
</script> --}}


<div class="modal fade" id="addTaskModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addTaskForm" action="{{ route('company.crm.activities.store') }}" method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="type" value="task">
                    
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="taskTitle" name="title" required placeholder="Enter task title">
                            <label for="taskTitle">Task Title</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="relatedToName" placeholder="Enter contact or account name" required>
                            <label for="relatedToName">Related To</label>
                        </div>
                        <input type="hidden" id="relatedTo" name="related_to" value="">
                        <input type="hidden" id="relatedToType" name="related_to_type" value="contact">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="dueDate" name="start_date" required>
                                <label for="dueDate">Due Date</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="priority" name="priority" required>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                                <label for="priority">Priority</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Description"></textarea>
                            <label for="description">Description</label>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="addTask">Add Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Call Modal -->
<div class="modal fade" id="scheduleCallModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Schedule Call</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="scheduleCallForm" action="{{ route('company.crm.activities.store') }}" method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="type" value="call">
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="callTitle" name="callTitle" required>
                            <label for="callTitle">Call Title</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="tel" class="form-control" id="contact"  name="contact" required>
                          
                            <label for="contact">Contact</label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="datetime-local" class="form-control" id="callDate"  name="callDate" required>
                                <label for="callDate">Call Date & Time</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="callType" name="callType">
                                    <option value="phone">Phone Call</option>
                                    <option value="video">Video Call</option>
                                </select>
                                <label for="callType">Call Type</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" id="callNotes" name="callNotes" rows="3"></textarea>
                            <label for="callNotes">Notes</label>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="schedulecall">Schedule Call</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Meeting Modal -->
<div class="modal fade" id="scheduleMeetingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Schedule Meeting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="scheduleMeetingForm" action="{{ route('company.crm.activities.store') }}" method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="type" value="meeting">
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="meetingTitle" name="meetingTitle"  required>
                            <label for="meetingTitle">Meeting Title</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="meetingParticipants" name="meetingParticipants">
                                <option value="">Select Participants</option>
                                <option value="1">John Doe</option>
                                <option value="2">Jane Smith</option>
                            </select>
                            <label for="meetingParticipants">Participants</label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="datetime-local" class="form-control" id="meetingDate" name="meetingDate" required>
                                <label for="meetingDate">Meeting Date & Time</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="meetingDuration" name="meetingDuration" required>
                                <label for="meetingDuration">Duration (minutes)</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" id="meetingAgenda" name="meetingAgenda" rows="3"></textarea>
                            <label for="meetingAgenda">Agenda</label>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="schedulemeeting">Schedule Meeting</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addEventForm" action="{{ route('company.crm.activities.store') }}" method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="type" value="event">
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="eventName" name="eventName" required>
                            <label for="eventName">Event Name</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="eventType" name="eventType">
                                <option value="">Select Event Type</option>
                                <option value="meeting">Meeting</option>
                                <option value="call">Call</option>
                                <option value="task">Task</option>
                                <option value="other">Other</option>
                            </select>
                            <label for="eventType">Event Type</label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="datetime-local" class="form-control" id="eventStart" name="eventStart" required>
                                <label for="eventStart">Start Date & Time</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="datetime-local" class="form-control" id="eventEnd" name="eventEnd" required>
                                <label for="eventEnd">End Date & Time</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" id="eventDescription" name="eventDescription" rows="3"></textarea>
                            <label for="eventDescription">Description</label>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="addnewevent">Add Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>











<div class="modal fade" id="editTaskModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editTaskForm" action="{{ route('company.crm.activities.update', ['activity' => ':id']) }}" method="POST" class="needs-validation" novalidate>
                    @method('PUT')
                    <input type="hidden" name="id" id="editTaskId">
                    <input type="hidden" name="type" value="task">
                    
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="editTaskTitle" name="title" required placeholder="Enter task title">
                            <label for="editTaskTitle">Task Title</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="editRelatedToName" placeholder="Enter contact or account name" required>
                            <label for="editRelatedToName">Related To</label>
                        </div>
                        <input type="hidden" id="editRelatedTo" name="related_to">
                        <input type="hidden" id="editRelatedToType" name="related_to_type" value="contact">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="editDueDate" name="start_date" required>
                                <label for="editDueDate">Due Date</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="editPriority" name="priority" required>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                                <label for="editPriority">Priority</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" id="editDescription" name="description" rows="3" placeholder="Description"></textarea>
                            <label for="editDescription">Description</label>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="updateTask">Update Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="editCallModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Call</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editCallForm" action="{{ route('company.crm.activities.update', ['activity' => ':id']) }}" method="POST" class="needs-validation" novalidate>
                    @method('PUT')
                    <input type="hidden" name="id" id="editCallId">
                    <input type="hidden" name="type" value="call">
                    
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="editCallTitle" name="title" required>
                            <label for="editCallTitle">Call Title</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="tel" class="form-control" id="editContact" name="contact" required>
                            <label for="editContact">Contact</label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="datetime-local" class="form-control" id="editCallDate" name="start_date" required>
                                <label for="editCallDate">Call Date & Time</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="editCallType" name="call_event_type">
                                    <option value="phone">Phone Call</option>
                                    <option value="video">Video Call</option>
                                </select>
                                <label for="editCallType">Call Type</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" id="editCallNotes" name="description" rows="3"></textarea>
                            <label for="editCallNotes">Notes</label>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="updateCall">Update Call</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>







<div class="modal fade" id="editMeetingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Meeting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editMeetingForm" action="{{ route('company.crm.activities.update', ['activity' => ':id']) }}" method="POST" class="needs-validation" novalidate>
                    @method('PUT')
                    <input type="hidden" name="id" id="editMeetingId">
                    <input type="hidden" name="type" value="meeting">
                    
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="editMeetingTitle" name="title" required>
                            <label for="editMeetingTitle">Meeting Title</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="editMeetingParticipants" name="participants">
                                <option value="">Select Participants</option>
                                <option value="1">John Doe</option>
                                <option value="2">Jane Smith</option>
                            </select>
                            <label for="editMeetingParticipants">Participants</label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="datetime-local" class="form-control" id="editMeetingDate" name="start_date" required>
                                <label for="editMeetingDate">Meeting Date & Time</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="editMeetingDuration" name="duration" required>
                                <label for="editMeetingDuration">Duration (minutes)</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" id="editMeetingAgenda" name="description" rows="3"></textarea>
                            <label for="editMeetingAgenda">Agenda</label>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="updateMeeting">Update Meeting</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="editEventModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editEventForm" action="{{ route('company.crm.activities.update', ['activity' => ':id']) }}" method="POST" class="needs-validation" novalidate>
                    @method('PUT')
                    <input type="hidden" name="id" id="editEventId">
                    <input type="hidden" name="type" value="event">
                    
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="editEventName" name="title" required>
                            <label for="editEventName">Event Name</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="editEventType" name="call_event_type">
                                <option value="">Select Event Type</option>
                                <option value="meeting">Meeting</option>
                                <option value="call">Call</option>
                                <option value="task">Task</option>
                                <option value="other">Other</option>
                            </select>
                            <label for="editEventType">Event Type</label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="datetime-local" class="form-control" id="editEventStart" name="start_date" required>
                                <label for="editEventStart">Start Date & Time</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="datetime-local" class="form-control" id="editEventEnd" name="end_date">
                                <label for="editEventEnd">End Date & Time</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" id="editEventDescription" name="description" rows="3"></textarea>
                            <label for="editEventDescription">Description</label>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="updateEvent">Update Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<!-- Add custom styles -->
<style>
    /* Activity Calendar Styles */
    #activityCalendar {
        background: #ffffff;
        border-radius: 0.5rem;
        padding: 1rem;
    }

    /* Activity Stats Styles */
    .activity-stats {
        padding: 1rem 0;
    }

    .activity-stat-item {
        padding: 0.5rem 0;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.875rem;
    }

    .stat-value {
        font-weight: 600;
        font-size: 1.25rem;
    }

    /* Table Styles */
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .table td {
        vertical-align: middle;
    }

    /* Modal Styles */
    .modal-content {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        background-color: #f8f9fa;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    /* Dark Mode Styles */
    .bg-dark {
        background-color: #212529 !important;
    }

    .text-light {
        color: #f8f9fa !important;
    }

    .bg-dark .text-light {
        color: black !important;
    }

    /* Form Control Styles */
    .form-control:focus,
    .form-select:focus {
        border-color: #727cf5;
        box-shadow: 0 0 0 0.2rem rgba(114, 124, 245, 0.25);
    }

    /* Button Styles */
    .btn-group .btn {
        padding: 0.5rem 1rem;
        font-weight: 500;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .btn-group {
            flex-direction: column;
            width: 100%;
        }

        .btn-group .btn {
            width: 100%;
            margin-left: 0 !important;
            margin-bottom: 0.5rem;
        }

        .btn-group .btn:last-child {
            margin-bottom: 0;
        }
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
    .form-floating select.form-select:focus,
    .form-floating textarea.form-control:focus {
        border-color: #033c42;
        box-shadow: none;
    }
    .form-floating input.form-control:focus ~ label,
    .form-floating select.form-select:focus ~ label,
    .form-floating textarea.form-control:focus ~ label {
        height: auto;
        padding: 0 0.5rem;
        transform: translateY(-50%) translateX(0.5rem) scale(0.85);
        color: white;
        border-radius: 5px;
        z-index: 5;
    }
    .form-floating input.form-control:focus ~ label::before,
    .form-floating select.form-select:focus ~ label::before,
    .form-floating textarea.form-control:focus ~ label::before {
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
    .form-floating input.form-control:not(:placeholder-shown) ~ label,
    .form-floating select.form-select:not([value=""]) ~ label,
    .form-floating textarea.form-control:not(:placeholder-shown) ~ label {
        height: auto;
        padding: 0 0.5rem;
        transform: translateY(-50%) translateX(0.5rem) scale(0.85);
        color: white;
        border-radius: 5px;
        z-index: 5;
    }
    .form-floating input.form-control:not(:placeholder-shown) ~ label::before,
    .form-floating select.form-select:not([value=""]) ~ label::before,
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
    .modal-body {
        background: none;
        padding: 1.5rem;
    }
</style>

<!-- Add necessary JavaScript -->
{{-- @push('scripts') --}}



<!-- Before closing body -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@5.11.3/main.min.js'></script>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Wait for jQuery to be loaded
    // if (typeof jQuery === 'undefined') {
    //     console.error('jQuery is not loaded');
    //     return;
    // }

    function showSafeSweetAlert(options) {
            if (!window.isAlertShowing) {
                window.isAlertShowing = true;
                return Swal.fire(options).finally(() => {
                    window.isAlertShowing = false;
                });
            }
        }

    $(document).ready(function() {

        // alert("hi");
        // Initialize DataTable
        // $('#activities-table').DataTable({
        //     pageLength: 10,
        //     order: [[3, 'desc']],
        //     responsive: true
        // });

        // console.log('jQuery is ready');

        // // Form Submission Handlers
        // $('#adTaskForm').on('submit', function(e) {
        //     e.preventDefault();
        //     console.log('Form submission triggered');

        //     const formData = new FormData();
        //     formData.append('title', $('#taskTitle').val());
        //     formData.append('type', 'task');
        //     formData.append('description', $('#description').val());
        //     formData.append('related_to', $('#relatedTo').val());
        //     formData.append('start_date', $('#dueDate').val());
        //     formData.append('priority', $('#priority').val());
        //     formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        //     console.log('Form data:', {
        //         title: $('#taskTitle').val(),
        //         type: 'task',
        //         description: $('#description').val(),
        //         related_to: $('#relatedTo').val(),
        //         start_date: $('#dueDate').val(),
        //         priority: $('#priority').val()
        //     });

        //     $.ajax({
        //         url: '{{ route("crm.activities.store") }}',
        //         method: 'POST',
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(response) {
        //             console.log('Success response:', response);
        //             if (response.success) {
        //                 // Show success message
        //                 Swal.fire({
        //                     icon: 'success',
        //                     title: 'Success!',
        //                     text: response.message || 'Activity created successfully',
        //                     timer: 2000,
        //                     showConfirmButton: false
        //                 }).then(() => {
        //                     $('#addTaskModal').modal('hide');
        //                     location.reload();
        //                 });
        //             }
        //         },
        //         error: function(xhr) {
        //             console.error('Error response:', xhr.responseJSON);
        //             const errors = xhr.responseJSON?.errors || {};
        //             let errorMessage = 'An error occurred while creating the activity.';
                    
        //             if (Object.keys(errors).length > 0) {
        //                 errorMessage = Object.values(errors).map(e => e[0]).join('<br>');
        //             }
                    
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: 'Error!',
        //                 html: errorMessage,
        //                 timer: 5000,
        //                 showConfirmButton: true
        //             });
        //         }
        //     });
        // });



















//   alert("hi");


    $(document).off('click', '#addTask').on('click', '#addTask', function(e) {
    e.preventDefault();

    // console.log("fff");

    // alert("hi");
    
  
    let submitBtn = $(this);
    submitBtn.prop("disabled", true).text("Saving...");

    let urlc = $("#addTaskForm").attr("action");  // Get form action URL
    let formData = new FormData($("#addTaskForm")[0]);  // Collect form data

    $.ajax({
        url: urlc,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        success: function(response) {
            console.log('Server response:', response);
            submitBtn.prop("disabled", false).text("Add New Task");

            if (response.success) {
                fetchActivitiesData();
                showSafeSweetAlert({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Task added successfully',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#addLeadModal').modal('hide');
                        $('#addDealForm')[0].reset();
                        fetchSalesData();
                    }
                });
            } else {
                console.error('Error response:', response);
                showSafeSweetAlert({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message[0] || 'Failed to add new Task. Please try again.',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', { status, error, response: xhr.responseJSON });
            submitBtn.prop("disabled", false).text("Add Task");

            let errorMessage = 'Failed to add Deal. Please try again.';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
            }

            showSafeSweetAlert({
                icon: 'error',
                title: 'Error!',
                html: errorMessage,
                confirmButtonText: 'OK'
            });
        }
    });
});







$(document).off('click', '#schedulecall').on('click', '#schedulecall', function(e) {
    e.preventDefault();
    

  
    let submitBtn = $(this);
    submitBtn.prop("disabled", true).text("Scheduling...");

    let urlc = $("#scheduleCallForm").attr("action");  // Get form action URL
    let formData = new FormData($("#scheduleCallForm")[0]);  // Collect form data

    $.ajax({
        url: urlc,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        success: function(response) {
            console.log('Server response:', response);
            submitBtn.prop("disabled", false).text("Schedule Call");

            if (response.success) {
                fetchActivitiesData();
                showSafeSweetAlert({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Schedule added successfully',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#addLeadModal').modal('hide');
                        $('#addDealForm')[0].reset();
                        fetchSalesData();
                    }
                });
            } else {
                console.error('Error response:', response);
                showSafeSweetAlert({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message[0] || 'Failed to Schedule Call. Please try again.',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', { status, error, response: xhr.responseJSON });
            submitBtn.prop("disabled", false).text("Schedule Call");

            let errorMessage = 'Failed to Schedule call. Please try again.';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
            }

            showSafeSweetAlert({
                icon: 'error',
                title: 'Error!',
                html: errorMessage,
                confirmButtonText: 'OK'
            });
        }
    });
});









$(document).off('click', '#schedulemeeting').on('click', '#schedulemeeting', function(e) {
    e.preventDefault();
  
    let submitBtn = $(this);
    submitBtn.prop("disabled", true).text("Scheduling Meeting...");

    let urlc = $("#scheduleMeetingForm").attr("action");  // Get form action URL
    let formData = new FormData($("#scheduleMeetingForm")[0]);  // Collect form data

    $.ajax({
        url: urlc,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        success: function(response) {
            fetchActivitiesData();
            console.log('Server response:', response);
            submitBtn.prop("disabled", false).text("Schedule Meeting");

            if (response.success) {
                showSafeSweetAlert({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Schedule added successfully',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#addLeadModal').modal('hide');
                        $('#addDealForm')[0].reset();
                        fetchSalesData();
                    }
                });
            } else {
                console.error('Error response:', response);
                showSafeSweetAlert({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message[0] || 'Failed to Schedule. Please try again.',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', { status, error, response: xhr.responseJSON });
            submitBtn.prop("disabled", false).text("Schedule Meeting");

            let errorMessage = 'Failed to Schedule Meeting. Please try again.';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
            }

            showSafeSweetAlert({
                icon: 'error',
                title: 'Error!',
                html: errorMessage,
                confirmButtonText: 'OK'
            });
        }
    });
});






$(document).off('click', '#addnewevent').on('click', '#addnewevent', function(e) {
    e.preventDefault();
    

  
    let submitBtn = $(this);
    submitBtn.prop("disabled", true).text("Adding...");

    let urlc = $("#addEventForm").attr("action");  // Get form action URL
    let formData = new FormData($("#addEventForm")[0]);  // Collect form data

    $.ajax({
        url: urlc,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        success: function(response) {
            console.log('Server response:', response);
            submitBtn.prop("disabled", false).text("Add Event");

            if (response.success) {
                fetchActivitiesData();
                showSafeSweetAlert({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Event added successfully',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#addLeadModal').modal('hide');
                        $('#addDealForm')[0].reset();
                        fetchSalesData();
                    }
                });
            } else {
                console.error('Error response:', response);
                showSafeSweetAlert({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message[0] || 'Failed to add Event. Please try again.',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', { status, error, response: xhr.responseJSON });
            submitBtn.prop("disabled", false).text("Add Event");

            let errorMessage = 'Failed to add Event. Please try again.';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
            }

            showSafeSweetAlert({
                icon: 'error',
                title: 'Error!',
                html: errorMessage,
                confirmButtonText: 'OK'
            });
        }
    });
});




function fetchActivitiesData(page = 1) {
    $.ajax({
        url: `/company/crm/activities/all?page=${page}`, 
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log(response);
            let tableBody = '';
            
            if (response.data.length === 0) {
                tableBody = `<tr>
                    <td colspan="7" class="text-center">
                        <div class="text-muted">
                            <i class="fas fa-tasks fa-3x mb-3"></i>
                            <p>No activities found. Start by creating a new activity.</p>
                        </div>
                    </td>
                </tr>`;
            } else {
                response.data.forEach(activity => {
                    // Determine icon class based on type
                    let typeIconClass = '';
                    switch(activity.type) {
                        case 'task': 
                            typeIconClass = 'fa-tasks text-primary'; 
                            break;
                        case 'call': 
                            typeIconClass = 'fa-phone-alt text-success'; 
                            break;
                        case 'meeting': 
                            typeIconClass = 'fa-video text-info'; 
                            break;
                        case 'event': 
                            typeIconClass = 'fa-calendar text-secondary'; 
                            break;
                        default: 
                            typeIconClass = 'fa-tasks text-muted';
                    }
                    
                    // Determine status badge class
                    let statusBadgeClass = '';
                    switch(activity.status) {
                        case 'completed': 
                            statusBadgeClass = 'bg-success'; 
                            break;
                        case 'in_progress': 
                            statusBadgeClass = 'bg-info'; 
                            break;
                        case 'pending': 
                            statusBadgeClass = 'bg-warning'; 
                            break;
                        default: 
                            statusBadgeClass = 'bg-danger';
                    }
                    
                    // Determine priority badge class
                    let priorityBadgeClass = '';
                    switch(activity.priority) {
                        case 'high': 
                            priorityBadgeClass = 'bg-danger'; 
                            break;
                        case 'medium': 
                            priorityBadgeClass = 'bg-warning'; 
                            break;
                        case 'low': 
                            priorityBadgeClass = 'bg-info'; 
                            break;
                        default: 
                            priorityBadgeClass = 'bg-secondary';
                    }
                    
                    // Format date
                    let dueDate = activity.start_date ? 
                        new Date(activity.start_date).toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        }) : 'N/A';
                    
                    // All day badge
                    let allDayBadge = activity.all_day ? 
                        '<span class="badge bg-secondary ms-1">All Day</span>' : '';
                    
                    tableBody += `<tr>
                        <td>
                            <i class="fas ${typeIconClass}"></i>
                        </td>
                        <td>${activity.title}</td>
                        <td>${activity.related_to || 'N/A'}</td>
                        <td>
                            ${dueDate}
                            ${allDayBadge}
                        </td>
                        <td>
                            <span class="badge ${statusBadgeClass}">
                                ${activity.status.charAt(0).toUpperCase() + activity.status.slice(1)}
                            </span>
                        </td>
                        <td>
                            <span class="badge ${priorityBadgeClass}">
                                ${activity.priority.charAt(0).toUpperCase() + activity.priority.slice(1)}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex">
                                <i class="fas fa-edit text-primary me-3 editactivity" 
                                   data-bs-toggle="moda" 
                                   data-bs-target="#editActivityMod"
                                   data-activity-id="${activity.id}"
                                   style="cursor: pointer; font-size: 1.5rem; transition: transform 0.2s;"
                                   onmouseover="this.style.transform='scale(1.1)'"></i>
                                <i class="fas fa-check text-success me-3 complete-activity" 
                                   data-id="${activity.id}"
                                   style="cursor: pointer; font-size: 1.5rem; transition: transform 0.2s;"
                                   onmouseover="this.style.transform='scale(1.1)'"></i>
                                <i class="fas fa-trash text-danger delete-activity" 
                                   data-id="${activity.id}"
                                   style="cursor: pointer; font-size: 1.5rem; transition: transform 0.2s;"
                                   onmouseover="this.style.transform='scale(1.1)'"></i>
                            </div>
                        </td>
                    </tr>`;
                });
            }

            $('#activities-table tbody').html(tableBody);

            // Generate Pagination
            let paginationHtml = '';
            
            // if (response.pagination.last_page > 1) {
                paginationHtml = `<li class="page-item ${response.pagination.prev_page_url ? '' : 'disabled'}">
                    <a class="page-link" href="#" onclick="return changePageActivities(event, ${response.pagination.current_page - 1})">Previous</a>
                </li>`;

                for (let i = 1; i <= response.pagination.last_page; i++) {
                    paginationHtml += `<li class="page-item ${response.pagination.current_page === i ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="return changePageActivities(event, ${i})">${i}</a>
                    </li>`;
                }

                paginationHtml += `<li class="page-item ${response.pagination.next_page_url ? '' : 'disabled'}">
                    <a class="page-link" href="#" onclick="return changePageActivities(event, ${response.pagination.current_page + 1})">Next</a>
                </li>`;
            // }

            $('#activities-pagination').html(paginationHtml);
            
            // Initialize tooltips for action buttons
            $('[data-toggle="tooltip"]').tooltip();
        },
        error: function(xhr, status, error) {
            console.error("Error:", status, error, xhr.responseText);
            // Show error message to user
            alert('Failed to load activities data. Please try again.');
        }
    });
}

// Page change function
function changePageActivities(event, page) {
    event.preventDefault();
    fetchActivitiesData(page);
}



fetchActivitiesData();





$(document).on('click', '.delete-activity', function() {
    let activityId = $(this).data('id');
    
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/company/crm/activities/${activityId}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    fetchActivitiesData();
                    showSafeSweetAlert({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message[0] || 'Activity has been deleted successfully.',
                    confirmButtonText: 'OK'
                });
                    // fetchActivitiesData();
                },
                error: function(xhr, status, error) {
                    console.error("Error:", status, error, xhr.responseText);
                    showSafeSweetAlert({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message[0] || 'Failed to Delete Activity. Please try again.',
                    confirmButtonText: 'OK'
                });
                }
            });
        }
    });
});


// $(document).on('click', '.complete-activity', function() {
//     let activityId = $(this).data('id');
    
//     Swal.fire({
//         title: 'Mark as completed?',
//         text: "This will update the activity status.",
//         icon: 'question',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Yes, complete it!'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             $.ajax({
//                 url: `/company/crm/activities/${activityId}/complete`,
//                 method: 'POST',
//                 headers: {
//                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 },
//                 success: function(response) {
//                     Swal.fire(
//                         'Completed!',
//                         'Activity marked as completed.',
//                         'success'
//                     );
//                     fetchActivitiesData();
//                 },
//                 error: function(xhr, status, error) {
//                     console.error("Error:", status, error, xhr.responseText);
//                     Swal.fire(
//                         'Error!',
//                         'Failed to complete activity.',
//                         'error'
//                     );
//                 }
//             });
//         }
//     });
// });


// $(document).on('click', '.complete-activity', function() {
//     let activityId = $(this).data('id');
    
//     Swal.fire({
//         title: 'Mark as completed?',
//         text: "This will update the activity status.",
//         icon: 'question',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Yes, complete it!',
//         showLoaderOnConfirm: true,
//         preConfirm: () => {
//             return $.ajax({
//                 url: `/company/crm/activities/${activityId}/complete`,
//                 method: 'POST',
//                 headers: {
//                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 }
//             }).then(response => {
//                 if (!response.success) {
//                     throw new Error(response.message || 'Failed to complete activity');
//                 }
//                 return response;
//             }).catch(error => {
//                 Swal.showValidationMessage(
//                     `Request failed: ${error.statusText || error.responseJSON.message || 'Unknown error'}`
//                 );
//             });
//         },
//         allowOutsideClick: () => !Swal.isLoading()
//     }).then((result) => {
//         if (result.isConfirmed) {
//             Swal.fire({
//                 title: 'Completed!',
//                 text: 'Activity marked as completed.',
//                 icon: 'success',
//                 timer: 1500,
//                 showConfirmButton: false
//             });
//             fetchActivitiesData(); 
//         }
//     });
// });


$(document).on('click', '.complete-activity', function(e) {
    e.preventDefault();
    let activityId = $(this).data('id');
    
    // Get fresh CSRF token from meta tag
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    
    Swal.fire({
        title: 'Complete Activity?',
        text: "Are you sure you want to mark this activity as completed?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, complete it!',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return $.ajax({
                url: `/company/crm/activities/${activityId}/complete`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                dataType: 'json'
            }).then(response => {
                if (!response.success) {
                    throw new Error(response.message || 'Failed to complete activity');
                }
                return response;
            }).catch(error => {
                Swal.showValidationMessage(
                    `Request failed: ${error.responseJSON?.message || error.statusText || 'Unknown error'}`
                );
                return false;
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            Swal.fire({
                title: 'Completed!',
                text: 'Activity marked as completed.',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            });
            fetchActivitiesData(); // Refresh the activities list
        }
    });
});


$(document).on("click", ".editactivity", function() {
    let id = $(this).attr("data-activity-id");
    
    // Show loading indicator
    $('#loadingIndicator').show();
    
    // Fetch activity data
    $.ajax({
        url: `/company/crm/activities/${id}`,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const activity = response.data;
                
                // Determine which modal to show based on activity type
                switch(activity.type) {
                    case 'task':
                        populateTaskModal(activity);
                        $('#editTaskModal').modal('show');
                        break;
                    case 'call':
                        populateCallModal(activity);
                        $('#editCallModal').modal('show');
                        break;
                    case 'meeting':
                        populateMeetingModal(activity);
                        $('#editMeetingModal').modal('show');
                        break;
                    case 'event':
                        populateEventModal(activity);
                        $('#editEventModal').modal('show');
                        break;
                    default:
                        console.error('Unknown activity type:', activity.type);
                }
            } else {
                showToast('error', 'Failed to fetch activity data');
            }
        },
        error: function(xhr, status, error) {
            showToast('error', 'An error occurred while fetching activity data');
            console.error('Error:', error);
        },
        complete: function() {
            $('#loadingIndicator').hide();
        }
    });
});


// Task Update Handler
$('#editTaskForm').on('submit', function(e) {
    e.preventDefault();
    handleActivityUpdate($(this), 'Task');
});

// Call Update Handler
$('#editCallForm').on('submit', function(e) {
    e.preventDefault();
    handleActivityUpdate($(this), 'Call');
});

// Meeting Update Handler
$('#editMeetingForm').on('submit', function(e) {
    e.preventDefault();
    handleActivityUpdate($(this), 'Meeting');
});

// Event Update Handler
$('#editEventForm').on('submit', function(e) {
    e.preventDefault();
    handleActivityUpdate($(this), 'Event');
});

// Universal Update Function with SweetAlert
function handleActivityUpdate(form, activityType) {
    const activityId = form.find('input[name="id"]').val();
    const submitBtn = form.find('button[type="submit"]');
    const originalBtnText = submitBtn.html();

    // Show loading state
    submitBtn.prop('disabled', true).html(`
        <span class="spinner-border spinner-border-sm" role="status"></span>
        Updating...
    `);

    Swal.fire({
        title: 'Are you sure?',
        text: `Update this ${activityType.toLowerCase()}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update it!'
    }).then((result) => {
        if (result.isConfirmed) {
            performUpdateRequest(form, activityId, activityType, submitBtn, originalBtnText);
        } else {
            submitBtn.prop('disabled', false).html(originalBtnText);
        }
    });
}

function performUpdateRequest(form, activityId, activityType, submitBtn, originalBtnText) {
    $.ajax({
        url: `/company/crm/activities/${activityId}`,
        type: 'PUT',
        data: form.serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log(response);
            
          fetchActivitiesData();
          fetchActivityStats();

          submitBtn.prop('disabled', false).text(`Update ${activityType}`);


            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: `${activityType} has been updated.`,
                    timer: 2000,
                    showConfirmButton: false
                });
                form.closest('.modal').modal('hide');
                refreshActivities();
            } else {
                showError(response.message || `${activityType} update failed`);
            }
        },
        error: function(xhr) {
            const errorMsg = xhr.responseJSON?.message || 
                          xhr.statusText || 
                          `${activityType} update failed`;
            showError(errorMsg);
        },
        complete: function() {
            submitBtn.prop('disabled', false).html(originalBtnText);
        }
    });
}

function showError(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message,
        timer: 3000
    });
}

function refreshActivities() {
    // Implement your refresh logic here
    if ($.fn.DataTable.isDataTable('#activitiesTable')) {
        $('#activitiesTable').DataTable().ajax.reload(null, false);
    }
    // Or trigger custom event
    $(document).trigger('activities:updated');
}
// Toast notification helper
function showToast(type, message) {
    const toast = $(`
        <div class="toast align-items-center text-white bg-${type} border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `);
    
    $('#toastContainer').append(toast);
    new bootstrap.Toast(toast[0]).show();
    
    toast.on('hidden.bs.toast', function() {
        $(this).remove();
    });
}





// Helper functions to populate each modal type
function populateTaskModal(activity) {
    $('#editTaskId').val(activity.id);
    $('#editTaskTitle').val(activity.title);
    $('#editRelatedToName').val(activity.relatedModel ? activity.relatedModel.name : '');
    $('#editRelatedTo').val(activity.related_to);
    $('#editRelatedToType').val(activity.related_to_type);
    $('#editDueDate').val(formatDateForInput(activity.start_date));
    $('#editPriority').val(activity.priority);
    $('#editDescription').val(activity.description_agenda_notes);
    
    // Update form action with correct ID
    $('#editTaskForm').attr('action', `/company/crm/activities/${activity.id}`);
}

function populateCallModal(activity) {
    $('#editCallId').val(activity.id);
    $('#editCallTitle').val(activity.title);
    $('#editContact').val(activity.contact);
    $('#editCallDate').val(formatDateTimeForInput(activity.start_date));
    $('#editCallType').val(activity.call_event_type);
    $('#editCallNotes').val(activity.description_agenda_notes);
    
    // Update form action with correct ID
    $('#editCallForm').attr('action', `/company/crm/activities/${activity.id}`);
}

function populateMeetingModal(activity) {
    $('#editMeetingId').val(activity.id);
    $('#editMeetingTitle').val(activity.title);
    $('#editMeetingParticipants').val(activity.participants);
    $('#editMeetingDate').val(formatDateTimeForInput(activity.start_date));
    $('#editMeetingDuration').val(activity.duration);
    $('#editMeetingAgenda').val(activity.description_agenda_notes);
    
    // Update form action with correct ID
    $('#editMeetingForm').attr('action', `/company/crm/activities/${activity.id}`);
}

function populateEventModal(activity) {
    $('#editEventId').val(activity.id);
    $('#editEventName').val(activity.title);
    $('#editEventType').val(activity.call_event_type);
    $('#editEventStart').val(formatDateTimeForInput(activity.start_date));
    $('#editEventEnd').val(formatDateTimeForInput(activity.end_date));
    $('#editEventDescription').val(activity.description_agenda_notes);
    
    // Update form action with correct ID
    $('#editEventForm').attr('action', `/company/crm/activities/${activity.id}`);
}

// Helper function to format date for date input
function formatDateForInput(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toISOString().split('T')[0];
}

// Helper function to format datetime for datetime-local input
function formatDateTimeForInput(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    // Convert to local datetime string in format YYYY-MM-DDTHH:MM
    return new Date(date.getTime() - (date.getTimezoneOffset() * 60000))
        .toISOString()
        .slice(0, 16);
}

// Helper function to show toast notifications
function showToast(type, message) {
    // Implement your toast notification system here
    const toast = $(`<div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>`);
    
    $('#toastContainer').append(toast);
    new bootstrap.Toast(toast[0]).show();
    
    // Remove toast after it hides
    toast.on('hidden.bs.toast', function() {
        $(this).remove();
    });
}





function fetchActivityStats() {
        $.ajax({
            url: '/company/crm/activities/statistics',
            method: 'POST',
            // dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                // Show loading state if needed
                $('.activity-stats').addClass('loading');
            },
            success: function(response) {

                // console.log(response);
                // alert("ff");
                if (response.success) {
                    updateActivityStats(response.data);
                } else {
                    console.error('Failed to load stats:', response.message);
                    showErrorAlert('Failed to load activity statistics');
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                showErrorAlert('Error fetching activity data');
            },
            complete: function() {
                $('.activity-stats').removeClass('loading');
            }
        });
    }

    // Update the UI with stats
    function updateActivityStats(data) {
        // Update counts
        $('#taskCount').text(data.by_type.task);
        $('#callCount').text(data.by_type.call);
        $('#meetingCount').text(data.by_type.meeting);
        $('#eventCount').text(data.by_type.event);
        $('#totalActivities').text(data.total_activities);
        $('#completionRate').text(data.completion_rate);
        
        // Calculate percentages for progress bars
        const maxCount = Math.max(
            data.by_type.task,
            data.by_type.call,
            data.by_type.meeting,
            data.by_type.event
        ) || 1; // Avoid division by zero
        
        // Update progress bars
        $('#taskProgress').css('width', (data.by_type.task / maxCount * 100) + '%');
        $('#callProgress').css('width', (data.by_type.call / maxCount * 100) + '%');
        $('#meetingProgress').css('width', (data.by_type.meeting / maxCount * 100) + '%');
        $('#eventProgress').css('width', (data.by_type.event / maxCount * 100) + '%');
        $('#completionProgress').css('width', data.completion_rate + '%');
        
        // Add animation
        $('.progress-bar').each(function() {
            $(this).css('transition', 'width 1s ease-in-out');
        });
    }

    // Show error alert
    function showErrorAlert(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            timer: 3000,
            showConfirmButton: false
        });
    }

    // Initial load
    fetchActivityStats();
    


    
    
   

});
</script>

{{-- @endpush --}}