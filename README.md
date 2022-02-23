## Prueba Ingeniería Resuelve
### Problema
---

El sueldo de los jugadores del Resuelve FC se compone de dos partes un sueldo fijo y un bono variable, la suma de estas dos partes es el sueldo de un jugador. El bono variable se compone de dos partes meta de goles individual y meta de goles por equipo cada una tiene un peso de 50%.

Tu programa deberá hacer el cálculo del sueldo de los jugadores del Resuelve FC.

### Guía de instalación
---
#### Requisitos del servidor

Para poder instalar y utilizar esta API, deberá asegurarse de que su servidor cumpla con los siguientes requisitos:
* PHP >= 7.3
* BCMath PHP Extension
* Ctype PHP Extension
* Fileinfo PHP Extension
* JSON PHP Extension
* Mbstring PHP Extension
* OpenSSL PHP Extension
* PDO PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* [Composer](https://getcomposer.org/) es una librería de PHP para el manejo de dependencias.

#### Instalación
##### Laravel
Deberá tener instalado Laravel para poder correr el proyecto si no lo tiene siga las instrucciones del siguiente link:
* [Guia de Instalación Oficial de Laravel 8](https://laravel.com/docs/8.x/installation)
##### Proyecto
1. Clonar el repositorio con: `git clone https://github.com/Luisvl13/prueba_resuelve`
2. Instalar dependencias: `composer install`
3. Renombrar el archivo `.env.example` a `.env` ubicado en la raiz del directorio de instalación y editarlo.
       
       APP_DEBUG=false
       APP_ENV=production
       DB_HOST=
       DB_DATABASE=prueba_resuelve
       DB_USERNAME=
       DB_PASSWORD=
       
* **APP_KEY**: Clave de encriptación para laravel.
* **APP_DEBUG**: `false`
* **APP_ENV**: `production`.
* **DB_HOST**: Dominio de la conexión a la base de datos.
* **DB_DATABASE**: Nombre de la base de datos.
* **DB_USERNAME**: Usuario con permisos de lectura y escritura para la base de datos.
* **DB_PASSWORD**: Contraseña del usuario.
4. Genera key: `php artisan key:generate`

5. Abrir su Sistema Gestor de Base de Datos y crear la base de datos `prueba_resuelve`.
6. Abrir una terminal con la ruta raiz donde fue clonado el proyecto y correr los siguiente comandos:
    * `php artisan key:generate` genera la key del proyecto
    * `php artisan migrate --seed` crea las tablas y e inserta los datos precargados de muestra.
7. Una vez configurado el proyecto se inicia con `php artisan serve` y nos levanta un servidor: 
    * `http://127.0.0.1:8000` o su equivalente `http://localhost:8000`

