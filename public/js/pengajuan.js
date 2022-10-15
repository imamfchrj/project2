$('#kategori_id').on('change', function () {
    // alert('test');
    var kategori_id = $('#kategori_id').val();
    console.log(kategori_id);

    if (kategori_id == 1){
        // $("#group-1").removeClass("hide");
        // $("#group-2").remove();
        $("#group-1").show();
        $("#group-2").hide();
        $("#group-3").show();
    }else{
        // $("#group-1").remove();
        // $("#group-2").removeClass("hide");
        $("#group-2").show();
        $("#group-1").hide();
        $("#group-3").show();
    }

    return false;
});

$(document).ready(function(){
    $("#group-1").hide();
    $("#group-2").hide();
    $("#group-3").hide();
});

