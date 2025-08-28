@extends('layouts.modern-master')

@section('title', 'Create Group - TV Wall Admin')
@section('page-title', 'Create New Group')

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
                                <i class="bi bi-plus-circle me-2"></i>
                                Create New Group
                            </h3>
                            <p class="text-muted mb-0 mt-1">Create a new content group for organizing your media</p>
                        </div>
                        <a href="{{ route('datagroup') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i>
                            Back to Groups
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Form -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="modern-card" data-aos="fade-up" data-aos-delay="100">
                <div class="card-body">
                    <form action="{{ url('simpangroup') }}" method="POST" id="createGroupForm">
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
                                       name="nama" 
                                       placeholder="Enter group name (e.g., Marketing Campaign, Event Display)"
                                       required
                                       maxlength="100">
                            </div>
                            <div class="form-text">
                                <small class="text-muted">Choose a descriptive name for easy identification</small>
                                <div class="float-end">
                                    <span id="nameCounter">0</span>/100
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
                                          placeholder="Describe the purpose of this group, what type of content it will contain, or any special instructions..."
                                          maxlength="500"></textarea>
                            </div>
                            <div class="form-text">
                                <small class="text-muted">Optional: Provide additional details about this group</small>
                                <div class="float-end">
                                    <span id="descCounter">0</span>/500
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

                        <!-- Preview Card -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Preview</label>
                            <div class="preview-card">
                                <div class="preview-header">
                                    <div class="preview-icon">
                                        <i class="bi bi-collection" id="previewIcon"></i>
                                    </div>
                                    <div class="preview-info">
                                        <h6 class="preview-name" id="previewName">Group Name</h6>
                                        <small class="preview-desc" id="previewDesc">Group description will appear here</small>
                                    </div>
                                    <div class="preview-badge">
                                        <span class="badge bg-success">New</span>
                                    </div>
                                </div>
                                <div class="preview-stats">
                                    <div class="stat-item">
                                        <i class="bi bi-file-earmark-play"></i>
                                        <span>0 Media Files</span>
                                    </div>
                                    <div class="stat-item">
                                        <i class="bi bi-eye"></i>
                                        <span>Ready to Display</span>
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
                                Create Group
                            </button>
                        </div>
                    </form>
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

.preview-card {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
    border: 1px solid rgba(99, 102, 241, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
}

.preview-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.preview-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.preview-info {
    flex-grow: 1;
}

.preview-name {
    font-weight: 700;
    color: var(--dark-color);
    margin: 0;
}

.preview-desc {
    color: #6b7280;
}

.preview-stats {
    display: flex;
    gap: 2rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(99, 102, 241, 0.2);
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    font-size: 0.9rem;
}

.stat-item i {
    color: var(--primary-color);
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

@media (max-width: 768px) {
    .icon-selector .row {
        justify-content: center;
    }
    
    .preview-stats {
        flex-direction: column;
        gap: 1rem;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('groupName');
    const descInput = document.getElementById('groupDescription');
    const nameCounter = document.getElementById('nameCounter');
    const descCounter = document.getElementById('descCounter');
    const previewName = document.getElementById('previewName');
    const previewDesc = document.getElementById('previewDesc');
    const previewIcon = document.getElementById('previewIcon');
    
    // Character counters
    nameInput.addEventListener('input', function() {
        const length = this.value.length;
        nameCounter.textContent = length;
        previewName.textContent = this.value || 'Group Name';
        
        if (length > 80) {
            nameCounter.style.color = '#ef4444';
        } else {
            nameCounter.style.color = '#6b7280';
        }
    });
    
    descInput.addEventListener('input', function() {
        const length = this.value.length;
        descCounter.textContent = length;
        previewDesc.textContent = this.value || 'Group description will appear here';
        
        if (length > 400) {
            descCounter.style.color = '#ef4444';
        } else {
            descCounter.style.color = '#6b7280';
        }
    });
    
    // Icon selection
    document.querySelectorAll('input[name="group_icon"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const iconMap = {
                'collection': 'bi-collection',
                'folder': 'bi-folder',
                'grid': 'bi-grid-3x3',
                'display': 'bi-display',
                'tv': 'bi-tv',
                'camera': 'bi-camera-video'
            };
            
            previewIcon.className = `bi ${iconMap[this.value]}`;
        });
    });
    
    // Form validation
    document.getElementById('createGroupForm').addEventListener('submit', function(e) {
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
    
    // Auto-focus on name input
    nameInput.focus();
});
</script>
@endpush