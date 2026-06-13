<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Clientes</title>
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
        require_once(__DIR__ . "/../../dao/ClienteDAO.php");

        if(isset($_GET['txtDatoFiltrar']) && strlen(trim($_GET['txtDatoFiltrar'])) > 0){
            $datoFiltrar = trim($_GET['txtDatoFiltrar']);
            $clienteDAO = new ClienteDAO();

            $tablaBuscarPorNombre = $clienteDAO -> getBuscarPorNombre( $datoFiltrar);
        }
        else{
            $datoFiltrar = ""; 
            $tablaBuscarPorNombre = []; 
        }

        // Verificar confirmación de Eliminación de Producto 
        $confirmDelete = $_POST['idDelete'] ?? null; 

        if($confirmDelete !== null){
            // Verificar existencia de Producto en la BD 
            $clienteEliminar = $clienteDAO -> getBuscarPorId((int) $confirmDelete);

            if($clienteEliminar !== null){
                // Eliminar el Producto 
                $clienteDAO -> setEliminar($clienteEliminar->getId());

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

    <h1>Gestor de Clientes</h1>

    <h1>Menú Principal</h1>
    <a href="../../index.php">Inicio</a>
    <a href="">Cliente</a>
    <a href="../producto/">Producto</a>
    <a href="../venta/">Venta</a>
    
    <hr>
    
    <a href="insertar.php?txtDatoFiltrar=<?php echo  urlencode($datoFiltrar)?>">Agregar Cliente</a>

    <hr>

    <form>
        <table border="1" >
            <thead>
                <tr>
                    <td>
                        <label for="txtDatoFiltrar">Filtrar por Nombre</label>
                    </td>

                    <td>
                        <input type="text" placeholder="Ingrese nombre a buscar"
                        id="txtDatoFiltrar" name="txtDatoFiltrar" 
                        value="<?php echo $datoFiltrar ?>">
                    </td>

                    <td>
                        <input type="submit" value="Buscar">
                    </td>
                </tr>
            </thead>
        </table>
    </form>

    <hr>

    <table border="1">
        <thead>
            <tr>
                <th>N° Orden</th>
                <th>Id</th>
                <th>Nombre</th>
                <th>NumRuc</th>
                <th>Dirección</th>
                <th>N° Telefono</th>
                <th colspan="2">Opciones</th>
            </tr>
        </thead>

        <tbody>
            <?php if(count($tablaBuscarPorNombre) > 0){ ?> 
                <?php foreach($tablaBuscarPorNombre as $index => $cliente){?>
                    <tr>
                        <td><?php echo $index + 1 ?></td>
                        <td><?php echo $cliente -> getId() ?></td>
                        <td><?php echo $cliente -> getNombre() ?></td>
                        <td><?php echo $cliente -> getNumRuc() ?></td>
                        <td><?php echo $cliente -> getDireccion() ?></td>
                        <td><?php echo $cliente -> getTelefono() ?></td>
                        <td>
                            <a class="btn-option-crud"
                            href="actualizar.php?id=<?php echo $cliente -> getId()?>&txtDatoFiltrar=<?php echo urlencode($datoFiltrar)?>">Actualizar</a>
                        </td>
                        <td>
                            <button class="btn-option-crud" onclick="openDeleteModal(<?php echo $cliente -> getId() ?>)"> Eliminar </button>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else {?>
                    <tr>
                        <td colspan="8" class="info-not-result">No se encontraron resultados...</td>
                    </tr>
            <?php } ?> 
        </tbody>
    </table>
	
</body>
</html>