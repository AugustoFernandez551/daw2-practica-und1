<?php

namespace dao;

use PDO;
use PDOException;

class Conexion
{
    protected $conexion;

    public function __construct()
    {
        try {

            $this->conexion = new PDO(
                "mysql:host=127.0.0.1;dbname=practica_daw2_und1;charset=utf8",
                "root",
                ""
            );

            $this->conexion->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function getConexion()
    {
        return $this->conexion;
    }
}
