                <tbody> <!--AQUI-->
                    <?php 
                    $subTotal = 0; //Aqui seria el valor inicial del valor neto

                    $query ="SELECT Car.id_producto, Car.id_carrito, Prd.nombre, Car.cantidad_vender, Prd.precio*Car.cantidad_vender, Prd.cantidad-Car.cantidad_vender FROM carrito Car INNER JOIN productos Prd ON Car.id_producto = Prd.id WHERE id_usuario = '$id_usuario' "; //Agrega los valores que se muestran en Monto a Pagar 


                    $consulta=$conexion->query($query); //Necesario para la creación del PDO
                    while($fila=$consulta->fetch(PDO::FETCH_ASSOC)) // Muestra todos los resultados seleccionados por el query 
                    { ?>
                        <tr>
                <!--FORMULARIO INFORMACION A LA BASE DE DATOS-->
                <form action="./insertar_caja_registradora.php" method="get">

                            <td><?php echo $fila['nombre']?></td> <!--Nombre-->
                            <td><?php echo $fila['cantidad_vender']?></td> <!--Cantidad a Vender-->
                            <td><?php echo $fila['Prd.cantidad-Car.cantidad_vender']?></td> <!--Cantidad Restante-->
                            <td><?php echo $fila['Prd.precio*Car.cantidad_vender']?></td> <!--Precio-->
                            
                            <td><a href="procesar_eliminar_carrito.php?id=<?php echo $fila["id_carrito"];?>" type="button" class="btn btn-danger btn-sm eliminar_boton">Eliminar</a></td> <!--Opcion para eliminar del carrito / tabla de base de datos-->

                            <input type="hidden" name="id_producto[]" id="id_producto[]" value="<?php echo $fila['id_producto'];?>">
                        </tr>
        
                    <?php $subTotal= (int)number_format($subTotal+=$fila['Prd.precio*Car.cantidad_vender'],2); } //Operacion que va sumando los precios de las compras ?>

                        <tr>
                            <th>Monto Neto:</th>
                            <th colspan='1'></th>
                            <th colspan='1'></th>
                            <th colspan='1'></th>
                            <th colspan='1'><input type="hidden" id="monto_total" name="monto_total" value="<?php echo "$subTotal";?>"> $<?php echo "$subTotal";?></th>
                        </tr>
                </tbody>





                <div class="border pb-3"> 
        <div class="py-3">
          <h3 class="text-center py-1 pb-2 border border-dark">Añadir producto</h3>
        </div>

        <!--FORMULARIO INFORMACION A LA BASE DE DATOS-->
        <form action="" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
          <div class="row g-3">
            <div class="col-sm-3 position-relative">
              <label for="nom_prd" class="form-label">Nombre del producto</label>
              <input type="text" class="form-control" id="nom_prd" name="nom_prd" placeholder="Ej: Arroz Maria" onkeypress="return SoloLetras(event);" onpaste="return false"  maxlength="30" required> <!-- ENVIAR INFORMACION -->
              <div class="invalid-tooltip">
                Es necesario poner el nombre del producto
              </div>
            </div>

            <div class="col-sm-3 position-relative">
              <label for="pre_prd" class="form-label">Precio del producto</label>
              <input type="text" step="0.001" class="form-control" id="pre_prd" name="pre_prd" placeholder="Ej: 100.00" onkeypress="return SoloNumeros(event);" onpaste="return false" required> <!-- ENVIAR INFORMACION -->
              <div class="invalid-tooltip">
                Es necesario poner el precio del producto
              </div>
            </div>

            <div class="col-sm-3  position-relative">
              <label for="iva_prd" class="form-label">IVA del producto</label>
                <div class="btn-group col-12" role="group" aria-label="Basic mixed styles example">
                    <input class="form-control" placeholder="<?php echo $iva."%";?>" onkeypress="return SoloNumeros(event);" onpaste="return false" disabled>

                    <input type="hidden" name="iva_prd" value="0"/>
                    <input type="checkbox" class="btn-check" id="btn-check-outlined" name="iva_prd" autocomplete="off" value="1">

                    <label class="btn btn-outline-danger" for="btn-check-outlined">IVA</label>
                </div>
              <!--<span class="input-group-text input-group">@</span>
              <div class="form-floating input-group">
               <input type="text" class="form-control" id="iva_prd" name="iva_prd" placeholder="Ej: 02" onkeypress="return SoloNumeros(event);" onpaste="return false" required> ENVIAR INFORMACION
                <input type="text" class="form-control" id="floatingInputGroup1" placeholder="Username">
                <div class="invalid-tooltip">
                  Es necesario poner el IVA del producto
                </div> 
              </div>-->
              
              
            </div>

            <div class="col-sm-3 position-relative">
              <label for="can_prd" class="form-label">Cantidad del producto</label>
              <input type="text" class="form-control" id="can_prd" name="can_prd" placeholder="Ej: 45" onkeypress="return SoloNumeros(event);" onpaste="return false" required> <!-- ENVIAR INFORMACION -->
              <div class="invalid-tooltip">
                Es necesario poner la cantidad del producto
              </div>
            </div>
          <div class="col-12">
            <button type="submit" name="accion" class="w-100 btn btn-info btn-lg" >Añadir nuevo producto</button> 
          </div>
          <!-- ENVIAR INFORMACION -->
        </form>
        </div>
      </div>

      

      <div class="pb-4"><br></div> <!--Separador de tablas-->


      public function ID(){
            $this->id_cliente = "SELECT id_cliente FROM clientes ";
            $execute = $this->conexion->query($this->id_cliente);

            foreach ($this->conexion->query($this->id_cliente) as $i){
                $this->id_cliente_[] = $i['id_cliente'];
            }

            foreach ($this->id_cliente_ as $l){

                $id_cliente = $l;
                $sql = "SELECT Com.monto_total, Cli.id_cliente, Cli.nom_cliente, Cli.ced_cliente, Com.id_com, Com.fecha FROM compras Com  INNER JOIN clientes Cli ON Com.id_cliente = Cli.id_cliente WHERE Cli.id_cliente = '$id_cliente' GROUP BY Com.fecha";
                $execute = $this->conexion->query($sql);

                $suma_compras=0;

                foreach ($this->conexion->query($sql) as $e){

                    $monto_total = $e['monto_total'];
                    $suma_compras = $suma_compras+= $monto_total;

                }
            }   


            var_dump($suma_compras);
            return $suma_compras;
        }



        public function Suma(){

            foreach ($this->id_cliente_ as $id){

                var_dump($id);

                $sql = "SELECT Com.monto_total, Cli.id_cliente, Cli.nom_cliente, Cli.ced_cliente, Com.id_com, Com.fecha FROM compras Com  INNER JOIN clientes Cli ON Com.id_cliente = Cli.id_cliente WHERE Cli.id_cliente = '$id' GROUP BY Com.fecha";
                $execute = $this->conexion->query($sql);

                $suma_compras=0;

                foreach ($this->conexion->query($sql) as $e){

                    $monto_total = $e['monto_total'];
                    $suma_compras+=$monto_total;
                    
                }

                var_dump($suma_compras);
            }

        }

        public function Compras(){

            $id_cliente = "SELECT id_cliente FROM clientes ";
            $execute = $this->conexion->query($id_cliente);

            foreach ($this->conexion->query($id_cliente) as $i){
                $id_cliente_[] = $i['id_cliente'];
            }

            foreach ($id_cliente_ as $l){

                $id_cliente = $l;
                $sql = "SELECT Com.monto_total, Cli.id_cliente, Cli.nom_cliente, Cli.ced_cliente, Com.id_com, Com.fecha FROM compras Com  INNER JOIN clientes Cli ON Com.id_cliente = Cli.id_cliente WHERE Cli.id_cliente = '$id_cliente' GROUP BY Com.fecha";
                $execute = $this->conexion->query($sql);

                $suma_compras=0;

                foreach ($this->conexion->query($sql) as $e){

                    $monto_total = $e['monto_total'];
                    $suma_compras = $suma_compras+= $monto_total;

                }
                var_dump($suma_compras);

            }   

        }