@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Payment Gateways</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Payment Gateways</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="card-title">All Payment Gateways</h4>
                            <a href="{{ route('admin.payment-gateways.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Add New Gateway
                            </a>
                        </div>

                        @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session()->get('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <div class="table-responsive">
                            <table id="payment-gateways-table" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Logo</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Test Mode</th>
                                        <th>Sort Order</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($gateways as $gateway)
                                    <tr>
                                        <td>{{ $gateway->id }}</td>
                                        <td>
                                            @if($gateway->logo)
                                            <img src="{{ asset('storage/'.$gateway->logo) }}" alt="{{ $gateway->name }}" style="width: 50px; height: 50px; object-fit: contain;">
                                            @else
                                            <span class="badge badge-secondary">No Logo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $gateway->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $gateway->code }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ ucfirst($gateway->type) }}</span>
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" class="toggle-status" data-id="{{ $gateway->id }}" {{ $gateway->is_active ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>
                                            @if($gateway->is_test_mode)
                                            <span class="badge badge-warning">Test Mode</span>
                                            @else
                                            <span class="badge badge-success">Live</span>
                                            @endif
                                        </td>
                                        <td>{{ $gateway->sort_order }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.payment-gateways.show', $gateway->id) }}" class="btn btn-info btn-sm" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.payment-gateways.edit', $gateway->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm delete-gateway" data-id="{{ $gateway->id }}" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No payment gateways found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    {{ $gateways->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('payment-gateways.partials.scripts')
@endsection
