# 🚀 Proyecto de Gestión de Unidades Windows -- Panel Web

Desarrollado con ❤️ por **ChatGPT (OpenAI)** y **Azzlaer** para
**LatinBattle.com**

------------------------------------------------------------------------

## 📌 ¿Qué es este proyecto?

Este proyecto es una herramienta web creada en **PHP** que permite
administrar unidades de almacenamiento en **Windows 10/11** mediante
PowerShell.\
El sistema incluye autenticación y un dashboard para realizar tareas
avanzadas de administración del sistema desde un entorno web seguro.

------------------------------------------------------------------------

![Descripci贸n de la imagen](https://github.com/Azzlaer/AA_Disks/blob/main/capturas/01.png)
![Descripci贸n de la imagen](https://github.com/Azzlaer/AA_Disks/blob/main/capturas/02.png)


## 🧩 Características principales

### 🔐 Sistema de Login

-   Autenticación segura vía PHP.\
-   Configurable mediante un archivo `config.php`.\
-   Evita accesos no autorizados a las herramientas del servidor.

### 💽 Panel de Control de Unidades (Dashboard)

Permite administrar unidades del sistema Windows:

-   📋 Listado detallado de unidades detectadas.\
-   👁️ Ocultar unidades en el Explorador de Windows (modificando
    registro).\
-   🔓 Mostrar todas las unidades nuevamente.\
-   ❌ Quitar letras de unidad utilizando PowerShell.\
-   🆕 Asignar letras nuevas a particiones sin letra.

Todo de forma visual, organizada y sin necesidad de abrir PowerShell
manualmente.

------------------------------------------------------------------------

## ⚙️ Estructura del proyecto

    /aadrivers
    │
    ├── controllers/
    │   └── DrivesController.php   # Lógica de manipulación de unidades
    │
    ├── views/
    │   ├── login.php              # Formulario de acceso
    │   ├── dashboard.php          # Panel principal del sistema
    │   └── templates/             # Estilos / layouts globales
    │
    ├── config.php                 # Credenciales y parámetros del sistema
    ├── index.php                  # Página inicial / redirección
    └── README.md                  # Este archivo

------------------------------------------------------------------------

## 🔧 Requisitos

-   🖥️ Windows 10 / 11 (64-bit)\
-   🧩 XAMPP / WAMP / Laragon o cualquier servidor Apache con PHP\
-   ⚡ PowerShell habilitado\
-   🔑 Permisos administrativos para ejecutar comandos sobre discos

------------------------------------------------------------------------

## 🛡️ Seguridad

Este proyecto toca funciones sensibles del sistema operativo:\
➡️ **Modificar letras de unidad**\
➡️ **Cambiar valores del registro (Registry)**

⚠️ Asegúrate de proteger el acceso al panel con contraseñas fuertes y,
si es posible, habilitar HTTPS.

------------------------------------------------------------------------

## ✨ Crédtios

Proyecto creado por:

-   🤖 **ChatGPT -- OpenAI**\
-   🧑‍💻 **Azzlaer**\
-   🌐 Para la comunidad de **LatinBattle.com**

------------------------------------------------------------------------

## 📄 Licencia

Este proyecto puede ser utilizado y modificado con fines personales o
educativos.\
No se recomienda su uso en entornos de producción sin auditoría de
seguridad previa.

------------------------------------------------------------------------

## 🏁 ¡Gracias por usar este panel!

Si deseas agregar módulos, mejorar UI/UX o integrar más funciones, ¡solo
dímelo! 😄
