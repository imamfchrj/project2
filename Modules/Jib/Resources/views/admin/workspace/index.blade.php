@extends('layouts.dashboard')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>JIB WORKSPACE</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a
                            href="{{ url('admin/jib/workspace') }}">Manage Workspace</a></div>
            </div>
        </div>
        <div class="section-body">
            {{--<h2 class="section-title">@lang('jib::pengajuan.pengajuan_list')</h2>--}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="col-sm-3">
                                <h4>LIST OF WORKSPACE</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('jib::admin.shared.flash')
                            @include('jib::admin.workspace._filter')
                            <div class="table-responsive">
                                <table id="workspace" class="table table-bordered table-striped table-sm" style="min-width: max-content">
                                    <thead>
                                    <th style="padding: 10px;">No</th>
                                    <th style="padding: 10px;">@lang('jib::pengajuan.jib_number')</th>
                                    <th style="padding: 10px;">@lang('jib::pengajuan.initiaor_label')</th>
                                    <th style="padding: 10px;">@lang('jib::pengajuan.segment_label')</th>
                                    <th style="padding: 10px;">@lang('jib::pengajuan.customer_label')</th>
                                    <th style="padding: 10px;">@lang('jib::pengajuan.kegiatan_label')</th>
                                    <th style="padding: 10px;">@lang('jib::pengajuan.drp_label')</th>
                                    <th style="padding: 10px;">@lang('jib::pengajuan.kategori_label')</th>
                                    <th style="padding: 10px;">@lang('jib::pengajuan.nilai_capex_label')</th>
                                    <th style="padding: 10px;">@lang('jib::pengajuan.status_label')</th>
                                    <th style="padding: 10px;">@lang('jib::pengajuan.action_label')</th>
                                    </thead>
                                    <tbody>
                                    @forelse ($pengajuan as $peng)
                                        <tr>
                                            <td style="padding: 10px;">{{$loop->iteration}}</td>
                                            <td style="padding: 10px;">{{ $peng->jib_number }}</td>
                                            <td style="padding: 10px;">{{ $peng->nama_sub_unit }}</td>
                                            <td style="padding: 10px;">{{ $peng->msegments->name }}</td>
                                            <td style="padding: 10px;">{{ !empty($peng->mcustomers->name) ? $peng->mcustomers->name : '-' }}</td>
                                            <td style="padding: 10px;">{{ $peng->kegiatan }}</td>
                                            <td style="padding: 10px;">{{ $peng->no_drp }}</td>
                                            <td style="padding: 10px;">{{ $peng->mcategories->name }}</td>
                                            <td style="padding: 10px;">{{ number_format($peng->nilai_capex) }}</td>
                                            @if ($peng->status_id == 7) <!-- Draft -->
                                                <td style="padding: 10px;">
                                                    <div class="mt-1 badge badge-info">{{ $peng->mstatuses->name.' - '.$peng->users->name}}</div>
                                                </td>
                                            @elseif ($peng->status_id == 8) <!-- Initiator -->
                                                <td style="padding: 10px;">
                                                    <div class="mt-1 badge badge-info">{{ $peng->mstatuses->name }}</div>
                                                </td>
                                            @elseif ($peng->status_id == 6) <!-- Closed -->
                                                <td style="padding: 10px;">
                                                    <div class="mt-1 badge badge-secondary">{{ $peng->mstatuses->name }}</div>
                                                </td>
                                            @elseif ($peng->status_id == 5) <!-- Approval -->
                                                <td style="padding: 10px;">
                                                    <div class="mt-1 badge badge-success">{{ $peng->mstatuses->name.' - '.$peng->mpemeriksa->nama }}</div>
                                                </td>
                                            @elseif ($peng->status_id == 9) <!-- Rejected -->
                                                <td style="padding: 10px;">
                                                    <div class="mt-1 badge badge-danger">{{ $peng->mstatuses->name.' - '.$peng->mpemeriksa->nama }}</div>
                                                </td>
                                            @else <!-- Reviewer -->
                                                <td style="padding: 10px;">
                                                    <div class="mt-1 badge badge-warning">{{ $peng->mstatuses->name.' - '.$peng->mpemeriksa->nama }}</div>
                                                </td>
                                            @endif
                                            <td style="padding: 10px;">
                                                @can('edit_jib-pengajuan')
                                                    <!-- <a class="btn btn-sm btn-light"
                                                    href="{{ url('admin/jib/workspace/'. $peng->pengajuan_id .'/editworkspace')}}"><i
                                                                class="far fa-edit"></i>
                                                        {{--@lang('jib::pengajuan.btn_edit_label')--}}
                                                    </a> -->
                                                    <!-- pakai ID pengajuan bukan di reviewer karena draft blm ada di reviewer -->
                                                    <a class="btn btn-sm btn-light"
                                                    href="{{ url('admin/jib/workspace/'. $peng->id .'/editworkspace')}}"><i
                                                                class="far fa-edit"></i>
                                                        {{--@lang('jib::pengajuan.btn_edit_label')--}}
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-header">
                                <h4 class="text-md-right">
                                    Showing
                                    {{ $pengajuan->firstItem() }}
                                    to
                                    {{ $pengajuan->lastItem() }}
                                    of
                                    {{ $pengajuan->total() }}
                                    Entries
                                </h4>
                                <div class="card-header-action">
                                    {{ $pengajuan->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection