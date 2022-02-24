## Prueba Ingeniería Resuelve
### Problema
---

El sueldo de los jugadores del Resuelve FC se compone de dos partes un sueldo fijo y un bono variable, la suma de estas dos partes es el sueldo de un jugador. El bono variable se compone de dos partes meta de goles individual y meta de goles por equipo cada una tiene un peso de 50%.

Tu programa deberá hacer el cálculo del sueldo de los jugadores del Resuelve FC.

Si quieres saber más de la [Prueba Ingeniería Resuelve](https://github.com/resuelve/prueba-ing-backend) 

[Análisis del problema](https://github.com/Luisvl13/prueba_resuelve/blob/master/public/assets/analisis_problema.pdf) 

### Guía de instalación
---

Si desea ver la forma de correr el proyecto sin docker vaya este link:
[Instalación sin docker](https://github.com/Luisvl13/prueba_resuelve/blob/master/READMESINDOCKER.md) 

#### Requisitos del servidor

* [Docker](https://www.docker.com/) plataforma de software que le permite crear, probar e implementar aplicaciones rápidamente.

#### Instalación
1. Renombrar el archivo `.env.example` a `.env` ubicado en la raiz del directorio de instalación y editarlo.
2. Sustituir las variables por estas:
       
        DB_CONNECTION=mysql
        DB_HOST=db
        DB_PORT=3306
        DB_DATABASE=prueba_resuelve
        DB_USERNAME=resuelve_user
        DB_PASSWORD=password

3. Cree la imagen con `docker-compose build app`
4. Ejecute imagen `docker-compose up -d`
5. Instalar composer `docker-compose exec app composer install`
6. Generar la key del proyecto `docker-compose exec app php artisan key:generate`
7. Ejecuta migraciones e insertar datos precargados`docker-compose exec app php artisan migrate:fresh --seed`
8. (Opcional) [Postman](https://www.getpostman.com/) que permite el envío de peticiones HTTP REST sin necesidad de desarrollar un cliente. Probar con la ruta:
    * `http://127.0.0.1:8000` o su equivalente `http://localhost:8000`

### Documentación de la API
---
** La ruta para el calculo del sueldo_completo acepta Array de solo jugadores o un array de equipos con su array de jugadores **

Si desea ver la documentación tiene que levantar el servidor y entrar a la siguiente url en su navegador:
* `http://localhost:8000/api/doc`

Se vera algo asi:
![Ejemplo documentación](https://github.com/Luisvl13/prueba_resuelve/blob/master/public/assets/documentacion.png)

### Pruebas
---
Para ejecutar los test del proyecto puede correr:

Para todas las pruebas 
* `docker-compose exec app php artisan test`

De manera individual
* `docker-compose exec app php artisan test --filter test_suma_goles_meta_equipo`
* `docker-compose exec app php artisan test --filter test_suma_goles_anotados_equipo`
* `docker-compose exec app php artisan test --filter test_porcentaje_alcance_bono_equipo`
* `docker-compose exec app php artisan test --filter test_sueldo_completo`

### Estructura JSON
---
#### Solo jugadores
```json
{
   "jugadores" : [  
      {  
         "nombre":"Juan Perez",
         "nivel":"C",
         "goles":10,
         "sueldo":50000,
         "bono":25000,
         "sueldo_completo":null,
         "equipo":"rojo"
      },
      {  
         "nombre":"EL Cuauh",
         "nivel":"Cuauh",
         "goles":30,
         "sueldo":100000,
         "bono":30000,
         "sueldo_completo":null,
         "equipo":"azul"
      },
      {  
         "nombre":"Cosme Fulanito",
         "nivel":"A",
         "goles":7,
         "sueldo":20000,
         "bono":10000,
         "sueldo_completo":null,
         "equipo":"azul"

      },
      {  
         "nombre":"El Rulo",
         "nivel":"B",
         "goles":9,
         "sueldo":30000,
         "bono":15000,
         "sueldo_completo":null,
         "equipo":"rojo"

      }
   ]
}
```

#### Equipos
```json
{
    "equipos": [
        {
            "id": 1,
            "nombre": "Resuelve FC",
            "jugadores": [
                {
                    "nombre": "Juan Perez",
                    "nivel": "C",
                    "goles": 10,
                    "sueldo": 50000,
                    "bono": 25000,
                    "sueldo_completo": null,
                    "equipo": "rojo"
                },
                {
                    "nombre": "EL Cuauh",
                    "nivel": "Cuauh",
                    "goles": 30,
                    "sueldo": 100000,
                    "bono": 30000,
                    "sueldo_completo": null,
                    "equipo": "azul"
                },
                {
                    "nombre": "Cosme Fulanito",
                    "nivel": "A",
                    "goles": 7,
                    "sueldo": 20000,
                    "bono": 10000,
                    "sueldo_completo": null,
                    "equipo": "azul"
                },
                {
                    "nombre": "El Rulo",
                    "nivel": "B",
                    "goles": 9,
                    "sueldo": 30000,
                    "bono": 15000,
                    "sueldo_completo": null,
                    "equipo": "rojo"
                }
            ]
        },
        {
            "id": 2,
            "nombre": "Tuxtla FC",
            "jugadores": [
                {
                    "nombre": "Juan Perez",
                    "nivel": "Bronze",
                    "goles": 6,
                    "sueldo": 50000,
                    "bono": 25000,
                    "sueldo_completo": null,
                    "equipo": "rojo"
                },
                {
                    "nombre": "Pedro",
                    "nivel": "Plata",
                    "goles": 7,
                    "sueldo": 100000,
                    "bono": 30000,
                    "sueldo_completo": null,
                    "equipo": "azul"
                },
                {
                    "nombre": "Martin",
                    "nivel": "Oro",
                    "goles": 16,
                    "sueldo": 20000,
                    "bono": 10000,
                    "sueldo_completo": null,
                    "equipo": "azul"
                },
                {
                    "nombre": "Luis",
                    "nivel": "Especial",
                    "goles": 19,
                    "sueldo": 50000,
                    "bono": 10000,
                    "sueldo_completo": null,
                    "equipo": "rojo"
                }
            ]
        }
    ]
}
```
