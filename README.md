silex-sandbox
=============

silex-sandbox est une application Silex préconfigurée permettant d'initialiser
rapidement un projet.

Pour en savoir plus sur Silex, veuillez vous conformer à la documentation
https://github.com/digitas/silex-sandbox/blob/master/doc/guidelines-silex.md

Authors
-------

* Damien Pitard <dpitard at digitas dot fr>

Getting started
---------------

### Configuration de PHP

Voici les valeurs de configuration recommandée :

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

### Initialisation de l'instance

Pour initialiser un nouveau projet à partir de la sandbox,
[télécharger l'archive](https://github.com/digitas/silex-sandbox/zipball/master)

Puis lancer la commande suivante :

    php app/console digex:vendor

### Test de l'instance

Visiter le script de test sur **http://.../check.php** pour vérifier la configuration
du serveur.

Visiter l'environnement de dev sur **http://.../index_dev.php**.

### Configuration de l'instance

Le paramètrage de l'application se fait en Yaml dans le répertorie : **app/config**

La configuration par défaut se trouve dans **app/config/config.yml**.

Les surcharges de configuration en fonction de l'environnement se trouve dans **app/config/config_<DEV>.yml**.

Requirements
------------

Softwares:

* apache >= 2.2.x
* myqsl >= 5.1.x
* PHP >= 5.3.x

Apache mods:

* mod_rewrite
* mod_expires
* mod_headers (optionnel)
* mod_setenvif (optionnel)
* mod_deflate (optionnel)
* mod_filter (optionnel)

PHP mods:

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

Tree
----

* *app* : les fichiers propres à l'application
    * *Resources*
        * *views* : contenant les templates (au format twig)
    * *config* : contenant les fichiers de configuration
    * *data* : données de l'application
    * *logs* : contenant les logs applicatifs  (auto-généré)
    * *cache* : contenant le cache applicatif (auto-généré)
* *src* : contenant les librairies spécifiques
* *vendor* : contenant les librairies externes
* *web* : DocumentRoot