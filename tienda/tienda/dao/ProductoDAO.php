<?php 
require_once(__DIR__. "/../config/conexion.php");
require_once(__DIR__ . "/../models/Producto.php");

    class ProductoDAO{
        // MÉTODOS CRUD (Create, Read, Update, Delete)
        public function getBuscarPorId(int $idSearch): ?Producto{
            // Conectar e instanciar al Objeto PDO 
            $cnx = Conexion::getConexionMySQL(); 
            // Preparar la sentencia SQL (Statement) 
            $sentencia = $cnx -> prepare("select * from producto where id=:idSearch");
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

            return new Producto(
                $registro["id"] ,
                $registro["descripcion"],
                $registro["categoria"],
                $registro["precio"]
            );
        }

        public function getBuscarPorDescripcion(string $descSearch): ?array{
            // Conectar e instanciar al Objeto PDO 
            $cnx = Conexion::getConexionMySQL(); 
            // Preparar la sentencia SQL (Statement) 
            $sentencia = $cnx -> prepare("select * from producto where descripcion like concat('%', :desc, '%')");
            $sentencia -> bindValue(":desc", $descSearch);
            // Ejecutar la sentencia SQL 
            $sentencia ->execute();
            // Recoger Fila fetch(PDO::FETCH_ASSOC)
            $listRegistros = $sentencia -> fetchAll(PDO::FETCH_ASSOC);
            // LIBERAR RECURSOS
            $sentencia = null; 
            $cnx = null;

            $listProductos = [];

            foreach($listRegistros as $producto){
                $newProducto = new Producto(
                    $producto["id"],
                    $producto["descripcion"], 
                    $producto["categoria"],
                    $producto["precio"]
                ); 
                array_push($listProductos, $newProducto);
            }
            return $listProductos;
        }

        public function setInsertar(Producto $producto): int{
            // Conectar e instanciar al Objeto PDO 
            $cnx = Conexion::getConexionMySQL(); 
            // Preparar la sentencia SQL (Statement) 
            $sentencia = $cnx -> prepare("insert into producto (descripcion, categoria, precio)
                                          values (:descripcion, :categoria, :precio)");
            $sentencia -> bindValue(":descripcion", $producto -> getDescripcion());
            $sentencia -> bindValue(":categoria", $producto -> getCategoria()); 
            $sentencia -> bindValue(":precio",$producto -> getPrecio());

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

        public function setActualizar(Producto $producto): bool{
            // Conectar e instanciar al Objeto PDO 
            $cnx = Conexion::getConexionMySQL(); 
            // Preparar la sentencia SQL (Statement) 
            $sentencia = $cnx -> prepare("update producto set descripcion = :descripcion, categoria = :categoria, 
                                    precio = :precio where id = :id");
            $sentencia -> bindValue(":descripcion", $producto -> getDescripcion());
            $sentencia -> bindValue(":categoria", $producto -> getCategoria()); 
            $sentencia -> bindValue(":precio", $producto -> getPrecio());
            $sentencia -> bindValue(":id", $producto -> getId());

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
            $sentencia = $cnx -> prepare("delete from producto where id = :id");
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