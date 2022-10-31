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
    {!! Form::open(['url' => 'admin/jib/workspace/storeworkspace', 'files'=>true]) !!}
    @csrf
    <input type="hidden" id="status_btn" name="status_btn" />
    <input type="hidden" name="pengajuan_id"
        value="{{ old('pengajuan_id', !empty($pengajuan) ? $pengajuan->id : '') }}">
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
                                <select class="form-control" name="jenis_id" id="jenis_id" disabled>
                                    <option value=" ">
                                        {{ !empty($pengajuan->mjenises->name) ? $pengajuan->mjenises->name : '' }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.kategori_label')</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="kategori_id" id="kategori_id" disabled>
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
                                <select class="form-control" name="segment_id" id="segment_id" disabled>
                                    <option value=" ">
                                        {{ !empty($pengajuan->msegments->name) ? $pengajuan->msegments->name : '' }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">@lang('jib::pengajuan.customer_label')</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="customer_id" id="customer_id" disabled>
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
                                    value="{{ !empty($pengajuan->nilai_capex) ? $pengajuan->nilai_capex : '' }}"
                                    disabled>
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
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-md-right">Form Persetujuan</h4>
                        <div class="card-header-action">
                            @if (empty($persetujuan_id))
                            <a class="btn btn-sm btn-primary"
                                href="{{ url('admin/jib/workspace/createform/'. $pengajuan->id)}}"><i
                                    class="fas fa-file"></i> Create
                            </a>
                            @endif
                            {{--<a class="btn btn-sm btn-danger"--}}
                            {{--href="#"><i class="fas fa-upload"></i>--}}
                            {{--Upload--}}
                            {{--</a>--}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm ">
                                <thead class="thead-dark text-center">
                                    <th>No DRP</th>
                                    <th>Nama Kegiatan</th>
                                    {{--<th>Download PDF</th>--}}
                                    <th>Created Date</th>
                                    <th>Created By</th>
                                    <th>Download Full Sign</th>
                                    <th>Action</th>
                                </thead>
                                <tbody class="text-center">
                                    @forelse ($persetujuan as $setuju)
                                    <tr>
                                        <td>{{ $setuju->no_drp }}</td>
                                        <td>{{ $setuju->kegiatan }}</td>
                                        {{--<td><a class="btn btn-sm btn-light"--}}
                                        {{--href="">Generate PDF--}}
                                        {{--</a></td>--}}
                                        <td>{{ $setuju->created_at }}</td>
                                        <td>{{ $setuju->updated_by }}</td>
                                        <!-- <td>{{ !empty($setuju->file_fullsign)?$setuju->file_fullsign :'-' }}</td> -->
                                        <td>
                                            @if(!empty($file_approval))
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
                                        <td>
                                            <a class="btn btn-sm btn-primary"
                                                href="{{ url('admin/jib/workspace/'. $setuju->id .'/editform')}}"><i
                                                    class="far fa-edit"></i>
                                            </a>
                                            <a class="btn btn-sm btn-secondary" target="_blank"
                                                href="{{ url('admin/jib/workspace/persetujuan/'. $setuju->id .'/download')}}"><i
                                                    class="fas fa-download"></i>
                                            </a>
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
                        <div class="card-header-action">
                            @if (empty($mom_id))
                            <a class="btn btn-sm btn-primary"
                                href="{{ url('admin/jib/workspace/createmom/'. $pengajuan->id)}}"><i
                                    class="fas fa-file"></i> Create
                            </a>
                            @endif
                            {{--<a class="btn btn-sm btn-danger"--}}
                            {{--href="#"><i class="fas fa-upload"></i>--}}
                            {{--Upload--}}
                            {{--</a>--}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm ">
                                <thead class="thead-dark text-center">
                                    <th>Dasar MoM</th>
                                    {{--<th>Download PDF</th>--}}
                                    <th>Created Date</th>
                                    <th>Created By</th>
                                    <th>Download Full Sign</th>
                                    <th>Action</th>
                                </thead>
                                <tbody class="text-center">
                                    @forelse ($mom as $moms)
                                    <tr>
                                        <td>{{ $moms->dasar_mom }}</td>
                                        {{--<td><a class="btn btn-sm btn-light"--}}
                                        {{--href="">Generate PDF--}}
                                        {{--</a></td>--}}
                                        <td>{{ $moms->created_at }}</td>
                                        <td>{{ $moms->updated_by }}</td>
                                        <td>{{ !empty($moms->file_fullsign)?$moms->file_fullsign :'-' }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-primary"
                                                href="{{ url('admin/jib/workspace/'. $moms->id .'/editmom')}}"><i
                                                    class="far fa-edit"></i>
                                            </a>
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
                        <div class="form-row">
                            @if (!empty($notes))
                            @foreach ($notes as $note)
                            <div class="col-md-2 text-center">
                                <i class="far fa-comment-dots"></i>
                            </div>
                            <div class="col-md-10">
                                {{ $note->created_at }} - <b>{{$note->nama_karyawan.' / '.$note->nik_gsd}}</b> -
                                {{$note->status}}<br>
                                {{ $note->notes }}
                                <hr>
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
                        <a class="btn btn-light" href="{{ url('admin/jib/workspace') }}">Close</a>
                        <button id="btn_workspace_approve" class="btn btn-success">Approve</button>
                        <button id="btn_workspace_return" name="draft" value="true"
                            class="btn btn-warning">Return</button>
                        <button id="btn_workspace_reject" name="draft" value="true"
                            class="btn btn-danger">Reject</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</section>
@endsection