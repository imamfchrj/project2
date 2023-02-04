@extends('layouts.dashboard')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>@lang('users.user_management')</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ url('admin/profile') }}">Edit Profile</a></div>
                <div class="breadcrumb-item active"><a
                            href="{{ url('admin/roles/create') }}">@lang('users.user_add_new')</a></div>
            </div>
        </div>
        <form method="POST" action="{{ route('users.profile_update', $user->id) }}">
            <input type="hidden" name="id" value="{{ $user->id }}"/>
            @method('PUT')
            @csrf
            <div class="section-body">
                <h2 class="section-title">Update Profile</h2>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Update Profile</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.shared.flash')
                                <div class="form-group">
                                    <label>@lang('users.name_label')</label>
                                    <input type="text" name="name"
                                           class="form-control @error('name') is-invalid @enderror @if (!$errors->has('name') && old('name')) is-valid @endif"
                                           value="{{ old('name', !empty($user) ? $user->name : null) }}">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>@lang('users.nik_label')</label>
                                    <input type="number" name="nik"
                                           class="form-control @error('nik') is-invalid @enderror @if (!$errors->has('nik') && old('nik')) is-valid @endif"
                                           value="{{ old('nik', !empty($user) ? $user->nik : null) }}" readonly>
                                    @error('nik')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>@lang('users.nik_gsd_label')</label>
                                    <input type="number" name="nik_gsd"
                                           class="form-control @error('nik_gsd') is-invalid @enderror @if (!$errors->has('nik_gsd') && old('nik_gsd')) is-valid @endif"
                                           value="{{ old('nik_gsd', !empty($user) ? $user->nik_gsd : null) }}" readonly>
                                    @error('nik_gsd')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>@lang('users.email_label')</label>
                                    <input type="text" name="email"
                                           class="form-control @error('email') is-invalid @enderror @if (!$errors->has('email') && old('email')) is-valid @endif"
                                           value="{{ old('email', !empty($user) ? $user->email : null) }}" readonly>
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>@lang('users.password_label')</label>
                                    <input type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror @if (!$errors->has('password') && old('password')) is-valid @endif">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>@lang('users.password_confirmation_label')</label>
                                    <input type="password" name="password_confirmation"
                                           class="form-control @error('password_confirmation') is-invalid @enderror @if (!$errors->has('password_confirmation') &&
                                old('password_confirmation')) is-valid @endif">
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button
                                        class="btn btn-primary">Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
