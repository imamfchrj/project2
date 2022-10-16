@php
    $route = 'admin/jib/workspace';
@endphp

{!! Form::open(['url' => $route, 'method' => 'GET']) !!}
    <div class="form-row">
        <div class="form-group col-md-2">
            <input type="text" name="q" class="form-control" id="q" placeholder="Type keywords..." value="{{ !empty($filter['q']) ? $filter['q'] : '' }}">
        </div>
        {{--<div class="form-group col-md-2">--}}
            {{--{!! Form::select('status', $statuses, !empty($filter['status']) ? $filter['status'] : old('status'), ['class' => 'form-control', 'placeholder' => '-- Status --']) !!}--}}
        {{--</div>--}}
        <div class="form-group col-md-2">
            {!! Form::select('segment', $segments, !empty($filter['segment']) ? $filter['segment'] : old('segment'), ['class' => 'form-control', 'placeholder' => '-- Segment --']) !!}
        </div>
        <div class="form-group col-md-2">
            {!! Form::select('customer', $customers, !empty($filter['customer']) ? $filter['customer'] : old('customer'), ['class' => 'form-control', 'placeholder' => '-- Customer --']) !!}
        </div>
        <div class="form-group col-md-1">
            <button class="btn btn-block btn-primary btn-filter"><i class="fas fa-search"></i> {{ __('general.btn_search_label') }}</button>
        </div>
    </div>
{!! Form::close() !!}
