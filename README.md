Pangolin Framework
========

MVC Framework for PHP 5.3

Installations
-------------

For installation, you must to do next commands:

    git clone git://github.com/gidman/Pangolin.git <project name>
    cd <project name>
    mkdir cache
    php composer.phar install
    
Configurating
-------------

Copy `config/database.json.dist` to `config/database.json`, and edit it.

Database migration
------------------

For migration, you must to do:

    php tools/db.migrate.php