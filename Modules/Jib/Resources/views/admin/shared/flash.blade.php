@if ($errors->any())
    <div class="alert alert-warning">
        <div class="alert-title">Whoops!</div>
        @lang('jib::general.validation_error_message')
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div> 
@endif

@if (session('success'))
    <div class="alert alert-success">@lang('jib::pengajuan.success_create_message')</div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif