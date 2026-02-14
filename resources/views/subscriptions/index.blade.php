@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Subscriptions</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Subscriptions</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="card-title">All Subscriptions</h4>
                            <div>
                                <a href="{{ route('admin.subscriptions.statistics') }}" class="btn btn-info">
                                    <i class="fa fa-chart-bar"></i> Statistics
                                </a>
                                <a href="{{ route('admin.subscriptions.export') }}" class="btn btn-success">
                                    <i class="fa fa-download"></i> Export
                                </a>
                                <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Add New
                                </a>
                            </div>
                        </div>

                        <form method="GET" action="{{ route('admin.subscriptions.index') }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="text" name="search" class="form-control" placeholder="Search user..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <select name="status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="paused" {{ request('status') == 'paused' ? 'selected' : '' }}>Paused</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="plan_type" class="form-control">
                                        <option value="">All Plans</option>
                                        <option value="daily" {{ request('plan_type') == 'daily' ? 'selected' : '' }}>Daily</option>
                                        <option value="weekly" {{ request('plan_type') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                        <option value="monthly" {{ request('plan_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                        <option value="yearly" {{ request('plan_type') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                        <option value="lifetime" {{ request('plan_type') == 'lifetime' ? 'selected' : '' }}>Lifetime</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" placeholder="Start Date">
                                </div>
                                <div class="col-md-2">
                                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" placeholder="End Date">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </form>

                        @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show">
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
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Plan</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subscriptions as $subscription)
                                    <tr>
                                        <td>{{ $subscription->id }}</td>
                                        <td>
                                            @if($subscription->user)
                                            <strong>{{ $subscription->user->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $subscription->user->email }}</small>
                                            @else
                                            <span class="text-danger">User not found</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $subscription->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ ucfirst($subscription->plan_type) }}</small>
                                        </td>
                                        <td>{{ $subscription->price }} {{ $subscription->currency }}</td>
                                        <td>
                                            @if($subscription->status == 'active')
                                            <span class="badge badge-success">Active</span>
                                            @elseif($subscription->status == 'expired')
                                            <span class="badge badge-danger">Expired</span>
                                            @elseif($subscription->status == 'cancelled')
                                            <span class="badge badge-warning">Cancelled</span>
                                            @elseif($subscription->status == 'paused')
                                            <span class="badge badge-info">Paused</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($subscription->payment_status == 'completed')
                                            <span class="badge badge-success">Paid</span>
                                            @elseif($subscription->payment_status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                            @elseif($subscription->payment_status == 'failed')
                                            <span class="badge badge-danger">Failed</span>
                                            @else
                                            <span class="badge badge-secondary">{{ $subscription->payment_status ?? 'N/A' }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $subscription->start_date->format('Y-m-d') }}</td>
                                        <td>{{ $subscription->end_date->format('Y-m-d') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.subscriptions.show', $subscription->id) }}" class="btn btn-info btn-sm" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.subscriptions.edit', $subscription->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @if($subscription->status == 'active')
                                                <button type="button" class="btn btn-warning btn-sm pause-subscription" data-id="{{ $subscription->id }}" title="Pause">
                                                    <i class="fa fa-pause"></i>
                                                </button>
                                                @elseif($subscription->status == 'paused')
                                                <button type="button" class="btn btn-success btn-sm resume-subscription" data-id="{{ $subscription->id }}" title="Resume">
                                                    <i class="fa fa-play"></i>
                                                </button>
                                                @endif
                                                <button type="button" class="btn btn-danger btn-sm delete-subscription" data-id="{{ $subscription->id }}" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No subscriptions found.</td>
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
