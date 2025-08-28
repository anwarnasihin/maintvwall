@extends('layouts.modern-master')

@section('title', 'Edit Group - TV Wall Admin')
@section('page-title', 'Edit Group')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card fade-in-up" data-aos="fade-up">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0">
                                <i class="bi bi-pencil-square me-2"></i>
                                Edit Group: {{ $gro->name }}
                            </h3>
                            <p class="text-muted mb-0 mt-1">Update group information and settings</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="/show/{{ $gro->name }}" target="_blank" class="btn btn-outline-primary">
                                <i class="bi bi-display"></i>
                                Preview Display
                            </a>
                            <a href="{{ route('datagroup') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i>
                                Back to Groups
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Edit Form -->
        <div class="col-lg-8">
            <div class="modern-card" data-aos="fade-up" data-aos-delay="100">
                <div class="card-body">
                    <form action="{{ url('updategroup', $gro->id) }}" method="POST" id="editGroupForm">
                        @csrf
                        
                        <!-- Group Icon Selection -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Group Icon</label>
                            <div class="icon-selector">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="radio" class="btn-check" name="group_icon" id="icon1" value="collection" checked>
                                        <label class="btn btn-outline-primary icon-option" for="icon1">
                                            <i class="bi bi-collection"></i>
                                        </label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="radio" class="btn-check" name="group_icon" id="icon2" value="folder">
                                        <label class="btn btn-outline-primary icon-option" for="icon2">
                                            <i class="bi bi-folder"></i>
                                        </label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="radio" class="btn-check" name="group_icon" id="icon3" value="grid">
                                        <label class="btn btn-outline-primary icon-option" for="icon3">
                                            <i class="bi bi-grid-3x3"></i>
                                        </label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="radio" class="btn-check" name="group_icon" id="icon4" value="display">
                                        <label class="btn btn-outline-primary icon-option" for="icon4">
                                            <i class="bi bi-display"></i>
                                        </label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="radio" class="btn-check" name="group_icon" id="icon5" value="tv">
                                        <label class="btn btn-outline-primary icon-option" for="icon5">
                                            <i class="bi bi-tv"></i>
                                        </label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="radio" class="btn-check" name="group_icon" id="icon6" value="camera">
                                        <label class="btn btn-outline-primary icon-option" for="icon6">
                                            <i class="bi bi-camera-video"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted">Choose an icon to represent this group</small>
                        </div>

                        <!-- Group Name -->
                        <div class="mb-4">
                            <label for="groupName" class="form-label fw-bold">
                                Group Name <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-tag"></i>
                                </span>
                                <input type="text" 
                                       class="form-control form-control-lg" 
                                       id="groupName" 
                                       name="name" 
                                       value="{{ $gro->name }}"
                                       placeholder="Enter group name"
                                       required
                                       maxlength="100">
                            </div>
                            <div class="form-text">
                                <small class="text-muted">Choose a descriptive name for easy identification</small>
                                <div class="float-end">
                                    <span id="nameCounter">{{ strlen($gro->name) }}</span>/100
                                </div>
                            </div>
                        </div>

                        <!-- Group Description -->
                        <div class="mb-4">
                            <label for="groupDescription" class="form-label fw-bold">
                                Description
                            </label>
                            <div class="input-group">
                                <span class="input-group-text align-items-start pt-3">
                                    <i class="bi bi-text-paragraph"></i>
                                </span>
                                <textarea class="form-control" 
                                          id="groupDescription" 
                                          name="keterangan" 
                                          rows="4" 
                                          placeholder="Describe the purpose of this group..."
                                          maxlength="500">{{ $gro->keterangan }}</textarea>
                            </div>
                            <div class="form-text">
                                <small class="text-muted">Optional: Provide additional details about this group</small>
                                <div class="float-end">
                                    <span id="descCounter">{{ strlen($gro->keterangan ?? '') }}</span>/500
                                </div>
                            </div>
                        </div>

                        <!-- Group Settings -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Group Settings</label>
                            <div class="settings-grid">
                                <div class="setting-item">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="autoPlay" name="auto_play" checked>
                                        <label class="form-check-label" for="autoPlay">
                                            <strong>Auto Play</strong>
                                            <small class="d-block text-muted">Automatically start playing content when displayed</small>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="setting-item">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="loopContent" name="loop_content" checked>
                                        <label class="form-check-label" for="loopContent">
                                            <strong>Loop Content</strong>
                                            <small class="d-block text-muted">Repeat content continuously</small>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="setting-item">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="showTransitions" name="show_transitions" checked>
                                        <label class="form-check-label" for="showTransitions">
                                            <strong>Smooth Transitions</strong>
                                            <small class="d-block text-muted">Enable smooth transitions between content</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('datagroup') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-x-circle me-2"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn-modern btn-lg">
                                <i class="bi bi-check-circle me-2"></i>
                                Update Group
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Group Statistics -->
        <div class="col-lg-4">
            <div class="modern-card" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-bar-chart me-2"></i>
                        Group Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="stats-list">
                        <div class="stat-item">
                            <div class="stat-icon bg-primary">
                                <i class="bi bi-file-earmark-play"></i>
                            </div>
                            <div class="stat-info">
                                <div class="stat-value">{{ $mediaCount ?? 0 }}</div>
                                <div class="stat-label">Media Files</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon bg-success">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div class="stat-info">
                                <div class="stat-value">{{ $activeCount ?? 0 }}</div>
                                <div class="stat-label">Active Content</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon bg-warning">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div class="stat-info">
                                <div class="stat-value">{{ $scheduledCount ?? 0 }}</div>
                                <div class="stat-label">Scheduled</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon bg-info">
                                <i class="bi bi-calendar-plus"></i>
                            </div>
                            <div class="stat-info">
                                <div class="stat-value">{{ $gro->created_at ? $gro->created_at->format('M d, Y') : 'Unknown' }}</div>
                                <div class="stat-label">Created</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="modern-card mt-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lightning me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('createfile') }}?group={{ $gro->id }}" class="btn btn-outline-primary">
                            <i class="bi bi-plus-circle me-2"></i>
                            Add Media to Group
                        </a>
                        <a href="/show/{{ $gro->name }}" target="_blank" class="btn btn-outline-success">
                            <i class="bi bi-display me-2"></i>
                            Preview Display
                        </a>
                        <button class="btn btn-outline-danger" onclick="confirmDelete()">
                            <i class="bi bi-trash me-2"></i>
                            Delete Group
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-selector .icon-option {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.icon-selector .btn-check:checked + .icon-option {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    border-color: var(--primary-color);
    transform: scale(1.05);
}

.settings-grid {
    display: grid;
    gap: 1rem;
}

.setting-item {
    padding: 1rem;
    background: rgba(99, 102, 241, 0.05);
    border-radius: 12px;
    border: 1px solid rgba(99, 102, 241, 0.1);
}

.form-switch .form-check-input {
    width: 3rem;
    height: 1.5rem;
}

.form-switch .form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.stats-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(0, 0, 0, 0.02);
    border-radius: 12px;
}

.stat-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.stat-info {
    flex-grow: 1;
}

.stat-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--dark-color);
}

.stat-label {
    font-size: 0.875rem;
    color: #6b7280;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
}

.input-group-text {
    background: rgba(99, 102, 241, 0.1);
    border-color: #e5e7eb;
    color: var(--primary-color);
}

.btn-lg {
    padding: 0.75rem 2rem;
    font-size: 1.1rem;
    border-radius: 12px;
}
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('groupName');
    const descInput = document.getElementById('groupDescription');
    const nameCounter = document.getElementById('nameCounter');
    const descCounter = document.getElementById('descCounter');
    
    // Character counters
    nameInput.addEventListener('input', function() {
        const length = this.value.length;
        nameCounter.textContent = length;
        
        if (length > 80) {
            nameCounter.style.color = '#ef4444';
        } else {
            nameCounter.style.color = '#6b7280';
        }
    });
    
    descInput.addEventListener('input', function() {
        const length = this.value.length;
        descCounter.textContent = length;
        
        if (length > 400) {
            descCounter.style.color = '#ef4444';
        } else {
            descCounter.style.color = '#6b7280';
        }
    });
    
    // Form validation
    document.getElementById('editGroupForm').addEventListener('submit', function(e) {
        const name = nameInput.value.trim();
        
        if (!name) {
            e.preventDefault();
            alert('Please enter a group name');
            nameInput.focus();
            return;
        }
        
        if (name.length < 3) {
            e.preventDefault();
            alert('Group name must be at least 3 characters long');
            nameInput.focus();
            return;
        }
    });
});

function confirmDelete() {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will delete the group and all its associated media files!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `{{ url('deletegroup') }}/{{ $gro->id }}`;
        }
    });
}
</script>
@endpush