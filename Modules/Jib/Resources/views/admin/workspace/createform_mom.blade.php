@extends('layouts.dashboard')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>MoM JIB</h1>
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
                            <h4> Form MoM JIB</h4>
                        </div>
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
                                           value="">
                                </div>

                                <label class="col-sm-2 col-form-label">Ruang Lingkup</label>
                                <div class="col-sm-4">
                                    <input type="text" name="ruang_lingkup"
                                           class="form-control @error('ruang_lingkup') is-invalid @enderror @if (!$errors->has('ruang_lingkup') && old('ruang_lingkup')) is-valid @endif"
                                           value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Datetime</label>
                                <div class="col-sm-4">
                                    <input type="text" name="tanggal_mom"
                                           class="form-control @error('tanggal_mom') is-invalid @enderror @if (!$errors->has('tanggal_mom') && old('tanggal_mom')) is-valid @endif"
                                           value="">
                                </div>

                                <label class="col-sm-2 col-form-label">Spesifikasi</label>
                                <div class="col-sm-4">
                                    <input type="text" name="spesifikasi"
                                           class="form-control @error('spesifikasi') is-invalid @enderror @if (!$errors->has('spesifikasi') && old('spesifikasi')) is-valid @endif"
                                           value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Venue</label>
                                <div class="col-sm-4">
                                    <input type="text" name="venue"
                                           class="form-control @error('venue') is-invalid @enderror @if (!$errors->has('venue') && old('venue')) is-valid @endif"
                                           value="">
                                </div>

                                <label class="col-sm-2 col-form-label">Pelaksanaan Kegiatan</label>
                                <div class="col-sm-4">
                                    <input type="text" name="kegiatan"
                                           class="form-control @error('kegiatan') is-invalid @enderror @if (!$errors->has('kegiatan') && old('kegiatan')) is-valid @endif"
                                           value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Meeting Called</label>
                                <div class="col-sm-4">
                                    <input type="text" name="meeting_called"
                                           class="form-control @error('meeting_called') is-invalid @enderror @if (!$errors->has('meeting_called') && old('meeting_called')) is-valid @endif"
                                           value="">
                                </div>

                                <label class="col-sm-2 col-form-label">Lokasi</label>
                                <div class="col-sm-4">
                                    <input type="text" name="lokasi"
                                           class="form-control @error('lokasi') is-invalid @enderror @if (!$errors->has('lokasi') && old('lokasi')) is-valid @endif"
                                           value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Type of Meeting</label>
                                <div class="col-sm-4">
                                    <input type="text" name="meeting_type"
                                           class="form-control @error('meeting_type') is-invalid @enderror @if (!$errors->has('meeting_type') && old('meeting_type')) is-valid @endif"
                                           value="">
                                </div>

                                <label class="col-sm-2 col-form-label">Tata Cara Pembayaran</label>
                                <div class="col-sm-4">
                                    <input type="text" name="top"
                                           class="form-control @error('top') is-invalid @enderror @if (!$errors->has('top') && old('top')) is-valid @endif"
                                           value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Facilitator</label>
                                <div class="col-sm-4">
                                    <input type="text" name="facilitator"
                                           class="form-control @error('facilitator') is-invalid @enderror @if (!$errors->has('facilitator') && old('facilitator')) is-valid @endif"
                                           value="">
                                </div>

                                <label class="col-sm-2 col-form-label">Analisa Kelayakan Investasi</label>
                                <div class="col-sm-4">
                                    <input type="text" name="aki"
                                           class="form-control @error('aki') is-invalid @enderror @if (!$errors->has('aki') && old('aki')) is-valid @endif"
                                           value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Attende</label>
                                <div class="col-sm-4">
                                    <input type="text" name="attende"
                                           class="form-control @error('attende') is-invalid @enderror @if (!$errors->has('attende') && old('attende')) is-valid @endif"
                                           value="">
                                </div>

                                <label class="col-sm-2 col-form-label"><b>Kesimpulan dan Rekomendasi</b></label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label"><b>Pembahasan dan Analisa</b></label>

                                <label class="col-sm-2 col-form-label">Catatan</label>
                                <div class="col-sm-4">
                                    <textarea name="catatan" class="form-control" style="height: 70px;"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Review Kelengkapan Administrasi</label>
                                <div class="col-sm-4">
                                    <input type="text" name="kelengkapan"
                                           class="form-control @error('kelengkapan') is-invalid @enderror @if (!$errors->has('kelengkapan') && old('kelengkapan')) is-valid @endif"
                                           value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Review Ketersediaan Anggaran</label>
                                <div class="col-sm-4">
                                    <input type="text" name="anggaran"
                                           class="form-control @error('anggaran') is-invalid @enderror @if (!$errors->has('anggaran') && old('anggaran')) is-valid @endif"
                                           value="">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-left">
                            <a href="{{ url('admin/jib/workspace/'.$pengajuan->id.'/editworkspace') }}"><button class="btn btn-light">Back</button></a>
                            <a href=""><button class="btn btn-success">Create</button></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection