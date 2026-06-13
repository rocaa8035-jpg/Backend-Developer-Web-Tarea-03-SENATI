<?php 
// Declarar la clase para la conexión a la BD
class Conexion{
    // Propiedades
    
    // Metodos
    public static function getConexionMySQL(){
        try{
            $cadena = "mysql:host=127.0.0.1;port=3307;dbname=bdmarket";
            $usuario = "root";
            $clave = "root";

            // Instanciar un nuevo objeto PDO
            $pdo = new PDO($cadena, $usuario, $clave);

            // Configura PDO para que lance excepciones en caso de errores SQL.
            // Esto asegura un manejo consistente de errores mediante try/catch,
            // evitando comportamientos silenciosos o retornos falsos en operaciones fallidas.
            $pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // RETORNAMOS EL OBJETO PDO  (PHP DATA OBJECT)
            return $pdo;
        }
        catch(PDOException $e){
            echo "Error en la conexión: " . $e -> getMessage();
            return null;
        }
    }
}                                                                                                                                                                                                                    
?>