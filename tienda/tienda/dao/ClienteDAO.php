<?php 
require_once(__DIR__. "/../config/conexion.php");
require_once(__DIR__ . "/../models/Cliente.php");

    class ClienteDAO{
        // MÉTODOS CRUD (Create, Read, Update, Delete)
        public function getBuscarPorId(int $idSearch): ?Cliente{
            // Conectar e instanciar al Objeto PDO 
            $cnx = Conexion::getConexionMySQL(); 
            // Preparar la sentencia SQL (Statement) 
            $sentencia = $cnx -> prepare("select * from cliente where id=:idSearch");
            $sentencia ->bindValue(":idSearch", $idSearch);
            // Ejecutar la sentencia SQL 
            $sentencia ->execute();
            // Recoger Fila fetch(PDO::FETCH_ASSOC)
            $registro = $sentencia -> fetch(PDO::FETCH_ASSOC);
            // LIBERAR RECURSOS
            $sentencia = null; 
            $cnx = null;
            // Devolver el objeto Cliente 
            if(!$registro){
                return null;
            }

            return new Cliente(
                $registro["id"] ,
                $registro["nombre"],
                $registro["numruc"],
                $registro["direccion"],
                $registro["telefono"]
            );
        }

        public function getBuscarPorNombre(string $nameSearch): ?array{
            // Conectar e instanciar al Objeto PDO 
            $cnx = Conexion::getConexionMySQL(); 
            // Preparar la sentencia SQL (Statement) 
            $sentencia = $cnx -> prepare("select * from cliente where nombre like concat('%', :name, '%')");
            $sentencia -> bindValue(":name", $nameSearch);
            // Ejecutar la sentencia SQL 
            $sentencia ->execute();
            // Recoger Fila fetch(PDO::FETCH_ASSOC)
            $listRegistros = $sentencia -> fetchAll(PDO::FETCH_ASSOC);
            // LIBERAR RECURSOS
            $sentencia = null; 
            $cnx = null;

            $listClientes = [];

            foreach($listRegistros as $cliente){
                $newCliente = new Cliente(
                    $cliente["id"],
                    $cliente["nombre"], 
                    $cliente["numruc"],
                    $cliente["direccion"],
                    $cliente["telefono"]
                ); 
                array_push($listClientes, $newCliente);
            }
            return $listClientes;
        }


        public function setInsertar(Cliente $cliente): int{
            // Conectar e instanciar al Objeto PDO 
            $cnx = Conexion::getConexionMySQL(); 
            // Preparar la sentencia SQL (Statement) 
            $sentencia = $cnx -> prepare("insert into cliente (nombre, numruc, direccion, telefono) 
                                          values (:nombre, :numruc, :direccion, :telefono)");
            $sentencia -> bindValue(":nombre", $cliente -> getNombre());
            $sentencia -> bindValue(":numruc", $cliente -> getNumRuc()); 
            $sentencia -> bindValue(":direccion", $cliente -> getDireccion());
            $sentencia -> bindValue(":telefono", $cliente -> getTelefono());

            // Ejecutar la sentencia SQL 
            $sentencia -> execute(); 

            // Recuperar el ID nuevo 
            $nuevoId = $cnx -> lastInsertId();

            // LIBERAR RECURSOS 
            $sentencia = null; 
            $cnx = null;

            // Retornar
            return (int) $nuevoId; 
        }

        public function setActualizar(Cliente $cliente): bool{
            // Conectar e instanciar al Objeto PDO 
            $cnx = Conexion::getConexionMySQL(); 
            // Preparar la sentencia SQL (Statement) 
            $sentencia = $cnx -> prepare("update cliente set nombre = :nombre, numruc = :numruc, 
                                    direccion = :direccion, telefono = :telefono where id = :id");
            $sentencia -> bindValue(":nombre", $cliente -> getNombre());
            $sentencia -> bindValue(":numruc", $cliente -> getNumRuc()); 
            $sentencia -> bindValue(":direccion", $cliente -> getDireccion());
            $sentencia -> bindValue(":telefono", $cliente -> getTelefono());
            $sentencia -> bindValue(":id", $cliente -> getId());

            // Ejecutar la sentencia SQL 
            $ok =  $sentencia -> execute();
            
            // LIBERAR RECURSOS 
            $sentencia = null; 
            $cnx = null;
            
            // Retorna true si se ejecuta SQL correctamente, false si hay error SQL
            return $ok;

        }

        public function setEliminar(int $id): bool{
            // Conectar e instanciar al Objeto PDO 
            $cnx = Conexion::getConexionMySQL(); 
            // Preparar la sentencia SQL (Statement) 
            $sentencia = $cnx -> prepare("delete from cliente where id = :id");
            $sentencia -> bindValue(":id", $id);

            // Ejecutar la sentencia SQL 
            $ok =  $sentencia -> execute();
            
            // LIBERAR RECURSOS 
            $sentencia = null; 
            $cnx = null;
            
            // Retorna true si se ejecuta SQL correctamente, false si hay error SQL
            return $ok;
        }
    }

?>