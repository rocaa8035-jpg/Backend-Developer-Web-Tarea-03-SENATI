<?php 
    class Cliente{
        private ?int $id;
        private ?string $nombre; 
        private ?string $numruc; 
        private ?string $direccion; 
        private ?string $telefono; 

        // Constructor 
        function __construct(
            ?int $id = null, 
            ?string $nombre = null, 
            ?string  $numruc = null, 
            ?string $direccion = null, 
            ?string $telefono = null){
            
            $this -> id = $id;
            $this -> nombre = $nombre;
            $this -> numruc = $numruc; 
            $this -> direccion = $direccion;
            $this -> telefono = $telefono;
        }

        // Métodos GET y SET 
        public function getId(): ?int{
            return $this -> id;
        }

        public function setId(int $new): void{
            $this -> id = $new;
        }

        public function getNombre(): ?string{
            return $this -> nombre;
        }

        public function setNombre(string $new): void{
            $this -> nombre = $new;
        }

        public function getNumRuc(): ?string{
            return $this -> numruc;
        }

        public function setNumRuc(string $new): void{
            $this -> numruc = $new;
        }

        public function getDireccion(): ?string{
            return $this -> direccion;
        }

        public function setDireccion(string $new): void{
            $this -> direccion = $new;
        }

        public function getTelefono(): ?string{
            return $this -> telefono;
        }

        public function setTelefono(string $new): void{
            $this -> telefono = $new;
        }

    }
?>