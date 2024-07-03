<?php require_once("/xampp/htdocs/final_poo/plantillas/bd.php");

class Eliminar extends Conexion{
    private $id_prod;
    private $conexion;

    public function __construct(){
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->conexion();
    }

    public function EliminarProductos(int $id_prod){
        $this->id_prod = $id_prod;

        $sql = "UPDATE productos SET estado_prod = 0 WHERE id_prod =? ";
        $insertar = $this->conexion->prepare($sql);
        $arrData = array($this->id_prod);
        $resInsertar = $insertar->execute($arrData);
        
        echo "<script>alert('Se ha eliminado el producto con éxito');window.location='../paginas/almacen_productos.php'</script>"; 
    }
}

?>