$(function(){
    
    $('#clienteReserva').typeahead({
            source: function(typeahead, query) {
                if (query.length < 1)
                    return [];
                $.post('/agenda/listar-clientes', {query: query}, function(data) {
                    return typeahead.process(JSON.parse(data));
                });
            },
            onselect: function(obj) {
                $("#otroCliente").val(obj.id);                
            }
        });
    
    var url = "/admin/ingresos/buscar-alumno";
    
    
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
               var v = parseFloat($("#visa").val());
               var ms = parseFloat($("#mastercard").val());
               var e = parseFloat($("#efectivo").val());  
               if (isNaN(v)) v = 0;
               if (isNaN(ms)) ms = 0;
               if (isNaN(e)) e = 0;               
               var sum = v+ms+e;
               
               var total = parseFloat($("#totalValue").val());
               
               if (sum == total) {
                   $("#frmTicket").submit();
               }                   
               else {
                   alert('Los montos ingresados no coinciden');
                    return false;
               }
               
           });
       },
       
        appendTableIngresos : function(btn, tabla) {
            $(btn).bind("click", function(){
                //Obteniendo valores
                var tipo     = $("#idTipo").val();                
                var servicio     = $("#idItem").val();
                var precio     = Math.round(parseFloat($("#idPrecio").val())*100)/100;
                var comision     = parseFloat($("#comision").val());
                
                if(($(this).attr("disabled")== "" || $(this).attr("disabled")== undefined)&& servicio != '0'){
                    
                $("#generar").removeAttr("disabled");
                var row = $(tabla+' tbody>tr:last').removeClass("hide").clone(true);
                row.insertAfter(tabla+' tbody>tr:last');
                
                
                if (isNaN(comision)) {
                    comision = 0;
                }
                var idworker     = $("#idUsuario").val();                
                
                var total     = $("#totalValue").val();
                
                if (total != "") {
                    var sum = Math.round((parseFloat($("#totalValue").val()) + parseFloat(precio))*100)/100;
                    $("#totalValue").val(sum);                    
                } else {
                    $("#totalValue").val(precio);
                }
                $("#efectivo").val(Math.round(parseFloat($("#totalValue").val())*100)/100);
                
                //MEDIO PAGO
                var inputMediopago = "<input type='hidden' name='detalleServicio[]' value='"+servicio+"' />";
                var inputMediopagoValor = $("#idItem option:selected").text();
                //worker
                var inputWorker = "<input type='hidden' name='detalleWorker[]' value='"+idworker+"' />";
                
                var inputWorkerValor = $("#idUsuario option:selected").text();
                
                //COSTO
                var inputCosto = "<input type='hidden' name='detalleCosto[]' value='"+precio+"' />";
                var inputCostoValor = "S/. <span class='precio'>"+precio+"</span>";
                // PRECIO
                
                comision = Math.round(parseFloat(precio) * parseFloat(comision)*100)/100;
                var inputComision = "<input type='hidden' name='detalleComision[]' value='"+ comision +"' />";
                //var inputComisionValor = "S/. <span class='comision'>"+ comision +"</span>";
                                
                
                $("th:eq(0)", row).html(inputMediopagoValor+inputMediopago);
                $("th:eq(1)", row).html(inputCostoValor+inputCosto); 
                $("th:eq(2)", row).html(inputWorkerValor+inputWorker+inputComision);
                //$("th:eq(3)", row).html(inputComisionValor+inputComision);
                $(tabla+' tbody>tr:first').addClass("hide");
                var tfinal = parseFloat($("#totalValue").val());
                $("#totalfinal").html(tfinal.toFixed(2));
                
                }
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
