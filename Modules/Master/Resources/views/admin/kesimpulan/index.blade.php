@extends('layouts.dashboard')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Manage Kesimpulan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a
                            href="{{ url('admin/master/kesimpulan') }}">Manage Kesimpulan</a></div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">List of Kesimpulan</h2>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            @include('master::admin.shared.flash')
                            @include('master::admin.kesimpulan._filter')
                            <div class="table-responsive">
                                <table id="kesimpulan" class="table table-bordered table-striped table-sm ">
                                    <thead>
                                    <th>No</th>
                                    <th>Nama Kesimpulan</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    @forelse ($kesimpulans as $kesimpulan)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{ $kesimpulan->name }}</td>
                                            <td>
                                                {{--@can('view_master-kesimpulan')--}}
                                                    {{--<a class="btn btn-sm btn-primary"--}}
                                                       {{--href="{{ url('admin/master/kesimpulan/'. $kesimpulan->id )}}"><i--}}
                                                                {{--class="far fa-eye"></i>--}}
                                                        {{--Show--}}
                                                    {{--</a>--}}
                                                {{--@endcan--}}
                                                @can('edit_master-kesimpulan')
                                                    <a class="btn btn-sm btn-warning"
                                                       href="{{ url('admin/master/kesimpulan/'. $kesimpulan->id .'/edit')}}"><i
                                                                class="far fa-edit"></i>
                                                        Edit
                                                    </a>
                                                @endcan
                                                @can('delete_master-kesimpulan')
                                                    <a href="{{ url('admin/master/kesimpulan/'. $kesimpulan->id) }}"
                                                       class="btn btn-sm btn-danger" onclick="
                                                            event.preventDefault();
                                                            if (confirm('Do you want to remove this?')) {
                                                            document.getElementById('delete-role-{{ $kesimpulan->id }}').submit();
                                                            }">
                                                        <i class="far fa-trash-alt"></i>
                                                        Delete
                                                    </a>
                                                    <form id="delete-role-{{ $kesimpulan->id }}"
                                                          action="{{ url('admin/master/kesimpulan/'. $kesimpulan->id) }}"
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