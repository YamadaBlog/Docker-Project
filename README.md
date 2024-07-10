# Vide Grenier en Ligne

Ce Readme.md est à destination des futurs repreneurs du site-web Vide Grenier en Ligne.

## Mise en place du projet via Docker Compose

Installez [Docker](https://docs.docker.com/install/) et [Docker Compose](https://docs.docker.com/compose/install/) sur votre machine.
Sur Windows, vous aurez également besoin de [Git Bash](https://git-scm.com/downloads).

Utilisez le script `start-env.sh` afin de lancer le projet dans l'environnement de développement :

```bash
bash start-env.sh
```

Vous auriez également besoin d'installer les dépendances du projet via `composer` à l'intérieur du conteneur PHP.
Utilisez la commande suivante :

```bash
docker exec -it videgrenier-dev-app-1 composer install
```

Afin d'utiliser un autre environnement, vous pouvez utiliser passer le paramètre `preprod` ou `prod` à la commande :

```bash
bash start-env.sh preprod
```

```bash
bash start-env.sh prod
```

Vous pouvez également passer des arguments `docker compose` à la commande `run` qui sera lancée par `start-env.sh` :

```bash
bash start-env.sh dev --build
```

## Routing

Le [Router](Core/Router.php) traduit les URLs.

Les routes sont ajoutées via la méthode `add`.

En plus des **controllers** et **actions**, vous pouvez spécifier un paramètre comme pour la route suivante:

```php
$router->add('product/{id:\d+}', ['controller' => 'Product', 'action' => 'show']);
```

## Vues

Les vues sont rendues grâce à **Twig**.
Vous les retrouverez dans le dossier `App/Views`.

```php
View::renderTemplate('Home/index.html', [
    'name'    => 'Toto',
    'colours' => ['rouge', 'bleu', 'vert']
]);
```

## Models

Les modèles sont utilisés pour récupérer ou stocker des données dans l'application. Les modèles héritent de `Core
\Model
` et utilisent [PDO](http://php.net/manual/en/book.pdo.php) pour l'accès à la base de données.

```php
$db = static::getDB();
```
