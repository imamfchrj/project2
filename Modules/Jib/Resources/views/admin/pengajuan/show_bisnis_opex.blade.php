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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>@lang('jib::pengajuan.pengajuan_detail')</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.initiaor_label')</label>
                                <div class="col-sm-5">
                                    <input type="text" name="nama_sub_unit"
                                           class="form-control @error('nama_sub_unit') is-invalid @enderror @if (!$errors->has('nama_sub_unit') && old('nama_sub_unit')) is-valid @endif"
                                           value="{{ !empty($pengajuan) ? $pengajuan->nama_sub_unit : '' }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.jenis_label')</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="jenis_id" id ="jenis_id" disabled>
                                        <option value=" ">
                                            {{ !empty($pengajuan->mjenises->name) ? $pengajuan->mjenises->name : '' }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.kategori_label')</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="kategori_id" id ="kategori_id" disabled>
                                        <option value=" ">
                                            {{ !empty($pengajuan->mcategories->name) ? $pengajuan->mcategories->name : '' }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4> BISNIS OPEX</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.kegiatan_label')</label>
                                <div class="col-sm-5">
                                    <input type="text" name="kegiatan_1"
                                           class="form-control @error('kegiatan_1') is-invalid @enderror @if (!$errors->has('kegiatan_1') && old('kegiatan_1')) is-valid @endif"
                                           value="{{ !empty($pengajuan->kegiatan) ? $pengajuan->kegiatan : '' }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.segment_label')</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="segment_id_1" id ="segment_id_1" disabled>
                                        <option value=" ">
                                            {{ !empty($pengajuan->msegments->name) ? $pengajuan->msegments->name : '' }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.customer_label')</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="customer_id_1" id ="customer_id_1" disabled>
                                        <option value=" ">
                                            {{ !empty($pengajuan->mcustomers->name) ? $pengajuan->mcustomers->name : '' }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">NO DRK</label>
                                <div class="col-sm-5">
                                    <input type="text" name="no_drp_1"
                                           class="form-control @error('no_drp_1') is-invalid @enderror @if (!$errors->has('no_drp_1') && old('no_drp_1')) is-valid @endif"
                                           value="{{ !empty($pengajuan->no_drp) ? $pengajuan->no_drp : '' }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nilai Proyek</label>
                                <div class="col-sm-5">
                                    <input type="text" name="nilai_capex_1"
                                           class="form-control @error('nilai_capex_1') is-invalid @enderror @if (!$errors->has('nilai_capex_1') && old('nilai_capex_1')) is-valid @endif"
                                           value="{{ !empty($pengajuan->nilai_capex) ? $pengajuan->nilai_capex : '' }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Revenue</label>
                                <div class="col-sm-5">
                                    <input type="text" name="est_revenue"
                                           class="form-control @error('est_revenue') is-invalid @enderror @if (!$errors->has('est_revenue') && old('est_revenue')) is-valid @endif"
                                           value="{{ !empty($pengajuan) ? $pengajuan->est_revenue : '' }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Cost</label>
                                <div class="col-sm-5">
                                    <input type="text" name="cost"
                                           class="form-control @error('cost') is-invalid @enderror @if (!$errors->has('cost') && old('cost')) is-valid @endif"
                                           value="{{ !empty($pengajuan) ? $pengajuan->cost : '' }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Profit Margin</label>
                                <div class="col-sm-5">
                                    <input type="text" name="profit_margin"
                                           class="form-control @error('profit_margin') is-invalid @enderror @if (!$errors->has('profit_margin') && old('profit_margin')) is-valid @endif"
                                           value="{{ !empty($pengajuan) ? $pengajuan->profit_margin : '' }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Net Cash Flow</label>
                                <div class="col-sm-5">
                                    <input type="text" name="net_cf"
                                           class="form-control @error('net_cf') is-invalid @enderror @if (!$errors->has('net_cf') && old('net_cf')) is-valid @endif"
                                           value="{{ !empty($pengajuan) ? $pengajuan->net_cf : '' }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Suku Bunga Acuan</label>
                                <div class="col-sm-5">
                                    <input type="text" name="suku_bunga"
                                           class="form-control @error('suku_bunga') is-invalid @enderror @if (!$errors->has('suku_bunga') && old('suku_bunga')) is-valid @endif"
                                           value="{{ !empty($pengajuan) ? $pengajuan->suku_bunga : '' }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Upload History</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="pengajuan" class="table table-bordered table-sm ">
                                    <thead class ="thead-dark text-center">
                                        <th>Upload Date</th>
                                        <th>Uploader</th>
                                        <th>Download</th>
                                    </thead>
                                    <tbody class ="text-center">
                                    @if(!empty($file_jib))
                                        @foreach($file_jib as $file_upload)
                                            <tr>
                                                <td>{{ $file_upload->created_at }}</td>
                                                <td>{{ !empty($pengajuan) ? $pengajuan->users->name.' / '.$pengajuan->users->nik_gsd : '' }} </td>
                                                <td><a href={{ $file_upload->uuid.'/download' }} ><i class="fas fa-download"></i> {{ $file_upload->name }}</a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-md-right">Form Persetujuan</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm ">
                                    <thead class ="thead-dark text-center">
                                    <th>No DRP</th>
                                    <th>Nama Kegiatan</th>
                                    {{--<th>Download PDF</th>--}}
                                    <th>Created Date</th>
                                    <th>Created By</th>
                                    <th>Download Full Sign</th>
                                    </thead>
                                    <tbody class ="text-center">
                                    @forelse ($persetujuan as $setuju)
                                        <tr>
                                            <td>{{ $setuju->no_drp }}</td>
                                            <td>{{ $setuju->kegiatan }}</td>
                                            {{--<td><a class="btn btn-sm btn-light"--}}
                                                   {{--href="">Generate PDF--}}
                                                {{--</a></td>--}}
                                            <td>{{ $setuju->created_at }}</td>
                                            <td>{{ $setuju->updated_by }}</td>
                                            <td>@if(!empty($file_approval))
                                                    {{--{{ dd($file_approval->count()) }}--}}
                                                    @if ($file_approval->count() > 0)
                                                        <a href="{{ $file_approval->last()->uuid.'/download' }}"><i class="fas fa-download"></i>
                                                            {{ $file_approval->last()->name }}</a>
                                                    @else
                                                        -
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-md-right">MoM</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm ">
                                    <thead class ="thead-dark text-center">
                                    <th>Dasar MoM</th>
                                    {{--<th>Download PDF</th>--}}
                                    <th>Created Date</th>
                                    <th>Created By</th>
                                    <th>Download Full Sign</th>
                                    </thead>
                                    <tbody class ="text-center">
                                    @forelse ($mom as $moms)
                                        <tr>
                                            <td>{{ $moms->dasar_mom }}</td>
                                            {{--<td><a class="btn btn-sm btn-light"--}}
                                                   {{--href="">Generate PDF--}}
                                                {{--</a></td>--}}
                                            <td>{{ $moms->created_at }}</td>
                                            <td>{{ $moms->updated_by }}</td>
                                            <td>@if(!empty($file_mom))
                                                    {{--{{ dd($file_mom->count()) }}--}}
                                                    @if ($file_mom->count() > 0)
                                                        <a href="{{ $file_mom->last()->uuid.'/download' }}"><i class="fas fa-download"></i>
                                                            {{ $file_mom->last()->name }}</a>
                                                    @else
                                                        -
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Notes</h4>
                        </div>
                        <div class="card-body">
                            {{--<div class="row">--}}
                            {{--<div class="col-6">--}}
                            {{--@include('jib::admin.pengajuan._nested_pemeriksa', [])--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-row">
                                @if (!empty($notes))
                                    @foreach ($notes as $note)
                                        <div class="col-md-2 text-center">
                                            <i class="far fa-comment-dots"></i>
                                        </div>
                                        <div class="col-md-10">
                                            {{ $note->created_at }} - <b>{{$note->nama_karyawan.' / '.$note->nik_gsd}}</b> - {{$note->status}}<br>
                                            {{ $note->notes }}<hr>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="card-footer text-left">
                            <a href="{{ url('admin/jib/pengajuan') }}"><button class="btn btn-light">Close</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection