$('#jenis_id').on('change', function () {
    var jenis_id = $('#jenis_id').val();
    var kategori_id = $('#kategori_id').val();

    if ((kategori_id == 1) && (jenis_id == 1)) {
        $("#group-1").show();
        $("#group-2").hide();
        $("#group-3").show();
        $("#group-4").hide();
    } else if ((kategori_id == 1) && (jenis_id == 2)) {
        $("#group-1").hide();
        $("#group-2").hide();
        $("#group-3").show();
        $("#group-4").show();
    } else if ((kategori_id == 2) && (jenis_id == 1)) {
        $("#group-1").hide();
        $("#group-2").show();
        $("#group-3").show();
        $("#group-4").hide();
    } else if ((kategori_id == 2) && (jenis_id == 2)) {
        $("#group-1").hide();
        $("#group-2").show();
        $("#group-3").show();
        $("#group-4").hide();
    } else {
        $("#group-1").hide();
        $("#group-2").hide();
        $("#group-3").hide();
        $("#group-4").hide();
    }

    return false;
});

$('#kategori_id').on('change', function () {
    var jenis_id = $('#jenis_id').val();
    var kategori_id = $('#kategori_id').val();

    if ((kategori_id == 1) && (jenis_id == 1)) {
        $("#group-1").show();
        $("#group-2").hide();
        $("#group-3").show();
        $("#group-4").hide();
    } else if ((kategori_id == 1) && (jenis_id == 2)) {
        $("#group-1").hide();
        $("#group-2").hide();
        $("#group-3").show();
        $("#group-4").show();
    } else if ((kategori_id == 2) && (jenis_id == 1)) {
        $("#group-1").hide();
        $("#group-2").show();
        $("#group-3").show();
        $("#group-4").hide();
    } else if ((kategori_id == 2) && (jenis_id == 2)) {
        $("#group-1").hide();
        $("#group-2").show();
        $("#group-3").show();
        $("#group-4").hide();
    } else {
        $("#group-1").hide();
        $("#group-2").hide();
        $("#group-3").hide();
        $("#group-4").hide();
    }

    return false;
});

$(document).ready(function () {
    $("#group-1").hide();
    $("#group-2").hide();
    $("#group-3").hide();
    $("#group-4").hide();
    $("#cust-draft").hide();
    $('#jenis_id').change();
    $('#kategori_id').change();

    $('input[name=id]').length ?
        $('#upload_history').show() :
        $('#upload_history').hide()

    // OPEX BISNIS
    var nilai_capex_4 = document.getElementById('nilai_capex_4');
    nilai_capex_4.addEventListener('keyup',function (e) {
        nilai_capex_4.value = formatRupiah(this.value);
    });
    var est_revenue_4 = document.getElementById('est_revenue_4');
    est_revenue_4.addEventListener('keyup', function (e) {
        est_revenue_4.value = formatRupiah(this.value);
    });

    // OPEX/CAPEX SUPPORT
    var nilai_capex_2 = document.getElementById('nilai_capex_2');
    nilai_capex_2.addEventListener('keyup', function (e) {
        nilai_capex_2.value = formatRupiah(this.value);
    });

    // OPEX/CAPEX SUPPORT
    var nilai_capex_1 = document.getElementById('nilai_capex_1');
    nilai_capex_1.addEventListener('keyup', function (e) {
        nilai_capex_1.value = formatRupiah(this.value);
    });
    var est_revenue = document.getElementById('est_revenue');
    est_revenue.addEventListener('keyup', function (e) {
        est_revenue.value = formatRupiah(this.value);
    });

    function formatRupiah(angka)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah ;
    }
});

$('#btn_pengajuan_draft').click(function () {
    $('#draft_status').val(true);
});

$('#btn_pengajuan').click(function () {
    $('#draft_status').val(false);
});

$('#btn_workspace_approve').click(function () {
    $('#status_btn').val(1);
});

$('#btn_workspace_return').click(function () {
    $('#status_btn').val(2);
});

$('#btn_workspace_reject').click(function () {
    $('#status_btn').val(3);
});


