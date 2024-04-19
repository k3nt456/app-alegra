# APLICACIÓN ALEGRA
Reto: 💥
Jornada de almuerzo ¡Gratis!
Un reconocido restaurante ha decidido tener una jornada de donación de comida a los residentes de la región con la única condición de que el plato que obtendrán los comensales será aleatorio. El administrador del restaurante requiere con urgencia un sistema que permita pedir platos a la cocina.

----
| Stack tecnológico| Versión|
| ------        | ------    |
| PHP           | 8.2.13    |
| Laravel       | 10.48.8   |
| MySQL         | 8.2.0     |
| PhpMyAdmin    | 5.2.1     |



## LARAVEL
`app-alegra/src`

### Estructura del proyecto:
- Las rutas están organizadas según su función con consideración del uso de middleware para la verificación de accesos.
- Modelos, controladores y servicios se organizan según su función.
- En caso de uso de observer se añade una función boot desde el mismo modelo.
- Los request están asociados a los controladores, y los resource a los servicios correspondientes.

### Proceso back:
* Arquitectura usada: Service-Oriented Design (SOD)
* Patrón usado: Active record

### Proceso front:
* Se usa como base las plantillas blade que incrusta HTML, CSS y JS con código PHP
* Bootstrap con css personalizado
* Manejo de vistas responsive

### Librerías utilizadas:
* [laravel-make-service](https://github.com/getsolaris/laravel-make-service): Utilizada para automatizar la creación de servicios en Laravel, lo que facilita la estructuración y organización del código.

* [Bootstrap](https://getbootstrap.com/): Marco de diseño front-end que proporciona una colección de clases CSS y componentes predefinidos para la construcción rápida y fácil de interfaces de usuario responsivas y atractivas.

* [datatables](https://datatables.net/examples/styling/bootstrap5.html): Biblioteca JavaScript que proporciona una amplia funcionalidad para la manipulación y presentación avanzada de datos tabulares en las vistas de la aplicación, integrada con Bootstrap para un diseño y estilo coherentes.

* [jQuery](https://jquery.com/): Biblioteca JavaScript ampliamente utilizada que simplifica la manipulación del DOM, la realización de peticiones AJAX y otras tareas comunes de desarrollo web, lo que facilita la creación de aplicaciones web dinámicas e interactivas.

### Persistencia de la sesión:
El manejo de la persistencia de la sesión se maneja con el middleware de autenticación.




## Migraciones y base de datos:
Las migraciones se realizan desde Laravel para facilitar el cambio de base de datos si fuera necesario. Se organizan según su función y se utilizan UUID según sea necesario.

### Semilla de datos:
Se incluye semillas para la inicialización del proyecto con información básica y datos extras. 

Las credenciales generadas por defecto son:
>> **username**: kento | **password**: demo



## Modelado de base de datos
`app-alegra/bd-model`

La base de datos se ha generado utilizando las migraciones de Laravel y se ha organizado utilizando **MySQL Workbench** para mejorar la legibilidad y comprensión de cómo se estructuran las tablas según la lógica del negocio. Se ha incluido un archivo PDF para facilitar su visualización.



## DESPLIEGUE A SERVIDOR
* En el siguiente enlace esta el despliegue de la web - https://alegra.website/ - [WEB](https://www.hostinger.com/)

* Implementación de [Hostinger](https://www.hostinger.com/) para el despliegue de la aplicación en un servidor.

* Utilización de [Clever Cloud](https://developers.clever-cloud.com/doc/) para el despliegue de la base de datos en un servidor.

* Empleo de [Filezilla](https://filezilla-project.org/) para acceder a las carpetas del servidor.

* Utilización de [Putty](https://www.putty.org/) para acceder al servidor para realizar ajustes de permisos y activación de funciones necesarios para la lectura del despliegue.

### Inicio de sesión:
Para acceder, se requiere un nombre de usuario y su contraseña.
>> Nombre de usuario: kento | Contraseña: demo



## DOCKER:
`app-alegra/docker`

Se utiliza [Chocolatey](https://chocolatey.org/) para poder usar [Make](https://community.chocolatey.org/packages/make) que ayuda en la abreviación de comandos

Para instalar chocolatey se realiza via powershell mediante el siguiente comando (Modo administrador)

```
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://chocolatey.org/install.ps1'))
```

Luego instalar Make (Modo administrador)

```
choco install make
```

Con las instalaciones anteriores solo necesita escribir los siguientes comandos estando ubicado dentro de la carpeta docker
El archivo `.env.example` ya esta configurado con las credenciales de la configuración de docker, antes de usar los comandos `make` recuerde copiar el archivo en un .env .
>`make setup`
>>Para hacer el docker-compose build, docker-compose up -d, composer update y key:generate

>`make data`
>>Para hacer la migración junto con las semillas del proyecto

>`make access`
>>Para ingresar a la ruta del proyecto desde docker y usar los comandos habituales como: php artisan serve

En caso no desear instalar `Make` puede obviar lo anterior y escribir los comandos completos que puede ubicarlos en `app-alegra/docker/Makefile`

>Nota: Los archivos dockerfile fueron separados en distintas carpetas, el .env contiene sus variables de nombres, puertos para leerse desde el makefile y docker-compose.yml para una mejor integración.

---