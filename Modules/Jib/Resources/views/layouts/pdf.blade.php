@if($pengajuan->kategori_id == 1 && $pengajuan->jenis_id == 1)
    @include('jib::layouts.temp_capexbisnis')
@elseif($pengajuan->kategori_id == 1 && $pengajuan->jenis_id == 2)
    @include('jib::layouts.temp_opexbisnis')
@else
    @include('jib::layouts.temp_capexopexsupport')
@endif