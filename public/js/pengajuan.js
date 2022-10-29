$('#jenis_id').on('change', function () {
    var jenis_id = $('#jenis_id').val();
    var kategori_id = $('#kategori_id').val();

    if ((kategori_id == 1) && (jenis_id==1)){
        $("#group-1").show();
        $("#group-2").hide();
        $("#group-3").show();
        $("#group-4").hide();
    }else if ((kategori_id == 1) && (jenis_id==2)){
        $("#group-1").hide();
        $("#group-2").hide();
        $("#group-3").show();
        $("#group-4").show();
    }else if ((kategori_id == 2) && (jenis_id==1)){
        $("#group-1").hide();
        $("#group-2").show();
        $("#group-3").show();
        $("#group-4").hide();
    }else if ((kategori_id == 2) && (jenis_id==2)){
        $("#group-1").hide();
        $("#group-2").show();
        $("#group-3").show();
        $("#group-4").hide();
    }else {
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

    if ((kategori_id == 1) && (jenis_id==1)){
        $("#group-1").show();
        $("#group-2").hide();
        $("#group-3").show();
        $("#group-4").hide();
    }else if ((kategori_id == 1) && (jenis_id==2)){
        $("#group-1").hide();
        $("#group-2").hide();
        $("#group-3").show();
        $("#group-4").show();
    }else if ((kategori_id == 2) && (jenis_id==1)){
        $("#group-1").hide();
        $("#group-2").show();
        $("#group-3").show();
        $("#group-4").hide();
    }else if ((kategori_id == 2) && (jenis_id==2)){
        $("#group-1").hide();
        $("#group-2").show();
        $("#group-3").show();
        $("#group-4").hide();
    }else {
        $("#group-1").hide();
        $("#group-2").hide();
        $("#group-3").hide();
        $("#group-4").hide();
    }

    return false;
});

$(document).ready(function(){
    $("#group-1").hide();
    $("#group-2").hide();
    $("#group-3").hide();
    $("#group-4").hide();
});

$('#btn_pengajuan_draft').click(function(){
    $('#draft_status').val(true);
});

$('#btn_workspace_approve').click(function(){
    $('#status_btn').val(1);
});

$('#btn_workspace_return').click(function(){
    $('#status_btn').val(2);
});

$('#btn_workspace_reject').click(function(){
    $('#status_btn').val(3);
});