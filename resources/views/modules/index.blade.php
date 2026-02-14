@extends('layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{ __('lang.module_management') }}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{ __('lang.dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('lang.modules') }}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex top-title-section pb-4 justify-content-between">
                    <div class="d-flex top-title-left align-self-center">
                        <span class="icon mr-3"><img src="{{ asset('images/module.png') }}"></span>
                        <h3 class="mb-0">{{ __('lang.module_management') }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('lang.system_modules') }}</h4>
                        <p class="card-subtitle mb-4">{{ __('lang.module_description') }}</p>

                        <div id="modules-alert"></div>

                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('lang.module_name') }}</th>
                                        <th>{{ __('lang.status') }}</th>
                                        <th>{{ __('lang.description') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="modules-list">
                                    <tr>
                                        <td colspan="3" class="text-center py-4">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="sr-only">{{ __('lang.loading') }}...</span>
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
                console.error('Error loading modules document.getElementBy:', error);
               Id('modules-list').innerHTML = 
                    '<tr><td colspan="3" class="text-center text-danger">{{ __("lang.error_loading") }}</td></tr>';
            });
    }

    function renderModules(modules) {
        const tbody = document.getElementById('modules-list');
        
        if (modules.length === 0) {
            tbody.innerHTML = '<tr><td colspan="3" class="text-center">{{ __("lang.no_modules") }}</td></tr>';
            return;
        }

        tbody.innerHTML = modules.map((module, index) => `
            <tr class="animate__animated animate__fadeIn" style="animation-delay: ${index * 0.1}s">
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
                    <span class="ml-2 ${module.enabled ? 'text-success' : 'text-secondary'} font-weight-bold">
                        ${module.enabled ? '{{ __("lang.enabled") }}' : '{{ __("lang.disabled") }}'}
                    </span>
                </td>
                <td>
                    <small class="text-muted">{{ __('lang.click_toggle') }}</small>
                </td>
            </tr>
        `).join('');

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
        alertDiv.innerHTML = '<div class="alert alert-info">{{ __("lang.updating") }}...</div>';

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
                alertDiv.innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                    ${data.message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`;
                loadModules();
            } else {
                alertDiv.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ${data.message || '{{ __("lang.error_update") }}'}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`;
                loadModules();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alertDiv.innerHTML = '<div class="alert alert-danger">{{ __("lang.error_occurred") }}</div>';
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
.switch input { opacity: 0; width: 0; height: 0; }
.slider {
    position: absolute;
    cursor: pointer;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 24px;
}
.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}
input:checked + .slider { background-color: #2196F3; }
input:focus + .slider { box-shadow: 0 0 1px #2196F3; }
input:checked + .slider:before { transform: translateX(26px); }
</style>
@endpush
@endsection
