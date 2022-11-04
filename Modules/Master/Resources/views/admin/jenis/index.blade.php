@extends('layouts.dashboard')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Manage Jenis</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a
                            href="{{ url('admin/master/jenis') }}">Manage Jenis</a></div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">List of Jenis</h2>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            @include('master::admin.shared.flash')
                            @include('master::admin.jenis._filter')
                            <div class="table-responsive">
                                <table id="jenis" class="table table-bordered table-striped table-sm ">
                                    <thead>
                                    <th>No</th>
                                    <th>Nama Jenis</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    @forelse ($jeniss as $jenis)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{ $jenis->name }}</td>
                                            <td>
                                                {{--@can('view_master-jenis')--}}
                                                    {{--<a class="btn btn-sm btn-primary"--}}
                                                       {{--href="{{ url('admin/master/jenis/'. $jenis->id )}}"><i--}}
                                                                {{--class="far fa-eye"></i>--}}
                                                        {{--Show--}}
                                                    {{--</a>--}}
                                                {{--@endcan--}}
                                                @can('edit_master-jenis')
                                                    <a class="btn btn-sm btn-warning"
                                                       href="{{ url('admin/master/jenis/'. $jenis->id .'/edit')}}"><i
                                                                class="far fa-edit"></i>
                                                        Edit
                                                    </a>
                                                @endcan
                                                @can('delete_master-jenis')
                                                    <a href="{{ url('admin/master/jenis/'. $jenis->id) }}"
                                                       class="btn btn-sm btn-danger" onclick="
                                                            event.preventDefault();
                                                            if (confirm('Do you want to remove this?')) {
                                                            document.getElementById('delete-role-{{ $jenis->id }}').submit();
                                                            }">
                                                        <i class="far fa-trash-alt"></i>
                                                        Delete
                                                    </a>
                                                    <form id="delete-role-{{ $jenis->id }}"
                                                          action="{{ url('admin/master/jenis/'. $jenis->id) }}"
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