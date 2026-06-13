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
        require_once(__DIR__ . "/../../dao/ProductoDAO.php");
        require_once(__DIR__ . "/../../models/Producto.php");

        $datoFiltrar = $_GET['txtDatoFiltrar'] ?? "";

        /*
            filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)
            1. Busca el parámetro 'id' dentro de $_GET.
            2. Si existe, valida que sea un número entero.
            3. Si es un entero válido, devuelve dicho valor.
            4. Si no existe, devuelve null.
            5. Si existe pero no es un entero válido, devuelve false.
        */
        $idProducto = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        $rules = [
            "precio" => '/^\d+(\.\d+)?$/'
        ];

        if($idProducto === false || $idProducto === null){
            // Muestra mensaje y detiene ejecución del script
            die("ERROR: ID inválido...");
        }

        $productoDAO = new ProductoDAO(); 
        $producto = $productoDAO -> getBuscarPorId($idProducto);

        if($producto === null){
            die("ERROR: Producto no encontrado...");
        }

        $descNew = trim($_POST['txtDescNew'] ?? ""); 
        $catgNew = trim($_POST['txtCatgNew'] ?? ""); 
        $priceNew =  trim($_POST['txtPriceNew'] ?? "");
        
        $priceValido = preg_match($rules["precio"], $priceNew);

        if(strlen($descNew) > 3 && strlen($catgNew) > 3 && $priceValido && strlen($priceNew) >= 1){
            $priceNew = (float) $priceNew;
            $productoDAO = new ProductoDAO(); 
            $producto -> setDescripcion($descNew); 
            $producto -> setCategoria($catgNew); 
            $producto -> setPrecio($priceNew);
            
            $exito = $productoDAO -> setActualizar($producto); 

            if($exito){
                $producto = $productoDAO -> getBuscarPorId($idProducto);
            }
        }

    ?>
    
    <h1>Actualización de Producto</h1>
    
    <a href="index.php?txtDatoFiltrar=<?php echo urlencode($datoFiltrar)?>">Volver</a>
   
    <hr>
    <form method="post">
        <?php  if($producto -> getId() !== null){ ?>
        <div class="box-infoId">
            <span class="labelId">Código del Producto</span>
            <span class="txtNewId"> <?php  echo $producto -> getId() ?> </span>
        </div>
        <?php } ?>

        <div class="box-input">
            <label for="txtDescNew">Descripción</label>
            <textarea name="txtDescNew" id="txtDescNew" class="input-text" 
            placeholder="Descripción"><?php echo $producto -> getDescripcion() ?></textarea>
        </div>

        <div class="box-input">
            <label for="txtCatgNew">Categoría</label>
            <input type="text" name="txtCatgNew" id="txtCatgNew" 
            class="input-text" placeholder="Categoría del producto..."
            value="<?php echo $producto -> getCategoria() ?>">
        </div>

        <div class="box-input">
            <label for="txtPriceNew">Precio (S/.)</label>
            <input type="text" name="txtPriceNew" id="txtPriceNew" 
            class="input-text" placeholder="Precio del producto..."
            value="<?php echo $producto -> getPrecio() ?>">
        </div>

        <div class="box-input">
            <input type="submit" value="Actualizar Producto">
        </div>
    </form>

</body>
</html>