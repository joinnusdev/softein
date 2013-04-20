$(function(){    
    
    var ingresos = {
        
        init : function() {
           this.ComboDependiente("#convocatoria", "#tablabody", "#tablabody", "--- Seleccionar ---", "/admin/reportes/ajax-listar-empresas", "idConvocatoria", "nombreProducto", "#tablalista");
           this.appendTableIngresos("#agregarItem", "#idPanelTablaDetalleIngreso");
           this.validaMonto("#generar");
           this.deleteRowTableIngreso();           
        },        
        ComboDependiente : function (c, cd, cus, def, url, fieldv, fields,tabla) {
            $(c).live("change blur", function(){
                var actual = $(this);                
                if (actual.val() != 0) {
                    $(cd).html("");
                    $(cd).append("<tr class = 'hide modelo'><th></th><th></th><th></th><th><a class='eliminarDetalleIngreso'> Eliminar</a></th></tr>");
                    
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                           id : actual.val()
                        },
                        dataType: 'json',                        
                        success: function(data){
                            
                            $.each(data, function(index, value){
                                    
                                var ID = value["idEmpresa"];
                                var nombre = value["nombreEmpresa"];
                                var telefono = value["telefono"];
                                    
                                var row = $(tabla+' tbody>tr:last').removeClass("hide").clone(true);
                                row.insertAfter(tabla+' tbody>tr:last');
                
                                var link = "<a href='/admin/reportes/imprimir/empresa/"+value["idEmpresa"]+"/convocatoria/"+actual.val()+"' class='btn btn-success'><i class='icon-edit'></i>  IMPRIMIR DATOS</a>";
                
                
                                $("th:eq(0)", row).html(ID);
                                $("th:eq(1)", row).html(nombre); 
                                $("th:eq(2)", row).html(telefono);
                                $("th:eq(3)", row).html(link);
                                $(tabla+' tbody>tr:first').addClass("hide");
                            });
                        }
                    });                    
                } 
            });
       },
       ComboDependienteDos : function (tipo, c, cd, def, url, fieldv, fields) {           
           $(c).bind("change blur", function(){
               var actual = $(this);
               
               var precio = $("#idItem option:selected").attr("precio");
               var comision = $("#idItem option:selected").attr("comision");
               $("#idPrecio").val(precio);
               $("#comision").val(comision);
               
                var tipoVal = $(tipo).val();                
                
                if (actual.val() != 0) {
                    $(cd).removeAttr("disabled");
                    $("#agregarItem").removeAttr("disabled");
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                           id : actual.val(),
                           tipo : tipoVal
                        },
                        dataType: 'json',
                        success: function(data){
                                $(cd).html("");
                                $.each(data, function(index, value){
                                    $(cd).append("<option id='idUsuario'  data ='"+ value[fields]+"' value='"+value[fieldv]+"'>"+value[fields]+"</option>");
                                });
                        }
                    });                    
                } else {
                    $(cd).html("");
                    $(cd).append("<option value='0'>"+def+"</option>");
                    $(cd).attr("disabled", "disabled");                    
                }
            });
       },
       validaMonto : function(gen){
           $(gen).bind("click", function(){
               
               var idp = $("#personal").val();               
               if (idp == undefined) {                   
                   alert('Debe seleccionar por lo menos un personal');
                   $("#generar").attr("disabled", "disabled");
                    return false;
               } else {                   
                   $("#frmTicket").submit();
               }
               
           });
       },
       
        appendTableIngresos : function(btn, tabla) {
            $(btn).bind("click", function(){
                //Obteniendo valores
                var nombre = $("#idUsuario option:selected").attr("nombre");
                var cargo = $("#idUsuario option:selected").attr("cargo");
                var nivel = $("#idUsuario option:selected").attr("nivel");
                var idp = $("#idUsuario option:selected").attr("value");
                    
                $("#generar").removeAttr("disabled");
                $("#imprimir").removeAttr("disabled");
                var row = $(tabla+' tbody>tr:last').removeClass("hide").clone(true);
                row.insertAfter(tabla+' tbody>tr:last');
                
                var inputWorker = "<input id='personal' type='hidden' name='personal[]' value='"+idp+"' />";
                
                
                $("th:eq(0)", row).html(nombre+inputWorker);
                $("th:eq(1)", row).html(cargo); 
                $("th:eq(2)", row).html(nivel);
                $(tabla+' tbody>tr:first').addClass("hide");
                
                
                
                
                
                
            });
            
        },
        deleteRowTableIngreso : function() {
           $(".eliminarDetalleIngreso").live("click", function(e){               
               var va = $(this).parents("tr").find("th");
               var les = $($(va[1]).find("span")).html();               
               var sum = Math.round((parseFloat($("#totalValue").val()) - parseFloat(les))*100)/100;
               $("#totalValue").val(sum);               
               $("#totalfinal").html(sum);
               $("#efectivo").val(Math.round(parseFloat(sum)*100)/100);
               e.preventDefault();
               $(this).parents("tr").remove();
               
           });
        }
    }
    
    ingresos.init();
    
    
    
});
