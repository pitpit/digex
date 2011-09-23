SilexSandbox
============

SilexSandbox est une application Silex préconfigurée permettant d'initialiser
rapidement un projet

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

Guidelines
----------

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


### Coding

* Les développements doivent respecter le standard de code de SYmfony2 : http://symfony.com/doc/2.0/contributing/code/standards.html
* Utiliser des noms de variables simples, significatifs, sans abbréviations, et en anglais
* conserver la consistance des variables (conserver le nom initial de la donnée).

Par exemple, si l'on souhaite récupérer le paramètre d'URL "title", le code suivant serait impropre :

        $myVar = $request->request->get('title');
  
et l'on preferera :

        $title = $request->request->get('title');
  
* "Attraper" systématiquement les cas d'erreurs et générer des exceptions PHP correspondantes. Utiliser les expcetions du SPL pour plus d'exhaustivité (http://www.php.net/~helly/php/ext/spl/classException.html)
* les messages d'erreur, de log et les exceptions sont rédigés en anglais
* les getters d'une classe commencent par "get" suivi du nom de la donnée
* les setters d'une classe commencent par "set" suivi du nom de la donnée

### Classes dédiés

Les classes spécifiques au projet sont déposé dans un sous-repertoire de src/Digitas.
Ce sous-répertoire représente le nom du package (au sens UML) qui se doit d'être
exhaustif et relatif aux fonctionnalités des classes qu'il contient. On ne
mélangera pas dans un package des classes dont la portée fonctionnelle diffère.

Le namespace de ces classes commencent pas **Digitas\AlwaysUnesco**.
Elles sont chargées par l'autoloader dans l'application grâce au code suivant :

    $app['autoloader']->registerNamespace(
      'Digitas',
      array(__DIR__.'/../src', __DIR__.'/../vendor')
    );

### Librairies externes

Les librairies externes ne doivent pas être retouchées pour des besoins
spécifiques. Si nécessaire, des surcharges locales des classes peuvent être
implémentées. Elle ne doivent pas être commitées dans le repository et doivent
être intégrées grâce au mécanisme d'integration des dépendances de Symfony2
(fichiers bin/vendors & deps dans l'arbo initiale).

### Documentation

* Toutes les classes et les méthodes sont documentées au format PHPDoc et en anglais.
* Toutes les classes sont précédées du cartouche respectant le motif suivant :

        /**
         * {nom de la classe|description}
         *
         * @copyright   Copyright (c) Digitas France (http://www.digitas.fr)
         * @author      {votre nom} <{votre email}>
         * @version     $Id$
         */

* Les commentaires de code sont en anglais
* Les sources du projet doivent contenir un fichier nommé LICENSE portant le contenu suivant :

        Copyright (c) Digitas France
        All rights reserved

###  Tests

Chaque méthode publique de chaque classe est testée unitairement avec PHPUnit.
La mise en place de tests fonctionnels sur les actions de contrôleur n'est pas
obligatoire mais recommandés pour les processus critiques (pouvant mettre en
péril l'activité du site).

Pour lancer les tests unitaire, il faut se mettre à la racine du site en ligne de commande et lancer :

    phpunit --configuration=phpunit.xml.dist

### Intégration des librairies externes

Ajouter des lignes sur le modèle suivant dans le fichier **deps**

    [nom-du-repertoire]
        git=http://github.com/<user>/<projet>.git

Puis faites un update des librairies en vous plaçant à la racine du site :

    php bin/vendors update

### Base de données

#### Librairies Doctrine

On utilise Doctrine DBAL pour effectuer les requêtes vers la base de données.

Pour intégrer les librairies doctrine, ajouter les lignes suivantes au fichier de dépendances **deps** :

    [doctrine-common]
        git=http://github.com/doctrine/common.git

    [doctrine-dbal]
        git=http://github.com/doctrine/dbal.git
      
Puis faites un update des librairies externes en vous plaçant à la racine du site :

    php bin/vendors update
    
#### Entités & repositories

On créée une classe d'objet (une entité) par table dans la base de donnée portant un champ correspondant à chaque colonne de la table.

Par exemple pour la table subscribtion suivante :

    CREATE TABLE subscribtion (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
        user_id INT NOT NULL ,
        email VARCHAR( 100 ) NOT NULL
    );


On aura la classe d'entité suivante :

    class Subscribtion
    {
        protected $id;
        protected $user_id;
        protected $email;
    }

Cette classe sera placé dans le namespace dédié au projet (par exemple Digitas\AlwaysUnesco)

Pour prendre en charge l'interaction avec la base de donnée (les requêtes), on créée une classe de repository.
Cette classe contiendra :

    * une methode store($entity) permettant de sauvegarder un objet entité
    * une méthode pour chaque requête
        * renvoyant une liste de toutes les entités : **findAll()**
        * renvoyant une liste d'entité (DoctrineCollection) selon des filtres sur les champs de la table : **find[By<field>][And<field>]...([\$value1][, \$value2]...)**
        * renvoyant une entité : **findOneBy<field>[And<field>]...([\$value1][,\$value2]...)**

    class SubscribeRepository
    {
        protected $connection;

        public function __construct(Doctrine\DBAL\Connection $connection)
        {
          $this->connection = $connection;
        }

        /**
         * store a Subscribtion object
         * @return void
         */
        public function store(Subscribe $Subscribtion);

        /**
         * @param integer $userId
         * @return Subscribe|null
         */
        public function findOneByUserId($userId);

        /**
         */
        public function findAll();
    }

Par ailleurs,l'ensemble des requêtes doivent être protégés contre l'injection SQL en utilisant les params DQL de Doctrine.

* http://www.doctrine-project.org/docs/dbal/2.1/en/reference/data-retrieval-and-manipulation.html

Il ne faut pas écrire :
  
      $query  = "SELECT * FROM subscribtion " ;
      $query .= " WHERE user_id = '" . $userId . "'" ;
      $subscribtion = $conn->executeQuery($query)->fetch();
      
mais :
 
    $statement = $conn->executeQuery(
      'SELECT * FROM subscribtion WHERE user_id = ?',
      array($userId))
    );
    $subscribtion = $statement->fetch();




