@extends('layouts.dashboard')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>MoM JIB</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ url('admin/jib/workspace') }}">Manage Pengajuan JIB</a>
            </div>
        </div>
    </div>
    @if(isset($mom))
    {!! Form::model($mom, ['url' => ['admin/jib/workspace/updatemom', $mom->id], 'method' => 'PUT', 'files' => true ])
    !!}
    {!! Form::hidden('id') !!}
    @else
    {!! Form::open(['url' => 'admin/jib/workspace/storemom', 'files'=>true]) !!}
    @endif
    @csrf
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Form MoM JIB</h4>
                    </div>
                    <input type="hidden" name="pengajuan_id"
                        value="{{ old('pengajuan_id', !empty($pengajuan) ? $pengajuan->id : '') }}">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-6 col-form-label"><b>Review Bisnis</b></label>

                            <label class="col-sm-6 col-form-label"><b>Informasi Umum</b></label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Dasar Inisiatif Bisnis</label>
                            <div class="col-sm-4">
                                <input type="text" name="dasar_mom"
                                    class="form-control @error('dasar_mom') is-invalid @enderror @if (!$errors->has('dasar_mom') && old('dasar_mom')) is-valid @endif"
                                    value="{{ !empty($mom->dasar_mom) ? $mom->dasar_mom : '' }}">
                            </div>

                            <label class="col-sm-2 col-form-label">Ruang Lingkup</label>
                            <div class="col-sm-4">
                                <input type="text" name="ruang_lingkup"
                                    class="form-control @error('ruang_lingkup') is-invalid @enderror @if (!$errors->has('ruang_lingkup') && old('ruang_lingkup')) is-valid @endif"
                                    value="{{ !empty($mom->ruang_lingkup) ? $mom->ruang_lingkup : '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Datetime</label>
                            <div class="col-sm-4">
                                <input type="text" name="tanggal_mom"
                                    class="form-control @error('tanggal_mom') is-invalid @enderror @if (!$errors->has('tanggal_mom') && old('tanggal_mom')) is-valid @endif"
                                    value="{{ !empty($mom->tanggal_mom) ? $mom->tanggal_mom : '' }}">
                            </div>

                            <label class="col-sm-2 col-form-label">Spesifikasi</label>
                            <div class="col-sm-4">
                                <input type="text" name="spesifikasi"
                                    class="form-control @error('spesifikasi') is-invalid @enderror @if (!$errors->has('spesifikasi') && old('spesifikasi')) is-valid @endif"
                                    value="{{ !empty($mom->spesifikasi) ? $mom->spesifikasi : '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Venue</label>
                            <div class="col-sm-4">
                                <input type="text" name="venue"
                                    class="form-control @error('venue') is-invalid @enderror @if (!$errors->has('venue') && old('venue')) is-valid @endif"
                                    value="{{ !empty($mom->venue) ? $mom->venue : '' }}">
                            </div>

                            <label class="col-sm-2 col-form-label">Pelaksanaan Kegiatan</label>
                            <div class="col-sm-4">
                                <input type="text" name="kegiatan"
                                    class="form-control @error('kegiatan') is-invalid @enderror @if (!$errors->has('kegiatan') && old('kegiatan')) is-valid @endif"
                                    value="{{ !empty($mom->kegiatan) ? $mom->kegiatan : '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Meeting Called</label>
                            <div class="col-sm-4">
                                <input type="text" name="meeting_called"
                                    class="form-control @error('meeting_called') is-invalid @enderror @if (!$errors->has('meeting_called') && old('meeting_called')) is-valid @endif"
                                    value="{{ !empty($mom->meeting_called) ? $mom->meeting_called : '' }}">
                            </div>

                            <label class="col-sm-2 col-form-label">Lokasi</label>
                            <div class="col-sm-4">
                                <input type="text" name="lokasi"
                                    class="form-control @error('lokasi') is-invalid @enderror @if (!$errors->has('lokasi') && old('lokasi')) is-valid @endif"
                                    value="{{ !empty($mom->lokasi) ? $mom->lokasi : '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Type of Meeting</label>
                            <div class="col-sm-4">
                                <input type="text" name="meeting_type"
                                    class="form-control @error('meeting_type') is-invalid @enderror @if (!$errors->has('meeting_type') && old('meeting_type')) is-valid @endif"
                                    value="{{ !empty($mom->meeting_type) ? $mom->meeting_type : '' }}">
                            </div>

                            <label class="col-sm-2 col-form-label">Tata Cara Pembayaran</label>
                            <div class="col-sm-4">
                                <input type="text" name="top"
                                    class="form-control @error('top') is-invalid @enderror @if (!$errors->has('top') && old('top')) is-valid @endif"
                                    value="{{ !empty($mom->top) ? $mom->top : '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Facilitator</label>
                            <div class="col-sm-4">
                                <input type="text" name="facilitator"
                                    class="form-control @error('facilitator') is-invalid @enderror @if (!$errors->has('facilitator') && old('facilitator')) is-valid @endif"
                                    value="{{ !empty($mom->facilitator) ? $mom->facilitator : '' }}">
                            </div>

                            <label class="col-sm-2 col-form-label">Analisa Kelayakan Investasi</label>
                            <div class="col-sm-4">
                                <input type="text" name="aki"
                                    class="form-control @error('aki') is-invalid @enderror @if (!$errors->has('aki') && old('aki')) is-valid @endif"
                                    value="{{ !empty($mom->aki) ? $mom->aki : '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Attende</label>
                            <div class="col-sm-4">
                                <input type="text" name="attende"
                                    class="form-control @error('attende') is-invalid @enderror @if (!$errors->has('attende') && old('attende')) is-valid @endif"
                                    value="{{ !empty($mom->attende) ? $mom->attende : '' }}">
                            </div>

                            <label class="col-sm-2 col-form-label"><b>Kesimpulan dan Rekomendasi</b></label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-6 col-form-label"><b>Pembahasan dan Analisa</b></label>

                            <label class="col-sm-2 col-form-label">Catatan</label>
                            <div class="col-sm-4">
                                <textarea name="catatan" class="form-control"
                                    style="height: 70px;">{{ !empty($mom->catatan) ? $mom->catatan : '' }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Review Kelengkapan Administrasi</label>
                            <div class="col-sm-4">
                                <input type="text" name="kelengkapan"
                                    class="form-control @error('kelengkapan') is-invalid @enderror @if (!$errors->has('kelengkapan') && old('kelengkapan')) is-valid @endif"
                                    value="{{ !empty($mom->kelengkapan) ? $mom->kelengkapan : '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Review Ketersediaan Anggaran</label>
                            <div class="col-sm-4">
                                {!! Form::select('anggaran', $anggaran, !empty($mom->anggaran) ? $mom->anggaran :
                                old('anggaran'), ['class' => 'form-control', 'placeholder' => '-- Select --']) !!}
                            </div>

                            @if(!empty($mom))
                            <label class="col-sm-2 col-form-label">File Upload</label>
                            <div class="col-sm-4" id="file_mom">
                                <input type="file" name="file_mom" class="form-control" />
                            </div>
                            @error('file_mom')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                            @endif

                        </div>
                    </div>
                    <div class="card-footer text-left">
                        <a class="btn btn-light"
                            href="{{ url('admin/jib/workspace/'.$pengajuan->id.'/editworkspace') }}">Back</a>
                        <a href=""><button class="btn btn-primary">{{ !empty($mom) ? 'Update' : 'Create' }}</button></a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {!! Form::close() !!}
</section>
@endsection