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
        // Arreglar acerca del precio pues lo demás está bien 
        require_once(__DIR__ . "/../../dao/ProductoDAO.php");
        require_once(__DIR__ . "/../../models/Producto.php");

        $rules = [
            "precio" => '/^\d+(\.\d+)?$/'
        ];

        $datoFiltrar = $_GET['txtDatoFiltrar'] ?? ""; 

        $producto = new Producto();

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
            $idNew = $productoDAO -> setInsertar($producto); 
            $producto -> setId($idNew); 
        }
    ?>
    


    <h1>Agregar nuevo Producto</h1>
    
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
            <input type="text" name="txtDescNew" id="txtDescNew" 
            class="input-text" placeholder="Descripción del producto..." 
            value="<?php echo $descNew?>">
        </div>

        <div class="box-input">
            <label for="txtCatgNew">Categoría</label>
            <input type="text" name="txtCatgNew" id="txtCatgNew" 
            class="input-text" placeholder="Categoría del producto..."
            value="<?php echo $catgNew?>">
        </div>

        <div class="box-input">
            <label for="txtPriceNew">Precio (S/.)</label>
            <input type="text" name="txtPriceNew" id="txtPriceNew" 
            class="input-text" placeholder="Precio del producto..."
            value="<?php echo $priceNew?>">
        </div>

        <div class="box-input">
            <input type="submit" value="Agregar Producto">
        </div>

        <div class="box-link">
            <a href="insertar.php?txtDatoFiltrar=<?php echo urlencode($datoFiltrar)?>">Agregar Producto</a>
        </div>
    </form>

</body>
</html>