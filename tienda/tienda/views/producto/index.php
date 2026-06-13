<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 01 de PDO en PHP</title>
    <link rel="icon" 
        href="https://pngimg.com/uploads/php/php_PNG34.png"
        type="image/png">
    
    <!-- ESTILOS CSS -->
    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/variables.css">
    <link rel="stylesheet" href="../../css/modalDelete.css">

    <!-- JS -->
     <script src="../../js/filtros.js" defer></script>
</head>
<body>
    <?php 
        require_once(__DIR__ . "/../../dao/ProductoDAO.php");

        if(isset($_GET['txtDatoFiltrar']) && strlen(trim($_GET['txtDatoFiltrar'])) > 0){
            // Recoger el valor 
            $datoFiltrar = trim($_GET['txtDatoFiltrar']);

            // Instanciar el producto 
            $productoDAO = new ProductoDAO();

            // Ejecutar método de busqueda 
            $tablaBuscarPorDescripcion = $productoDAO -> getBuscarPorDescripcion($datoFiltrar);
            
        }
        else{
            $datoFiltrar = '';
            $tablaBuscarPorDescripcion = [];
        }

        // Verificar confirmación de Eliminación de Producto 
        $confirmDelete = $_POST['idDelete'] ?? null; 

        if($confirmDelete !== null){
            // Verificar existencia de Producto en la BD 
            $productoEliminar = $productoDAO -> getBuscarPorId((int) $confirmDelete);

            if($productoEliminar !== null){
                // Eliminar el Producto 
                $productoDAO -> setEliminar($productoEliminar->getId());

                header("Location: index.php?txtDatoFiltrar=" . urlencode($datoFiltrar)); 
            }
        }

    ?>

    <!--==== MODAL PARA CONFIRMAR EL BORRADO DE UN DATO -->

    <dialog  class="modal-confirm-delete" id="modal-delete">
        <div class="modal-body">
            <div class="modal-content">
                <span class="question-delete">¿Seguro que desea eliminar este registro?</span>

                <form class="form-options" method="post">
                    <input type="hidden" name="idDelete" id="idDelete">

                    <div class="btn-options-container">
                        <button type="submit" class="btn-option option-confirm">Sí</button>
                        <button type="button" class="btn-option option-cancel cerrar-modal">Cancelar</button>
                    </div>
                </form>
            </div>
            
            <button class="btn-closed cerrar-modal">X</button>

        </div>
    </dialog>

    <h1>Gestión de Producto</h1>
    
    <h1>Menú Principal</h1>
    <a href="../../index.php">Inicio</a>
    <a href="../cliente/index.php">Cliente</a>
    <a href="">Producto</a>
    <a href="../venta/index.php">Venta</a>

    <hr>

    <a href="insertar.php?txtDatoFiltrar=<?php echo  urlencode($datoFiltrar)?>">Agregar Producto</a>
    
   
    <hr>
    <form>
        <table border="1">
            <tr>
                <td>
                    <label for="txtDatoFiltrar">Descripcion</label>
                </td>

                <td>
                    <input type="text" name="txtDatoFiltrar" 
                    placeholder="descripcion..." id="txtDatoFiltrar"
                    value="<?php echo $datoFiltrar ?>">
                </td>

                <td>
                    <input type="submit" value="Buscar" >
                </td>
            </tr>
        </table>
    </form>
	
    <hr>

    <table border="1">
        <thead>
            <tr>
                <th>N° de Orden</th>
                <th>Código </th>
                <th>Descripcion</th>
                <th>Categoría</th>
                <th>Precio S/.</th>
                <th colspan="2">Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($tablaBuscarPorDescripcion)> 0){ ?>
                <?php foreach($tablaBuscarPorDescripcion as $index => $fila){ ?>

                <tr>
                    <td><?php echo $index + 1 ?></td>
                    <td><?php echo $fila -> getId() ?></td>

                    <td><?php echo $fila -> getDescripcion() ?></td>

                    <td><?php echo $fila -> getCategoria() ?></td>

                    <td><?php echo $fila -> getPrecio() ?></td>

                    <td>
                        <a class="btn-option-crud"
                        href="actualizar.php?id=<?php echo $fila -> getId()?>&txtDatoFiltrar=<?php echo urlencode($datoFiltrar)?>">Actualizar</a>

                    </td>

                    <td>
                        <button class="btn-option-crud" onclick="openDeleteModal(<?php echo $fila -> getId() ?>)"> Eliminar </button>
                    </td>
                </tr>

                <?php } ?>
            <?php } else{?>
                    <tr>
                        <td colspan="7" class="info-not-result">No se encontraron resultados...</td>
                    </tr>
            <?php }?>
        </tbody>
        
    </table>

</body>
</html>