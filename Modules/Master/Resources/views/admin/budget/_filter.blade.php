@php
$route = 'admin/master/budget';
@endphp

{!! Form::open(['url' => $route, 'method' => 'GET']) !!}
<div class="form-row pull-right">
    <div class="form-group col-md-2">
        @can('add_master-budget')
        <a href="{{ url('admin/master/budget/download') }}" class="btn btn-icon btn-block icon-left btn-success btn-filter"><i class="fas fa-download"></i> Download</a>
        @endcan
    </div>
    {!! Form::open(['url' => 'admin/master/budget/upload', 'files'=>true]) !!}
    <div class="form-group col-md-4">
        <input type="file" name="q" class="form-control" id="q" placeholder="Pilih File">
    </div>
    <div class="form-group col-md-2">
        @can('add_master-budget')
        <a href="{{ url('admin/master/budget/upload') }}" class="btn btn-icon btn-block icon-left btn-info btn-filter"><i class="fas fa-upload"></i> Upload Realisasi</a>
        @endcan
    </div>
    {!! Form::close() !!}
</div>
{!! Form::close() !!}