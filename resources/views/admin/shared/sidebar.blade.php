@php
    $activeClass = 'active';
@endphp
<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        {{--<a href="{{ url('/')}}">{{ config('app.name', 'Laravel') }}</a>--}}
        <img class="my-3" src="{{ asset('admin/logo/Picture1qqqq.png') }}" height="70px" width="90px" />
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        {{--<a href="{{ url('/')}}">LS</a>--}}
    </div>
    <ul class="sidebar-menu my-5">
        <li class="{{ ($currentAdminMenu == 'dashboard') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/dashboard') }}"><i class="fab fa-dashcube"></i> <span>Dashboard</span></a></li>
        @foreach ($moduleAdminMenus as $moduleAdminMenu)
            <li class="menu-header">{{ $moduleAdminMenu['module'] }}</li>
            @foreach ($moduleAdminMenu['admin_menus'] as $moduleMenu)
                @can($moduleMenu['permission'])
                    <li class="{{ ($currentAdminMenu == strtolower($moduleMenu['name'])) ? $activeClass : '' }}"><a class="nav-link" href="{{ url($moduleMenu['route'])}}"><i class="{{ $moduleMenu['icon'] }}"></i> <span>{{ $moduleMenu['name'] }}</span></a></li>
                @endcan
            @endforeach
        @endforeach
        <li class="menu-header">@lang('general.menu_account_label')</li>
        @can('view_users')
            <li class="{{ ($currentAdminMenu == 'users') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/users')}}"><i class="fas fa-user"></i> <span>Users</span></a></li>
        @endcan
        @can('view_roles')
            <li class="{{ ($currentAdminMenu == 'roles') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/roles')}}"><i class="fas fa-lock"></i> <span>@lang('roles.menu_role_label')</span></a></li>
        @endcan
        @if (auth()->user()->hasRole(\App\Models\Role::ADMIN))
            {{--<li class="{{ ($currentAdminMenu == 'settings') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/settings')}}"><i class="fas fa-cogs"></i> <span>@lang('settings.menu_settings_label')</span></a></li>--}}
        @endif
        @if (auth()->user()->hasRole(\App\Models\Role::ADMIN) || auth()->user()->roles[0]->name == "Reviewer")
            <li class="{{ ($currentAdminMenu == 'user_login_his') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/users_login_his')}}"><i class="fas fa-cogs"></i> <span>User Login History</span></a></li>
        @endif
    </ul>
</aside>
