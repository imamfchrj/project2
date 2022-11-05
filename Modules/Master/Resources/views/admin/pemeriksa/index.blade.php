@extends('layouts.dashboard')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Manage Pemeriksa</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a
                            href="{{ url('admin/master/pemeriksa') }}">Manage Pemeriksa</a></div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">List of Pemeriksa</h2>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            @include('master::admin.shared.flash')
                            @include('master::admin.pemeriksa._filter')
                            <div class="table-responsive">
                                <table id="pemeriksa" class="table table-bordered table-striped table-sm ">
                                    <thead>
                                    <th>No</th>
                                    {{--<th>Rules</th>--}}
                                    <th>Rules</th>
                                    <th>Urutan</th>
                                    <th>Petugas</th>
                                    <th>Nik</th>
                                    <th>Nama</th>
                                    <th>Nama Posisi</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    @forelse ($pemeriksas as $pemeriksa)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            {{--<td>{{ $pemeriksa->rules }}</td>--}}
                                            <td>{{ $pemeriksa->keterangan }}</td>
                                            <td>{{ $pemeriksa->urutan }}</td>
                                            <td>{{ $pemeriksa->petugas }}</td>
                                            <td>{{ $pemeriksa->nik }}</td>
                                            <td>{{ $pemeriksa->nama }}</td>
                                            <td>{{ $pemeriksa->nama_posisi }}</td>
                                            <td>
                                                {{--@can('view_master-pemeriksa')--}}
                                                    {{--<a class="btn btn-sm btn-primary"--}}
                                                       {{--href="{{ url('admin/master/pemeriksa/'. $pemeriksa->id )}}"><i--}}
                                                                {{--class="far fa-eye"></i>--}}
                                                        {{--Show--}}
                                                    {{--</a>--}}
                                                {{--@endcan--}}
                                                @can('edit_master-pemeriksa')
                                                    <a class="btn btn-sm btn-warning"
                                                       href="{{ url('admin/master/pemeriksa/'. $pemeriksa->id .'/edit')}}"><i
                                                                class="far fa-edit"></i>
                                                        Edit
                                                    </a>
                                                @endcan
                                                @can('delete_master-pemeriksa')
                                                    <a href="{{ url('admin/master/pemeriksa/'. $pemeriksa->id) }}"
                                                       class="btn btn-sm btn-danger" onclick="
                                                            event.preventDefault();
                                                            if (confirm('Do you want to remove this?')) {
                                                            document.getElementById('delete-role-{{ $pemeriksa->id }}').submit();
                                                            }">
                                                        <i class="far fa-trash-alt"></i>
                                                        Delete
                                                    </a>
                                                    <form id="delete-role-{{ $pemeriksa->id }}"
                                                          action="{{ url('admin/master/pemeriksa/'. $pemeriksa->id) }}"
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