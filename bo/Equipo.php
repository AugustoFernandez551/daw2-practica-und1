<?php
namespace bo;

use dao\Equipo as EquipoDAO;
use dto\Equipo as EquipoDTO;

class Equipo {
    private $dao;

    public function __construct() {
        $this->dao = new EquipoDAO();
    }

    public function registrar($codigo, $nombre, $categoria) {
        $equipo = new EquipoDTO(null, $codigo, $nombre, $categoria, 'OPERATIVO');
        return $this->dao->registrar($equipo);
    }

    public function listar() {
        return $this->dao->listar();
    }

    public function buscar($texto) {
        return $this->dao->buscarPorCategoria($texto);
    }

    public function cambiarEstado($id) {
        $equipo = $this->dao->obtenerPorId($id);
        if ($equipo) {
            $nuevoEstado = ($equipo->getEstado() === 'OPERATIVO') ? 'BAJA' : 'OPERATIVO';
            return $this->dao->actualizarEstado($id, $nuevoEstado);
        }
        return false;
    }
}