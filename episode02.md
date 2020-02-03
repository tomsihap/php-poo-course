# TP : Programmation orientée objet en PHP (Épisode 2)

## Chapitre 1 : Classes de services
### Retirer toutes les fonctions procédurales
Avoir un gros fichier `functions.php` n'est pas idéal pour gérer un projet et rester organisé. Nous allons voir comment utiliser une classe pour stocker tout ça et donner un autre niveau de sophistication à notre application !

Pour commencer, débarassons-nous de la fonction `battle()` dans `functions.php`.

Prenons par exemple `Ship`. C'est une classe qui va simplement contenir des données, c'est à dire les valeurs des attributs d'un objet `Ship`. Donc, un objet `Ship` contient des données, les restitue en les modifiant parfois un peu, mais ne fait pas grand chose de plus.

La première raison de créer des classes est la suivante : nous avons besoin d'un outil qui permette de rester organisés dans nos différentes données. C'est ce que fait `Ship`.

La seconde grosse raison de faire une classe, c'est parce qu'on a besoin de faire des briques logiques. Par exemple, dans `functions.php`, la fonction `battle()` fonctionne bien : on lui donne deux `Ship`, et après quelques calculs et autres, et un peu de logique pour voir comment les différentes forces et vaisseaux agissent entre eux, elle nous retourne le résultat de ces calculs.

Jusque-là, nous sommes habitués à créer des fonctions de ce genre. À partir de maintenant, le secret de l'orienté objet pour des fonctions logiques/métier, c'est simplement de... Ne plus créer de fonctions n'importe où dans le code comme `battle()`, mais de les mettre dans une classe avec une méthode dedans !

Nous souhaitons faire une classe qui contiendra notre fonction `battle()`, et peut-être d'autres choses. On peut du coup la nommer `BattleManager`. Comme d'habitude pour les classes, stockez la dans un fichier à part nommé `BattleManager.php` ! On peut la mettre dans le dossier `/lib`.

```php
// Fichier: /lib/BattleManager.php
class BattleManager {

}
```

Jusque-là, rien de difficile. Maintenant, comment supprimer notre fonction `battle()` de `functions.php` pour la mettre dans la classe ?

Réponse : en... supprimant notre fonction `battle()` de `functions.php` et en la mettant dans la classe. Tout simplement ! N'oubliez pas de mettre `public` devant `function` néanmoins : cela nous permet d'avoir accès à la méthode en dehors de la classe, et non pas qu'à l'intérieur de la classe.

On a donc **supprimé** la fonction `battle()` de `functions.php`, qui est maintenant dans `BattleManager.php` :

```php
class BattleManager {
    /**
     * L'algorithme de combat super complexe !
     *
     * @return array [winning_ship, losing_ship, used_jedi_powers]
     */
    public function battle(Ship $ship1, $ship1Quantity, Ship $ship2, $ship2Quantity)
    {
        // ...
    }
}
```

C'est réellement le seul changement que nous avons à faire. Mettre la fonction dans une classe, lui rajouter `public`. Pour le reste, les méthodes et les fonctions sont la même chose, rien n'est à changer.

Cependant, nous devons tout de même un peu changer `battle.php` qui ne saura plus où trouver la fonction. Dans `battle.php`, changez : 

```php
$outcome = battle($ship1, $ship1Quantity, $ship2, $ship2Quantity);
```

Par : 
```php
$battleManager = new BattleManager();   // On créée un objet BattleManager
$outcome = $battleManager->battle($ship1, $ship1Quantity, $ship2, $ship2Quantity); // Qui a accès à la méthode battle de sa classe !
```

Et **n'oubliez pas** d'importer notre nouvelle classe pour que cela fonctionne ! Ajoutez-la en haut de `battle.php` :
```php
<?php
session_start();
require __DIR__ . '/functions.php';
require __DIR__ . '/lib/BattleManager.php';
```

Comme on l'a vu à l'épisode 1, il existe une manière d'importer nos classes sans devoir les taper à chaque fois ici, c'est l'autoloading. On le verra plus tard.

Testez votre application, normalement les combats devraient fonctionner comme avant.

Vous avez maintenant 2 raisons de créer des classes :
1. Stocker des données de façon claire et descriptive. Une sorte d'array superpuissant avec des attributs bien définis et des méthodes qui nous donnent accès à toutes sortes de fonctionnalités sur nos données. En général, on comme ces classes représentent nos données, les modélisent, on appelle ça un modèle (ou Model).

2. Écrire des fonctions pour faire quelque chose dans votre application (ici, une bataille). L'avantage, c'est de pouvoir trier nos fonctions en différentes classes, par exemple, dans une classe `BattleManager`, on peut avoir des fonctions qui font le combat, génèrent une liste d'opposants, tirent un tableau des meilleurs scores...

3. Ou bien on peut même faire un `ScoreManager` qui serait une classe qui gèrerait spécifiquement les scores ! C'est à vous de voir comment vous voulez organiser votre projet. En général, on met dans une classe toutes les fonctions qui se rapportent au nom de la classe (`BattleManager` : fonctions autour d'une bataille, `ScoreManager` : fonctions autour du calcul des scores). Utilisez des noms parlants !

## Chapitre 2 : Une armée de classes services
## Chapitre 3 : Ajuster le résultat d'une bataille avec une classe
## Chapitre 4 : Optional type-hinting & Semantic Methods
## Chapitre 5 : Objects are Passed by Reference
## Chapitre 6 : Fetching Objects from the Database
## Chapitre 7 : Handling the Object Id
## Chapitre 8 : Making only one DB Connection with a Property
## Chapitre 9 : Best Practice: Centralizing Configuration
## Chapitre 10 : Best Practice: Centralizing the Connection
## Chapitre 11 : Service Container
## Chapitre 12 : Container: Force Single Objects, Celebrate
## Chapitre 13 : Container to the Rescue