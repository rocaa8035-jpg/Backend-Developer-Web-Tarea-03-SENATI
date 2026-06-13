<?php
    require_once(__DIR__ . "/../config/conexion.php");
    require_once(__DIR__ . "/../models/Venta.php");
    require_once(__DIR__ . "/ClienteDAO.php");

    class VentaDAO{
        public function getBuscarporId(int $idSearch): ?Venta {
            //Conexion PDO 
            $cnx = Conexion::getConexionMySQL(); 
            // Sentencia statement 
            $sentencia = $cnx -> prepare("select * from venta where id = :id"); 
            $sentencia -> bindValue(":id", $idSearch); 

            $sentencia -> execute(); 

            $registro = $sentencia -> fetch(PDO::FETCH_ASSOC); 

            if(!$registro){
                return null;
            }

            $idCliente = (int) $registro["idCliente"];

            $clienteDAO = new ClienteDAO(); 

            $cliente = $clienteDAO -> getBuscarPorId($idCliente); 

            // LIBERAR RECURSOS
            $sentencia = null; 
            $cnx = null;

            return new Venta(
                $registro["id"], 
                $cliente, 
                $registro["fecventa"] // era fechaVenta pero lo pusieron fecventa
            );
        }


        public function getBuscarPorClienteId(int $idSearch): ?array{
            // conexion 
            $cnx = Conexion::getConexionMySQL(); 
            // Sentencia statement 
            $sentencia = $cnx -> prepare("select * from venta where idCliente = :id"); 
            $sentencia -> bindValue(":id", $idSearch); 

            $sentencia -> execute(); 

            $listRegistros = $sentencia -> fetchAll(PDO::FETCH_ASSOC); 

            // LIBERAR RECURSOS
            $sentencia = null; 
            $cnx = null;

            $listVentas = []; 
            $clienteDAO = new ClienteDAO();
            // SE TRATA DEL MISMO CLIENTE 
            $cliente = $clienteDAO -> getBuscarPorId($idSearch); 
            foreach($listRegistros as $venta){
                $newVenta = new Venta(
                    $venta["id"], 
                    $cliente, 
                    $venta["fecventa"] // era fechaVenta pero lo pusieron fecventa
                );

                array_push($listVentas, $newVenta);
            }

            return $listVentas;

        }

        public function setInsertar(Venta $venta): int{
            // conexion 
            $cnx = Conexion::getConexionMySQL(); 
            // Sentencia statement 
            $sentencia = $cnx -> prepare("insert into venta (fecventa, idCliente) 
                                         values (:fecventa, :idCliente)");
            
            $sentencia -> bindValue(":fecventa", $venta -> getFecha()); 
            $sentencia -> bindValue(":idCliente", $venta -> getCliente() -> getId()); 

            $sentencia -> execute(); 

            $nuevoId = $cnx -> lastInsertId(); 

            // LIBERAR RECURSOS
            $sentencia = null; 
            $cnx = null;

            return (int) $nuevoId; 

        }

        public function setAxctualizar(Venta $venta) : void {
            // conexion 
            $cnx = Conexion::getConexionMySQL(); 
            // Sentencia statement 
            $sentencia = $cnx -> prepare("update venta set fecventa = :fecha, idCliente = :idCliente where id = :id");
            $sentencia -> bindValue(":fecha", $venta -> getFecha()); 
            $sentencia -> bindValue(":idCliente", $venta -> getCliente() -> getId()); 
            $sentencia -> bindValue(":id", $venta -> getId());

            $sentencia -> execute(); 

            // LIBERAR RECURSOS
            $sentencia = null; 
            $cnx = null;
        }

        public function setEliminar(int $idEliminar) : void {
            // conexion 
            $cnx = Conexion::getConexionMySQL(); 
            // Sentencia statement 
            $sentencia = $cnx -> prepare("delete from venta where id = :id");
            $sentencia -> bindValue(":id", $idEliminar);

            $sentencia -> execute(); 

            // LIBERAR RECURSOS
            $sentencia = null; 
            $cnx = null;
        }
    }
?>