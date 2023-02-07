@extends('layouts.dashboard')
@push('custom-css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- <link rel="stylesheet" href="../node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css"> -->
<!-- <link rel="stylesheet" href="../node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css"> -->
<style>
    .dt-body-nowrap {
        white-space: nowrap;
    }
</style>
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
                        <!-- <div class="card-header-form"> -->
                        @include('master::admin.budget._filter')
                        <!-- </div> -->
                    </div>
                    <div class="card-body">
                        @include('master::admin.shared.flash')
                        <div class="table-responsive">
                            <table id="tbl_budget" class="table table-bordered table-striped nowrap no-footer" role='grid' aria-describedby="tbl_budget_info">
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
                                    <th>Program</th>
                                    <th>Nilai Program</th>
                                    <th>Nilai Realisasi</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
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
            scrollx: true,
            processing: true,
            serverSide: true,
            lengthMenu: [
                [10, 20, 50, 75, -1],
                [10, 20, 50, 75, "All"]
            ],
            ajax: "{{ url('admin/master/budget') }}",
            language: {
                decimal: "-",
                thousands: "."
            },
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
                    render: $.fn.dataTable.render.number( '.', ',' )
                },
                {
                    data: 'nilai_realisasi',
                    name: 'nilai_realisasi',
                    render: $.fn.dataTable.render.number( '.', ',' )
                },

                {
                    data: 'created_at',
                    name: 'created_at',
                    render: $.fn.dataTable.render.date( 'D-MMMM-YYYY | HH:m:s' )
                }, {
                    data: 'updated_at',
                    name: 'updated_at',
                    render: $.fn.dataTable.render.date( 'D-MMMM-YYYY | HH:m:s' )
                },

            ],
            order: [
                [0, 'asc']
            ]
        });
    });
</script>
<script>
    $("#m-upload").fireModal({
        title: 'Upload Budget',
        body: $("#modal-upload-part"),
        footerClass: 'bg-whitesmoke',
        autoFocus: false,
        onFormSubmit: function(modal, e, form) {
            console.log(form);
        },
        // onFormSubmit: function(modal, e, form) {
        //     // Form Data
        //     let form_data = $(e.target).serialize();
        //     console.log(form_data)

        //     let files = $('#file_upload_rkap')[0].files;

        //     if (files.length > 0) {
        //         var fd = new FormData();

        //         // Append data 
        //         fd.append('file_upload_rkap', files[0]);
        //         // fd.append('_token', form_data);

        //         // DO AJAX HERE
        //         let fake_ajax = setTimeout(function() {
        //             form.stopProgress();
        //             modal.find('.modal-body').prepend('<div class="alert alert-info">Budget upload Successfully</div>')

        //             clearInterval(fake_ajax);
        //         }, 1500);

        //         // $.ajaxSetup({
        //         //     headers: {
        //         //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         //     }
        //         // });
        //         // AJAX request 
        //         $.ajax({
        //             url: "{{route('master-budget.import')}}",
        //             method: 'post',
        //             data: fd,
        //             contentType: false,
        //             processData: false,
        //             dataType: 'json',
        //             success: function(response) {
        //                 form.stopProgress();
        //                 if (response.success == 1) { // Uploaded successfully
        //                     alert('susccess');
        //                 } else if (response.success == 2) { // File not uploaded
        //                     alert('gagal');
        //                 } else {

        //                 }
        //             },
        //             error: function(response) {
        //                 console.log("error : " + JSON.stringify(response));
        //             }
        //         });
        //     } else {
        //         alert("Please select a file.");
        //     }

        //     e.preventDefault();
        // },
        shown: function(modal, form) {
            // console.log(form)
        },
        buttons: [{
            text: 'Submit',
            submit: true,
            class: 'btn btn-primary btn-shadow',
            handler: function(modal) {}
        }]
    });
</script>
@endpush