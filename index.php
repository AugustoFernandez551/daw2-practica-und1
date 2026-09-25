<?php

require_once "config/Autoload.php";

// TODO:
// importar el BO correspondiente
use bo\Equipo as EquipoBO;

// instanciar el objeto BO correspondiente
$equipoBO = new EquipoBO();

$registros = [];

/*
|--------------------------------------------------------------------------
| REGISTRAR
|--------------------------------------------------------------------------
*/

if (
    $_SERVER["REQUEST_METHOD"] === "POST"
    && ($_POST["accion"] ?? "") === "registrar"
) {

    // TODO:
    // llamar al método registrar()
    $codigo = trim($_POST["codigo"] ?? "");
    $nombre = trim($_POST["nombre"] ?? "");
    $categoria = trim($_POST["categoria"] ?? "");

    if (!empty($codigo) && !empty($nombre) && !empty($categoria)) {
        $equipoBO->registrar($codigo, $nombre, $categoria);
    }
}


/*
|--------------------------------------------------------------------------
| CAMBIAR ESTADO
|--------------------------------------------------------------------------
*/

if (
    $_SERVER["REQUEST_METHOD"] === "POST"
    && ($_POST["accion"] ?? "") === "cambiarEstado"
) {

    // TODO:
    // llamar al método cambiarEstado()
    $id = intval($_POST["id"] ?? 0);
    if ($id > 0) {
        $equipoBO->cambiarEstado($id);
    }
}


/*
|--------------------------------------------------------------------------
| BUSCAR / LISTAR
|--------------------------------------------------------------------------
*/

if (!empty($_GET["buscar"])) {

    // TODO:
    // llamar al método buscar()
    $registros = $equipoBO->buscar($_GET["buscar"]);

} else {

    // TODO:
    // llamar al método listar()
    $registros = $equipoBO->listar();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Práctica Unidad I</title>
</head>

<body>

    <h1>Gestión de registros</h1>

    <!-- FORMULARIO DE REGISTRO -->

    <form method="POST">

        <input type="hidden" name="accion" value="registrar">

        <!--
            Aquí van los campos
            correspondientes a la variante
        -->
        <label>Código: <input type="text" name="codigo" required></label>
        <label>Nombre: <input type="text" name="nombre" required></label>
        <label>Categoría: <input type="text" name="categoria" required></label>

        <button type="submit">
            Registrar
        </button>

    </form>


    <hr>


    <!-- FORMULARIO DE BÚSQUEDA -->

    <form method="GET">

        <input
            type="text"
            name="buscar"
            placeholder="Buscar">

        <button type="submit">
            Buscar
        </button>

    </form>


    <hr>


    <!-- LISTADO -->

    <table border="1" cellpadding="5">

        <thead>
            <tr>
                <!-- columnas -->
                <th>ID</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($registros as $item): ?>

                <tr>

                    <!-- datos -->
                    <td><?= $item->getId() ?></td>
                    <td><?= $item->getCodigo() ?></td>
                    <td><?= $item->getNombre() ?></td>
                    <td><?= $item->getCategoria() ?></td>
                    <td><?= $item->getEstado() ?></td>

                    <td>

                        <form method="POST">

                            <input
                                type="hidden"
                                name="accion"
                                value="cambiarEstado">

                            <input
                                type="hidden"
                                name="id"
                                value="<?= $item->getId() ?>">

                            <button type="submit">
                                Cambiar estado
                            </button>

                        </form>

                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</body>

</html>