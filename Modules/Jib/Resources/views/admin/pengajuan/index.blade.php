@extends('layouts.dashboard')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>@lang('jib::pengajuan.manage_pengajuan')</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a
                            href="{{ url('admin/jib/pengajuan') }}">@lang('jib::pengajuan.manage_pengajuan')</a></div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">@lang('jib::pengajuan.pengajuan_list')</h2>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            {{--<div class="col-sm-3">--}}
                                {{--<h4>@lang('jib::pengajuan.manage_pengajuan')</h4>--}}
                            {{--</div>--}}
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col mb-4 mb-lg-0 font-weight-bold text-center">
                                        <div>{{ $count_review + $count_approval }}</div>
                                        <div class="mt-2 badge badge-info">On Progress</div>
                                    </div>
                                    <div class="col mb-4 mb-lg-0 font-weight-bold text-center">
                                        <div>{{ $count_review }}</div>
                                        <div class="mt-2 badge badge-warning">Review</div>
                                    </div>
                                    <div class="col mb-4 mb-lg-0 font-weight-bold text-center">
                                        <div>{{ $count_approval }}</div>
                                        <div class="mt-2 badge badge-success">Approval</div>
                                    </div>
                                    <div class="col mb-4 mb-lg-0 font-weight-bold text-center">
                                        <div>{{ $count_closed }}</div>
                                        <div class="mt-2 badge badge-secondary">Closed</div>
                                    </div>
                                    <div class="col mb-4 mb-lg-0 font-weight-bold   text-center">
                                        <div>{{ $count_review + $count_approval + $count_closed}}</div>
                                        <div class="mt-2 badge badge-dark">Total</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('jib::admin.shared.flash')
                            @include('jib::admin.pengajuan._filter')
                            <div class="table-responsive">
                                <table id="pengajuan" class="table table-bordered table-striped table-sm ">
                                {{--<table class="class="table table-sm  table-bordered table-hover table-striped">--}}
                                    <thead>
                                    <th>No</th>
                                    <th>@lang('jib::pengajuan.initiaor_label')</th>
                                    <th>@lang('jib::pengajuan.segment_label')</th>
                                    <th>@lang('jib::pengajuan.customer_label')</th>
                                    <th>@lang('jib::pengajuan.kegiatan_label')</th>
                                    <th>@lang('jib::pengajuan.drp_label')</th>
                                    <th>@lang('jib::pengajuan.kategori_label')</th>
                                    <th>@lang('jib::pengajuan.nilai_capex_label')</th>
                                    {{--<th>@lang('jib::pengajuan.est_rev__label')</th>--}}
                                    {{--<th>@lang('jib::pengajuan.irr_label')</th>--}}
                                    {{--<th>@lang('jib::pengajuan.persubmit_label')</th>--}}
                                    {{--<th>@lang('jib::pengajuan.perclose_label')</th>--}}
                                    <th>@lang('jib::pengajuan.status_label')</th>
                                    {{--<th>@lang('jib::pengajuan.submitby_label')</th>--}}
                                    <th>@lang('jib::pengajuan.action_label')</th>
                                    </thead>
                                    <tbody>
                                    @forelse ($pengajuan as $peng)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{ $peng->nama_sub_unit }}</td>
                                            <td>{{ $peng->msegments->name }}</td>
                                            <td>{{ $peng->mcustomers->name }}</td>
                                            <td>{{ $peng->kegiatan }}</td>
                                            <td>{{ $peng->no_drp }}</td>
                                            <td>{{ $peng->mcategories->name }}</td>
                                            <td>{{ number_format($peng->nilai_capex) }}</td>
                                            {{--<td>{{ number_format($peng->est_revenue) }}</td>--}}
                                            {{--<td>{{ !empty($peng->irr) ? $peng->irr."%" : "-" }} </td>--}}
                                            {{--<td>{{ $peng->periode_up }}</td>--}}
                                            {{--<td>{{ $peng->periode_end }}</td>--}}
                                            <td>{{ $peng->mstatuses->name }}</td>
                                            {{--<td>{{ $peng->users->name }}</td>--}}
                                            <td>
                                                @if ($peng->trashed())
                                                    @can('delete_jib-pengajuan')
                                                        <a class="btn btn-sm btn-warning"
                                                           href="{{ url('admin/jib/pengajuan/'. $peng->id .'/restore')}}"><i
                                                                    class="fa fa-sync-alt"></i> @lang('jib::pengajuan.btn_restore_label')
                                                        </a>
                                                        <a href="{{ url('admin/jib/pengajuan/'. $peng->id) }}"
                                                           class="btn btn-sm btn-danger" onclick="
                                                                event.preventDefault();
                                                                if (confirm('Do you want to remove this permanently?')) {
                                                                document.getElementById('delete-role-{{ $peng->id }}').submit();
                                                                }">
                                                            <i class="far fa-trash-alt"></i> @lang('jib::pengajuan.btn_delete_permanent_label')
                                                        </a>
                                                        <form id="delete-role-{{ $peng->id }}"
                                                              action="{{ url('admin/jib/pengajuan/'. $peng->id) }}"
                                                              method="POST">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_permanent_delete" value="TRUE">
                                                            @csrf
                                                        </form>
                                                    @endcan
                                                @else
                                                    @can('view_jib-pengajuan')
                                                        <a class="btn btn-sm btn-info"
                                                           href="{{ url('admin/jib/pengajuan/'. $peng->id )}}"><i
                                                                    class="far fa-eye"></i> @lang('jib::pengajuan.btn_show_label')
                                                        </a>
                                                    @endcan
                                                    {{--@can('edit_jib-pengajuan')--}}
                                                        {{--<a class="btn btn-sm btn-success"--}}
                                                           {{--href="{{ url('admin/jib/pengajuan/'. $peng->id .'/edit')}}"><i--}}
                                                                    {{--class="far fa-edit"></i> @lang('jib::pengajuan.btn_edit_label')--}}
                                                        {{--</a>--}}
                                                    {{--@endcan--}}
                                                    @can('delete_jib-pengajuan')
                                                        <a href="{{ url('admin/jib/pengajuan/'. $peng->id) }}"
                                                           class="btn btn-sm btn-warning" onclick="
                                                                event.preventDefault();
                                                                if (confirm('Do you want to remove this?')) {
                                                                document.getElementById('delete-role-{{ $peng->id }}').submit();
                                                                }">
                                                            <i class="far fa-trash-alt"></i> @lang('jib::pengajuan.btn_delete_label')
                                                        </a>
                                                        <form id="delete-role-{{ $peng->id }}"
                                                              action="{{ url('admin/jib/pengajuan/'. $peng->id) }}"
                                                              method="POST">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            @csrf
                                                        </form>
                                                    @endcan
                                                @endif
                                            </td>
                                        </tr>
                                    @empty

                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{--{{ $posts->links() }}--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection