@extends('layouts.dashboard')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Manage Anggaran</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a
                    href="{{ url('admin/master/anggaran') }}">Manage Anggaran</a></div>
        </div>
    </div>
    @if(isset($anggaran))
    {!! Form::model($anggaran, ['url' => ['admin/master/anggaran', $anggaran->id], 'method' => 'PUT', 'files' => true ]) !!}
    {!! Form::hidden('id') !!}
    @else
    {!! Form::open(['url' => 'admin/master/anggaran', 'files'=>true]) !!}
    @endif
    @csrf
    <div class="section-body">
        <h2 class="section-title">
            {{ empty($anggaran) ? 'Create Anggaran' : 'Update Anggaran' }}
        </h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ empty($anggaran) ? 'Add New Anggaran' : 'Update Anggaran' }}
                        </h4>
                    </div>
                    <div class="card-body">
                        @include('master::admin.shared.flash')
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Anggaran</label>
                            <div class="col-sm-5">
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror @if (!$errors->has('name') && old('name')) is-valid @endif"
                                    value="{{ old('name', !empty($anggaran) ? $anggaran->name : '') }}">
                                <input type="hidden" name="id"
                                    value="{{ old('id', !empty($anggaran) ? $anggaran->id : '') }}">
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
                                class="btn btn-primary">{{ empty($anggaran) ? 'Create' : 'Update' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</section>
@endsection