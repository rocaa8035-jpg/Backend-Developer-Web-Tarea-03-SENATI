<?php 
    class Producto{
        // Propiedades
        private ?int $id = null;
        private ?string $descripcion;
        private ?string $categoria;
        private ?float $precio;  


        // Constructor
        function __construct(
            ?int $id = null,
            ?string $descripcion = null, 
            ?string $categoria = null, 
            ?float $precio = null 
        ){
            $this -> id = $id; 
            $this -> descripcion = $descripcion; 
            $this -> categoria = $categoria; 
            $this -> precio = $precio;
        }

        // Métodos GET y SET 
        public function getId(): ?int{
            return $this -> id;
        }

        public function setId(int $new): void{
            $this -> id = $new;
        }

        public function getDescripcion(): ?string{
            return $this -> descripcion;
        }

        public function setDescripcion(string $new): void{
            $this -> descripcion = $new;
        }

        public function getCategoria(): ?string{
            return $this -> categoria;
        }

        public function setCategoria(string $new): void{
            $this -> categoria = $new;
        }

        public function getPrecio(): ?float{
            return $this -> precio;
        }

        public function setPrecio(float $new): void{
            $this -> precio = $new;
        }

    }


?>