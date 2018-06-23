$(document).ready(function() {
    $(id_one).on('change', function(){
        var Id_select_1 = $(this).val();
        if(Id_select_1) {
            $.ajax({
                url: ruta+ '/'+Id_select_1,
                type:"GET",
                dataType:"json",
                beforeSend: function(){
                    $('#loader').css("visibility", "visible");
                },
                success:function(data) {
                    $(id_two).empty();
                    $.each(data, function(key, value){
                        $(id_two).append('<option value="'+ key +'">' + value + '</option>');
                    });
                },
                complete: function(){
                    $('#loader').css("visibility", "hidden");
                }
            });
        } else {
            $(id_two).empty();
        }
    });
});