@extends('layouts.dashboard')

@push('custom-css')
    <link  href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Manage Notification</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ url('admin/notification') }}">Manage Notification</a></div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">List of Notifications</h2>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tbl_notification" class="table table-bordered table-striped table-sm ">
                                    <thead>
                                    <th>#ID</th>
                                    <th>Deskripsi</th>
                                    <th>Tipe</th>
                                    <th>From NIK</th>
                                    <th>From Name</th>
                                    <th>Created Date</th>
                                    <th>Read Date</th>
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
            $('#tbl_notification').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('admin/notification') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'deskripsi', name: 'deskripsi'},
                    {data: 'tipe', name: 'tipe'},
                    {data: 'nik', name: 'nik'},
                    {data: 'nama', name: 'nama'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'read_at', name: 'read_at'},
                ],
                order: [
                    [0, 'desc']
                ]
            });
        });
    </script>
@endpush