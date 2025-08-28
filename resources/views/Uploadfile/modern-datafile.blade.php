@extends('layouts.modern-master')

@section('title', 'Media Files Management - TV Wall Admin')
@section('page-title', 'Media Files Management')

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
                                <i class="bi bi-file-earmark-play me-2"></i>
                                Media Files Management
                            </h3>
                            <p class="text-muted mb-0 mt-1">Manage your media content and schedules</p>
                        </div>
                        <a href="{{ route('createfile') }}" class="btn-modern">
                            <i class="bi bi-plus-circle"></i>
                            Add New Media
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card" data-aos="fade-up" data-aos-delay="100">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Filter by Type</label>
                            <select class="form-select" id="typeFilter">
                                <option value="">All Types</option>
                                <option value="images">Images</option>
                                <option value="video">Videos</option>
                                <option value="youtube">YouTube</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Filter by Group</label>
                            <select class="form-select" id="groupFilter">
                                <option value="">All Groups</option>
                                @foreach($dataFile->pluck('groups.name')->unique()->filter() as $groupName)
                                <option value="{{ $groupName }}">{{ $groupName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Filter by Status</label>
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="expired">Expired</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-secondary" id="resetFilters">
                                    <i class="bi bi-arrow-clockwise"></i>
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Media Files Grid -->
    <div class="row" id="mediaGrid">
        @forelse($dataFile as $item)
        <div class="col-lg-4 col-md-6 mb-4 media-item" 
             data-type="{{ $item->typeFile }}" 
             data-group="{{ $item->groups ? $item->groups->name : '' }}"
             data-status="{{ $item->ed_date <= date('Y-m-d') ? 'expired' : 'active' }}"
             data-aos="fade-up" 
             data-aos-delay="{{ $loop->index * 50 }}">
            <div class="modern-card h-100">
                <div class="card-body">
                    <!-- Media Header -->
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="media-type-badge">
                            @if($item->typeFile == 'images')
                                <i class="bi bi-image"></i>
                                <span>Image</span>
                            @elseif($item->typeFile == 'video')
                                <i class="bi bi-play-circle"></i>
                                <span>Video</span>
                            @else
                                <i class="bi bi-youtube"></i>
                                <span>YouTube</span>
                            @endif
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item preview-media" href="#" 
                                       data-type="{{ $item->typeFile }}" 
                                       data-src="{{ $item->direktori }}">
                                    <i class="bi bi-eye me-2"></i>Preview
                                </a></li>
                                @if($item->typeFile != 'youtube')
                                <li><a class="dropdown-item download-media" href="#" data-src="{{ $item->direktori }}">
                                    <i class="bi bi-download me-2"></i>Download
                                </a></li>
                                @endif
                                <li><a class="dropdown-item edit-media" href="#" 
                                       data-id="{{ $item->id }}"
                                       data-type="{{ $item->typeFile }}"
                                       data-duration="{{ $item->duration }}"
                                       data-start="{{ $item->str_date }}"
                                       data-end="{{ $item->ed_date }}"
                                       data-days="{{ $item->selected_days }}">
                                    <i class="bi bi-pencil me-2"></i>Edit
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger delete-item" href="#" data-id="{{ $item->id }}">
                                    <i class="bi bi-trash me-2"></i>Delete
                                </a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Media Preview -->
                    <div class="media-preview mb-3">
                        @if($item->typeFile == 'images')
                            <img src="{{ asset($item->direktori) }}" alt="Media" class="img-fluid rounded">
                        @elseif($item->typeFile == 'video')
                            <video class="w-100 rounded" style="max-height: 200px;">
                                <source src="{{ asset($item->direktori) }}" type="video/mp4">
                            </video>
                        @else
                            <div class="youtube-preview">
                                <i class="bi bi-youtube display-1 text-danger"></i>
                                <p class="mt-2">YouTube Video</p>
                            </div>
                        @endif
                    </div>

                    <!-- Media Info -->
                    <div class="media-info">
                        <h6 class="fw-bold mb-2">{{ basename($item->direktori) }}</h6>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <small class="text-muted">Group:</small>
                                <div class="fw-semibold">{{ $item->groups ? $item->groups->name : 'No Group' }}</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Duration:</small>
                                <div class="fw-semibold">
                                    @if($item->typeFile == 'images')
                                        {{ $item->duration }}ms
                                    @else
                                        Auto
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <small class="text-muted">Start Date:</small>
                                <div class="fw-semibold">{{ date('d/m/Y', strtotime($item->str_date)) }}</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">End Date:</small>
                                <div class="fw-semibold {{ $item->ed_date <= date('Y-m-d') ? 'text-danger' : '' }}">
                                    {{ date('d/m/Y', strtotime($item->ed_date)) }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">Created by:</small>
                            <div class="fw-semibold">{{ optional($item->user)->name ?? 'Unknown' }}</div>
                        </div>

                        <!-- Status Badge -->
                        <div class="d-flex justify-content-between align-items-center">
                            @if($item->ed_date <= date('Y-m-d'))
                                <span class="badge bg-danger">Expired</span>
                            @else
                                <span class="badge bg-success">Active</span>
                            @endif
                            
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary preview-media" 
                                        data-type="{{ $item->typeFile }}" 
                                        data-src="{{ $item->direktori }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-outline-secondary edit-media"
                                        data-id="{{ $item->id }}"
                                        data-type="{{ $item->typeFile }}"
                                        data-duration="{{ $item->duration }}"
                                        data-start="{{ $item->str_date }}"
                                        data-end="{{ $item->ed_date }}"
                                        data-days="{{ $item->selected_days }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-outline-danger delete-item" data-id="{{ $item->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="modern-card text-center py-5" data-aos="fade-up">
                <div class="card-body">
                    <div class="empty-state">
                        <i class="bi bi-file-earmark-play display-1 text-muted mb-3"></i>
                        <h4 class="text-muted">No Media Files Found</h4>
                        <p class="text-muted mb-4">Start by uploading your first media file</p>
                        <a href="{{ route('createfile') }}" class="btn-modern">
                            <i class="bi bi-plus-circle"></i>
                            Upload First Media
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-pencil me-2"></i>
                    Edit Media Settings
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST" action="/editDuration">
                @csrf
                <input type="hidden" id="editId" name="id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12" id="durationDiv">
                            <label class="form-label">Duration (milliseconds)</label>
                            <input type="number" id="editDuration" name="duration" class="form-control" placeholder="5000">
                            <small class="text-muted">Only applies to images</small>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" id="editStartDate" name="str_date" class="form-control">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">End Date</label>
                            <input type="date" id="editEndDate" name="ed_date" class="form-control">
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label">Display Days</label>
                            <div class="day-selector">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="selected_days[]" value="1" id="day1">
                                    <label class="form-check-label" for="day1">Mon</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="selected_days[]" value="2" id="day2">
                                    <label class="form-check-label" for="day2">Tue</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="selected_days[]" value="3" id="day3">
                                    <label class="form-check-label" for="day3">Wed</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="selected_days[]" value="4" id="day4">
                                    <label class="form-check-label" for="day4">Thu</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="selected_days[]" value="5" id="day5">
                                    <label class="form-check-label" for="day5">Fri</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="selected_days[]" value="6" id="day6">
                                    <label class="form-check-label" for="day6">Sat</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="selected_days[]" value="7" id="day7">
                                    <label class="form-check-label" for="day7">Sun</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="checkAllDays">
                                    <label class="form-check-label" for="checkAllDays"><strong>All Days</strong></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-eye me-2"></i>
                    Media Preview
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div id="previewContainer"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Download Form -->
<form id="downloadForm" action="/download" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="konten" id="downloadSrc">
</form>

<style>
.media-type-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.25rem 0.75rem;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.media-preview {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background: #f8fafc;
    min-height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.media-preview img,
.media-preview video {
    max-height: 200px;
    object-fit: cover;
}

.youtube-preview {
    text-align: center;
    padding: 2rem;
    color: #6b7280;
}

.day-selector {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.form-check-inline {
    margin-right: 0;
}

.empty-state i {
    opacity: 0.3;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.dropdown-menu {
    border: none;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    padding: 0.5rem;
}

.dropdown-item {
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background: rgba(99, 102, 241, 0.1);
    color: var(--primary-color);
}

.badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
    border-radius: 20px;
}
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://www.youtube.com/iframe_api"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const typeFilter = document.getElementById('typeFilter');
    const groupFilter = document.getElementById('groupFilter');
    const statusFilter = document.getElementById('statusFilter');
    const resetFilters = document.getElementById('resetFilters');
    const mediaItems = document.querySelectorAll('.media-item');

    function filterItems() {
        const typeValue = typeFilter.value;
        const groupValue = groupFilter.value;
        const statusValue = statusFilter.value;

        mediaItems.forEach(item => {
            const itemType = item.dataset.type;
            const itemGroup = item.dataset.group;
            const itemStatus = item.dataset.status;

            const typeMatch = !typeValue || itemType === typeValue;
            const groupMatch = !groupValue || itemGroup === groupValue;
            const statusMatch = !statusValue || itemStatus === statusValue;

            if (typeMatch && groupMatch && statusMatch) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    typeFilter.addEventListener('change', filterItems);
    groupFilter.addEventListener('change', filterItems);
    statusFilter.addEventListener('change', filterItems);

    resetFilters.addEventListener('click', function() {
        typeFilter.value = '';
        groupFilter.value = '';
        statusFilter.value = '';
        filterItems();
    });

    // Edit functionality
    document.querySelectorAll('.edit-media').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const type = this.dataset.type;
            const duration = this.dataset.duration;
            const startDate = this.dataset.start;
            const endDate = this.dataset.end;
            const days = this.dataset.days;

            document.getElementById('editId').value = id;
            document.getElementById('editDuration').value = duration;
            document.getElementById('editStartDate').value = startDate;
            document.getElementById('editEndDate').value = endDate;

            // Show/hide duration field based on type
            const durationDiv = document.getElementById('durationDiv');
            if (type === 'images') {
                durationDiv.style.display = 'block';
            } else {
                durationDiv.style.display = 'none';
            }

            // Set selected days
            document.querySelectorAll('input[name="selected_days[]"]').forEach(checkbox => {
                checkbox.checked = false;
            });

            if (days) {
                try {
                    const selectedDays = JSON.parse(days);
                    selectedDays.forEach(day => {
                        const checkbox = document.querySelector(`input[name="selected_days[]"][value="${day}"]`);
                        if (checkbox) checkbox.checked = true;
                    });
                } catch (e) {
                    console.error('Error parsing selected days:', e);
                }
            }

            new bootstrap.Modal(document.getElementById('editModal')).show();
        });
    });

    // Check all days functionality
    document.getElementById('checkAllDays').addEventListener('change', function() {
        const isChecked = this.checked;
        document.querySelectorAll('input[name="selected_days[]"]').forEach(checkbox => {
            checkbox.checked = isChecked;
        });
    });

    // Preview functionality
    document.querySelectorAll('.preview-media').forEach(button => {
        button.addEventListener('click', function() {
            const type = this.dataset.type;
            const src = this.dataset.src;
            const container = document.getElementById('previewContainer');

            container.innerHTML = '';

            if (type === 'images') {
                const img = document.createElement('img');
                img.src = src;
                img.className = 'img-fluid';
                img.style.maxHeight = '70vh';
                container.appendChild(img);
            } else if (type === 'video') {
                const video = document.createElement('video');
                video.src = src;
                video.controls = true;
                video.className = 'w-100';
                video.style.maxHeight = '70vh';
                container.appendChild(video);
            } else if (type === 'youtube') {
                const videoId = src.split('/').pop().split('?')[0];
                const iframe = document.createElement('iframe');
                iframe.src = `https://www.youtube.com/embed/${videoId}`;
                iframe.width = '100%';
                iframe.height = '400';
                iframe.frameBorder = '0';
                iframe.allowFullscreen = true;
                container.appendChild(iframe);
            }

            new bootstrap.Modal(document.getElementById('previewModal')).show();
        });
    });

    // Download functionality
    document.querySelectorAll('.download-media').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const src = this.dataset.src;
            document.getElementById('downloadSrc').value = src;
            document.getElementById('downloadForm').submit();
        });
    });

    // Delete functionality
    document.querySelectorAll('.delete-item').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.dataset.id;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `deletefile/${id}`;
                }
            });
        });
    });
});
</script>
@endpush