@extends('layouts.dashboard')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Manage Pemeriksa</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a
                    href="{{ url('admin/master/pemeriksa') }}">Manage Pemeriksa</a></div>
        </div>
    </div>
    @if(isset($pemeriksa))
    {!! Form::model($pemeriksa, ['url' => ['admin/master/pemeriksa', $pemeriksa->id], 'method' => 'PUT', 'files' => true ]) !!}
    {!! Form::hidden('id') !!}
    @else
    {!! Form::open(['url' => 'admin/master/pemeriksa', 'files'=>true]) !!}
    @endif
    @csrf
    <div class="section-body">
        <h2 class="section-title">
            {{ empty($pemeriksa) ? 'Create Pemeriksa' : 'Update Pemeriksa' }}
        </h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ empty($pemeriksa) ? 'Add New Pemeriksa' : 'Update Pemeriksa' }}
                        </h4>
                    </div>
                    <div class="card-body">
                        @include('master::admin.shared.flash')
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Pemeriksa</label>
                            <div class="col-sm-5">
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror @if (!$errors->has('name') && old('name')) is-valid @endif"
                                    value="{{ old('name', !empty($pemeriksa) ? $pemeriksa->name : '') }}">
                                <input type="hidden" name="id"
                                    value="{{ old('id', !empty($pemeriksa) ? $pemeriksa->id : '') }}">
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
                                class="btn btn-primary">{{ empty($pemeriksa) ? 'Create' : 'Update' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</section>
@endsection