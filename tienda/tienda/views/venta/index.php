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
</head>
<body>
    <?php 
        require_once(__DIR__ . "/../../dao/VentaDAO.php");

        if(isset($_POST['txtIdClienteBuscar']) && strlen(trim($_POST['txtIdClienteBuscar'])) > 0){
            $idClienteBuscar = trim($_POST['txtIdClienteBuscar']);
            $ventaDAO = new VentaDAO();

            $tablaBuscarPorIdCliente = $ventaDAO -> getBuscarPorClienteId((int) $idClienteBuscar);
        }
        else{
            $idClienteBuscar = ""; 
            $tablaBuscarPorIdCliente = []; 
        }
    
    ?>

    <h1>Venta</h1>

    <h1>Menú Principal</h1>
    <a href="../../index.php">Inicio</a>
    <a href="../cliente/">Cliente</a>
    <a href="../producto/">Producto</a>
    <a href="">Venta</a>

    <hr>

    <form method="post">
        <table border="1">
            <thead>
                <tr>
                    <td>
                        <label for="txtIdClienteBuscar">Filtrar por Id de Cliente</label>
                    </td>

                    <td>
                        <input type="text" placeholder="Ingrese id del cliente para filtrar"
                        id="txtIdClienteBuscar" name="txtIdClienteBuscar" 
                        value="<?php echo $idClienteBuscar ?>">
                    </td>

                    <td>
                        <input type="submit" value="Buscar">
                    </td>
                </tr>
            </thead>
        </table>
    </form>

    <hr>

    <table border="1" style="min-width: 500px;">
        <thead>
            <tr>
                <th>N° Orden</th>
                <th>Id</th>
                <th>Cliente</th>
                <th>Fecha de Venta</th>
            </tr>
        </thead>

        <tbody>
            <?php if(count($tablaBuscarPorIdCliente) > 0){ ?> 
                <?php foreach($tablaBuscarPorIdCliente as $index => $venta){?>
                    <tr>
                        <td><?php echo $index + 1 ?></td>
                        <td><?php echo $venta -> getId() ?></td>
                        <td><?php echo $venta -> getCliente() -> getId() ?></td>
                        <td><?php echo $venta  -> getFEcha() ?></td>
                    </tr>
                <?php } ?>
            <?php } else {?>
                    <tr>
                        <td colspan="4" class="info-not-result" >No se encontraron resultados...</td>
                    </tr>
            <?php } ?> 
        </tbody>
    </table>
	
</body>
</html>