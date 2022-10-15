@extends('layouts.dashboard')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>@lang('jib::pengajuan.manage_pengajuan')</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ url('admin/jib/pengajuan') }}">@lang('jib::pengajuan.manage_pengajuan')</a></div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">@lang('jib::pengajuan.pengajuan_list')</h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>@lang('jib::pengajuan.pengajuan_detail')</h4>
                    </div>
                    <div class="card-body">
                        @include('jib::admin.shared.flash')
                        <div class="form-row">
                            <div class="col-md-2">
                                <Label>@lang('jib::pengajuan.initiaor_label')</Label>
                            </div>
                            <div class="col-md-10">
                                : {{ $pengajuan->nama_sub_unit }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">
                                <Label>@lang('jib::pengajuan.segment_label')</Label>
                            </div>
                            <div class="col-md-10">
                                : {{ $pengajuan->msegments->name }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">
                                <Label>@lang('jib::pengajuan.customer_label')</Label>
                            </div>
                            <div class="col-md-10">
                                : {{ $pengajuan->mcustomers->name }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">
                                <Label>@lang('jib::pengajuan.kegiatan_label')</Label>
                            </div>
                            <div class="col-md-10">
                                : {{ $pengajuan->kegiatan }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">
                                <Label>@lang('jib::pengajuan.drp_label')</Label>
                            </div>
                            <div class="col-md-10">
                                : {{ $pengajuan->no_drp }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">
                                <Label>@lang('jib::pengajuan.kategori_label')</Label>
                            </div>
                            <div class="col-md-10">
                                : {{ $pengajuan->mcategories->name }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">
                                <Label>@lang('jib::pengajuan.nilai_capex_label')</Label>
                            </div>
                            <div class="col-md-10">
                                : {{ number_format($pengajuan->nilai_capex) }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">
                                <Label>@lang('jib::pengajuan.est_rev__label')</Label>
                            </div>
                            <div class="col-md-10">
                                : {{ number_format($pengajuan->est_revenue) }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">
                                <Label>@lang('jib::pengajuan.irr_label')</Label>
                            </div>
                            <div class="col-md-10">
                                : {{ !empty($pengajuan->irr) ? $pengajuan->irr."%" : "-" }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">
                                <Label>@lang('jib::pengajuan.npv_label')</Label>
                            </div>
                            <div class="col-md-10">
                                : {{ !empty($pengajuan->npv) ? $pengajuan->npv."%" : "-" }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">
                                <Label>@lang('jib::pengajuan.pbp_label')</Label>
                            </div>
                            <div class="col-md-10">
                                : {{ !empty($pengajuan->pbp) ? $pengajuan->pbp."%" : "-" }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">
                                <Label>@lang('jib::pengajuan.bcr_label')</Label>
                            </div>
                            <div class="col-md-10">
                                : {{ !empty($pengajuan->bcr) ? $pengajuan->bcr."%" : "-" }}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">
                                <Label>@lang('jib::pengajuan.status_label')</Label>
                            </div>
                            <div class="col-md-10">
                                : {{ $pengajuan->mstatuses->name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection