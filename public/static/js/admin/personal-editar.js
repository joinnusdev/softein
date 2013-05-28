$(function(){

    var url = "/admin/personal/crear"; 
    
    var personal = {        
        init : function() {
           this.ComboDependiente("#idProfesion", "#idEspecialidad", "-- Seleccionar --", "/admin/especialidad/especialidad-ajax", "idEspecialidad", "descripcion");
           this.ComboDependienteSub("#idEspecialidad", "#idSubEspecialidad", "-- Seleccionar --", "/admin/subespecialidad/sub-especialidad-ajax", "idSubEspecialidad", "descripcion");
        },
        ComboDependiente : function (c, cd, def, url, fieldv, fields) {
            $(c).bind("change blur", function(){                
                var actual = $(this);
                if (actual.val()!=0) {
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',    
                        url: url,
                                           
                        data: {
                           id : actual.val()
                        },
                        
                        success: function(data){                            
                            if(data.length){
                                $("#idSubEspecialidad").children("option").remove();
                                $("#idSubEspecialidad").append('<option value="0"> --- Seleccionar --- </option>');
                                $(cd).children("option").remove();
                                $(cd).append('<option value="0"> --- Seleccionar --- </option>');
                                for(var i = 0;i < data.length; i++){
                                    for(var elem in data[i]){
                                        $(cd).append('<option value='+ elem +'>'+ data[i][elem]+'</option>');
                                    }
                                }
                            }
                        }
                    });
                } else {
                    $(cd).html("");
                    $(cd).append("<option value='0'>"+def+"</option>");
                    //$(cd).attr("disabled", "disabled");
                    
                }
            });
       }
        ,
        ComboDependienteSub : function (c, cd, def, url, fieldv, fields) {
            $(c).bind("change", function(){
                var actual = $(this);
                if (actual.val()!=0) {
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',    
                        url: url,                                           
                        data: {
                           id : actual.val()
                        },
                        
                        success: function(data){                            
                            if(data.length){                               
                                $(cd).children("option").remove();
                                $(cd).append('<option value="0"> --- Seleccionar --- </option>');                                
                                for(var i = 0;i < data.length; i++){
                                    for(var elem in data[i]){
                                        $(cd).append('<option value='+ elem +'>'+ data[i][elem]+'</option>');
                                    }
                                }
                            }
                        }
                    });
                } else {
                    $(cd).html("");
                    $(cd).append("<option value='0'>"+def+"</option>");
                    //$(cd).attr("disabled", "disabled");
                    
                }


            });
       }
    }
    
    personal.init();
    
    
    
});