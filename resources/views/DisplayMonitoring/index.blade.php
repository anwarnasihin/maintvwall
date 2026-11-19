
@extends('layouts.master')

@section('content')

<style>
    .monitoring-header {
        background: linear-gradient(135deg, #008ED3, #001a33);
        color: white;
        padding: 22px;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .monitoring-stat {
        border-radius: 12px;
        padding: 18px;
        background: white;
        box-shadow: 0 3px 12px rgba(0,0,0,.08);
        border-left: 5px solid #008ED3;
        margin-bottom: 15px;
    }

    .monitoring-stat.online { border-left-color: #28a745; }
    .monitoring-stat.offline { border-left-color: #dc3545; }
    .monitoring-stat.disabled { border-left-color: #6c757d; }

    .monitoring-stat h3 {
        font-size: 30px;
        font-weight: 800;
        margin: 0;
    }

    .monitoring-stat p {
        margin: 5px 0 0;
        color: #777;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
    }

    .display-card {
        background: white;
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 18px;
        box-shadow: 0 3px 12px rgba(0,0,0,.08);
        border-top: 4px solid #008ED3;
        transition: .25s;
    }

    .display-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,.12);
    }

    .display-card.status-online { border-top-color: #28a745; }
    .display-card.status-offline { border-top-color: #dc3545; }
    .display-card.status-disabled { border-top-color: #6c757d; }

    .display-icon {
        font-size: 30px;
        color: #008ED3;
    }

    .display-detail {
        font-size: 13px;
        color: #666;
        margin-top: 10px;
        line-height: 1.8;
        overflow-wrap: anywhere;
    }

    .status-indicator {
        font-size: 11px;
        font-weight: 800;
        padding: 6px 12px;
        border-radius: 20px;
    }

    .status-online {
        background: #d4edda;
        color: #155724;
    }

    .status-offline {
        background: #f8d7da;
        color: #721c24;
    }

    .status-disabled {
        background: #e2e3e5;
        color: #383d41;
    }

    .monitoring-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 15px;
    }

    #monitoring-error {
        display: none;
    }

    .group-switcher {
    margin-top: 15px;
    padding-top: 12px;
    border-top: 1px solid #eee;
}

.group-switcher label {
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 6px;
}

.group-switcher select {
    font-size: 13px;
}

.active-group-label {
    font-size: 13px;
    margin-top: 10px;
}

.group-switcher button {
    margin-top: 8px;
}
</style>

<section class="content">
    <div class="container-fluid pt-3">

        <!-- HEADER -->
        <div class="monitoring-header">
            <div class="d-flex align-items-center">
                <i class="fas fa-desktop fa-3x mr-3"></i>
                <div>
                    <h4 class="font-weight-bold mb-1">
                        TV WALL DISPLAY MONITORING
                    </h4>
                    <div>
                        Monitoring kondisi perangkat TV Wall secara real-time
                    </div>
                </div>
            </div>
        </div>

        <!-- SUMMARY -->
        <div class="row">

            <div class="col-md-3 col-6">
                <div class="monitoring-stat">
                    <h3 id="total-display">0</h3>
                    <p>Total Display</p>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="monitoring-stat online">
                    <h3 id="online-display">0</h3>
                    <p>Online</p>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="monitoring-stat offline">
                    <h3 id="offline-display">0</h3>
                    <p>Offline</p>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="monitoring-stat disabled">
                    <h3 id="disabled-display">0</h3>
                    <p>Disabled</p>
                </div>
            </div>

        </div>

        <!-- TOOLBAR -->
        <div class="card">
            <div class="card-body">

                <div class="monitoring-toolbar">
                    <div>
                        <h5 class="font-weight-bold mb-1">
                            <i class="fas fa-network-wired mr-2"></i>
                            Daftar Perangkat
                        </h5>
                        <small class="text-muted">
                            Status diperbarui otomatis setiap 10 detik.
                        </small>
                    </div>

                    <div>
                        <button type="button"
                                class="btn btn-primary btn-sm"
                                id="refresh-monitoring">
                            <i class="fas fa-sync-alt mr-1"></i>
                            Refresh
                        </button>
                    </div>
                </div>

                <div id="monitoring-error"
                     class="alert alert-danger">
                    Gagal mengambil data monitoring.
                    <span id="monitoring-error-message"></span>
                </div>

                <div class="text-muted small mb-3">
                    Terakhir diperbarui:
                    <strong id="last-updated">Belum tersedia</strong>
                </div>

                <!-- DISPLAY CARDS -->
                <div class="row" id="display-list">

                    <div class="col-12 text-center text-muted py-4">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        Mengambil data perangkat...
                    </div>

                </div>

            </div>
        </div>

    </div>
</section>

@endsection

@section('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const statusUrl = @json(route('admin.displayMonitoring.status'));
    const changeGroupUrl = @json(url('/admin/display-monitoring'));
    const csrfToken = @json(csrf_token());
    const displayList = document.getElementById('display-list');
    const errorBox = document.getElementById('monitoring-error');
    const errorMessage = document.getElementById('monitoring-error-message');

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, function (char) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char];
        });
    }

    function formatDate(value) {
        if (!value) return 'Belum pernah';

        const date = new Date(value);

        if (isNaN(date.getTime())) return '-';

        return date.toLocaleString('id-ID', {
            timeZone: 'Asia/Jakarta',
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        }) + ' WIB';
    }

    function getStatusLabel(status) {
        const labels = {
            online: 'ONLINE',
            offline: 'OFFLINE',
            disabled: 'DISABLED'
        };

        return labels[status] || 'UNKNOWN';
    }

    function renderDisplays(displays, availableGroups) {

        if (!displays.length) {
            displayList.innerHTML = `
                <div class="col-12 text-center text-muted py-4">
                    <i class="fas fa-info-circle mr-2"></i>
                    Belum ada perangkat Display terdaftar.
                </div>
            `;
            return;
        }

        displayList.innerHTML = displays.map(function (display) {

            const status = ['online', 'offline', 'disabled']
                .includes(display.status) ? display.status : 'offline';

            const assignedGroups = Array.isArray(display.groups)
                ? display.groups
                : [];

            const groups = assignedGroups.length
                ? assignedGroups.map(group => escapeHtml(group.name)).join(', ')
                : 'Belum ditentukan';

            const activeGroup = display.active_group || null;

            const activeGroupName = activeGroup
                ? escapeHtml(activeGroup.name)
                : 'Belum dipilih';

            const groupOptions = availableGroups.map(group => `
                <option
                    value="${Number(group.id)}"
                    ${activeGroup && Number(activeGroup.id) === Number(group.id) ? 'selected' : ''}
                >
                    ${escapeHtml(group.name)}
                </option>
            `).join('');

            return `
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="display-card status-${status}">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>
                                <i class="fas fa-desktop display-icon"></i>

                                <h5 class="font-weight-bold mt-2 mb-1">
                                    ${escapeHtml(display.display_name)}
                                </h5>

                                <small class="text-muted">
                                    ${escapeHtml(display.display_code)}
                                </small>
                            </div>

                            <span class="status-indicator status-${status}">
                                ${getStatusLabel(status)}
                            </span>

                        </div>

                        <div class="display-detail">

                            <div>
                                <i class="fas fa-server mr-2"></i>
                                Hostname:
                                ${escapeHtml(display.hostname || '-')}
                            </div>

                            <div>
                                <i class="fas fa-network-wired mr-2"></i>
                                IP Address:
                                ${escapeHtml(display.ip_address || '-')}
                            </div>

                            <div>
                                <i class="fas fa-layer-group mr-2"></i>
                                Group:
                                ${groups}
                            </div>

                            <div class="active-group-label">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                Group Aktif:
                                <strong>${activeGroupName}</strong>
                            </div>


                            ${availableGroups.length > 0 ? `
                                <div class="group-switcher">
                                    <label for="group-select-${Number(display.id)}">
                                        PILIH GROUP BARU
                                    </label>

                                    <select
                                        class="form-control group-select"
                                        id="group-select-${Number(display.id)}"
                                        data-display-id="${Number(display.id)}"
                                                                        >
                                        <option value="" disabled ${activeGroup ? '' : 'selected'}>
                                            -- Pilih Group --
                                        </option>
                                        ${groupOptions}
                                    </select>

                                    <button
                                        type="button"
                                        class="btn btn-primary btn-sm btn-block change-group-btn"
                                        data-display-id="${Number(display.id)}"
                                    >
                                        <i class="fas fa-exchange-alt mr-1"></i>
                                        Ganti Group
                                    </button>
                                </div>
                            ` : `
                                <div class="alert alert-warning mt-3 mb-0">
                                    Belum ada Group yang tersedia.
                                </div>
                            `}

                            <div>
                                <i class="fas fa-heartbeat mr-2"></i>
                                Last Heartbeat:
                                ${formatDate(display.last_seen_at)}
                            </div>

                            <div>
                                <i class="fas fa-sync-alt mr-2"></i>
                                Last Sync:
                                ${formatDate(display.last_sync_at)}
                            </div>

                            <div>
                                <i class="fas fa-code-branch mr-2"></i>
                                Agent:
                                ${escapeHtml(display.agent_version || '-')}
                            </div>

                        </div>

                    </div>
                </div>
            `;

        }).join('');
    }


    async function changeActiveGroup(displayId) {

        const select = document.getElementById(`group-select-${displayId}`);
        const button = document.querySelector(
            `.change-group-btn[data-display-id="${displayId}"]`
        );

        if (!select || !button) return;

        const groupId = Number(select.value);

        if (!groupId) {
            alert('Silakan pilih Group terlebih dahulu.');
            return;
        }

        const originalText = button.innerHTML;

        button.disabled = true;
        button.innerHTML = 'Menyimpan...';

        try {
            const response = await fetch(
                `${changeGroupUrl}/${displayId}/active-group`,
                {
                    method: 'PATCH',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        group_id: groupId
                    })
                }
            );

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(
                    result.message || 'Gagal mengubah Group.'
                );
            }

            alert(result.message || 'Group aktif berhasil diperbarui.');

            await loadMonitoring();

        } catch (error) {
            alert(error.message);

        } finally {
            button.disabled = false;
            button.innerHTML = originalText;
        }
    }


    async function loadMonitoring() {

        const refreshButton = document.getElementById('refresh-monitoring');

        refreshButton.disabled = true;

        try {

            const response = await fetch(statusUrl, {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }

            const result = await response.json();

            if (!result.success) {
                throw new Error('Respons server tidak valid.');
            }

            document.getElementById('total-display').textContent =
                result.summary.total;

            document.getElementById('online-display').textContent =
                result.summary.online;

            document.getElementById('offline-display').textContent =
                result.summary.offline;

            document.getElementById('disabled-display').textContent =
                result.summary.disabled;

            renderDisplays(
    		result.displays || [],
    		result.available_groups || []
		);

            document.getElementById('last-updated').textContent =
                formatDate(result.server_time);

            errorBox.style.display = 'none';

        } catch (error) {

            errorBox.style.display = 'block';
            errorMessage.textContent = error.message;

        } finally {

            refreshButton.disabled = false;

        }
    }

        document.getElementById('refresh-monitoring')
            .addEventListener('click', loadMonitoring);

        displayList.addEventListener('click', function (event) {

            const button = event.target.closest('.change-group-btn');

            if (!button) return;

            const displayId = Number(button.dataset.displayId);

            if (!displayId) return;

            changeActiveGroup(displayId);
        });

        loadMonitoring();

        setInterval(loadMonitoring, 10000);

});
</script>

@endsection
