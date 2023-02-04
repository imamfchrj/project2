@extends('layouts.dashboard')

@push('custom-css')
<link  href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Manage User Login History</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ url('admin/users_login_his') }}">Manage User Login History</a></div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">List of User Login History</h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @include('admin.shared.flash')
                        @include('admin.users._filter')
                        <div class="table-responsive">
                            <table id="tbl_login_his" class="table table-bordered table-striped table-sm ">
                                <thead>
                                    <th>#ID</th>
                                    <th>NIK</th>
                                    <th>IP</th>
                                    <th>Browser</th>
                                    <th>OS</th>
                                    <th>Tanggal</th>
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
        $('#tbl_login_his').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/users_login_his') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'user_ip',
                    name: 'user_ip'
                },
                {
                    data: 'browser',
                    name: 'browser'
                },
                {
                    data: 'os',
                    name: 'os'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
            ],
            order: [
                [0, 'desc']
            ]
        });
    });
</script>
@endpush