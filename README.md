silex-sandbox
=============

silex-sandbox est une application Silex préconfigurée permettant d'initialiser
rapidement un projet.

Pour en savoir plus sur Silex, veuillez vous conformer à la documentation
https://github.com/digitas/silex-sandbox/blob/master/doc/guidelines-silex.md

Authors
-------

* Damien Pitard <dpitard at digitas dot fr>

Changelog
---------

* no more phar
* updated to last Silex version

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

Pour valider la configuration serveur, un fichier de check est accessible en ligne
sur l'instance à l'adresse <http://.../check.php>. Ce script est protégé sur les
IPs interne (192.168.*) et locales (127.0.0.1, 10.0.2.2), donc il peut être livré
sans problème en production.

Getting started
---------------

### Initialisation du repository

Si votre projet 

Pour initialiser un nouveau projet à partir de cette sandbox, télécharger l'archive :

    https://github.com/digitas/silex-sandbox/zipball/master

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

        <Directory "[ROOT_DIR]/web">
            AllowOverride all
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>

### Configuration de Silex Sandbox

le paramètrage de l'application se faire par l'intermédiaire des fichiers de
configuration se trouvant dans : **app/config**

La configuration par défaut se trouve dans **app/config/config.yml**.

Cependant, il est possible d'effectuer des surcharges de configuration pour un
environnement donnée dans les fichiers :

* config_dev.yml
* config_test.yml

Pour lancer l'instance dans l'environnement de dev, charger l'URL http://.../index_dev.php

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
* src : contenant les librairies spécifiques
* vendor : contenant les librairies externes
* web : répertoire publique (DocumentRoot du serveur web)
* deps : fichier de gestion des dépendances externes