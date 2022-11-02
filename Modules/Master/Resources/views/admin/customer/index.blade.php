@extends('layouts.dashboard')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Manage Customer</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a
                            href="{{ url('admin/master/customer') }}">Manage Customer</a></div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">List of Customers</h2>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="col-sm-3">
                                <h4>Manage Pengajuan</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            {{--@include('jib::admin.shared.flash')--}}
                            {{--@include('jib::admin.pengajuan._filter')--}}
                            <div class="table-responsive">
                                <table id="customer" class="table table-bordered table-striped table-sm ">
                                {{--<table class="class="table table-sm  table-bordered table-hover table-striped">--}}
                                    <thead>
                                    <th>No</th>
                                    <th>Nama Customer</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    @forelse ($customers as $customer)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{ $customer->name }}</td>
                                            <td>
                                                @can('view_master-customer')
                                                    <a class="btn btn-sm btn-primary"
                                                       href="{{ url('admin/master/customer/'. $customer->id )}}"><i
                                                                class="far fa-eye"></i>
                                                        Show
                                                    </a>
                                                @endcan
                                                @can('edit_master-customer')
                                                    <a class="btn btn-sm btn-success"
                                                       href="{{ url('admin/master/customer/'. $customer->id .'/edit')}}"><i
                                                                class="far fa-edit"></i>
                                                        Edit
                                                    </a>
                                                @endcan
                                                @can('delete_master-customer')
                                                    <a href="{{ url('admin/master/customer/'. $customer->id) }}"
                                                       class="btn btn-sm btn-danger" onclick="
                                                            event.preventDefault();
                                                            if (confirm('Do you want to remove this?')) {
                                                            document.getElementById('delete-role-{{ $customer->id }}').submit();
                                                            }">
                                                        <i class="far fa-trash-alt"></i>
                                                        Delete
                                                    </a>
                                                    <form id="delete-role-{{ $customer->id }}"
                                                          action="{{ url('admin/master/customer/'. $customer->id) }}"
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