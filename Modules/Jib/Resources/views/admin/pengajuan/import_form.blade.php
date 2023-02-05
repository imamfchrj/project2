@extends('layouts.dashboard')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>@lang('jib::pengajuan.import_realisasi')</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ url('admin/jib/realisasi') }}">@lang('jib::pengajuan.import_realisasi')</a></div>
        </div>
    </div>
    {!! Form::open(['url' => 'admin/jib/realisasi/upload', 'files'=>true]) !!}
    @csrf
    <div class="section-body">
        <h2 class="section-title">
            Upload Realisasi JIB
        </h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Upload Realisasi
                        </h4>
                    </div>
                    <div class="card-body">
                        @include('jib::admin.shared.flash')
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="col-sm-2 col-form-label">File Upload</label>
                            <div class="col-sm-5">
                                <!-- @if (!empty($pengajuan) && $pengajuan->featured_image)
                                <img src="{{ $pengajuan->featured_image }}" alt="{{ $pengajuan->featured_image_caption }}" class="img-fluid img-thumbnail" />
                                @endif -->
                                <input type="file" name="file_realisasi" class="form-control btn primary" />
                            </div>
                            @error('file_realisasi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
              
                    <div class="card-footer text-left">
                        <button id="btn_realisasi" class="btn btn-primary">Submit</button>
                    </div>
                </div>
                <!-- Card Upload History -->
                <div class="card" id="realisasi_history">
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
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    
</section>
@endsection
@push('custom-script')
@endpush