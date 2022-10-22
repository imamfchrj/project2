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
                                    <input type="text" name="kegiatan"
                                           class="form-control @error('kegiatan') is-invalid @enderror @if (!$errors->has('kegiatan') && old('kegiatan')) is-valid @endif"
                                           value="{{ !empty($pengajuan->kegiatan) ? $pengajuan->kegiatan : '' }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.segment_label')</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="segment_id" id ="segment_id" disabled>
                                        <option value=" ">
                                            {{ !empty($pengajuan->msegments->name) ? $pengajuan->msegments->name : '' }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.customer_label')</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="customer_id" id ="customer_id" disabled>
                                        <option value=" ">
                                            {{ !empty($pengajuan->mcustomers->name) ? $pengajuan->mcustomers->name : '' }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">No DRK</label>
                                <div class="col-sm-5">
                                    <input type="text" name="no_drp"
                                           class="form-control @error('no_drp') is-invalid @enderror @if (!$errors->has('no_drp') && old('no_drp')) is-valid @endif"
                                           value="{{ !empty($pengajuan->no_drp) ? $pengajuan->no_drp : '' }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nilai Proyek</label>
                                <div class="col-sm-5">
                                    <input type="text" name="nilai_capex"
                                           class="form-control @error('nilai_capex') is-invalid @enderror @if (!$errors->has('nilai_capex') && old('nilai_capex')) is-valid @endif"
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
                                        <tr>
                                            <td>Monday 8 Agustus 2022 16:51:27</td>
                                            <td>95509517</td>
                                            <td><a><i class="fas fa-download"></i></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-md-right">Form Persetujuan dan MoM</h4>
                            <div class="card-header-action">
                                {{--<a class="btn btn-sm btn-success"--}}
                                {{--href=""><i class="fas fa-file"></i>--}}
                                {{--Create--}}
                                {{--</a>--}}
                                <a class="btn btn-sm btn-success"
                                   href="{{ url('admin/jib/workspace/createform/'. $pengajuan->id)}}"><i
                                            class="fas fa-file"></i> Create
                                </a>
                                <a class="btn btn-sm btn-danger"
                                   href="#"><i class="fas fa-upload"></i>
                                    Upload
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="pengajuan" class="table table-bordered table-sm ">
                                    <thead class ="thead-dark text-center">
                                    <th>Dokumen Type</th>
                                    <th>Upload Date</th>
                                    <th>Uploader</th>
                                    <th>Download</th>
                                    </thead>
                                    <tbody class ="text-center">
                                    <tr>
                                        <td class ="text-left">Form Persetujuan</td>
                                        <td>Monday 8 Agustus 2022 16:51:27</td>
                                        <td>95509517</td>
                                        <td><a><i class="fas fa-download"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td class ="text-left">MoM</td>
                                        <td>Monday 8 Agustus 2022 16:51:27</td>
                                        <td>95509517</td>
                                        <td><a><i class="fas fa-download"></i></a></td>
                                    </tr>
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
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right"><b>Komentar</b></label>
                                <div class="col-sm-5">
                                    <textarea name="note" class="form-control" style="height: 100px;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-left">
                            <a href="{{ url('admin/jib/pengajuan') }}"><button class="btn btn-light">Close</button></a>
                            <a href=""><button class="btn btn-warning">Return</button></a>
                            <a href=""><button class="btn btn-danger">Reject</button></a>
                            <a href=""><button class="btn btn-primary">Submit</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection