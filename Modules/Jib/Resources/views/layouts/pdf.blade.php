@if($pengajuan->kategori_id == 1 && $pengajuan->jenis_id == 1)
    @include('jib::layouts.temp_capexbisnis')
@elseif($pengajuan->kategori_id == 1 && $pengajuan->jenis_id == 2)
    @include('jib::layouts.temp_opexbisnis')
@elseif(($pengajuan->kategori_id == 1 && $pengajuan->jenis_id == 2) || ($pengajuan->kategori_id == 2 && $pengajuan->jenis_id == 2))
    @include('jib::layouts.temp_capexopexsupport')
@else
    @include('jib::layouts.temp_bisnismom')
@endif
