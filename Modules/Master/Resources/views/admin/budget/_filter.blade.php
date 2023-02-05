@php
$route = 'admin/master/budget';
@endphp

{!! Form::open(['url' => $route, 'method' => 'GET']) !!}
<div class="form-row">
    <div class="form-group">
        @can('add_master-budget')
        <a href="{{ url('admin/master/budget/download') }}" class="btn btn-icon btn-block icon-left btn-success btn-filter"><i class="fas fa-download"></i> Download</a>
        @endcan
    </div>
</div>


<div class="form-row card-header-action">
    {!! Form::open(['url' => 'admin/master/budget/upload', 'files'=>true]) !!}
    <div class="form-group ">
        <input type="file" name="budget_upload" class="form-control" id="budget_upload" placeholder="Pilih File">
    </div>
    <div class="form-group pull-right">
        @can('add_master-budget')
        <input type="submit" class="btn btn-icon btn-block icon-left btn-info btn-filter" value="Upload">
        <!-- <a href="{{ url('admin/master/budget/upload') }}" class="btn btn-icon btn-block icon-left btn-info btn-filter"><i class="fas fa-upload"></i> Upload Realisasi</a> -->
        @endcan
    </div>
    {!! Form::close() !!}
</div>

{!! Form::close() !!}