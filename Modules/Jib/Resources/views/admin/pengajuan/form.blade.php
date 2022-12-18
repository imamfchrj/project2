@extends('layouts.dashboard')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>@lang('jib::pengajuan.manage_pengajuan')</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a
                    href="{{ url('admin/jib/pengajuan') }}">@lang('jib::pengajuan.manage_pengajuan')</a></div>
        </div>
    </div>
    @if(isset($pengajuan))
    {!! Form::model($pengajuan, ['url' => ['admin/jib/pengajuan', $pengajuan->id], 'method' => 'PUT', 'files' => true ])
    !!}
    {!! Form::hidden('id') !!}
    @else
    {!! Form::open(['url' => 'admin/jib/pengajuan', 'files'=>true]) !!}
    <!-- {!! Form::hidden('xxxxxxx') !!} -->
    @endif
    {{--@if (empty($pengajuan))--}}
    {{--<form method="POST" action="{{ route('users.store') }}">--}}
    {{--@else--}}
    {{--<form method="POST" action="{{ route('users.update', $pengajuan->id) }}">--}}
    {{--<input type="hidden" name="id" value="{{ $pengajuan->id }}"/>--}}
    {{--@method('PUT')--}}
    {{--@endif--}}
    @csrf
    <input type="hidden" id="draft_status" name="draft_status" />
    <div class="section-body">
        <h2 class="section-title">
            {{ empty($pengajuan) ? __('jib::pengajuan.pengajuan_add_new') : __('jib::pengajuan.pengajuan_update') }}
        </h2>
        <div class="row">
            <div class="col-lg-12">
                <!-- CARD 1 -->
                <div class="card">
                    <div class="card-header">
                        <h4>{{ empty($pengajuan) ? __('jib::pengajuan.add_card_title') : __('jib::pengajuan.update_card_title') }}
                        </h4>
                    </div>
                    <div class="card-body">
                        @include('jib::admin.shared.flash')
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.initiaor_label')</label>
                            <div class="col-sm-5">
                                @if($initiatorAll->count() == 1)
                                    <input type="text" name="nama_sub_unit"
                                        class="form-control @error('nama_sub_unit') is-invalid @enderror @if (!$errors->has('nama_sub_unit') && old('nama_sub_unit')) is-valid @endif"
                                        value="{{ old('nama_sub_unit', !empty($pengajuan) ? $pengajuan->nama_sub_unit : $initiator->nama_sub_unit) }}">
                                    <input type="hidden" name="initiator_id"
                                    value="{{ old('initiator_id', !empty($pengajuan) ? $pengajuan->initiator_id : $initiator->id) }}">
                                    <input type="hidden" name="nama_posisi"
                                    value="{{ old('nama_posisi', !empty($pengajuan) ? $pengajuan->nama_posisi : $initiator->nama_posisi) }}">
                                @else
                                    <select class="form-control" name="nama_sub_unit" id="nama_sub_unit">
                                        <option>-- Pilih Unit --</option>

                                        @foreach ($initiatorAll as $key => $value)
                                            <option value="{{ $key }}"
                                                    {{ $key == (!empty($pengajuan)? $pengajuan->initiator_id : '') ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            @error('nama_sub_unit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.jenis_label')</label>
                            <div class="col-sm-5">

                                <select class="form-control" name="jenis_id" id="jenis_id">
                                    <option>@lang('jib::pengajuan.select_jenis_label')</option>

                                    @foreach ($jenis as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ $key == (!empty($pengajuan)? $pengajuan->jenis_id : '') ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>
                            @error('jenis_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.kategori_label')</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="kategori_id" id="kategori_id">
                                    <option>@lang('jib::pengajuan.select_kategori_label')</option>

                                    @foreach ($kategori as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ $key == (!empty($pengajuan)? $pengajuan->kategori_id : '') ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                    @endforeach

                                </select>
                                <hr>* bisnis : Berhubungan langsung dengan revenue <br>* support : Tidak berhubungan langsung dengan revenue
                            </div>
                            @error('kategori_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- CARD 1 -->
                <div class="card hide" id="group-1">
                    <div class="card-header">
                        <h4> BISNIS CAPEX </h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.kegiatan_label')</label>
                            <div class="col-sm-5">
                                <input type="text" name="kegiatan_1"
                                    class="form-control @error('kegiatan_1') is-invalid @enderror @if (!$errors->has('kegiatan_1') && old('kegiatan_1')) is-valid @endif"
                                    value="{{ old('kegiatan_1', !empty($pengajuan) ? $pengajuan->kegiatan : null) }}">
                            </div>
                            @error('kegiatan_1')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.segment_label')</label>
                            <div class="col-sm-5">
                                {!! Form::select('segment_id_1', $segment, !empty($pengajuan->segment_id) ?
                                $pengajuan->segment_id : old('segment_id_1'), ['class' => 'form-control', 'placeholder'
                                => '-- Select Segment --']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.customer_label')</label>
                            <div class="col-sm-5">
                                {!! Form::select('customer_id_1', $customer, !empty($pengajuan->customer_id) ?
                                $pengajuan->customer_id : old('customer_id_1'), ['class' => 'form-control',
                                'placeholder' => '-- Select Customer --']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.drp_label')</label>
                            <div class="col-sm-5">
                                <input type="text" name="no_drp_1"
                                    class="form-control @error('no_drp_1') is-invalid @enderror @if (!$errors->has('no_drp_1') && old('no_drp_1')) is-valid @endif"
                                    value="{{ old('no_drp_1', !empty($pengajuan) ? $pengajuan->no_drp : null) }}">
                            </div>
                            @error('no_drp_1')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.nilai_capex_label')</label>
                            <div class="col-sm-5">
                                <input id="nilai_capex_1" type="text" name="nilai_capex_1"
                                    class="form-control @error('nilai_capex_1') is-invalid @enderror @if (!$errors->has('nilai_capex_1') && old('nilai_capex_1')) is-valid @endif"
                                    value="{{ old('nilai_capex_1', !empty($pengajuan) ? $pengajuan->nilai_capex : null) }}">
                            </div>
                            @error('nilai_capex_1')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.est_rev__label')</label>
                            <div class="col-sm-5">
                                <input id="est_revenue" type="text" name="est_revenue"
                                    class="form-control @error('est_revenue') is-invalid @enderror @if (!$errors->has('est_revenue') && old('est_revenue')) is-valid @endif"
                                    value="{{ old('est_revenue', !empty($pengajuan) ? $pengajuan->est_revenue : null) }}">
                            </div>
                            @error('est_revenue')
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
                            @error('irr')
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
                            @error('npv')
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
                            @error('pbp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">File Upload</label>
                            <div class="col-sm-5">
                                @if (!empty($pengajuan) && $pengajuan->featured_image)
                                <img src="{{ $pengajuan->featured_image }}"
                                    alt="{{ $pengajuan->featured_image_caption }}" class="img-fluid img-thumbnail" />
                                @endif
                                <input type="file" name="file_jib_1" class="form-control" />
                            </div>
                            @error('file_jib_1')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- END CARD 1 -->
                <!-- CARD 2 -->
                <div class="card hide" id="group-2">
                    <div class="card-header">
                        <h4> SUPPORT CAPEX/OPEX</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.kegiatan_label')</label>
                            <div class="col-sm-5">
                                <input type="text" name="kegiatan_2"
                                    class="form-control @error('kegiatan_2') is-invalid @enderror @if (!$errors->has('kegiatan_2') && old('kegiatan_2')) is-valid @endif"
                                    value="{{ old('kegiatan_2', !empty($pengajuan) ? $pengajuan->kegiatan : null) }}">
                            </div>
                            @error('kegiatan_2')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.segment_label')</label>
                            <div class="col-sm-5">
                                {!! Form::select('segment_id_2', $segment, !empty($pengajuan->segment_id) ?
                                $pengajuan->segment_id : old('segment_id_2'), ['id' => 'seg', 'class' => 'form-control', 'placeholder'
                                => '-- Select Segment --']) !!}
                            </div>
                        </div>
                        @if (empty($pengajuan->segment_id))
                            <div class="form-group row" id="cust">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.customer_label')</label>
                                <div class="col-sm-5">
                                    {!! Form::select('customer_id_2', $customer, !empty($pengajuan->customer_id) ?
                                    $pengajuan->customer_id : old('customer_id_2'), ['class' => 'form-control',
                                    'placeholder' => '-- Select Customer --']) !!}
                                </div>
                            </div>
                        @else
                            @if ($pengajuan->segment_id != 6)
                                <div class="form-group row" id="cust">
                                    <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.customer_label')</label>
                                    <div class="col-sm-5">
                                        {!! Form::select('customer_id_2', $customer, !empty($pengajuan->customer_id) ?
                                        $pengajuan->customer_id : old('customer_id_2'), ['class' => 'form-control',
                                        'placeholder' => '-- Select Customer --']) !!}
                                    </div>
                                </div>
                            @else
                                <div class="form-group row" id="cust-draft">
                                    <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.customer_label')</label>
                                    <div class="col-sm-5">
                                        {!! Form::select('customer_id_2', $customer, !empty($pengajuan->customer_id) ?
                                        $pengajuan->customer_id : old('customer_id_2'), ['class' => 'form-control',
                                        'placeholder' => '-- Select Customer --']) !!}
                                    </div>
                                </div>
                            @endif
                        @endif
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">No DRP/DRK</label>
                            <div class="col-sm-5">
                                <input type="text" name="no_drp_2"
                                    class="form-control @error('no_drp_2') is-invalid @enderror @if (!$errors->has('no_drp_2') && old('no_drp_2')) is-valid @endif"
                                    value="{{ old('no_drp_2', !empty($pengajuan) ? $pengajuan->no_drp : null) }}">
                            </div>
                            @error('no_drp_2')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.nilai_capex_label')</label>
                            <div class="col-sm-5">
                                <input id="nilai_capex_2" type="text" name="nilai_capex_2"
                                    class="form-control @error('nilai_capex_2') is-invalid @enderror @if (!$errors->has('nilai_capex_2') && old('nilai_capex_2')) is-valid @endif"
                                    value="{{ old('nilai_capex_2', !empty($pengajuan) ? $pengajuan->nilai_capex : null) }}">
                            </div>
                            @error('nilai_capex_2')
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
                            @error('bcr')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">File Upload</label>
                            <div class="col-sm-5">
                                @if (!empty($pengajuan) && $pengajuan->featured_image)
                                <img src="{{ $pengajuan->featured_image }}"
                                    alt="{{ $pengajuan->featured_image_caption }}" class="img-fluid img-thumbnail" />
                                @endif
                                <input type="file" name="file_jib_2" class="form-control" />
                            </div>
                            @error('file_jib_2')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- END CARD 2 -->
                <!-- CARD 4 -->
                <div class="card hide" id="group-4">
                    <div class="card-header">
                        <h4> BISNIS OPEX </h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.kegiatan_label')</label>
                            <div class="col-sm-5">
                                <input type="text" name="kegiatan_4"
                                    class="form-control @error('kegiatan_4') is-invalid @enderror @if (!$errors->has('kegiatan_4') && old('kegiatan_4')) is-valid @endif"
                                    value="{{ old('kegiatan_4', !empty($pengajuan) ? $pengajuan->kegiatan : null) }}">
                            </div>
                            @error('kegiatan_4')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.segment_label')</label>
                            <div class="col-sm-5">
                                {!! Form::select('segment_id_4', $segment, !empty($pengajuan->segment_id) ?
                                $pengajuan->segment_id : old('segment_id_4'), ['class' => 'form-control', 'placeholder'
                                => '-- Select Segment --']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.customer_label')</label>
                            <div class="col-sm-5">
                                {!! Form::select('customer_id_4', $customer, !empty($pengajuan->customer_id) ?
                                $pengajuan->customer_id : old('customer_id_4'), ['class' => 'form-control',
                                'placeholder' => '-- Select Customer --']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">No DRK</label>
                            <div class="col-sm-5">
                                <input type="text" name="no_drp_4"
                                    class="form-control @error('no_drp_4') is-invalid @enderror @if (!$errors->has('no_drp_4') && old('no_drp_4')) is-valid @endif"
                                    value="{{ old('no_drp_4', !empty($pengajuan) ? $pengajuan->no_drp : null) }}">
                            </div>
                            @error('no_drp_4')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nilai Proyek</label>
                            <div class="col-sm-5">
                                <input id="nilai_capex_4" type="text" name="nilai_capex_4"
                                    class="form-control @error('nilai_capex_4') is-invalid @enderror @if (!$errors->has('nilai_capex_4') && old('nilai_capex_4')) is-valid @endif"
                                    value="{{ old('nilai_capex_4', !empty($pengajuan) ? $pengajuan->nilai_capex : null) }}">
                            </div>
                            @error('nilai_capex_4')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Revenue</label>
                            <div class="col-sm-5">
                                <input id="est_revenue_4" type="text" name="est_revenue_4"
                                    class="form-control @error('est_revenue_4') is-invalid @enderror @if (!$errors->has('est_revenue_4') && old('est_revenue_4')) is-valid @endif"
                                    value="{{ old('est_revenue_4', !empty($pengajuan) ? $pengajuan->est_revenue : null) }}">
                            </div>
                            @error('est_revenue_4')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Cost</label>
                            <div class="col-sm-5">
                                <input type="text" name="cost"
                                    class="form-control @error('cost') is-invalid @enderror @if (!$errors->has('cost') && old('cost')) is-valid @endif"
                                    value="{{ old('cost', !empty($pengajuan) ? $pengajuan->cost : null) }}">
                            </div>
                            @error('cost')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Profit Margin</label>
                            <div class="col-sm-5">
                                <input type="text" name="profit_margin"
                                    class="form-control @error('profit_margin') is-invalid @enderror @if (!$errors->has('profit_margin') && old('profit_margin')) is-valid @endif"
                                    value="{{ old('profit_margin', !empty($pengajuan) ? $pengajuan->profit_margin : null) }}">
                            </div>
                            @error('profit_margin')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Net Cash Flow</label>
                            <div class="col-sm-5">
                                <input type="text" name="net_cf"
                                    class="form-control @error('net_cf') is-invalid @enderror @if (!$errors->has('net_cf') && old('net_cf')) is-valid @endif"
                                    value="{{ old('net_cf', !empty($pengajuan) ? $pengajuan->net_cf : null) }}">
                            </div>
                            @error('net_cf')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Suku Bunga Acuan</label>
                            <div class="col-sm-5">
                                <input type="text" name="suku_bunga"
                                    class="form-control @error('suku_bunga') is-invalid @enderror @if (!$errors->has('suku_bunga') && old('suku_bunga')) is-valid @endif"
                                    value="{{ old('suku_bunga', !empty($pengajuan) ? $pengajuan->suku_bunga : null) }}">
                            </div>
                            @error('suku_bunga')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">File Upload</label>
                            <div class="col-sm-5">
                                @if (!empty($pengajuan) && $pengajuan->featured_image)
                                <img src="{{ $pengajuan->featured_image }}"
                                    alt="{{ $pengajuan->featured_image_caption }}" class="img-fluid img-thumbnail" />
                                @endif
                                <input type="file" name="file_jib_4" class="form-control" />
                            </div>
                            @error('file_jib_4')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- END CARD 4 -->
                <!-- Card Upload History -->
                <div class="card hide" id="upload_history">
                    <div class="card-header">
                        <h4>Upload History</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="pengajuan" class="table table-bordered table-sm ">
                                <thead class="thead-dark text-center">
                                <th>Upload Date</th>
                                <th>Uploader</th>
                                <th>Download</th>
                                </thead>
                                <tbody class="text-center">
                                @if(!empty($file_jib))
                                    @foreach($file_jib as $file_upload)
                                        <tr>
                                            <td>{{ $file_upload->created_at }}</td>
                                            <td>{{ !empty($pengajuan) ? $pengajuan->users->name.' / '.$pengajuan->users->nik_gsd : '' }}
                                            </td>
                                            <td><a href={{ $file_upload->uuid.'/download' }}><i class="fas fa-download"></i>
                                                    {{ $file_upload->name }}</a></td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End Card Upload History -->
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
                        <button id="btn_pengajuan"
                            class="btn btn-primary">{{ empty($pengajuan) ? __('jib::general.btn_create_label') : __('jib::general.btn_update_label') }}</button>
                        <button id="btn_pengajuan_draft" name="draft" value="true"
                            class="btn btn-secondary">{{ empty($pengajuan) ? __('jib::general.btn_draft_label') : __('jib::general.btn_draft_label') }}</button>
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