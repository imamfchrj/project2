@extends('layouts.dashboard')
@push('custom-css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- <link rel="stylesheet" href="../node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css"> -->
<!-- <link rel="stylesheet" href="../node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css"> -->
@endpush
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Manage Budget RKAP</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ url('admin/master/anggaran') }}">Manage Budget RKAP</a></div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">List of Budget RKAP</h2>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-form">
                            @include('master::admin.budget._filter')
                        </div>
                    </div>
                    <div class="card-body">
                        @include('master::admin.shared.flash')
                        <div class="table-responsive">
                            <table id="tbl_budget" class="table table-bordered table-striped dataTable no-footer" role='grid' aria-describedby="tbl_budget_info">
                                <thead>
                                    <th>ID</th>
                                    <th>Tahun</th>
                                    <th>Periode</th>
                                    <th>BA</th>
                                    <th>BA Name</th>
                                    <th>DRP</th>
                                    <th>Judul DRP</th>
                                    <th>Cost Center</th>
                                    <th>CC Name</th>
                                    <th style="width: 150px;">Program</th>
                                    <th>Nilai Program</th>
                                    <th>Nilai Realisasi</th>
                                    <th>Created at</th>
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
<!-- <script src="../node_modules/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="../node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script> -->
<!-- <script src="../node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js"></script> -->

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#tbl_budget').dataTable({
            autowidth: true,
            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/master/budget') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'tahun',
                    name: 'tahun'
                },
                {
                    data: 'periode',
                    name: 'periode'
                },
                {
                    data: 'ba',
                    name: 'ba'
                },
                {
                    data: 'ba_name',
                    name: 'ba_name'
                },
                {
                    data: 'no_drp',
                    name: 'no_drp'
                },
                {
                    data: 'nama_drp',
                    name: 'nama_drp'
                },
                {
                    data: 'cc',
                    name: 'cc'
                },
                {
                    data: 'cc_name',
                    name: 'cc_name'
                },
                {
                    data: 'program',
                    name: 'program'
                },
                {
                    data: 'nilai_program',
                    name: 'nilai_program',
                    "type": 'html-num'
                },
                {
                    data: 'nilai_realisasi',
                    name: 'nilai_realisasi'
                },

                {
                    data: 'created_at',
                    name: 'created_at'
                },
                // {
                //     data: 'action',
                //     name: 'action',
                //     orderable: false
                // },
            ],
            order: [
                [0, 'desc']
            ]
        });
    });
</script>
@endpush