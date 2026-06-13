<?php 
require_once(__DIR__ . "/Cliente.php");
    class Venta{
        //Propiedades 
        private ?int $id; 
        private ?Cliente $cliente;
        private ?string $fecha; 

        // Constructor 
        function __construct(?int $id = null, ?Cliente $cliente = null, ?string $fecha = null){
            $this -> id = $id; 
            $this -> cliente = $cliente; 
            $this -> fecha = $fecha;
        }

        // Get and Set
        function getId(): ?int{
            return $this ->id;
        }

        public function setId(int $new): void{
            $this -> id = $new;
        }

        function getCliente(): ?Cliente{
            return $this -> cliente;
        }

        function setCliente(Cliente $new): void{
            $this -> cliente = $new;
        } 

        function getFecha(): ?string{
            return $this -> fecha;
        }

        function setFecha(string $new): void{
            $this -> fecha = $new;
        }

    }
?>