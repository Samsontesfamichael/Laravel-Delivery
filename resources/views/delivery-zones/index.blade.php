@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Delivery Zones</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Delivery Zones</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="card-title">All Delivery Zones</h4>
                            <div>
                                <a href="{{ route('admin.delivery-zones.statistics') }}" class="btn btn-info">
                                    <i class="fa fa-chart-bar"></i> Statistics
                                </a>
                                <a href="{{ route('admin.delivery-zones.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Add New Zone
                                </a>
                            </div>
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
                            <table id="delivery-zones-table" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Base Fee</th>
                                        <th>Per Km</th>
                                        <th>Min Order</th>
                                        <th>Default</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($zones as $zone)
                                    <tr>
                                        <td>{{ $zone->id }}</td>
                                        <td>
                                            <strong>{{ $zone->name }}</strong>
                                            @if($zone->is_default)
                                            <span class="badge badge-primary">Default</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($zone->delivery_type == 'radius')
                                            <span class="badge badge-info">Radius</span>
                                            @elseif($zone->delivery_type == 'polygon')
                                            <span class="badge badge-warning">Polygon</span>
                                            @elseif($zone->delivery_type == 'postal_code')
                                            <span class="badge badge-success">Postal Code</span>
                                            @endif
                                        </td>
                                        <td>{{ $zone->base_delivery_fee }}</td>
                                        <td>{{ $zone->per_km_fee ?? 0 }}</td>
                                        <td>{{ $zone->minimum_order_amount ?? 0 }}</td>
                                        <td>
                                            @if($zone->is_default)
                                            <span class="badge badge-primary">Yes</span>
                                            @else
                                            <a href="{{ route('admin.delivery-zones.set-default', $zone->id) }}" class="btn btn-sm btn-outline-primary">Set Default</a>
                                            @endif
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" class="toggle-status" data-id="{{ $zone->id }}" {{ $zone->is_active ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.delivery-zones.show', $zone->id) }}" class="btn btn-info btn-sm" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.delivery-zones.edit', $zone->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-secondary btn-sm clone-zone" data-id="{{ $zone->id }}" title="Clone">
                                                    <i class="fa fa-copy"></i>
                                                </button>
                                                @if(!$zone->is_default)
                                                <button type="button" class="btn btn-danger btn-sm delete-zone" data-id="{{ $zone->id }}" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No delivery zones found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    {{ $zones->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('delivery-zones.partials.scripts')
@endsection
