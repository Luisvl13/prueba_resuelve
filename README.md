## Prueba Ingeniería Resuelve
### Problema
---

El sueldo de los jugadores del Resuelve FC se compone de dos partes un sueldo fijo y un bono variable, la suma de estas dos partes es el sueldo de un jugador. El bono variable se compone de dos partes meta de goles individual y meta de goles por equipo cada una tiene un peso de 50%.

Tu programa deberá hacer el cálculo del sueldo de los jugadores del Resuelve FC.

Si quieres saber más de la [Prueba Ingeniería Resuelve](https://github.com/resuelve/prueba-ing-backend) 

[Análisis del problema](https://github.com/Luisvl13/prueba_resuelve/blob/master/public/assets/analisis_problema.pdf) 

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
1. Clonar el repositorio con: `git clone https://github.com/Luisvl13/prueba_resuelve.git`
2. Instalar dependencias: `composer install`
3. Renombrar el archivo `.env.example` a `.env` ubicado en la raiz del directorio de instalación y editarlo.
       
       APP_DEBUG=false
       APP_ENV=production
       DB_HOST=
       DB_DATABASE=prueba_resuelve
       DB_USERNAME=
       DB_PASSWORD=
       
* **APP_DEBUG**: `false`
* **APP_ENV**: `production`.
* **DB_HOST**: Dominio de la conexión a la base de datos.
* **DB_DATABASE**: Nombre de la base de datos.
* **DB_USERNAME**: Usuario con permisos de lectura y escritura para la base de datos.
* **DB_PASSWORD**: Contraseña del usuario.

4. Abrir su Sistema Gestor de Base de Datos y crear la base de datos `prueba_resuelve`.
5. Abrir una terminal con la ruta raiz donde fue clonado el proyecto y correr los siguiente comandos:
    * `php artisan key:generate` genera la key del proyecto
    * `php artisan migrate --seed` crea las tablas y e inserta los datos precargados de muestra.
6. Una vez configurado el proyecto se inicia con `php artisan serve` y nos levanta un servidor: 
    * `http://127.0.0.1:8000` o su equivalente `http://localhost:8000`

### Documentación de la API
---
** La ruta para el calculo del sueldo_completo acepta Array de solo jugadores o un array de equipos con su array de jugadores **

Si desea ver la documentación tiene que levantar el servidor y entrar a la siguiente ruta:
* `http://localhost:8000/api/doc`

Se vera algo asi:
![Ejemplo documentación](https://github.com/Luisvl13/prueba_resuelve/blob/master/public/assets/documentacion.png)

### Pruebas
---
Para ejecutar los test del proyecto puede correr:

Para todas las pruebas 
* `php artisan test`

De manera individual
* `php artisan test --filter test_suma_goles_meta_equipo`
* `php artisan test --filter test_suma_goles_anotados_equipo`
* `php artisan test --filter test_porcentaje_alcance_bono_equipo`
* `php artisan test --filter test_sueldo_completo`
