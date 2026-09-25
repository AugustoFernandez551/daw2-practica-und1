<?php
namespace dto;

class Equipo {
    private $id;
    private $codigo;
    private $nombre;
    private $categoria;
    private $estado;

    public function __construct($id = null, $codigo = null, $nombre = null, $categoria = null, $estado = 'OPERATIVO') {
        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->categoria = $categoria;
        $this->estado = $estado;
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getCodigo() { return $this->codigo; }
    public function setCodigo($codigo) { $this->codigo = $codigo; }

    public function getNombre() { return $this->nombre; }
    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getCategoria() { return $this->categoria; }
    public function setCategoria($categoria) { $this->categoria = $categoria; }

    public function getEstado() { return $this->estado; }
    public function setEstado($estado) { $this->estado = $estado; }
}
