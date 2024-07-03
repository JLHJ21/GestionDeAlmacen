<?php 
$id = $_GET["id"];
$productos = "SELECT * FROM productos WHERE id = '$id'";
?>
<form class="border" action="procesar_actualizar.php" method="post"> 
  <div class="py-3">
    <h3 class="text-center py-1 pb-2 border border-dark">Actualizar Productos</h3>
  </div>
    <table class="table table-bordered  table-wrapper">
        <thead>
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Precio</th>
        </tr>
        </thead>
        <tbody>
            <?php $resultado = mysqli_query($conexion, $productos);
            while($row=mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <input type="hidden" name="id" value="<?php echo $row["id"]?>">
                <td scope="row"><input type="text" name="nom_prd" value="<?php echo $row["nombre"]?>"></td>
                <td scope="row"><input type="number" name="pre_prd" value="<?php echo $row["precio"]?>"></td>
                <td scope="row"><input type="number" name="can_prd" value="<?php echo $row["cantidad"]?>"></td>
            <?php } mysqli_free_result($resultado);?>
                <td><input type="submit" class="w-100 btn btn-info btn-lg" value="Actualizar"></td>
            </tr>
        </tbody>
    </table>
</form>