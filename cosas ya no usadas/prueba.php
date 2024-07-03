<?php

require_once("/xampp/htdocs/final_poo/insertar/insertar_producto.php");


if($_POST && $_POST['id'])
{
    EliminarProducto($_POST['id']);
}

?>


<script>

function ValidarFormulario() {
    
    var confirmacion = document.forms["for_alm_prd"]["nom_prd"].value;
    if (confirmacion == "") { //En caso de que un valor este vacio te avisará
        alert("Falta valor en el cuadro Nombre del Producto");
        return false;
    }

    var confirmacion2 = document.forms["for_alm_prd"]["pre_prd"].value;
    if (confirmacion2 == "") { //En caso de que un valor este vacio te avisará
        alert("Falta valor en el cuadro Precio del Producto");
        return false;
    }
    var confirmacion3 = document.forms["for_alm_prd"]["can_prd"].value;
    if (confirmacion3 == "") { //En caso de que un valor este vacio te avisará
        alert("Falta valor en el cuadro Cantidad del Producto");
        return false;
    }
}


    

function SoloNumeros(ev){ //Buscar como usar
    
    var key = window.event ? ev.which : ev.keyCode;
    teclado_especial = false;
    if (key < 48 || key > 57) {
        ev.preventDefault();
        teclado_especial = true;
    }

}
    



/*function ValidarFormulario2(){
    var otro = document.forms["for_fac_prd"]["cantidad_vender"].value+1;
    if (otro == "") { //En caso de que un valor este vacio te avisará
        alert("Falta valor en el cuadro Cantidad a Vender del Producto");
        return false;
    }
}*/


</script>