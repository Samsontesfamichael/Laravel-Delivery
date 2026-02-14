@extends('layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{ __('lang.payment_gateways') }}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{ __('lang.dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('lang.payment_gateways') }}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex top-title-section pb-4 justify-content-between">
                    <div class="d-flex top-title-left align-self-center">
                        <span class="icon mr-3"><img src="{{ asset('images/payment.png') }}"></span>
                        <h3 class="mb-0">{{ __('lang.payment_gateways') }}</h3>
                        <span class="counter ml-3 badge badge-primary">{{ $gateways->count() }}</span>
                    </div>
                    <div class="d-flex top-title-right align-self-center">
                        <a href="{{ route('admin.payment-gateways.create') }}" class="btn btn-primary btn-rounded">
                            <i class="fa fa-plus mr-1"></i> {{ __('lang.add') }}
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
                            <table id="payment-gateways-table" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('lang.id') }}</th>
                                        <th>{{ __('lang.logo') }}</th>
                                        <th>{{ __('lang.name') }}</th>
                                        <th>{{ __('lang.type') }}</th>
                                        <th>{{ __('lang.status') }}</th>
                                        <th>{{ __('lang.test_mode') }}</th>
                                        <th>{{ __('lang.sort_order') }}</th>
                                        <th>{{ __('lang.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($gateways as $gateway)
                                    <tr class="animate__animated animate__fadeIn">
                                        <td>{{ $gateway->id }}</td>
                                        <td>
                                            @if($gateway->logo)
                                            <img src="{{ asset('storage/'.$gateway->logo) }}" alt="{{ $gateway->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fa fa-credit-card text-muted"></i>
                                            </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $gateway->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $gateway->code }}</small>
                                        </td>
                                        <td>
                                            @switch($gateway->type)
                                                @case('card')
                                                    <span class="badge badge-info">{{ __('lang.card') }}</span>
                                                    @break
                                                @case('bank')
                                                    <span class="badge badge-primary">{{ __('lang.bank') }}</span>
                                                    @break
                                                @case('mobile_money')
                                                    <span class="badge badge-warning">{{ __('lang.mobile_money') }}</span>
                                                    @break
                                                @case('wallet')
                                                    <span class="badge badge-success">{{ __('lang.wallet') }}</span>
                                                    @break
                                                @case('crypto')
                                                    <span class="badge badge-secondary">{{ __('lang.crypto') }}</span>
                                                    @break
                                                @default
                                                    <span class="badge badge-light">{{ ucfirst($gateway->type) }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" class="toggle-status" data-id="{{ $gateway->id }}" {{ $gateway->is_active ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>
                                            @if($gateway->is_test_mode)
                                            <span class="badge badge-warning">{{ __('lang.test_mode') }}</span>
                                            @else
                                            <span class="badge badge-success">{{ __('lang.live') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $gateway->sort_order }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.payment-gateways.show', $gateway->id) }}" class="btn btn-info btn-sm" title="{{ __('lang.view') }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.payment-gateways.edit', $gateway->id) }}" class="btn btn-primary btn-sm" title="{{ __('lang.edit') }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm delete-gateway" data-id="{{ $gateway->id }}" title="{{ __('lang.delete') }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fa fa-credit-card fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">{{ __('lang.no_payment_gateways') }}</p>
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
                    {{ $gateways->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('payment-gateways.partials.scripts')
@endsection
