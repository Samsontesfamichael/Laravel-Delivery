@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Module Management</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Modules</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">System Modules</h4>
                        <p class="card-subtitle">Enable or disable modules to control which features are available in your application.</p>

                        <div id="modules-alert"></div>

                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Module Name</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                    </tr>
                                </thead>
                                <tbody id="modules-list">
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <div class="spinner-border" role="status">
                                                <span class="sr-only">Loading...</span>
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
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadModules();

    function loadModules() {
        fetch('{{ route("admin.modules.status") }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderModules(data.modules);
                }
            })
            .catch(error => {
                console.error('Error loading modules:', error);
                document.getElementById('modules-list').innerHTML = 
                    '<tr><td colspan="3" class="text-center text-danger">Error loading modules</td></tr>';
            });
    }

    function renderModules(modules) {
        const tbody = document.getElementById('modules-list');
        
        if (modules.length === 0) {
            tbody.innerHTML = '<tr><td colspan="3" class="text-center">No modules found</td></tr>';
            return;
        }

        tbody.innerHTML = modules.map(module => `
            <tr>
                <td>
                    <strong>${module.name}</strong>
                </td>
                <td>
                    <label class="switch">
                        <input type="checkbox" class="module-toggle" 
                            data-module="${module.name}" 
                            ${module.enabled ? 'checked' : ''}>
                        <span class="slider round"></span>
                    </label>
                    <span class="ml-2 ${module.enabled ? 'text-success' : 'text-secondary'}">
                        ${module.enabled ? 'Enabled' : 'Disabled'}
                    </span>
                </td>
                <td>
                    <small class="text-muted">Click toggle to change status</small>
                </td>
            </tr>
        `).join('');

        // Add event listeners to toggles
        document.querySelectorAll('.module-toggle').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const module = this.dataset.module;
                const status = this.checked;
                toggleModule(module, status);
            });
        });
    }

    function toggleModule(module, status) {
        const alertDiv = document.getElementById('modules-alert');
        alertDiv.innerHTML = '<div class="alert alert-info">Updating module status...</div>';

        fetch('{{ route("admin.modules.toggle") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                module: module,
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertDiv.innerHTML = `<div class="alert alert-success alert-dismissible fade show">
                    ${data.message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`;
                
                // Update the status text
                loadModules();
            } else {
                alertDiv.innerHTML = `<div class="alert alert-danger alert-dismissible fade show">
                    Error: ${data.message || 'Failed to update module'}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`;
                loadModules();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alertDiv.innerHTML = '<div class="alert alert-danger">An error occurred while updating the module.</div>';
            loadModules();
        });
    }
});
</script>

<style>
.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
}

input:checked + .slider {
    background-color: #2196F3;
}

input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
    transform: translateX(26px);
}

.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
</style>
@endpush
@endsection
