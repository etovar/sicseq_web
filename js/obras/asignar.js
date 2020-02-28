$(document).ready(function(){
    $("#radioTodosComites").click(function(){
        $("#divTodosComites").show(500);
        $("#divPorComite").hide(500);
    });

    $("#radioPorComite").click(function(){
        $("#divPorComite").show(500);
        $("#divTodosComites").hide(500);
    });
});
