<?php
namespace dao;

use dto\Equipo as EquipoDTO;
use PDO;

class Equipo {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::getInstancia()->getConexion();
    }

    public function registrar(EquipoDTO $equipo) {
        $sql = "INSERT INTO equipos (codigo, nombre, categoria, estado) VALUES (:codigo, :nombre, :categoria, :estado)";
        $stmt = $this->conexion->prepare($sql);
        
        $codigo = $equipo->getCodigo();
        $nombre = $equipo->getNombre();
        $categoria = $equipo->getCategoria();
        $estado = $equipo->getEstado();

        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':estado', $estado);

        return $stmt->execute();
    }

    public function listar() {
        $sql = "SELECT * FROM equipos";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        $lista = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $lista[] = new EquipoDTO($row['id'], $row['codigo'], $row['nombre'], $row['categoria'], $row['estado']);
        }
        return $lista;
    }

    public function buscarPorCategoria($texto) {
        $sql = "SELECT * FROM equipos WHERE categoria LIKE :categoria";
        $stmt = $this->conexion->prepare($sql);
        $filtro = "%" . $texto . "%";
        $stmt->bindParam(':categoria', $filtro);
        $stmt->execute();

        $lista = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $lista[] = new EquipoDTO($row['id'], $row['codigo'], $row['nombre'], $row['categoria'], $row['estado']);
        }
        return $lista;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM equipos WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new EquipoDTO($row['id'], $row['codigo'], $row['nombre'], $row['categoria'], $row['estado']);
        }
        return null;
    }

    public function actualizarEstado($id, $nuevoEstado) {
        $sql = "UPDATE equipos SET estado = :estado WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':estado', $nuevoEstado);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}