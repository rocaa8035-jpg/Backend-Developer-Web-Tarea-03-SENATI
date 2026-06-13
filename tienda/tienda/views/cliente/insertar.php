<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Cliente </title>
    <link rel="icon" 
        href="https://pngimg.com/uploads/php/php_PNG34.png"
        type="image/png">
</head>
<body>
    <?php 
        require_once(__DIR__ . "/../../dao/ClienteDAO.php");
        require_once(__DIR__ . "/../../models/Cliente.php");

        $cliente = new Cliente();

        $rules = [
            "ruc" => '/^\d{11}$/',
            "telefono" => '/^\d{7,9}$/'
        ];

        $datoFiltrar = $_GET['txtDatoFiltrar'] ?? ""; 

        $nameNew = trim($_POST['txtNameNew'] ?? ""); 
        $numRucNew = trim($_POST['txtNumRucNew'] ?? ""); 
        $direccionNew = trim($_POST['txtDireccionNew'] ?? "");
        $telefonoNew = trim($_POST['txtTelefonoNew'] ?? "");

        $cliente -> setNombre($nameNew); 
        $cliente -> setNumRuc($numRucNew); 
        $cliente -> setDireccion($direccionNew); 
        $cliente -> setTelefono($telefonoNew);
    
        if(strlen($nameNew) > 2 && strlen($direccionNew) > 2 && 
          preg_match($rules["ruc"], $numRucNew) && preg_match($rules["telefono"], $telefonoNew)){
            $clienteDAO = new ClienteDAO(); 
            $newId = $clienteDAO -> setInsertar($cliente); 
            $cliente -> setId($newId);
        }
    ?>
    
    <h1>Agregar nuevo Cliente</h1>
    
    <a href="index.php?txtDatoFiltrar=<?php echo  urlencode($datoFiltrar)?>">Volver</a>
   
    <hr>
    <form method="post">
        <?php  if($cliente -> getId() !== null){ ?>
        <div class="box-infoId">
            <span class="labelId">Código del Cliente</span>
            <span class="txtNewId"> <?php  echo $cliente -> getId() ?> </span>
        </div>
        <?php } ?>

        <div class="box-input">
            <label for="txtNameNew">Nombre</label>
            <input type="text" name="txtNameNew" id="txtNameNew" 
            class="input-text" placeholder="Nombre del cliente" 
            value="<?php echo $cliente -> getNombre() ?>">
        </div>

        <div class="box-input">
            <label for="txtNumRucNew">N° Ruc</label>
            <input type="text" name="txtNumRucNew" id="txtNumRucNew" 
            class="input-text" placeholder="Número de RUC"
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
            class="input-text" placeholder="Telefono del cliente"
            value="<?php echo $cliente -> getTelefono() ?>">
        </div>

        <div class="box-input">
            <input type="submit" value="Agregar Cliente">
        </div>

        <div class="box-link">
            <a href="insertar.php?txtDatoFiltrar=<?php echo urlencode($datoFiltrar)?>">Agregar Producto</a>
        </div>
    </form>

</body>
</html>