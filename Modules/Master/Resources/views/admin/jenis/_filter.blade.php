@php
    $route = 'admin/master/jenis';

@endphp

{!! Form::open(['url' => $route, 'method' => 'GET']) !!}
    <div class="form-row">
        <div class="form-group col-md-4">
            <input type="text" name="q" class="form-control" id="q" placeholder="Type keywords..." value="{{ !empty($filter['q']) ? $filter['q'] : '' }}">
        </div>
        <div class="form-group col-md-2">
            <button class="btn btn-block btn-primary btn-filter"><i class="fas fa-search"></i> Search</button>
        </div>
        <div class="form-group col-md-2">
            @can('add_master-jenis')
                <a href="{{ url('admin/master/jenis/create') }}" class="btn btn-icon btn-block icon-left btn-success btn-filter"><i class="fas fa-plus-circle"></i> Create</a>
            @endcan
        </div>
    </div>
{!! Form::close() !!}
