@php
$route = 'admin/master/budget';
@endphp
<h4>Budget List</h4>
<div class="card-header-action">
    @can('add_master-budget')
    <div class="dropdown">
        <a href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle">Options</a>
        <div class="dropdown-menu">

            <a href="{{ url('admin/master/budget/download') }}" class="dropdown-item has-icon"><i class="fas fa-download"></i> Download</a>
            <div class="dropdown-divider"></div>
            <a href="#" id="m-upload" class="dropdown-item has-icon"><i class="fas fa-file-import"></i> Upload</a>
        </div>
    </div>
    @endcan
</div>
<!-- {!! Form::open(['url' => $route, 'method' => 'GET']) !!}
<div class="form-row">
    <div class="form-group">
        @can('add_master-budget')
        <a href="{{ url('admin/master/budget/download') }}" class="btn btn-icon btn-block icon-left btn-success btn-filter"><i class="fas fa-download"></i> Download</a>
        @endcan
    </div>
</div> -->


<!-- <div class="form-row card-header-action">
    {!! Form::open(['url' => 'admin/master/budget/upload', 'files'=>true]) !!}
    <div class="form-group ">
        <input type="file" name="budget_upload" class="form-control" id="budget_upload" placeholder="Pilih File">
    </div>
    <div class="form-group pull-right">
        @can('add_master-budget')
        <input type="submit" class="btn btn-icon btn-block icon-left btn-info btn-filter" value="Upload"> -->
<!-- <a href="{{ url('admin/master/budget/upload') }}" class="btn btn-icon btn-block icon-left btn-info btn-filter"><i class="fas fa-upload"></i> Upload Realisasi</a> -->
<!-- @endcan
    </div>
    {!! Form::close() !!}
</div> -->

<!-- {!! Form::close() !!} -->

<!-- <form class="modal-part" id="modal-login-part"> -->
{!! Form::open(['url' => route('master-budget.import'), 'id'=>'modal-upload-part', 'files'=>true]) !!}
<!-- @csrf -->
<p>Pilih File Budget RKAP.</p>
<div class="form-group">
    <label></label>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="fas fa-file-import"></i>
            </div>
        </div>
        <input type="file" class="form-control" placeholder="pilih file" id="file_upload_rkap" name="file_upload_rkap">
    </div>
</div>
{!! Form::close() !!}
<!-- </form> -->
