@extends('layouts.dashboard')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Manage Anggaran</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a
                            href="{{ url('admin/master/anggaran') }}">Manage Anggaran</a></div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">List of Anggarans</h2>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @include('master::admin.shared.flash')
                            @include('master::admin.anggaran._filter')
                            <div class="table-responsive">
                                <table id="tbl_anggaran" class="table table-bordered table-striped table-sm ">
                                    <thead>
                                    <th>No</th>
                                    <th>Nama Anggaran</th>
                                    <th>Action</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('custom-script')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#tbl_anggaran').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('admin/master/anggaran') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [
                    [0, 'asc']
                ]
            });
        });
    </script>
@endpush

{{--<tbody>--}}
{{--@forelse ($anggarans as $anggaran)--}}
    {{--<tr>--}}
        {{--<td>{{$loop->iteration}}</td>--}}
        {{--<td>{{ $anggaran->name }}</td>--}}
        {{--<td>--}}
            {{--@can('view_master-anggaran')--}}
                {{--<a class="btn btn-sm btn-primary"--}}
                   {{--href="{{ url('admin/master/anggaran/'. $anggaran->id )}}"><i--}}
                            {{--class="far fa-eye"></i>--}}
                    {{--Show--}}
                {{--</a>--}}
            {{--@endcan--}}
            {{--@can('edit_master-anggaran')--}}
                {{--<a class="btn btn-sm btn-warning"--}}
                   {{--href="{{ url('admin/master/anggaran/'. $anggaran->id .'/edit')}}"><i--}}
                            {{--class="far fa-edit"></i>--}}
                    {{--Edit--}}
                {{--</a>--}}
            {{--@endcan--}}
            {{--@can('delete_master-anggaran')--}}
                {{--<a href="{{ url('admin/master/anggaran/'. $anggaran->id) }}"--}}
                   {{--class="btn btn-sm btn-danger" onclick="--}}
                        {{--event.preventDefault();--}}
                        {{--if (confirm('Do you want to remove this?')) {--}}
                        {{--document.getElementById('delete-role-{{ $anggaran->id }}').submit();--}}
                        {{--}">--}}
                    {{--<i class="far fa-trash-alt"></i>--}}
                    {{--Delete--}}
                {{--</a>--}}
                {{--<form id="delete-role-{{ $anggaran->id }}"--}}
                      {{--action="{{ url('admin/master/anggaran/'. $anggaran->id) }}"--}}
                      {{--method="POST">--}}
                    {{--<input type="hidden" name="_method" value="DELETE">--}}
                    {{--@csrf--}}
                {{--</form>--}}
            {{--@endcan--}}
        {{--</td>--}}
    {{--</tr>--}}
{{--@empty--}}

{{--@endforelse--}}
{{--</tbody>--}}