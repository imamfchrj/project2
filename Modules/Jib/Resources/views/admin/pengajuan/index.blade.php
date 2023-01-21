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
                            @if($viewTrash == false)
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col mb-4 mb-lg-0 font-weight-bold text-center">
                                        <div>{{ $count_draft }}</div>
                                        <div class="mt-2 badge badge-info">Draft</div>
                                    </div>
                                    <div class="col mb-4 mb-lg-0 font-weight-bold text-center">
                                        <div>{{ $count_initiator }}</div>
                                        <div class="mt-2 badge badge-info">Initiator</div>
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
                                    <div class="col mb-4 mb-lg-0 font-weight-bold text-center">
                                        <div>{{ $count_rejected }}</div>
                                        <div class="mt-2 badge badge-danger">Rejected</div>
                                    </div>
                                    <div class="col mb-4 mb-lg-0 font-weight-bold   text-center">
                                        <div>{{ $count_review + $count_approval + $count_closed + $count_draft + $count_initiator + $count_rejected}}</div>
                                        <div class="mt-2 badge badge-dark">Total</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="card-body">
                            @include('jib::admin.shared.flash')
                            @include('jib::admin.pengajuan._filter')
                            <div class="table-responsive">
                                <table id="pengajuan" class="table table-bordered table-striped table-sm" style="min-width: max-content">
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
                                    <th style="padding: 10px;">@lang('jib::pengajuan.usia_dokumen')</th>
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
                                                <td style="padding: 10px;"><div class="mt-1 badge badge-info">{{ $peng->mstatuses->name.' - '.$peng->users->name}}</div></td>
                                            @elseif ($peng->status_id == 8) <!-- Initiator -->
                                                <td style="padding: 10px;"><div class="mt-1 badge badge-info">{{ $peng->mstatuses->name }}</div></td>
                                            @elseif ($peng->status_id == 6) <!-- Closed -->
                                                <td style="padding: 10px;"><div class="mt-1 badge badge-secondary">{{ $peng->mstatuses->name }}</div></td>
                                            @elseif ($peng->status_id == 5) <!-- Approval -->
                                                <td style="padding: 10px;"><div class="mt-1 badge badge-success">{{ $peng->mstatuses->name.' - '.$peng->mpemeriksa->nama }}</div></td>
                                            @elseif ($peng->status_id == 9) <!-- Rejected -->
                                                <td style="padding: 10px;"><div class="mt-1 badge badge-danger">{{ $peng->mstatuses->name.' - '.$peng->mpemeriksa->nama }}</div></td>
                                            @else <!-- Reviewer -->
                                                <td style="padding: 10px;"><div class="mt-1 badge badge-warning">{{ $peng->mstatuses->name.' - '.$peng->mpemeriksa->nama }}</div></td>
                                            @endif
                                            <td style="padding: 10px;">{{ $peng->aging.' Hari' }}</td>
                                            <td style="padding: 10px;">
                                                @if ($peng->trashed())
                                                    @can('delete_jib-pengajuan')
                                                        <a class="btn btn-sm btn-warning"
                                                           href="{{ url('admin/jib/pengajuan/'. $peng->id .'/restore')}}"><i
                                                                    class="fa fa-sync-alt"></i>
                                                        </a>
                                                        <a href="{{ url('admin/jib/pengajuan/'. $peng->id) }}"
                                                           class="btn btn-sm btn-danger" onclick="
                                                                event.preventDefault();
                                                                if (confirm('Do you want to remove this permanently?')) {
                                                                document.getElementById('delete-role-{{ $peng->id }}').submit();
                                                                }">
                                                            <i class="far fa-trash-alt"></i>
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
                                                        <a class="btn btn-sm btn-primary"
                                                           href="{{ url('admin/jib/pengajuan/'. $peng->id )}}"><i
                                                                    class="far fa-eye"></i>
                                                        </a>
                                                    @endcan
                                                    @can('delete_jib-pengajuan')
                                                        <a href="{{ url('admin/jib/pengajuan/'. $peng->id) }}"
                                                           class="btn btn-sm btn-danger" onclick="
                                                                event.preventDefault();
                                                                if (confirm('Do you want to remove this?')) {
                                                                document.getElementById('delete-role-{{ $peng->id }}').submit();
                                                                }">
                                                            <i class="far fa-trash-alt"></i>
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