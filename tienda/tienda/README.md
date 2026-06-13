# Sistema de Gestión de Clientes, Productos y Ventas con PHP PDO

## Descripción

Proyecto académico desarrollado en PHP utilizando PDO para la conexión a una base de datos MySQL. El sistema permite realizar operaciones CRUD sobre clientes, productos y ventas.

Actualmente el proyecto se encuentra en desarrollo y algunos aspectos visuales (CSS) aún están pendientes de completarse o mejorarse.

---

# Requisitos

* PHP 8 o superior.
* MySQL Server.
* MySQL Workbench.
* Servidor local (XAMPP, Laragon, WAMP o similar).
* Navegador web moderno.

---

# Configuración de la Base de Datos

La conexión se encuentra centralizada en la clase `Conexion`.

Ejemplo:

```php
<?php
class Conexion{

    public static function getConexionMySQL(){
        try{
            $cadena = "mysql:host=127.0.0.1;port=3307;dbname=bdmarket";
            $usuario = "root";
            $clave = "root";

            $pdo = new PDO($cadena, $usuario, $clave);

            $pdo->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $pdo;
        }
        catch(PDOException $e){
            echo "Error en la conexión: " . $e->getMessage();
            return null;
        }
    }
}
?>
```

---

# Configuración del Puerto

Es importante verificar el puerto utilizado por tu instalación de MySQL.

En este proyecto se utiliza:

```php
port=3307
```

Sin embargo, muchas instalaciones tienen configurado:

```php
port=3306
```

Para verificar el puerto utilizado:

1. Abrir MySQL Workbench.
2. Ir a la conexión configurada.
3. Seleccionar "Edit Connection".
4. Revisar el valor de "Port".

Si el puerto es diferente, modificar la cadena de conexión:

```php
$cadena = "mysql:host=127.0.0.1;port=TU_PUERTO;dbname=bdmarket";
```

---

# Explicación de la Conexión PDO

## host=127.0.0.1

Indica que la base de datos se encuentra en la misma computadora donde se ejecuta la aplicación.

```php
host=127.0.0.1
```

---

## port=3307

Indica el puerto por el cual MySQL acepta conexiones.

```php
port=3307
```

Debe coincidir con la configuración de MySQL Workbench o del servidor MySQL instalado.

---

## dbname=bdmarket

Especifica la base de datos que utilizará la aplicación.

```php
dbname=bdmarket
```

---

## Usuario y contraseña

Credenciales utilizadas para autenticar la conexión.

```php
$usuario = "root";
$clave = "root";
```

Cada desarrollador debe utilizar las credenciales configuradas en su entorno local.

---

# ¿Qué es PDO?

PDO (PHP Data Objects) es una extensión de PHP que proporciona una interfaz orientada a objetos para trabajar con bases de datos.

Permite:

* Conectarse a diferentes motores de bases de datos.
* Ejecutar consultas SQL.
* Utilizar consultas preparadas.
* Manejar excepciones.
* Obtener resultados de diferentes formas.

Ventajas:

* Mayor seguridad.
* Código más organizado.
* Facilidad de mantenimiento.
* Protección frente a SQL Injection.

---

# Manejo de Errores con PDO

```php
$pdo->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
);
```

Esta configuración indica que PDO debe lanzar excepciones cuando ocurra un error SQL.

Sin esta configuración, muchos errores únicamente devolverían `false`, dificultando detectar la causa del problema.

Gracias a ello es posible utilizar:

```php
try{
    // operaciones SQL
}
catch(PDOException $e){
    echo $e->getMessage();
}
```

---

# Uso de Consultas Preparadas

Ejemplo:

```php
$sentencia = $cnx->prepare(
    "select * from cliente
     where nombre like concat('%', :name, '%')"
);

$sentencia->bindValue(":name", $nameSearch);

$sentencia->execute();
```

---

## ¿Por qué usar prepare()?

La consulta SQL se prepara antes de recibir los datos.

Esto permite:

* Separar datos y código SQL.
* Mejorar la seguridad.
* Evitar SQL Injection.
* Facilitar el mantenimiento.

---

## ¿Por qué usar bindValue()?

```php
$sentencia->bindValue(":name", $nameSearch);
```

Asocia un valor PHP con un parámetro definido en la consulta.

Por ejemplo:

```php
:name
```

será reemplazado por:

```php
$nameSearch
```

de forma segura.

---

# Recuperación de Datos con PDO::FETCH_ASSOC

Ejemplo:

```php
$listRegistros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
```

## ¿Qué significa FETCH_ASSOC?

La palabra ASSOC proviene de "Associative Array" (Arreglo Asociativo).

Al utilizar:

```php
PDO::FETCH_ASSOC
```

PDO construye cada fila obtenida desde la base de datos como un arreglo asociativo donde:

* Las claves son los nombres de las columnas.
* Los valores son los datos almacenados en dichas columnas.

Por ejemplo, si la tabla contiene:

| id | nombre | telefono  |
| -- | ------ | --------- |
| 1  | Juan   | 999999999 |

PDO devolverá:

```php
[
    "id" => 1,
    "nombre" => "Juan",
    "telefono" => "999999999"
]
```

---

## Ventajas de FETCH_ASSOC

Permite acceder a los datos mediante el nombre de cada columna:

```php
$fila["nombre"]
```

en lugar de:

```php
$fila[1]
```

Esto hace que el código sea:

* Más legible.
* Más fácil de entender.
* Más fácil de mantener.
* Menos propenso a errores.

Además, evita almacenar índices numéricos duplicados innecesariamente, reduciendo el consumo de memoria.

---

# Recuperación del Último ID Insertado

Ejemplo:

```php
$nuevoId = $cnx->lastInsertId();
```

## ¿Qué hace lastInsertId()?

Devuelve el valor de la última clave primaria autoincremental generada por MySQL durante una operación INSERT.

Por ejemplo:

Tabla:

| id | descripcion |
| -- | ----------- |
| 1  | Mouse       |
| 2  | Teclado     |

Si ejecutamos:

```php
insert into producto(descripcion)
values('Monitor');
```

MySQL genera automáticamente:

| id | descripcion |
| -- | ----------- |
| 1  | Mouse       |
| 2  | Teclado     |
| 3  | Monitor     |

Entonces:

```php
$nuevoId = $cnx->lastInsertId();
```

devolverá:

```php
3
```

---

## ¿Por qué utilizar lastInsertId()?

Permite conocer el identificador generado inmediatamente después de insertar un registro.

Esto resulta útil para:

* Mostrar el código generado al usuario.
* Asociar registros relacionados.
* Actualizar objetos del modelo.

Ejemplo:

```php
$idNuevo = $productoDAO->setInsertar($producto);

$producto->setId($idNuevo);
```

De esta forma el objeto en memoria queda sincronizado con el registro almacenado en la base de datos.

---

# Estado Actual del Proyecto

## Implementado

* Conexión mediante PDO.
* CRUD de Clientes.
* CRUD de Productos.
* CRUD de Ventas.
* Búsquedas con filtros.
* Validaciones básicas.
* Consultas preparadas.
* Recuperación automática de IDs generados.

## Pendiente

* Completar y mejorar archivos CSS.
* Mejorar la interfaz visual.
* Validaciones adicionales del lado del cliente.
* Refinamiento de la experiencia de usuario.
* Optimización general del código.

---

# Objetivos Académicos

Este proyecto fue desarrollado para practicar:

* Programación Orientada a Objetos en PHP.
* Arquitectura por capas.
* Patrón DAO.
* Uso de PDO.
* Manejo de excepciones.
* Operaciones CRUD.
* Consultas preparadas.
* Seguridad básica frente a SQL Injection.
* Integración entre PHP y MySQL.
