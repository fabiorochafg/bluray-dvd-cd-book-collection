/* JS Document - Developed by Fabio Rocha (https://github.com/fabiorochafg | fabiorochafg@gmail.com) */

$(document).ready(function(){

    // view.movie
    $(".box-item img").click(function(){
        $(this).toggle("slow");
        $(this).next("dl").toggle("slow");
    });
    $(".box-item dl").click(function(){
        $(this).toggle("slow");
        $(this).prev("img").toggle("slow");
    });

    // Bot�o de exclus�o
    $(".danger").click(function() {
        return confirm($(this).attr("confirm") || "Tem certeza que deseja continuar?");
    });

    // Valida��o de formul�rios
    $("form").bind("submit",function() {
        var canSubmit = true;
        $(":input",this).each(function() {
            var element = $(this);
            var type = this.type;
            var tag = this.tagName.toLowerCase();
            var frase = "Por favor, preencha o campo: ";
            if (type != "checkbox" || type != "radio") {
                var label = $(this).prev("label").text();
                var campo = label.replace(':','.');
            }
            if (type != "hidden" && element.css("display") != "none" && (!element.hasClass('oculto')) && (!element.hasClass('nao-obrigatorio'))) {
                if ((type == "text" || type == "password" || type == "file" || tag == "textarea" || tag == "select") && this.value=="") {
                    alert(frase + campo);
                    this.focus();
                    canSubmit = false;
                } else if (type == "checkbox" && $("input[type='checkbox']:checked").length == 0) {
                    alert('Voc� precisa selecionar, no m�nimo, uma das op��es.');
                    canSubmit = false;
                } else if (type == "radio" && $("input[type='radio']:checked").length == 0) {
                    alert('Voc� precisa selecionar, no m�nimo, uma das op��es.');
                    canSubmit = false;
                } else if ($(this).attr("name") == "email" && ((this.value.indexOf("@") < 1))) {
                    alert("Por favor, preencha o campo de E-mail corretamente.");
                    this.focus();
                    canSubmit = false;
                }
                return canSubmit;
            }   
        });
        return canSubmit;
    });
});