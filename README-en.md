# Babelium Project (Api V3)

*Translations: [Spanish](README.md) | [English](README-en.md)

## Configuration

The **ApiV3** module has some configuration params available in the "**/~/module/ApiV3/config/module.config.php**" file.

### Doctrine

The database access and entity mapping is managed through **Doctrine** ORM. You'll find the configuration in the array "**doctrine**" -> "**connection**" -> "**orm_default**" -> "**params**"

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

Babelium requires some paramameters to be correctly configured, like:

````php
array(
    'path_uploads' => '/var/www/babelium-server-new/httpdocs/resources/uploads',
    'path_thumbs' => '/var/www/babelium-server-new/httpdocs/resources/images/thumbs'
)
````

## "data" Folder

The **data** folder is where external and temp files will be stored in a **Zend Framework** project. The next folder structure is also required:

```bash
data
├── cache
└── DoctrineORMModule
    ├── Migrations
    └── Proxy

```

The **storage** folder will include all the transformed videos that Moodle 3.x plugin will consume.

```bash
storage
└── media
    └── *
```

```
Both folder structures should be created with read and write permissions.
```

## Doctrine Commands (DEV)

Doctrine command description:

### DEV (development) environment commands

Sync changes between the database and Doctrine (KEY names):

```bash
./vendor/bin/doctrine-module orm:schema-tool:update --force
```
When defining a new fields in an entity, the next two Doctrine commands must be executed, "orm:generate-entities**" to generate the entity accesors and "**orm:schema-tool:update**" to apply changes in the database.

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

### Deploying to PROD (Production)

To apply the database changes execute:

```bash
./vendor/bin/doctrine-module orm:schema-tool:update --force
```

## Babelium Commands

```bash
./commands 
```

* babelium:convert:videos

```bash
  babelium:convert:response  Merges the exercise audio and the original video for the response
  babelium:convert:videos    Imports and merges videos to mp4 and webm
```

### One time execution on PROD

```bash
  babelium:convert:videos    Imports and merges videos to mp4 and webm
```

### CRON

```bash
  babelium:convert:response  Merges the exercise audio and the original video for the response
```


## VirtualHost configuration

The new API must be reached through an alias (or similar) pointing to the public folder of the project:

````bash
 Alias /api/v3 /~/babelium-zf2/public
````

## Links (DEV)

```bash

http://stackoverflow.com/questions/18463291/how-to-generate-entities-from-database-schema-using-doctrine-orm-module-and-zf2
https://samsonasik.wordpress.com/2013/04/10/zend-framework-2-generate-doctrine-entities-from-existing-database-using-doctrinemodule-and-doctrineormmodule/
http://stackoverflow.com/questions/29538840/create-doctrine-entity-of-single-table-from-database-in-zend-framework-2

```
