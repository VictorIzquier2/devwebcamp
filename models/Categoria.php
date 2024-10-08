<?php

namespace Model;

class Categoria extends ActiveRecord{
  protected static $tabla = 'categorias';
  protected static $columnasDB = ['id', 'nombre'];

  public $id;
  public $nombre;

  public function __construct($args = []) {
    $this->id = $args['id'] ?? '';
    $this->id = $args['nombre'] ?? '';
  }

  public function validar() {
    if(!$this->nombre) {
        self::$alertas['error'][] = 'El Nombre es Obligatorio';
    }
    return self::$alertas;
  }
}

?>