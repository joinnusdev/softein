$(function(){
    
    var url = "/admin/ingresos/buscar-alumno";
    
    
    var ingresos = {
        
        init : function() {
           this.buscarAlumno('#modalBuscarAlumno', "#linkModalBuscarAlumno");
           this.comboConcepto("#concepto");
           this.buscarAlumnoInto("#modalBuscarAlumno");
           this.medioPagoHide("#idMedioPago");
           this.seleccionarAlumno('#modalBuscarAlumno', "#frmIngresos");           
           this.ComboDependiente("#nivel", "#grado", "-- Seleccionar --", "/admin/grados/get-grados-por-nivel-ajax", "id", "descripcion");
           this.ComboDependienteTipo("#idTipoConcepto", "#idConcepto", "-- Seleccionar --", "/admin/concepto/get-concepto-ajax", "id", "descripcion");
           this.ComboDependienteBanco("#idBanco", "#idCuentaBancaria", "-- Seleccionar --", "/admin/cuenta-bancaria/get-cuenta-bancaria-ajax", "id", "numerocuenta");
           this.appendTableIngresos("#btnAgregarDetalleIngreso", "#idPanelTablaDetalleIngreso");
           this.deleteRowTableIngreso();
        },
        buscarAlumno : function(content, link) {
             $(link).bind("click", function(){
                 $(content).modal({
                     backdrop : true,
                     keyboard : true,
                     show : true
                 });
                 
                 //ajax para traer el formulario
                 $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        
                    },
                    dataType: 'html',
                    success: function(response){
                        $(content+" .modal-body").html(response);
                    }
                });
                 
                 
             });
        },
        ComboDependiente : function (c, cd, def, url, fieldv, fields) {
            $(c).live("change blur", function(){                
                var actual = $(this);
                if (actual.val()!=0) {                    
                    $(cd).removeAttr("disabled");
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                           id : actual.val()
                        },
                        dataType: 'json',
                        success: function(response){                            
                            if (response.status==true) {
                                var data = response.data;
                                $(cd).html("");
                                $.each(data, function(index, value){
                                    $(cd).append("<option value='"+value[fieldv]+"'>"+value[fields]+"</option>");
                                    
                                });
                            }
                        }
                    });
                } else {
                    $(cd).html("");
                    $(cd).append("<option value='0'>"+def+"</option>");
                    $(cd).attr("disabled", "disabled");
                    
                }
            });
       }
        ,
        ComboDependienteTipo : function (c, cd, def, url, fieldv, fields) {
            $(c).bind("change blur", function(){
                var actual = $(this);
                if (actual.val()!=0) {                    
                    $(cd).removeAttr("disabled");
                    $(cd).attr("disabled", "disabled");
                    $(cd).html("<option>Cargando...</option>");
                    $("#idMedioPago").val(0);
                    $("#idMedioPago").change();
                    
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                           id : actual.val()
                        },
                        dataType: 'json',
                        success: function(response){                            
                            if (response.status==true) {
                                var data = response.data;
                                $(cd).html("");
                                $.each(data, function(index, value){
                                    $(cd).append("<option value='"+value[fieldv]+"'>"+value[fields]+"</option>");
                                    
                                });
                                $(cd).removeAttr("disabled")
                            }
                        }
                    });
                } else {
                    $(cd).html("");
                    $(cd).append("<option value='0'>"+def+"</option>");
                    $(cd).attr("disabled", "disabled");
                    
                }
            });
       },
       ComboDependienteBanco : function (c, cd, def, url, fieldv, fields) {
            $(c).bind("change blur", function(){
                var actual = $(this);
                var concepto = $("#idConcepto");
                if (actual.val()!=0) {                    
                    $(cd).removeAttr("disabled");
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                           id : actual.val(),
                           idc : concepto.val()
                        },
                        dataType: 'json',
                        success: function(response){                            
                            if (response.status==true) {
                                var data = response.data;
                                $(cd).html("");
                                $.each(data, function(index, value){
                                    $(cd).append("<option value='"+value[fieldv]+"'>"+value[fields]+"</option>");
                                    
                                });
                            }
                        }
                    });
                } else {
                    $(cd).html("");
                    $(cd).append("<option value='0'>"+def+"</option>");
                    $(cd).attr("disabled", "disabled");
                    
                }
            });
       },
        buscarAlumnoInto : function(content) {
            $("#btnBuscarAlumno").live("click", function(){
                
                var name = $("#nombre").val();
                var apell = $("#apellidos").val();
                var nivel = $("#nivel").val();
                var grado = $("#grado").val();
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        nombre : name,
                        apellidos : apell,
                        nivel : nivel,
                        grado : grado
                    },
                    dataType: 'html',
                    success: function(response){
                        $(content+" .modal-body").html(response);
                    }
                });
                
                
            });
            
            
        },
        seleccionarAlumno : function(content, content2) {
            $(".linkSeleccionarAlumno").live("click", function(){
                $(content).modal("hide");
                var valor = $(this).attr("rel");
                var nombre = $(this).attr("data");
                
                $(content2+" #nombreAlumno").parent().append("<input type='hidden' value='"+valor+"' />");
                $("#nombreAlumno").val(nombre);
                
            });
        },
        medioPagoHide : function(content) {
            $(content).bind("change", function(){
                var medio = $(this).val();
                if (medio == 1) {
                    $("#panelInstitucionFinanciera").removeClass("hide");
                } else {
                    $("#panelInstitucionFinanciera").addClass("hide");
                }
                    
                
                
            });
        },
        appendTableIngresos : function(btn, tabla) {
            $(btn).bind("click", function(){
                var row = $(tabla+' tbody>tr:last').removeClass("hide").clone(true);
                row.insertAfter(tabla+' tbody>tr:last');
                
                //Obteniendo valores
                var mediopago     = $("#idMedioPago").val();
                var importe     = $("#importe").val();
                var costoconcepto = $("#costoConcepto span").html();
                var banco     = $("#idBanco").val();
                var cuentabancaria     = $("#idCuentaBancaria").val();
                var numerooperacion     = $("#numeroOperacion").val();
                
                //MEDIO PAGO
                var inputMediopago = "<input type='hidden' name='detalleMedioPago[]' value='"+mediopago+"' />";
                var inputMediopagoValor = $("#idMedioPago option:selected").text();
                
                //COSTO
                var inputCosto = "<input type='hidden' name='detalleCosto[]' value='"+costoconcepto+"' />";
                var inputCostoValor = "S/."+costoconcepto;
                
                //IMPORTE
                var inputImporte = "<input type='hidden' name='detalleImporte[]' value='"+importe+"' />";
                var inputImporteValor = "S/."+importe;
                
                //SALDO
                var saldo =  parseFloat(costoconcepto) - parseFloat(importe);
                
                //BANCO
                var inputBanco = "<input type='hidden' name='detalleBanco[]' value='"+banco+"' />";
                var inputBancoValor = $("#idBanco option:selected").text();
                
                //CUENTA BANCARIA
                var inputCuentaBancaria = "<input type='hidden' name='detalleCuentaBancaria[]' value='"+cuentabancaria+"' />";
                var inputCuentaBancariaValor = $("#idCuentaBancaria option:selected").text();
                
                //NUMERO DE OPERACION
                var inputNumeroOperacion = "<input type='hidden' name='detalleNumeroOperacion[]' value='"+importe+"' />";
                var inputNumeroOperacionValor = numerooperacion;
                
                $("td:eq(0)", row).html(inputMediopagoValor+inputMediopago);
                $("td:eq(1)", row).html(inputCostoValor+inputCosto);
                $("td:eq(2)", row).html(inputImporte+inputImporteValor);
                $("td:eq(3)", row).html(saldo);
                $("td:eq(4)", row).html(inputBanco+inputBancoValor);
                $("td:eq(5)", row).html(inputCuentaBancaria+inputCuentaBancariaValor);
                $("td:eq(6)", row).html(inputNumeroOperacion+inputNumeroOperacionValor);
                $(tabla+' tbody>tr:first').addClass("hide");
            });
        },
        deleteRowTableIngreso : function() {
           $(".eliminarDetalleIngreso").live("click", function(e){
               e.preventDefault();
               $(this).parents("tr").remove();    
           });
        },
        comboConcepto : function(nombre) {
            
        }
        
        
    }
    
    ingresos.init();
    
    
    
});