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
    @if(isset($pengajuan))
        {!! Form::model($pengajuan, ['url' => ['admin/jib/pengajuan', $pengajuan->id], 'method' => 'PUT', 'files' => true ]) !!}
        {!! Form::hidden('id') !!}
    @else
        {!! Form::open(['url' => 'admin/jib/pengajuan', 'files'=>true]) !!}
    @endif
    {{--@if (empty($pengajuan))--}}
        {{--<form method="POST" action="{{ route('users.store') }}">--}}
    {{--@else--}}
        {{--<form method="POST" action="{{ route('users.update', $pengajuan->id) }}">--}}
        {{--<input type="hidden" name="id" value="{{ $pengajuan->id }}"/>--}}
        {{--@method('PUT')--}}
    {{--@endif--}}
    @csrf
        <div class="section-body">
            <h2 class="section-title">{{ empty($pengajuan) ? __('jib::pengajuan.pengajuan_add_new') : __('jib::pengajuan.pengajuan_update') }}</h2>
            <div class="row">
                <div class="col-lg-12">
                    <!-- CARD 1 -->
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ empty($pengajuan) ? __('jib::pengajuan.add_card_title') : __('jib::pengajuan.update_card_title') }}</h4>
                        </div>
                        <div class="card-body">
                            @include('jib::admin.shared.flash')
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.initiaor_label')</label>
                                <div class="col-sm-5">
                                    <input type="text" name="nama_sub_unit"
                                           class="form-control @error('nama_sub_unit') is-invalid @enderror @if (!$errors->has('nama_sub_unit') && old('nama_sub_unit')) is-valid @endif"
                                           value="{{ old('nama_sub_unit', !empty($pengajuan) ? $pengajuan->nama_sub_unit : $initiator->nama_sub_unit) }}">
                                    <input type="hidden" name="initiator_id"
                                           value="{{ old('initiator_id', !empty($pengajuan) ? $pengajuan->initiator_id : $initiator->id) }}">
                                    <input type="hidden" name="nama_posisi"
                                           value="{{ old('nama_posisi', !empty($pengajuan) ? $pengajuan->nama_posisi : $initiator->nama_posisi) }}">
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.kategori_label')</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="kategori_id" id ="kategori_id">
                                        <option>@lang('jib::pengajuan.select_kategori_label')</option>

                                        @foreach ($kategori as $key => $value)
                                            <option value="{{ $key }}" {{ $key == $kategori_id ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    * bisnis : <br>* support :
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- CARD 2 -->
                    <div class="card hide" id="group-1">
                        <div class="card-header">
                            <h4> BISNIS </h4>
                        </div>
                        <div class="card-body">
                            @include('jib::admin.shared.flash')
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.kegiatan_label')</label>
                                <div class="col-sm-5">
                                    <input type="text" name="kegiatan_1"
                                           class="form-control @error('kegiatan') is-invalid @enderror @if (!$errors->has('kegiatan') && old('kegiatan')) is-valid @endif"
                                           value="{{ old('kegiatan', !empty($pengajuan) ? $pengajuan->kegiatan : null) }}">
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.segment_label')</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="segment_id_1">
                                        <option>@lang('jib::pengajuan.select_segment_label')</option>

                                        @foreach ($segment as $key => $value)
                                            <option value="{{ $key }}" {{ $key == $segment_id ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.customer_label')</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="customer_id_1">
                                        <option>@lang('jib::pengajuan.select_customer_label')</option>

                                        @foreach ($customer as $key => $value)
                                            <option value="{{ $key }}" {{ $key == $customer_id ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.drp_label')</label>
                                <div class="col-sm-5">
                                    <input type="text" name="no_drp_1"
                                           class="form-control @error('no_drp') is-invalid @enderror @if (!$errors->has('no_drp') && old('no_drp')) is-valid @endif"
                                           value="{{ old('no_drp', !empty($pengajuan) ? $pengajuan->no_drp : null) }}">
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.nilai_capex_label')</label>
                                <div class="col-sm-5">
                                    <input type="text" name="nilai_capex_1"
                                           class="form-control @error('nilai_capex') is-invalid @enderror @if (!$errors->has('nilai_capex') && old('nilai_capex')) is-valid @endif"
                                           value="{{ old('nilai_capex', !empty($pengajuan) ? $pengajuan->nilai_capex : null) }}">
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.est_rev__label')</label>
                                <div class="col-sm-5">
                                    <input type="text" name="est_revenue"
                                           class="form-control @error('est_revenue') is-invalid @enderror @if (!$errors->has('est_revenue') && old('est_revenue')) is-valid @endif"
                                           value="{{ old('est_revenue', !empty($pengajuan) ? $pengajuan->est_revenue : null) }}">
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.irr_label')</label>
                                <div class="col-sm-5">
                                    <input type="text" name="irr"
                                           class="form-control @error('irr') is-invalid @enderror @if (!$errors->has('irr') && old('irr')) is-valid @endif"
                                           value="{{ old('irr', !empty($pengajuan) ? $pengajuan->irr : null) }}">
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.npv_label')</label>
                                <div class="col-sm-5">
                                    <input type="text" name="npv"
                                           class="form-control @error('npv') is-invalid @enderror @if (!$errors->has('npv') && old('npv')) is-valid @endif"
                                           value="{{ old('npv', !empty($pengajuan) ? $pengajuan->npv : null) }}">
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.pbp_label')</label>
                                <div class="col-sm-5">
                                    <input type="text" name="pbp"
                                           class="form-control @error('pbp') is-invalid @enderror @if (!$errors->has('pbp') && old('pbp')) is-valid @endif"
                                           value="{{ old('pbp', !empty($pengajuan) ? $pengajuan->pbp : null) }}">
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">File Upload</label>
                                <div class="col-sm-5">
                                    @if (!empty($pengajuan) && $pengajuan->featured_image)
                                        <img src="{{ $pengajuan->featured_image }}" alt="{{ $pengajuan->featured_image_caption }}" class="img-fluid img-thumbnail"/>
                                    @endif
                                    <input type="file" name="file_jib_1" class="form-control"/>
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card hide" id="group-2">
                        <div class="card-header">
                            <h4> SUPPORT </h4>
                        </div>
                        <div class="card-body">
                            @include('jib::admin.shared.flash')
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.kegiatan_label')</label>
                                <div class="col-sm-5">
                                    <input type="text" name="kegiatan_2"
                                           class="form-control @error('kegiatan') is-invalid @enderror @if (!$errors->has('kegiatan') && old('kegiatan')) is-valid @endif"
                                           value="{{ old('kegiatan', !empty($pengajuan) ? $pengajuan->kegiatan : null) }}">
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.segment_label')</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="segment_id_2">
                                        <option>@lang('jib::pengajuan.select_segment_label')</option>

                                        @foreach ($segment as $key => $value)
                                            <option value="{{ $key }}" {{ $key == $segment_id ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.customer_label')</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="customer_id_2">
                                        <option>@lang('jib::pengajuan.select_customer_label')</option>

                                        @foreach ($customer as $key => $value)
                                            <option value="{{ $key }}" {{ $key == $customer_id ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.drp_label')</label>
                                <div class="col-sm-5">
                                    <input type="text" name="no_drp_2"
                                           class="form-control @error('no_drp') is-invalid @enderror @if (!$errors->has('no_drp') && old('no_drp')) is-valid @endif"
                                           value="{{ old('no_drp', !empty($pengajuan) ? $pengajuan->no_drp : null) }}">
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.nilai_capex_label')</label>
                                <div class="col-sm-5">
                                    <input type="text" name="nilai_capex_2"
                                           class="form-control @error('nilai_capex') is-invalid @enderror @if (!$errors->has('nilai_capex') && old('nilai_capex')) is-valid @endif"
                                           value="{{ old('nilai_capex', !empty($pengajuan) ? $pengajuan->nilai_capex : null) }}">
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.bcr_label')</label>
                                <div class="col-sm-5">
                                    <input type="text" name="bcr"
                                           class="form-control @error('bcr') is-invalid @enderror @if (!$errors->has('bcr') && old('bcr')) is-valid @endif"
                                           value="{{ old('bcr', !empty($pengajuan) ? $pengajuan->bcr : null) }}">
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">File Upload</label>
                                <div class="col-sm-5">
                                    @if (!empty($pengajuan) && $pengajuan->featured_image)
                                        <img src="{{ $pengajuan->featured_image }}" alt="{{ $pengajuan->featured_image_caption }}" class="img-fluid img-thumbnail"/>
                                    @endif
                                    <input type="file" name="file_jib_2" class="form-control"/>
                                </div>
                                @error('nama_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- END CARD 2 -->
                    <!-- CARD 3 -->
                    <div class="card hide" id="group-3">
                        <div class="card-header">
                            <h4>Notes</h4>
                        </div>
                        <div class="card-body">
                            {{--<div class="row">--}}
                                {{--<div class="col-6">--}}
                                    {{--@include('jib::admin.pengajuan._nested_pemeriksa', [])--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Notes</label>
                                <div class="col-sm-5">
                                    <textarea name="note" class="form-control" style="height: 100px;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-left">
                            {{--<button--}}
                            {{--class="btn btn-primary">{{ empty($pengajuan) ? __('jib::general.btn_draft_label') : __('jib::general.btn_update_label') }}</button>--}}
                            <button
                                    class="btn btn-primary">{{ empty($pengajuan) ? __('jib::general.btn_create_label') : __('jib::general.btn_update_label') }}</button>
                        </div>
                    </div>
                    <!-- END CARD 3 -->
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</section>
{{--<script src="{{ asset ('modules/jib/js/pengajuan.js') }}"></script>--}}
@endsection
{{--@section('scripts')--}}
    {{--<script src="{{ asset('js/pengajuan.js') }}"></script>--}}

{{--@endsection--}}