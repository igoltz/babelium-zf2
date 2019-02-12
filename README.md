# Babelium Project (Api V3)

Translations: [Spanish (outdated)](README-es.md) | [English](README.md)

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

### One time execution - migration from old Moodle API

Once exercises are uploaded in Babelium this command converts them to mp4.  
**Note:** Older API versions removed uploaded files after successfull conversion to flv. Thus they need to be resubmitted via additional migration tool.  
TODO: describe tool an push it

```bash
/commands babelium:convert:videos
```

Old responses must be converted too. Depending on the amount of responses this may need a (temporary) change to php.ini.  
For 60.000 responses we found __memory_limit = 512M__ sufficient.  
This merges the audio from old response file *_merge.flv with video stream from related exercise file (created by above conversion)

```bash
./commands babelium:migrate:response
```

### CRON

```bash
# /etc/cron.d/babelium_api3

LOG_PATH=path_to/log
API3_PATH=path_to/api3
PHP=path_to/php

# Merges the exercise audio and the original video for the response
*/5 * * * * apache ${PHP} ${API3_PATH}/commands babelium:convert:response >> ${LOG_PATH}/convert_response.log

# Imports and merges videos to mp4 and webm
*/15 * * * * apache ${PHP} ${API3_PATH}/commands babelium:convert:videos >> ${LOG_PATH}/convert_videos.log
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
