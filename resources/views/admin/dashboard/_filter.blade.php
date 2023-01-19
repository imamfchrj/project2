@php
$route = 'admin/dashboard';
@endphp

{!! Form::open(['url' => $route, 'method' => 'POST', 'class' => 'inline']) !!}
<div class="row" style="margin-top: 80px;">
    <div class="form-group col-sm-2 offset-md-6">
        <input type="text" name="filter_bulan" placeholder="Bulan" class="form-control dtpick @error('filter_bulan') is-invalid @enderror @if (!$errors->has('filter_bulan') && old('filter_bulan')) is-valid @endif" value="{{ old('filter_bulan', !empty($user) ? filter_bulan : null) }}">
        @error('filter_bulan')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group col-sm-2">
        <input type="text" name="filte_tahun" placeholder="Tahun" class="form-control dtpick @error('filte_tahun') is-invalid @enderror @if (!$errors->has('filte_tahun') && old('filte_tahun')) is-valid @endif" value="{{ old('filte_tahun', !empty($user) ? filte_tahun : null) }}">
        @error('filte_tahun')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group col-sm-2 offset-xs-2">
        <button class="btn btn-block btn-success btn-filter"><i class="fas fa-search"></i> {{ __('general.btn_search_label') }}</button>
    </div>
</div>
{!! Form::close() !!}
<hr />