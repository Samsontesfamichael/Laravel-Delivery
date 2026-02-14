@extends('layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{ __('lang.delivery_zones') }}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{ __('lang.dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('lang.delivery_zones') }}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex top-title-section pb-4 justify-content-between">
                    <div class="d-flex top-title-left align-self-center">
                        <span class="icon mr-3"><img src="{{ asset('images/zone.png') }}"></span>
                        <h3 class="mb-0">{{ __('lang.delivery_zones') }}</h3>
                        <span class="counter ml-3 badge badge-primary">{{ $zones->count() }}</span>
                    </div>
                    <div class="d-flex top-title-right align-self-center">
                        <a href="{{ route('admin.delivery-zones.statistics') }}" class="btn btn-info btn-rounded mr-2">
                            <i class="fa fa-chart-bar mr-1"></i> {{ __('lang.statistics') }}
                        </a>
                        <a href="{{ route('admin.delivery-zones.create') }}" class="btn btn-primary btn-rounded">
                            <i class="fa fa-plus mr-1"></i> {{ __('lang.add_zone') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="card border">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="delivery-zones-table" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('lang.id') }}</th>
                                        <th>{{ __('lang.name') }}</th>
                                        <th>{{ __('lang.type') }}</th>
                                        <th>{{ __('lang.base_fee') }}</th>
                                        <th>{{ __('lang.per_km') }}</th>
                                        <th>{{ __('lang.min_order') }}</th>
                                        <th>{{ __('lang.default') }}</th>
                                        <th>{{ __('lang.status') }}</th>
                                        <th>{{ __('lang.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($zones as $zone)
                                    <tr class="animate__animated animate__fadeIn">
                                        <td>{{ $zone->id }}</td>
                                        <td>
                                            <strong>{{ $zone->name }}</strong>
                                            @if($zone->is_default)
                                            <span class="badge badge-primary ml-1">{{ __('lang.default') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($zone->delivery_type == 'radius')
                                            <span class="badge badge-info">{{ __('lang.radius') }}</span>
                                            @elseif($zone->delivery_type == 'polygon')
                                            <span class="badge badge-warning">{{ __('lang.polygon') }}</span>
                                            @elseif($zone->delivery_type == 'postal_code')
                                            <span class="badge badge-success">{{ __('lang.postal_code') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $zone->base_delivery_fee }}</td>
                                        <td>{{ $zone->per_km_fee ?? 0 }}</td>
                                        <td>{{ $zone->minimum_order_amount ?? 0 }}</td>
                                        <td>
                                            @if($zone->is_default)
                                            <span class="badge badge-primary">{{ __('lang.yes') }}</span>
                                            @else
                                            <a href="{{ route('admin.delivery-zones.set-default', $zone->id) }}" class="btn btn-sm btn-outline-primary">{{ __('lang.set_default') }}</a>
                                            @endif
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" class="toggle-status" data-id="{{ $zone->id }}" {{ $zone->is_active ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.delivery-zones.show', $zone->id) }}" class="btn btn-info btn-sm" title="{{ __('lang.view') }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.delivery-zones.edit', $zone->id) }}" class="btn btn-primary btn-sm" title="{{ __('lang.edit') }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-secondary btn-sm clone-zone" data-id="{{ $zone->id }}" title="{{ __('lang.clone') }}">
                                                    <i class="fa fa-copy"></i>
                                                </button>
                                                @if(!$zone->is_default)
                                                <button type="button" class="btn btn-danger btn-sm delete-zone" data-id="{{ $zone->id }}" title="{{ __('lang.delete') }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fa fa-map-marker-alt fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">{{ __('lang.no_delivery_zones') }}</p>
                                            </div>
                                        </td>
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
