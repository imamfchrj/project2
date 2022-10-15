<style>
    .nested-pemeriksa {
        list-style: none;
    }

    .nested-pemeriksa li {
        margin-left: -30px;
    }

    .nested-pemeriksa-inner {
        padding: 1px;
        border: 1px solid #e3eaef;
        background: #f4f6f9;
        overflow: scroll;
        height: 160px;
    }
</style>
<div class="nested-pemeriksa-inner">
    <ul class="nested-pemeriksa">
        @foreach ($pemeriksa as $pem)
            <li>{{ $pem->petugas.' / '.$pem->nik.' / '.$pem->nama.';'}}</li>
        @endforeach
    </ul>
</div>