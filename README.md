<div style="width:100%;float:left;clear:both;margin-bottom:50px;">
    <a href="https://github.com/pabloripoll?tab=repositories">
        <img style="width:150px;float:left;" src="https://pabloripoll.com/files/logo-light-100x300.png"/>
    </a>
</div>

# Applicación de Ejemplo: Datos de Países

## MVC con conexión a RESTAPI externa

Este proyecto utilizar el diseño Modelo-Vista-Controlador (MVC)

## Stack

- Symfony 7.1.1
- PHP 8.3
- NGINX 1.24
- MySQL 5.7.44
- Plantilla AdminLTE
- Bootstrap 4.6.1
- JQuery 3.6

## Instalación

Para mejorar la agilidad de levantar el proyecto en local, se ha implementado comandos de Makefile para ser ejecutados desde la raíz de éste repositorio.

Antes de comenzar, existe un fichero de entorno [.env.example](.env.example) - copiar y pegarlo en la misma raíz como `.env` e ingrese los puertos donde va a servir la applicación.

De esta manera se construirá la infraestructura de los dos contenedores, uno con la aplicación y otro con la base de datos.

Ambos están unidos en la mayoría de comandos.

Para levantar los servicios, ejecute:
```bash
$ make project-create
```

Como la aplicación una vez activa intenta conectarse a la base de datos, es necesario copiar el fichero [application/.env.example](application/.env.example) como [application/.env](application/.env) en donde se encuentra los parámetros de conexión a la base de datos.

La conexión entre la aplicación y la base de datos se realizará a través del hostname del ordenador
```bash
$ make hostname
```

De esta manera quedaría conformado en fichero de entorno de Symfony para conectarse a la base de datos de la siguiente manera
```
DATABASE_URL="mysql://mysqluser:123456@192.168.1.41:8893/mysqldb?serverVersion=5.7&charset=utf8mb4"
```

Una vez levantado los contenedores, se puede proceder a la actualización de las dependencias de la aplicación backend
```bash
$ make backend-update
```

O de manera más activa en el contendor, entrando al mismo a través del siguiente comando.
```bash
$ make backend-ssh
```

Así sea la primera instalación or la reconstrucción de los contenedores será necesario actualizar Composer si faltara el directorio [application/vendor](application/vendor)
```bash
$ composer update
```

Habiendo instalado todo lo anterior, se debe proceder a la migración del model establecido para la base de datos
```bash
$ php bin/console doctrine:migration:migrate latest
```


Se puede crear los registro de pruebas con el comando de Fixtures
```bash
$ php bin/console doctrine:fixtures:load -q
```

## Detención de los servicios

Para detener los servicios
```bash
$ make project-stop
```

Y para volverlos a correr
```bash
$ make project-start
```

## Desinstalación

Si desea eliminar por completo la aplicación de su ordenador, recuerdo que será mejor primero detenerlos y luego eliminarlos, de la siguiente manera
```bash
$ make project-stop
$ make project-destroy
$ sudo docker system prune
$ sudo rm -rf infrastructure/mysql/docker/data # Elimina la persistencia de la BBDD
$ sudo rm -rf application/vendor # Elimina las dependencias de Symfony
```

## Nota

Para más información de los comando predefinidos, ejecute
```bash
$ make help
```