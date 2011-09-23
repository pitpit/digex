Guidelines Silex
================

Coding
------

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

Classes dédiés
--------------

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

Librairies externes
-------------------

Les librairies externes ne doivent pas être retouchées pour des besoins
spécifiques. Si nécessaire, des surcharges locales des classes peuvent être
implémentées. Elle ne doivent pas être commitées dans le repository et doivent
être intégrées grâce au mécanisme d'integration des dépendances de Symfony2
(fichiers bin/vendors & deps dans l'arbo initiale).

Ajouter des lignes sur le modèle suivant dans le fichier **deps**

    [nom-du-repertoire]
        git=http://github.com/<user>/<projet>.git

Puis faites un update des librairies en vous plaçant à la racine du site :

    php bin/vendors update

Documentation
-------------

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

Tests
-----

Chaque méthode publique de chaque classe est testée unitairement avec PHPUnit.
La mise en place de tests fonctionnels sur les actions de contrôleur n'est pas
obligatoire mais recommandés pour les processus critiques (pouvant mettre en
péril l'activité du site).

Pour lancer les tests unitaire, il faut se mettre à la racine du site en ligne de commande et lancer :

    phpunit --configuration=phpunit.xml.dist

Base de données
---------------

### Librairies Doctrine

On utilise Doctrine DBAL pour effectuer les requêtes vers la base de données.

Pour intégrer les librairies doctrine, ajouter les lignes suivantes au fichier de dépendances **deps** :

    [doctrine-common]
        git=http://github.com/doctrine/common.git

    [doctrine-dbal]
        git=http://github.com/doctrine/dbal.git
      
Puis faites un update des librairies externes en vous plaçant à la racine du site :

    php bin/vendors update
    
### Entités & repositories

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