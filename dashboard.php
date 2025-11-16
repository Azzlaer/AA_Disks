<?php
require_once "config.php";

// Protege el dashboard
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require_once "controllers/DrivesController.php";
$controller = new DrivesController();

// Obtener lista de discos
$drives = $controller->listDrives();

// Obtener lista de letras ocultas por Registro
$hidden = $controller->getHiddenDrivesReg();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Dashboard | Gestión de Unidades</title>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: "Segoe UI", Arial;
        background: #eef1f6;
    }

    .header {
        background: #1f2937;
        color: white;
        padding: 18px 25px;
        font-size: 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 3px 8px rgba(0,0,0,0.3);
    }

    .logout {
        color: #f87171;
        text-decoration: none;
        font-weight: bold;
    }

    .container {
        margin: 40px auto;
        width: 90%;
        max-width: 1100px;
        background: white;
        padding: 30px;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    h2 {
        margin-top: 0;
        font-size: 26px;
        color: #374151;
        margin-bottom: 25px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    th, td {
        padding: 12px;
        border-bottom: 1px solid #d7dce3;
        text-align: center;
    }

    th {
        background: #f3f4f6;
        font-size: 16px;
        color: #374151;
    }

    tr:hover {
        background: #f8fafc;
    }

    .btn {
        padding: 8px 12px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        margin: 3px;
        font-size: 14px;
    }

    .hide { background: #ef4444; color: white; }
    .show { background: #10b981; color: white; }
    .remove { background: #6366f1; color: white; }
    .assign { background: #3b82f6; color: white; }

    .badge {
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 13px;
        color: white;
    }

    .ok { background: #16a34a; }
    .warn { background: #f59e0b; }
    .danger { background: #dc2626; }

</style>
</head>
<body>

<div class="header">
    Panel de Gestión de Unidades
    <a class="logout" href="logout.php">Cerrar sesión</a>
</div>

<div class="container">
    <h2>Unidades detectadas en el sistema</h2>

    <table>
        <tr>
            <th>Unidad</th>
            <th>Volumen / Tipo</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>

        <?php foreach ($drives as $drive): ?>
            <?php
                $letter   = $drive["Letter"];
                $volume   = $drive["Volume"];
                $type     = $drive["Type"];
                $letterExists = ($letter !== "");
                $isHidden     = in_array($letter, $hidden);
            ?>
        <tr>
            <td><strong><?= $letter ?: "(sin letra)" ?></strong></td>
            <td><?= $volume ?> (<?= $type ?>)</td>

            <td>
                <?php if (!$letterExists): ?>
                    <span class="badge warn">Sin letra</span>
                <?php elseif ($isHidden): ?>
                    <span class="badge danger">Oculta por Registro</span>
                <?php else: ?>
                    <span class="badge ok">Visible</span>
                <?php endif; ?>
            </td>

            <td>
                <form method="post" action="index.php" style="display:inline-block;">
                    <input type="hidden" name="drive" value="<?= $letter ?>">

                    <?php if ($letterExists): ?>
                        <?php if ($isHidden): ?>
                            <button class="btn show" name="action" value="show_reg">Mostrar</button>
                        <?php else: ?>
                            <button class="btn hide" name="action" value="hide_reg">Ocultar</button>
                        <?php endif; ?>

                        <button class="btn remove" name="action" value="remove_letter">Quitar letra</button>
                    <?php else: ?>
                        <button class="btn assign" name="action" value="assign_letter">Asignar letra</button>
                    <?php endif; ?>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
