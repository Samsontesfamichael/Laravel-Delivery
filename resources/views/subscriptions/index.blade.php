@extends('layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{ __('lang.subscriptions') }}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{ __('lang.dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('lang.subscriptions') }}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex top-title-section pb-4 justify-content-between">
                    <div class="d-flex top-title-left align-self-center">
                        <span class="icon mr-3"><img src="{{ asset('images/subscription.png') }}"></span>
                        <h3 class="mb-0">{{ __('lang.subscriptions') }}</h3>
                        <span class="counter ml-3 badge badge-primary">{{ $subscriptions->count() }}</span>
                    </div>
                    <div class="d-flex top-title-right align-self-center">
                        <a href="{{ route('admin.subscriptions.statistics') }}" class="btn btn-info btn-rounded mr-2">
                            <i class="fa fa-chart-bar mr-1"></i> {{ __('lang.statistics') }}
                        </a>
                        <a href="{{ route('admin.subscriptions.export') }}" class="btn btn-success btn-rounded mr-2">
                            <i class="fa fa-download mr-1"></i> {{ __('lang.export') }}
                        </a>
                        <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary btn-rounded">
                            <i class="fa fa-plus mr-1"></i> {{ __('lang.add') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.subscriptions.index') }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="text" name="search" class="form-control" placeholder="{{ __('lang.search') }}" value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <select name="status" class="form-control">
                                        <option value="">{{ __('lang.all_status') }}</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('lang.active') }}</option>
                                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>{{ __('lang.expired') }}</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('lang.cancelled') }}</option>
                                        <option value="paused" {{ request('status') == 'paused' ? 'selected' : '' }}>{{ __('lang.paused') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="plan_type" class="form-control">
                                        <option value="">{{ __('lang.all_plans') }}</option>
                                        <option value="daily" {{ request('plan_type') == 'daily' ? 'selected' : '' }}>{{ __('lang.daily') }}</option>
                                        <option value="weekly" {{ request('plan_type') == 'weekly' ? 'selected' : '' }}>{{ __('lang.weekly') }}</option>
                                        <option value="monthly" {{ request('plan_type') == 'monthly' ? 'selected' : '' }}>{{ __('lang.monthly') }}</option>
                                        <option value="yearly" {{ request('plan_type') == 'yearly' ? 'selected' : '' }}>{{ __('lang.yearly') }}</option>
                                        <option value="lifetime" {{ request('plan_type') == 'lifetime' ? 'selected' : '' }}>{{ __('lang.lifetime') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">{{ __('lang.filter') }}</button>
                                    <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">{{ __('lang.reset') }}</a>
                                </div>
                            </div>
                        </form>

                        @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <div class="table-responsive">
                            <table id="subscriptions-table" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('lang.id') }}</th>
                                        <th>{{ __('lang.user') }}</th>
                                        <th>{{ __('lang.plan') }}</th>
                                        <th>{{ __('lang.price') }}</th>
                                        <th>{{ __('lang.status') }}</th>
                                        <th>{{ __('lang.payment') }}</th>
                                        <th>{{ __('lang.start_date') }}</th>
                                        <th>{{ __('lang.end_date') }}</th>
                                        <th>{{ __('lang.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subscriptions as $subscription)
                                    <tr class="animate__animated animate__fadeIn">
                                        <td>{{ $subscription->id }}</td>
                                        <td>
                                            @if($subscription->user)
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mr-2" style="width: 35px; height: 35px;">
                                                    {{ substr($subscription->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $subscription->user->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $subscription->user->email }}</small>
                                                </div>
                                            </div>
                                            @else
                                            <span class="text-danger">{{ __('lang.user_not_found') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $subscription->name }}</strong>
                                            <br>
                                            <small class="badge badge-info">{{ ucfirst($subscription->plan_type) }}</small>
                                        </td>
                                        <td><strong>{{ $subscription->price }}</strong> {{ $subscription->currency }}</td>
                                        <td>
                                            @if($subscription->status == 'active')
                                            <span class="badge badge-success">{{ __('lang.active') }}</span>
                                            @elseif($subscription->status == 'expired')
                                            <span class="badge badge-danger">{{ __('lang.expired') }}</span>
                                            @elseif($subscription->status == 'cancelled')
                                            <span class="badge badge-warning">{{ __('lang.cancelled') }}</span>
                                            @elseif($subscription->status == 'paused')
                                            <span class="badge badge-info">{{ __('lang.paused') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($subscription->payment_status == 'completed')
                                            <span class="badge badge-success">{{ __('lang.paid') }}</span>
                                            @elseif($subscription->payment_status == 'pending')
                                            <span class="badge badge-warning">{{ __('lang.pending') }}</span>
                                            @elseif($subscription->payment_status == 'failed')
                                            <span class="badge badge-danger">{{ __('lang.failed') }}</span>
                                            @else
                                            <span class="badge badge-secondary">{{ $subscription->payment_status ?? 'N/A' }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $subscription->start_date->format('Y-m-d') }}</td>
                                        <td>{{ $subscription->end_date->format('Y-m-d') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.subscriptions.show', $subscription->id) }}" class="btn btn-info btn-sm" title="{{ __('lang.view') }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.subscriptions.edit', $subscription->id) }}" class="btn btn-primary btn-sm" title="{{ __('lang.edit') }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @if($subscription->status == 'active')
                                                <button type="button" class="btn btn-warning btn-sm pause-subscription" data-id="{{ $subscription->id }}" title="{{ __('lang.pause') }}">
                                                    <i class="fa fa-pause"></i>
                                                </button>
                                                @elseif($subscription->status == 'paused')
                                                <button type="button" class="btn btn-success btn-sm resume-subscription" data-id="{{ $subscription->id }}" title="{{ __('lang.resume') }}">
                                                    <i class="fa fa-play"></i>
                                                </button>
                                                @endif
                                                <button type="button" class="btn btn-danger btn-sm delete-subscription" data-id="{{ $subscription->id }}" title="{{ __('lang.delete') }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fa fa-credit-card fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">{{ __('lang.no_subscriptions') }}</p>
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
                    {{ $subscriptions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('subscriptions.partials.scripts')
@endsection
