$(function(){    
    
    var ingresos = {
        
        init : function() {
           this.ComboDependiente("#idTipo", "#idItem", "#idUsuario", "-- Seleccionar --", "/admin/ticket/productotipo", "idProducto", "nombreProducto");
           this.ComboDependienteDos("#idTipo", "#idItem", "#idUsuario", "-- Seleccionar --", "/admin/user/get-usuarios", "idUsuario", "nombreUsuario");
           this.appendTableIngresos("#agregarItem", "#idPanelTablaDetalleIngreso");
           this.validaMonto("#generar");
           this.deleteRowTableIngreso();           
        },        
        ComboDependiente : function (c, cd, cus, def, url, fieldv, fields) {
            $(c).live("change blur", function(){                
                var actual = $(this);                
                if (actual.val() != 0) {
                    $(cus).html("");
                    $(cus).append("<option value='0'>"+def+"</option>");
                    $(cus).attr("disabled", "disabled");
                    
                    $(cd).removeAttr("disabled");                    
                    
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                           id : actual.val()
                        },
                        dataType: 'json',                        
                        success: function(data){
                                $(cd).html("<option value='0'> --Seleccionar-- </option>");
                                $.each(data, function(index, value){
                                    if ($(c).val() == 1 )
                                        value["comision"] = '0.06';
                                    $(cd).append("<option comision= '"+ value["comision"] +"' precio='" + value["precio"] + "' id='idItem'  data ='"+ value[fields]+"' value='"+value[fieldv]+"'>"+value[fields]+"</option>");
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
                var row = $(tabla+' tbody> #item:last').removeClass("hide").clone(true);
                row.insertAfter(tabla+' tbody>#item:last');
                
                var inputWorker = "<input id='personal' type='hidden' name='personal[]' value='"+idp+"' />";
                
                
                $("th:eq(0)", row).html(nombre+inputWorker);
                $("th:eq(1)", row).html(cargo); 
                $("th:eq(2)", row).html(nivel);
                $(tabla+' tbody>#item:first').addClass("hide");
                
                
                
                
                
                
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
