silex-sandbox
=============

silex-sandbox est une application Silex préconfigurée permettant d'initialiser
rapidement un projet. Pour en savoir plus, veuillez vous conformer à la documentation
https://github.com/digitas/silex-sandbox/blob/master/docs/guidelines-silex.md

Authors
-------

* Damien Pitard <dpitard at digitas dot fr>

Todo
----
...

Requirements
------------

* apache >= 2.2.x
* myqsl >= 5.1.x
* PHP >= 5.3.x

Apache modules :

* mod_rewrite
* mod_expires
* mod_headers (optionnel)
* mod_setenvif (optionnel)
* mod_deflate (optionnel)
* mod_filter (optionnel)

PHP Extensions :

* php-xml (libxml >= 2.7.x)
* apc
* Tokenizer
* Mbstring
* iconv (iconv >= 2.11.x)
* XML
* php_posix
* intl
* json
* pdo
* pdo_mysql
* xsl
* pcre
* cURL

Ces pré-requis peuvent être transmis à l'hébergeur tel-quel.

Pour valider la configuration serveur, un fichier de check est accessible en ligne
sur l'instance à l'adresse <http://.../check.php>. Ce script est protégé sur les
IPs interne (192.168.*) et locales (127.0.0.1, 10.0.2.2), donc il peut être livré
sans problème en production.

Getting started
---------------

### Initialisation du repository

Si votre projet 

Pour initialiser un nouveau projet à partir de cette sandbox, veuillez faire une
copie du repository :

    git clone --mirror https://<USERNAME>@github.com/digitas/SilexSandbox <YOUR_PROJECT>

Si vous utiliser Git pour votre project, faites un premier commit :

    cd <YOUR_PROJECT>
    git commit -a -m "initial import"

### Installation des outils requis

Sous debian :

apt-get install phpunit php5-apc git

### Configuration de PHP

    safe_mode = Off
    register_globals = Off
    short_open_tag = Off
    magic_quotes_gpc = Off
    magic_quotes_runtime = Off
    session.auto_start = Off
    date.timezone = "Europe/Paris"
    phar.readonly = Off
    phar.require_hash = Off
    suhosin.executor.include.whitelist = phar

### Configuration d'Apache

Installer le vhost suivant

    <VirtualHost *:80>
        ServerName [HOSTNAME]
        DocumentRoot "[ROOT_DIR]/web"
        #SetEnv ENV dev

        <Directory "[ROOT_DIR]/web">
            AllowOverride all
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>

### Initialisation des librairies externes

Lancez la commande suivante à la racine de Silex

    php bin/vendors install

### Configuration de Silex Sandbox

le paramètrage de l'application se faire par l'intermédiaire des fichiers de
configuration se trouvant dans : **app/config**

La configuration par défaut se trouve dans **app/config/config.yml**.

Cependant, il est possible d'effectuer des surcharges de configuration pour un
environnement donnée dans les fichiers :

* config_dev.yml
* config_test.yml

Pour déclarer à votre instance dans quel environnement elle doit s'executer
ajouter la directives suivantes au vhost ou au fichier web/.htaccess (dans ce
cas, ne jamais commiter cette directive) :

    SetEnv ENV dev

### Arborescence type

* app : les fichiers propres à l'application
    * Resources
        * views : contenant les templates (au format twig)
            * homepage.html.twig : template de home par défaut
            * base.html.twig : layout par défaut
    * config : contenant les fichiers de configuration
        * config.ini : fichier principal de configuration au format php.ini
    * data : données de l'application
        * schema.sql : structure de la base de données
        * fixtures.sql : données d'initialisation de l'application
        * x.x.x-TO-x.x.x.sql : script de migration de version d'application
    * logs : contenant les logs applicatifs  (auto-généré)
    * cache : contenant le cache applicatif (auto-généré)
    * phpunit.xml.dist : configuration de PHPUnit
* bin : contenant les scripts CLI PHP de maintenance ou de cron
    * vendors : script d'initialisation des librairies externes 
* src : contenant les librairies spécifiques
    * app.php : application principale
    * autoload.php : autoload des classes
* tests : contenant les tests unitaires et fonctionnels
    * AppTest.php : exemple de tests fonctionnels de l'application principale
    * bootstrap.php : initialisation des tests (autoload...)
* vendor : contenant les librairies externes
    * silex.phar : librairie du micro-framework Silex (https://github.com/fabpot/Silex)
    * digex.phar : librairie de l'outil Digex (https://pitpit@github.com/digitas/Digex.git)
* web : répertoire publique (DocumentRoot du serveur web)
* deps : fichier de gestion des dépendances externes