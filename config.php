<?php
// Usuario permitido
define("ADMIN_USER", "Azzlaer");

define("ADMIN_PASS_HASH", password_hash("12345", PASSWORD_DEFAULT));


// HASH seguro de la contraseña (NO guardes la contraseña en texto plano)
// Ejemplo: contraseña = 12345
//define("ADMIN_PASS_HASH", '$2y$10$1Z5zG9PEfUjS0HjMgVn7DuHjJ6I/K8DJC/FYCphE5D9NzYJUZqAQS');

// Start de sesión global para todos los archivos
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
