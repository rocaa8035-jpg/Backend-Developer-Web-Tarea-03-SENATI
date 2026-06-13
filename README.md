# Backend-Developer-Web-Tarea-03-SENATI

Esta tarea trata sobre la ceación y analisis profundo de una app web para la gestión dinámica de una base de datos implementando un "CRUD" (Create, Read, Update, and Delete).
La tarea fue hecha con la ayuda de 3 compañeros de clase

<img width="492" height="262" alt="Captura de pantalla 2026-06-04 203721" src="https://github.com/user-attachments/assets/2a2c985c-2f92-46dd-9f63-5df19d2e5b24" />
<img width="1365" height="767" alt="Captura de pantalla 2026-06-05 173819" src="https://github.com/user-attachments/assets/80563f18-7b01-4e89-9bd1-92dc36bf1906" />
<img width="1365" height="295" alt="Captura de pantalla 2026-06-05 174039" src="https://github.com/user-attachments/assets/c817cb4e-43af-47d1-9ff4-f46ef7de9ec7" />

------------------------------
## Guía de Instalación y Despliegue Local
Sigue estos pasos para configurar el entorno local con XAMPP y ejecutar la aplicación web.
## 1. Requisitos Previos e Instalación

   1. Descarga XAMPP desde el sitio oficial de Apache Friends.
   2. Ejecuta el instalador.
   3. Deja las opciones por defecto.
   4. Finaliza la instalación.

## 2. Ubicación del Proyecto
Para que el servidor web pueda leer tus archivos, debes mover la carpeta de tu proyecto a la ruta correcta.

* Ruta exacta en Windows: C:\xampp\htdocs\
* Acción: Copia la carpeta llamada tienda dentro de htdocs.
* Resultado: La estructura debe quedar así: C:\xampp\htdocs\tienda\

## 3. Encender los Servicios

   1. Abre el programa XAMPP Control Panel.
   2. Busca el módulo Apache y haz clic en Start.
   3. Busca el módulo MySQL y haz clic en Start.
   4. Verifica que ambos nombres se pongan en color verde.

## 4. Configurar la Base de Datos

   1. Abre tu navegador web.
   2. Entra a la URL de gestión: http://localhost/phpmyadmin/
   3. Haz clic en Nueva (menú izquierdo).
   4. Escribe el nombre de la base de datos.
   5. Haz clic en Crear.
   6. Importa el archivo .sql en la pestaña Importar.

## 5. Ejecutar la Aplicación en el Navegador
Una vez que el proyecto esté en htdocs y los servicios estén encendidos, abre tu navegador.

* URL principal a ingresar: http://localhost/tienda/tienda/

## 6. Tecnologías Utilizadas

* Backend: PHP
* Frontend: JavaScript, HTML, CSS
* Base de datos: MySQL (vía MariaDB en XAMPP)
* Servidor local: Apache
