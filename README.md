# Proyecto Login

**Alumna:** Yarleth Diaz
**Materia:** Analisis de sistemas
**Año de cursada:** 2026
**Trabajo Práctico:** TP3 – Proyecto Login (con documentación UML del TP4)

---

## Descripción

Sistema de autenticación de usuarios desarrollado con HTML5, CSS3, JavaScript y PHP 8, con persistencia en una base de datos relacional MySQL. Permite registrarse, iniciar sesión, acceder a un dashboard protegido por sesión, cerrar sesión y recuperar la contraseña.

## Funcionalidades

- **Inicio de sesión:** formulario con correo y contraseña, validado con el atributo `required` y con JavaScript. Los datos se envían por `POST` a un archivo PHP que consulta la base con un `SELECT`.
- **Registro de usuarios:** formulario con nombre, apellido, correo y contraseña, con campo de confirmación. PHP guarda los datos con un `INSERT`.
- **Dashboard:** mensaje de bienvenida al usuario logueado, accesible solo con sesión iniciada.
- **Cierre de sesión:** destruye la sesión y vuelve al login.
- **Recuperación de contraseña (opcional):** el usuario confirma su correo y apellido y elige una contraseña nueva.
- **Diseño responsive** en tonos rosa pastel.

## Tecnologías

| Capa | Tecnología |
|---|---|
| Front-end | HTML5, CSS3, JavaScript |
| Back-end | PHP 8 |
| Base de datos | MySQL (puerto 3306) |
| Servidor local | XAMPP – Apache (puertos 80 y 443), localhost (127.0.0.1) |

## Estructura del proyecto

```
ProyectoLogin_TP3/
├── css/
│   └── estilos.css
├── js/
│   └── validaciones.js
├── conexion.php
├── index.php                 # Login
├── registro.php              # Alta de usuario
├── olvide_password.php       # Recuperar contraseña
├── procesar_login.php
├── procesar_registro.php
├── dashboard.php
├── logout.php
└── README.md
```

## Base de datos

Base: `login_db`. Tabla: `usuarios`.

| Campo | Tipo | Detalle |
|---|---|---|
| id | INT | PK, autoincremental |
| nombre | VARCHAR(50) | Obligatorio |
| apellido | VARCHAR(50) | Obligatorio |
| correo | VARCHAR(100) | Obligatorio, único |
| password | VARCHAR(255) | Obligatorio, guardada con hash |
| fecha_registro | TIMESTAMP | Valor por defecto: fecha actual |

El archivo `conexion.php` crea la base y la tabla automáticamente si todavía no existen.

## Instalación y ejecución

1. Instalar [XAMPP](https://www.apachefriends.org/) e iniciar **Apache** y **MySQL** desde su panel de control.
2. Copiar la carpeta del proyecto dentro de `C:\xampp\htdocs\`.
3. Abrir en el navegador: `http://localhost/NOMBRE_DE_LA_CARPETA/`
4. Crear una cuenta desde **Crear una** e iniciar sesión.

> No abrir los archivos con doble clic ni con Live Server: PHP necesita ejecutarse a través de Apache.

## Validaciones

- **En el cliente (JavaScript):** campos vacíos, correo `@gmail.com`, contraseña de mínimo 8 caracteres con mayúscula, minúscula, número y símbolo, y coincidencia entre contraseña y confirmación.
- **En el servidor (PHP):** se repiten las validaciones, se evita el correo duplicado y se usan consultas preparadas contra inyección SQL.

## Seguridad

- Las contraseñas se guardan con `password_hash()` y se verifican con `password_verify()`.
- Consultas preparadas con `mysqli` (`prepare` / `bind_param`).
- Salida escapada con `htmlspecialchars()`.
- Sesión regenerada al iniciar sesión (`session_regenerate_id`).
