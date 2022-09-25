@extends('layouts.dashboard')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>@lang('jib::workspace.manage_workspace')</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ url('admin/jib/workspace') }}">@lang('jib::workspace.manage_workspace')</a></div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">@lang('jib::workspace.workspace_list')</h2>
            <div class="row">
                <div class="col-lg-12">
                    <p>Halaman Workspace</p>
                </div>
            </div>
        </div>
    </section>
@endsection