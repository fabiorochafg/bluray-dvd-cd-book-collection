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

    // Botão de exclusão
    $(".danger").click(function() {
        return confirm($(this).attr("confirm") || "Tem certeza que deseja continuar?");
    });

    // Validação de formulários
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
                    alert('Você precisa selecionar, no mínimo, uma das opções.');
                    canSubmit = false;
                } else if (type == "radio" && $("input[type='radio']:checked").length == 0) {
                    alert('Você precisa selecionar, no mínimo, uma das opções.');
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