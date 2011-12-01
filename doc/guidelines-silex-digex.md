Guidelines Silex & Digex
========================

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
être intégrées grâce au mécanisme d'integration des dépendances native de Digex.

Ajouter des lignes sur le modèle suivant dans le fichier **config/deps.yml**

    deps:
        target_dir_in_vendor:
            url: https://github.com/user/theproject.git

Puis rappatrier les librairies en vous plaçant à la racine du site :

    php app/console digex:vendor

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

On utilise Doctrine DBAL & ORM pour effectuer la modélisation des entités et les
requêtes vers la base de données.

Dans config/config.yml :

    app:
      providers:
        doctrine-dbal: true
        doctrine-orm: true

Puis lancer la commande suivante pour rappatrier les dépendances :

    php app/console digex:vendor
    
