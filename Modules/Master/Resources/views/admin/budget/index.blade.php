@extends('layouts.dashboard')
@push('custom-css')
<link  href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @include('master::admin.shared.flash')
                        @include('master::admin.budget._filter')
                        <div class="table-responsive">
                            <table id="tbl_budget" class="table table-bordered table-striped table-sm ">
                                <thead>
                                    <th>ID</th>
                                    <th>BA</th>
                                    <th>DRP</th>
                                    <th>Cost Center</th>
                                    <th>CC Name</th>
                                    <th>Program</th>
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

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#tbl_budget').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/master/budget') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'ba',
                    name: 'ba'
                },
                {
                    data: 'no_drp',
                    name: 'no_drp'
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
                    name: 'nilai_program'
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