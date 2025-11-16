<?php
$controller = new DrivesController();
$drives = $controller->listDrives();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/style.css">
    <meta charset="UTF-8">
    <title>Panel de Control de Unidades</title>
</head>
<body>

<h1>Panel de Administración de Unidades</h1>

<table>
    <tr>
        <th>Unidad</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($drives as $drive): ?>
    <tr>
        <td><?= $drive ?>:</td>
        <td>
            <form method="post">
                <input type="hidden" name="drive" value="<?= $drive ?>">
                <button name="action" value="hide_reg">Ocultar en Explorer</button>
                <button name="action" value="show_reg">Mostrar</button>
                <button name="action" value="remove_letter">Quitar letra</button>
                <button name="action" value="assign_letter">Asignar letra</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
