@extends('layouts.dashboard')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Manage Jenis</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a
                    href="{{ url('admin/master/jenis') }}">Manage Jenis</a></div>
        </div>
    </div>
    @if(isset($jenis))
    {!! Form::model($jenis, ['url' => ['admin/master/jenis', $jenis->id], 'method' => 'PUT', 'files' => true ]) !!}
    {!! Form::hidden('id') !!}
    @else
    {!! Form::open(['url' => 'admin/master/jenis', 'files'=>true]) !!}
    @endif
    @csrf
    <div class="section-body">
        <h2 class="section-title">
            {{ empty($jenis) ? 'Create Jenis' : 'Update Jenis' }}
        </h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ empty($jenis) ? 'Add New Jenis' : 'Update Jenis' }}
                        </h4>
                    </div>
                    <div class="card-body">
                        @include('master::admin.shared.flash')
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Jenis</label>
                            <div class="col-sm-5">
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror @if (!$errors->has('name') && old('name')) is-valid @endif"
                                    value="{{ old('name', !empty($jenis) ? $jenis->name : '') }}">
                                <input type="hidden" name="id"
                                    value="{{ old('id', !empty($jenis) ? $jenis->id : '') }}">
                            </div>
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer text-left">
                        <button
                                class="btn btn-primary">{{ empty($jenis) ? 'Create' : 'Update' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</section>
@endsection