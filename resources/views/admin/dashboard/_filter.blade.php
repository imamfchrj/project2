@php
$route = 'admin/dashboard';
@endphp

{!! Form::open(['url' => $route, 'method' => 'GET']) !!}
<div class="row" style="margin-top: 80px;">
    <div class="form-group col-sm-2 offset-md-6">
        {!! Form::select('bulan', $bulans, !empty($filter['bulan']) ? $filter['bulan'] : '<option value="0"> -- Pilih Bulan --</option>', ['class' => 'form-control browser-default select2', 'placeholder' => '-- Pilih Bulan --']) !!}
    </div>
    <div class="form-group col-sm-2">
        {!! Form::select('tahun', $tahuns, !empty($filter['tahun']) ? $filter['tahun'] : '<option value="0"> -- Pilih Tahun --</option>', ['class' => 'form-control browser-default select2', 'placeholder' => '-- Pilih Tahun --']) !!}
    </div>
    <div class="form-group col-sm-2 offset-xs-2">
        <button class="btn btn-block btn-success btn-filter"><i class="fas fa-search"></i> {{ __('general.btn_search_label') }}</button>
    </div>
</div>
{!! Form::close() !!}
<hr />