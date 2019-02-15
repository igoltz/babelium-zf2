# Description
The new APIv3 was created to work with latest (2016) babelium version. Older babelium versions did not store references to the original uploaded files and deleted them after conversion.  
In order to let command:convert:video create exercise media suitable for the new html5 based API the original files must stored on the server again and appropriate references in the DB schema created.  
fixRAWmedia.php was created to achieve this goal. It is based on improvequality.php from the original babelium developer (not part of any repo) and services/Create.php from the main project. It works against an already migrated DB schema.

# Usage

0. Prepare the script for your environment, change the BABELIUM_HOME constant to point to your babelium installation.

1. First create a list of existing exercises:
```bash
${PHP} fixRAWmedia.php getExerciseList media.csv
```
Or better, use improvequality.php on your old installation to be prepared for the migration. See https://github.com/igoltz/flex-standalone-site/blob/master/tools/improvequality.md

2. Then replace FILENAME occurrences in media.csv with the corresponding filenames of original media uploaded. And copy these files into the babelium upload folder.

3. Import the media into bablium with:
```bash
${PHP} fixRAWmedia.php fixMediaRendition media.csv
```

4. Finally run:
```bash
${PHP} commands babelium:convert:videos
```


