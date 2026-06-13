<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Producto </title>
    <link rel="icon" 
        href="https://pngimg.com/uploads/php/php_PNG34.png"
        type="image/png">
</head>
<body>
    <?php 
        require_once(__DIR__ . "/../../dao/ClienteDAO.php");
        require_once(__DIR__ . "/../../models/Cliente.php");

        $datoFiltrar = $_GET['txtDatoFiltrar'] ?? "";

        $rules = [
            "ruc" => '/^\d{11}$/',
            "telefono" => '/^\d{7,9}$/'
        ];

        /*
            filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)
            1. Busca el parámetro 'id' dentro de $_GET.
            2. Si existe, valida que sea un número entero.
            3. Si es un entero válido, devuelve dicho valor.
            4. Si no existe, devuelve null.
            5. Si existe pero no es un entero válido, devuelve false.
        */
        $idCliente = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); 

        if($idCliente === false || $idCliente === null){
            // Muestra mensaje y detiene ejecución del script
            die("ERROR: ID inválido...");
        }

        $clienteDAO = new ClienteDAO();
        $cliente = $clienteDAO -> getBuscarPorId($idCliente);

        if($cliente === null){
            die("ERROR: Cliente no encontrado...");
        }

        $nameNew = trim($_POST['txtNameNew'] ?? ""); 
        $numRucNew = trim($_POST['txtNumRucNew'] ?? ""); 
        $direccionNew = trim($_POST['txtDireccionNew'] ?? "");
        $telefonoNew = trim($_POST['txtTelefonoNew'] ?? "");
    
        if(strlen($nameNew) > 2 && strlen($direccionNew) > 2 && 
          preg_match($rules["ruc"], $numRucNew) && preg_match($rules["telefono"], $telefonoNew)){
            $cliente -> setNombre($nameNew); 
            $cliente -> setNumRuc($numRucNew); 
            $cliente -> setDireccion($direccionNew); 
            $cliente -> setTelefono($telefonoNew);
            $exito = $clienteDAO -> setActualizar($cliente); 

            if($exito){
                $cliente = $clienteDAO -> getBuscarPorId($idCliente);
            }
            
        }
        

    ?>
    
    <h1>Actualización de Producto</h1>
    
    <a href="index.php?txtDatoFiltrar=<?php echo urlencode($datoFiltrar)?>">Volver</a>
   
    <hr>
    <form method="post">
        <?php  if($cliente -> getId() !== null){ ?>
        <div class="box-infoId">
            <span class="labelId">Código del Producto</span>
            <span class="txtNewId"> <?php  echo $cliente -> getId() ?> </span>
        </div>
        <?php } ?>

        <div class="box-input">
            <label for="txtNameNew">Nombre</label>
            <textarea name="txtNameNew" id="txtNameNew" class="input-text" 
            placeholder="Nombre"><?php echo $cliente -> getNombre() ?></textarea>
        </div>

        <div class="box-input">
            <label for="txtNumRucNew">N° RUC</label>
            <input type="text" name="txtNumRucNew" id="txtNumRucNew" 
            class="input-text" placeholder="RUC del cliente"
            value="<?php echo $cliente -> getNumRuc() ?>">
        </div>

        <div class="box-input">
            <label for="txtDireccionNew">Dirección</label>
            <input type="text" name="txtDireccionNew" id="txtDireccionNew" 
            class="input-text" placeholder="Dirección del cliente"
            value="<?php echo $cliente -> getDireccion() ?>">
        </div>

        <div class="box-input">
            <label for="txtTelefonoNew">Telefono</label>
            <input type="text" name="txtTelefonoNew" id="txtTelefonoNew" 
            class="input-text" placeholder="Telefono del cliente..."
            value="<?php echo $cliente -> getTelefono() ?>">
        </div>

        <div class="box-input">
            <input type="submit" value="Actualizar Producto">
        </div>
    </form>

</body>
</html>