<?php

spl_autoload_register(function ($clase) {

    $ruta = str_replace("\\", "/", $clase);

    $archivo = __DIR__ . "/../" . $ruta . ".php";

    if (file_exists($archivo)) {
        require_once $archivo;
    }
});
