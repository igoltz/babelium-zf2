# Babelium Project (Api V3)

*Traducciones: [Español](README.md) | [English](README-en.md)

## Configuración

En el modulo de **ApiV3** hay una serie de parametros que se tienen que configurar en el archivo "**/~/module/ApiV3/config/module.config.php**", los cuales son:

### Doctrine

La conexión con base de datos va por medio de **Doctrine**, las configuraciones de la conexión estan en el array "**doctrine**" -> "**connection**" -> "**orm_default**" -> "**params**"

````php
array(
    'host'     => '~',
    'port'     => '~',
    'user'     => '~',
    'password' => '~',
    'dbname'   => '~',
    'charset'  => 'utf8'
)
````

### Babelium

Algunas configuraciones del proyecto actual de Babelium se necesitan para un correcto funcionamiento, las cuales son:

````php
array(
    'path_uploads' => '/var/www/babelium-server-new/httpdocs/resources/uploads',
    'path_thumbs' => '/var/www/babelium-server-new/httpdocs/resources/images/thumbs'
)
````

## Directorio "data"

El directorio **data** es donde se almacenan los archivos externos o temporales (cache) en los proyectos de Zend Framework, para este proyecto se necesita la siguiente estructura de directorios:

```bash
data
├── cache
└── DoctrineORMModule
    ├── Migrations
    └── Proxy

```

El directorio **storage** es donde se guardan los videos despues de ser transformados y se mantienen vivos para el uso del nuevo modulo de Moodle 3.x

```bash
storage
└── media
    └── *
```


```
Crear estas 2 estructuras en la raiz de la instalación con permisos de escritura
```

## Doctrine Commands

Comando de doctrine en Zend Framework

### Pase a producción

Para enviar los nuevos cambios a MySQL:

```bash
./vendor/bin/doctrine-module orm:schema-tool:update --force
```

### Desarrollo

Sincronizar los nuevos cambios en la base de datos y los cambios que realiza doctrine (nombres de las KEYS).

```bash
./vendor/bin/doctrine-module orm:schema-tool:update --force
```

Al definir un nuevo campo en las entidades hay que ejecutar 2 comandos de Doctrine, "**orm:generate-entities**" para generar los **getters** y **setters** y "**orm:schema-tool:update**" para aplicar los cambios en MySQL. 


```bash
./vendor/bin/doctrine-module orm:generate-entities ./module/ApiV3/src/ --generate-annotations=true
./vendor/bin/doctrine-module orm:schema-tool:update --force
```

```bash

./vendor/bin/doctrine-module orm:convert-mapping --namespace="ApiV3\\Entity\\" --force  --from-database annotation ./module/ApiV3/src/
./vendor/bin/doctrine-module orm:generate-entities ./module/ApiV3/src/ --generate-annotations=true

 * @ORM\Entity(repositoryClass="ApiV3\Entity\Repository\ResponseRepository")

./vendor/bin/doctrine-module orm:generate-repositories ./module/ApiV3/src/

```

## Babelium Commands

```bash
./commands 
```

* babelium:convert:videos

```bash
  babelium:convert:response  Combinar audio y video original para generar la respuesta
  babelium:convert:videos    Importa y convierte los videos a mp4 y webm
```

### Ejecuciòn al instalar

```bash
./commands babelium:convert:videos    Importa y convierte los videos a mp4 y webm
```

### CRON a definir

```bash
./commands babelium:convert:response  Combinar audio y video original para generar la respuesta
```


## VirtualHost

Para acceder a la nueva api hay crear un Alias/Link o lo que corresponda a la carpeta public

````bash
 Alias /api/v3 /~/babelium-zf2/public
````

## Links de apoyo

```bash

http://stackoverflow.com/questions/18463291/how-to-generate-entities-from-database-schema-using-doctrine-orm-module-and-zf2
https://samsonasik.wordpress.com/2013/04/10/zend-framework-2-generate-doctrine-entities-from-existing-database-using-doctrinemodule-and-doctrineormmodule/
http://stackoverflow.com/questions/29538840/create-doctrine-entity-of-single-table-from-database-in-zend-framework-2

```

