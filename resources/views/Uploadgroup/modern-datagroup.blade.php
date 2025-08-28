@extends('layouts.modern-master')

@section('title', 'Groups Management - TV Wall Admin')
@section('page-title', 'Groups Management')

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
                                <i class="bi bi-collection me-2"></i>
                                Groups Management
                            </h3>
                            <p class="text-muted mb-0 mt-1">Manage your content groups and displays</p>
                        </div>
                        <a href="{{ route('creategroup') }}" class="btn-modern">
                            <i class="bi bi-plus-circle"></i>
                            Add New Group
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Groups Grid -->
    <div class="row">
        @forelse($dtGroup as $item)
        <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            <div class="modern-card h-100">
                <div class="card-body">
                    <!-- Group Header -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="group-icon me-3">
                            <i class="bi bi-collection-fill"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1 fw-bold">{{ $item->name }}</h5>
                            <small class="text-muted">Group ID: #{{ $item->id }}</small>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/show/{{ $item->name}}" target="_blank">
                                    <i class="bi bi-display me-2"></i>Display
                                </a></li>
                                <li><a class="dropdown-item" href="{{ url('editgroup',$item->id) }}">
                                    <i class="bi bi-pencil me-2"></i>Edit
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger delete-item" href="#" data-id="{{ $item->id }}">
                                    <i class="bi bi-trash me-2"></i>Delete
                                </a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Group Description -->
                    <div class="mb-3">
                        <p class="text-muted mb-2">{{ $item->keterangan ?: 'No description available' }}</p>
                    </div>

                    <!-- Group Stats -->
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="stat-mini">
                                <div class="stat-mini-icon bg-primary">
                                    <i class="bi bi-file-earmark-play"></i>
                                </div>
                                <div class="stat-mini-info">
                                    <div class="stat-mini-value">{{ $item->sources_count ?? 0 }}</div>
                                    <div class="stat-mini-label">Media Files</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-mini">
                                <div class="stat-mini-icon bg-success">
                                    <i class="bi bi-eye"></i>
                                </div>
                                <div class="stat-mini-info">
                                    <div class="stat-mini-value">Active</div>
                                    <div class="stat-mini-label">Status</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2">
                        <a href="/show/{{ $item->name}}" target="_blank" class="btn btn-primary btn-sm flex-grow-1">
                            <i class="bi bi-display me-1"></i>
                            Display
                        </a>
                        <a href="{{ url('editgroup',$item->id) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-outline-danger btn-sm delete-item" data-id="{{ $item->id }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="modern-card text-center py-5" data-aos="fade-up">
                <div class="card-body">
                    <div class="empty-state">
                        <i class="bi bi-collection display-1 text-muted mb-3"></i>
                        <h4 class="text-muted">No Groups Found</h4>
                        <p class="text-muted mb-4">Start by creating your first content group</p>
                        <a href="{{ route('creategroup') }}" class="btn-modern">
                            <i class="bi bi-plus-circle"></i>
                            Create First Group
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($dtGroup->hasPages())
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $dtGroup->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="bi bi-exclamation-triangle display-1 text-warning mb-3"></i>
                    <h4>Are you sure?</h4>
                    <p class="text-muted">This action cannot be undone. All media files in this group will also be affected.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete Group</button>
            </div>
        </div>
    </div>
</div>

<style>
.group-icon {
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

.stat-mini {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem;
    background: rgba(0, 0, 0, 0.02);
    border-radius: 8px;
}

.stat-mini-icon {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
}

.stat-mini-info {
    flex-grow: 1;
}

.stat-mini-value {
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--dark-color);
}

.stat-mini-label {
    font-size: 0.75rem;
    color: #6b7280;
}

.empty-state i {
    opacity: 0.3;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 8px;
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
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let deleteId = null;
    
    // Handle delete button clicks
    document.querySelectorAll('.delete-item').forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            deleteId = this.dataset.id;
            
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
                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('deletegroup') }}/${deleteId}`;
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    
                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush