@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Edit Payment Gateway</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.payment-gateways.index')}}">Payment Gateways</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.payment-gateways.update', $paymentGateway->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Gateway Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $paymentGateway->name) }}" required>
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code">Gateway Code <span class="text-danger">*</span></label>
                                        <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $paymentGateway->code) }}" required>
                                        @error('code')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">Payment Type <span class="text-danger">*</span></label>
                                        <select name="type" id="type" class="form-control" required>
                                            <option value="card" {{ $paymentGateway->type == 'card' ? 'selected' : '' }}>Credit/Debit Card</option>
                                            <option value="bank" {{ $paymentGateway->type == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                                            <option value="mobile_money" {{ $paymentGateway->type == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                                            <option value="wallet" {{ $paymentGateway->type == 'wallet' ? 'selected' : '' }}>Digital Wallet</option>
                                            <option value="crypto" {{ $paymentGateway->type == 'crypto' ? 'selected' : '' }}>Cryptocurrency</option>
                                        </select>
                                        @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="logo">Logo</label>
                                        @if($paymentGateway->logo)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/'.$paymentGateway->logo) }}" alt="{{ $paymentGateway->name }}" style="width: 100px; height: 100px; object-fit: contain;">
                                        </div>
                                        @endif
                                        <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                                        @error('logo')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $paymentGateway->description) }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="api_key">API Key (leave blank to keep current)</label>
                                        <input type="text" name="api_key" id="api_key" class="form-control" placeholder="Enter new API key to update">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="api_secret">API Secret (leave blank to keep current)</label>
                                        <input type="password" name="api_secret" id="api_secret" class="form-control" placeholder="Enter new API secret to update">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="public_key">Public Key</label>
                                        <input type="text" name="public_key" id="public_key" class="form-control" value="{{ old('public_key', $paymentGateway->public_key) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="private_key">Private Key (leave blank to keep current)</label>
                                        <input type="password" name="private_key" id="private_key" class="form-control" placeholder="Enter new private key to update">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="merchant_id">Merchant ID</label>
                                        <input type="text" name="merchant_id" id="merchant_id" class="form-control" value="{{ old('merchant_id', $paymentGateway->merchant_id) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="webhook_url">Webhook URL</label>
                                        <input type="url" name="webhook_url" id="webhook_url" class="form-control" value="{{ old('webhook_url', $paymentGateway->webhook_url) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="callback_url">Callback URL</label>
                                        <input type="url" name="callback_url" id="callback_url" class="form-control" value="{{ old('callback_url', $paymentGateway->callback_url) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sort_order">Sort Order</label>
                                        <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $paymentGateway->sort_order) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fixed_charge">Fixed Charge</label>
                                        <input type="number" name="fixed_charge" id="fixed_charge" class="form-control" value="{{ old('fixed_charge', $paymentGateway->fixed_charge) }}" step="0.01" min="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="percentage_charge">Percentage Charge (%)</label>
                                        <input type="number" name="percentage_charge" id="percentage_charge" class="form-control" value="{{ old('percentage_charge', $paymentGateway->percentage_charge) }}" step="0.01" min="0" max="100">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Supported Currencies</label>
                                <select name="supported_currencies[]" id="supported_currencies" class="form-control" multiple>
                                    <option value="USD" {{ in_array('USD', old('supported_currencies', $paymentGateway->supported_currencies ?? [])) ? 'selected' : '' }}>USD - US Dollar</option>
                                    <option value="EUR" {{ in_array('EUR', old('supported_currencies', $paymentGateway->supported_currencies ?? [])) ? 'selected' : '' }}>EUR - Euro</option>
                                    <option value="GBP" {{ in_array('GBP', old('supported_currencies', $paymentGateway->supported_currencies ?? [])) ? 'selected' : '' }}>GBP - British Pound</option>
                                    <option value="KES" {{ in_array('KES', old('supported_currencies', $paymentGateway->supported_currencies ?? [])) ? 'selected' : '' }}>KES - Kenyan Shilling</option>
                                    <option value="NGN" {{ in_array('NGN', old('supported_currencies', $paymentGateway->supported_currencies ?? [])) ? 'selected' : '' }}>NGN - Nigerian Naira</option>
                                    <option value="ZAR" {{ in_array('ZAR', old('supported_currencies', $paymentGateway->supported_currencies ?? [])) ? 'selected' : '' }}>ZAR - South African Rand</option>
                                    <option value="GHS" {{ in_array('GHS', old('supported_currencies', $paymentGateway->supported_currencies ?? [])) ? 'selected' : '' }}>GHS - Ghanaian Cedi</option>
                                    <option value="INR" {{ in_array('INR', old('supported_currencies', $paymentGateway->supported_currencies ?? [])) ? 'selected' : '' }}>INR - Indian Rupee</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_active" {{ $paymentGateway->is_active ? 'checked' : '' }}> Active
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_test_mode" {{ $paymentGateway->is_test_mode ? 'checked' : '' }}> Test Mode
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update Gateway</button>
                                <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
