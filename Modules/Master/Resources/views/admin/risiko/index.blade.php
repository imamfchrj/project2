@extends('layouts.dashboard')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Manage Risiko</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a
                            href="{{ url('admin/master/risiko') }}">Manage Risiko</a></div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">List of Risiko</h2>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            @include('master::admin.shared.flash')
                            @include('master::admin.risiko._filter')
                            <div class="table-responsive">
                                <table id="risiko" class="table table-bordered table-striped table-sm ">
                                    <thead>
                                    <th>No</th>
                                    <th>Nama Risiko</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    @forelse ($risikos as $risiko)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{ $risiko->name }}</td>
                                            <td>
                                                {{--@can('view_master-risiko')--}}
                                                    {{--<a class="btn btn-sm btn-primary"--}}
                                                       {{--href="{{ url('admin/master/risiko/'. $risiko->id )}}"><i--}}
                                                                {{--class="far fa-eye"></i>--}}
                                                        {{--Show--}}
                                                    {{--</a>--}}
                                                {{--@endcan--}}
                                                @can('edit_master-risiko')
                                                    <a class="btn btn-sm btn-warning"
                                                       href="{{ url('admin/master/risiko/'. $risiko->id .'/edit')}}"><i
                                                                class="far fa-edit"></i>
                                                        Edit
                                                    </a>
                                                @endcan
                                                @can('delete_master-risiko')
                                                    <a href="{{ url('admin/master/risiko/'. $risiko->id) }}"
                                                       class="btn btn-sm btn-danger" onclick="
                                                            event.preventDefault();
                                                            if (confirm('Do you want to remove this?')) {
                                                            document.getElementById('delete-role-{{ $risiko->id }}').submit();
                                                            }">
                                                        <i class="far fa-trash-alt"></i>
                                                        Delete
                                                    </a>
                                                    <form id="delete-role-{{ $risiko->id }}"
                                                          action="{{ url('admin/master/risiko/'. $risiko->id) }}"
                                                          method="POST">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        @csrf
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty

                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection