<?php
require_once "config.php";

// Si ya está logueado, redirigir
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = trim($_POST['user'] ?? "");
    $pass = trim($_POST['pass'] ?? "");

    if ($user === ADMIN_USER && password_verify($pass, ADMIN_PASS_HASH)) {
        $_SESSION['logged_in'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel | Ingreso</title>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: "Segoe UI", Arial;
        background: linear-gradient(135deg, #1c1f26, #2a3140);
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-container {
        background: #ffffff;
        width: 360px;
        padding: 35px 40px;
        border-radius: 14px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.25);
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #222;
        font-size: 26px;
        letter-spacing: 1px;
    }

    input {
        width: 100%;
        padding: 12px 14px;
        margin: 12px 0;
        border-radius: 8px;
        border: 1px solid #cdd3dd;
        font-size: 15px;
        background: #f5f7fa;
        transition: all .2s ease;
    }

    input:focus {
        border-color: #3b82f6;
        outline: none;
        background: #ffffff;
        box-shadow: 0 0 5px rgba(59,130,246,0.4);
    }

    button {
        width: 100%;
        padding: 12px;
        margin-top: 12px;
        border: none;
        border-radius: 8px;
        background: #3b82f6;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: .2s;
        box-shadow: 0 4px 12px rgba(59,130,246,0.3);
    }

    button:hover {
        background: #2563eb;
        box-shadow: 0 6px 15px rgba(37,99,235,0.35);
    }

    .error {
        margin-top: 15px;
        padding: 10px;
        background: #ffe1e1;
        color: #c62828;
        text-align: center;
        border-radius: 8px;
        font-size: 14px;
        animation: shake .3s;
    }

    @keyframes shake {
        0% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        50% { transform: translateX(5px); }
        75% { transform: translateX(-5px); }
        100% { transform: translateX(0); }
    }

</style>

</head>
<body>

<div class="login-container">
    <h2>Acceso al Panel</h2>

    <form method="post">
        <input type="text" name="user" placeholder="Usuario" required>
        <input type="password" name="pass" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>

    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
</div>

</body>
</html>
