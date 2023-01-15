@extends('layouts.dashboard')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Manage Segment</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a
                            href="{{ url('admin/master/segment') }}">Manage Segment</a></div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">List of Segments</h2>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            @include('master::admin.shared.flash')
                            @include('master::admin.segment._filter')
                            <div class="table-responsive">
                                <table id="segment" class="table table-bordered table-striped table-sm ">
                                    <thead>
                                    <th>No</th>
                                    <th>Nama Segment</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    @forelse ($segments as $segment)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{ $segment->name }}</td>
                                            <td>
                                                {{--@can('view_master-segment')--}}
                                                    {{--<a class="btn btn-sm btn-primary"--}}
                                                       {{--href="{{ url('admin/master/segment/'. $segment->id )}}"><i--}}
                                                                {{--class="far fa-eye"></i>--}}
                                                        {{--Show--}}
                                                    {{--</a>--}}
                                                {{--@endcan--}}
                                                @can('edit_master-segment')
                                                    <a class="btn btn-sm btn-warning"
                                                       href="{{ url('admin/master/segment/'. $segment->id .'/edit')}}"><i
                                                                class="far fa-edit"></i>
                                                        Edit
                                                    </a>
                                                @endcan
                                                @can('delete_master-segment')
                                                    <a href="{{ url('admin/master/segment/'. $segment->id) }}"
                                                       class="btn btn-sm btn-danger" onclick="
                                                            event.preventDefault();
                                                            if (confirm('Do you want to remove this?')) {
                                                            document.getElementById('delete-role-{{ $segment->id }}').submit();
                                                            }">
                                                        <i class="far fa-trash-alt"></i>
                                                        Delete
                                                    </a>
                                                    <form id="delete-role-{{ $segment->id }}"
                                                          action="{{ url('admin/master/segment/'. $segment->id) }}"
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