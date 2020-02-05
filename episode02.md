- [TP : Programmation orientée objet en PHP (Épisode 2)](#tp--programmation-orient%c3%a9e-objet-en-php-%c3%89pisode-2)
  - [Chapitre 1 : Classes de services](#chapitre-1--classes-de-services)
    - [Retirer toutes les fonctions procédurales](#retirer-toutes-les-fonctions-proc%c3%a9durales)
  - [Chapitre 2 : Une armée de classes services](#chapitre-2--une-arm%c3%a9e-de-classes-services)
    - [Rendre la méthode privée](#rendre-la-m%c3%a9thode-priv%c3%a9e)
    - [Quelques notes](#quelques-notes)
    - [Un nouveau service, ShipLoader](#un-nouveau-service-shiploader)
    - [Un peu de nettoyage dans les require](#un-peu-de-nettoyage-dans-les-require)
  - [Chapitre 3 : Affiner le résultat d'une bataille avec une classe](#chapitre-3--affiner-le-r%c3%a9sultat-dune-bataille-avec-une-classe)
    - [Créer la classe modèle BattleResult](#cr%c3%a9er-la-classe-mod%c3%a8le-battleresult)
    - [Créer des getters](#cr%c3%a9er-des-getters)
    - [Commenter notre model BattleResult avec PHPDoc](#commenter-notre-model-battleresult-avec-phpdoc)
  - [Chapitre 4 : Déclarations de type et méthodes sémantiques](#chapitre-4--d%c3%a9clarations-de-type-et-m%c3%a9thodes-s%c3%a9mantiques)
    - [Déclaration de types](#d%c3%a9claration-de-types)
    - [Méthodes sémantiques](#m%c3%a9thodes-s%c3%a9mantiques)
  - [Chapitre 5 : Les objets sont toujours passés par référence](#chapitre-5--les-objets-sont-toujours-pass%c3%a9s-par-r%c3%a9f%c3%a9rence)
    - [Correction :](#correction)
  - [Chapitre 6 : Récupérer des objets depuis une base de données](#chapitre-6--r%c3%a9cup%c3%a9rer-des-objets-depuis-une-base-de-donn%c3%a9es)
    - [Exercice (eh oui, il en faut !)](#exercice-eh-oui-il-en-faut)
    - [Requête SQL](#requ%c3%aate-sql)
    - [Un peu d'aide ?](#un-peu-daide)
    - [Résumé](#r%c3%a9sum%c3%a9)
  - [Chapitre 7 : Gérer l'ID d'un objet](#chapitre-7--g%c3%a9rer-lid-dun-objet)
    - [Ajouter l'attribut ID et changer `index.php`](#ajouter-lattribut-id-et-changer-indexphp)
    - [Changer les noms de variables dans `battle.php`](#changer-les-noms-de-variables-dans-battlephp)
    - [Récupérer un élément Ship](#r%c3%a9cup%c3%a9rer-un-%c3%a9l%c3%a9ment-ship)
    - [Exercice :](#exercice)
  - [Correction :](#correction-1)
    - [Transformer un array en un objet Ship](#transformer-un-array-en-un-objet-ship)
    - [PHPDoc](#phpdoc)
  - [Chapitre 8 : Ne faire qu'une connexion à la BDD avec un attribut](#chapitre-8--ne-faire-quune-connexion-%c3%a0-la-bdd-avec-un-attribut)
    - [Prévenir la création de multiples instances de PDO](#pr%c3%a9venir-la-cr%c3%a9ation-de-multiples-instances-de-pdo)
  - [Chapitre 9 : Best Practice: Configuration centralisée](#chapitre-9--best-practice-configuration-centralis%c3%a9e)
    - [Passer aux objets la configuration dont ils ont besoin](#passer-aux-objets-la-configuration-dont-ils-ont-besoin)
    - [La règle d'or](#la-r%c3%a8gle-dor)
  - [Chapitre 10 : Best Practice: Connexion centralisée](#chapitre-10--best-practice-connexion-centralis%c3%a9e)
  - [Ajouter un argument $pdo au constructeur](#ajouter-un-argument-pdo-au-constructeur)
    - [Quelques rappels](#quelques-rappels)
  - [Chapitre 11 : Service Container](#chapitre-11--service-container)
    - [Créer un Service Container](#cr%c3%a9er-un-service-container)
    - [Centraliser la configuration](#centraliser-la-configuration)
  - [Chapitre 12 : Container: Forcer des objets uniques](#chapitre-12--container-forcer-des-objets-uniques)
  - [Chapitre 13 : Les containers à la rescouse](#chapitre-13--les-containers-%c3%a0-la-rescouse)
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
1. Stocker des données de façon claire et descriptive. Une sorte d'array superpuissant avec des attributs bien définis et des méthodes qui nous donnent accès à toutes sortes de fonctionnalités sur nos données. En général, on comme ces classes représentent nos données, les modélisent, on appelle ça un modèle (ou **Model**).

2. Écrire des fonctions pour faire quelque chose dans votre application (ici, une bataille). L'avantage, c'est de pouvoir trier nos fonctions en différentes classes, par exemple, dans une classe `BattleManager`, on peut avoir des fonctions qui font le combat, génèrent une liste d'opposants, tirent un tableau des meilleurs scores...

3. Ou bien on peut même faire un `ScoreManager` qui serait une classe qui gèrerait spécifiquement les scores ! C'est à vous de voir comment vous voulez organiser votre projet. En général, on met dans une classe toutes les fonctions qui se rapportent au nom de la classe (`BattleManager` : fonctions autour d'une bataille, `ScoreManager` : fonctions autour du calcul des scores). Utilisez des noms parlants !

Et comment on s'en sert, de ces classes ?

Comme on l'a vu : on créée un objet depuis la classe (`$battleManager = new BattleManager()`), puis on utilise cet objet pour appeler la fonction. Voyez `BattleManager` comme le rayon "boîte à outils" de Bricorama, et `$battleManager = new BattleManager()` UNE boîte à outils, la votre, dans laquelle vous picorez quelques outils quand il y en a besoin (`$battleManager->battle()` pour l'outil `battle()` !).

Ce deuxième type de classes pleines de fonctions, on appelle ça des **Services**.

## Chapitre 2 : Une armée de classes services
Il nous reste un petit souci : si on regarde bien `BattleManager::battle()` (c'est le petit nom donné à la méthode `battle()` située dans la classe `BattleManager`), on se rend compte qu'il nous reste une fonction procédurale qui est appelée dedans : `usedSpatiodriveBoosters()` (la fonction qui teste si le vaisseau a utilisé son booster Spatiodrive).

Comme on préfèrerait tout mettre dans notre BattleManager, allons-y, déplaçons la fonction de `functions.php` à notre classe de services `BattleManager` !

```php
class BattleManager {
    // ...
    public function usedSpatiodriveBoosters(Ship $ship)
    {
        $spatiodriveBoostersProbability = $ship->getSpatiodriveBooster() / 100;
        // On tire un nombre entre 1 et 100, s'il est inférieur à la probabilité du booster Spatiodrive, alors on retourne true :
        return mt_rand(1, 100) <= ($spatiodriveBoostersProbability * 100);
    }
}
```

Tout simplement : comme pour `battle()`, on copie-colle la fonction, on rajoute `public` devant, on la supprime de `functions.php` et c'est parti.

Attention tout de même, car pour l'instant on a un bug, la fonction n'existe plus (eh oui, c'est une méthode maintenant). Pour corriger cela, il suffit d'aller aux endroits où la fonction est appelée (spoiler: dans `BattleManager::battle`), et remplacer le code suivant :

```php
if (usedSpatiodriveBoosters($ship1)) {
    $ship2Health = 0;
    $ship1UsedSpatiodriveBoosters = true;
    // Si le spatiodrive booster a été utilisé, on break la boucle while
    break;
}
if (usedSpatiodriveBoosters($ship2)) {
    $ship1Health = 0;
    $ship1UsedSpatiodriveBoosters = true;
    // Si le spatiodrive booster a été utilisé, on break la boucle while
    break;
}
```

Par le code suivant :
```php
if ($this->usedSpatiodriveBoosters($ship1)) {
    $ship2Health = 0;
    $ship1UsedSpatiodriveBoosters = true;
    // Si le spatiodrive booster a été utilisé, on break la boucle while
    break;
}
if ($this->usedSpatiodriveBoosters($ship2)) {
    $ship1Health = 0;
    $ship1UsedSpatiodriveBoosters = true;
    // Si le spatiodrive booster a été utilisé, on break la boucle while
    break;
}
```

Et voilà, ça marche !

Mais, pourquoi `$this` ici ? Eh bien parce que `usedSpatiodriveBoosters()` est une fonction de la même classe, et que c'est un objet de la classe, `$battleManager`, qui appelle la méthode. Pour rappel, `$this`, dans une classe, ça représente l'objet lui-même (donc avec les attributs et méthodes de sa classe). Donc pour dire "accède à ta propre méthode qui s'apelle usedSpatiodriveBoosters()", on dit : `$this->usedSpatidoriveBoosters()`.

### Rendre la méthode privée
On se rend compte que cette méthode, `BattleManager::usedSpatiodriveBoosters()`, n'est utilisée que dans la classe elle-même et ne sera jamais utilisée à l'extérieur (en effet, elle ne sert à rien à part dans la méthode `BattleManager::battle()`).

On a vu qu'une classe service, ou une classe bourrée de fonctions, c'était une boîte à outils. Imaginez qu'un autre développeur prenne une copie de cette boîte à outils et, pas très dégourdi, ne sache pas quels outils sont utilisables directement, lesquels sont utilisables qu'en interne à la classe...

Par exemple : un fer à souder. C'est un outil `public`, on s'en sert de partout. Mais l'étain, ce fil qui nous permet de souder, ne nous sert à rien à l'extérieur de la boîte à outils, il ne sert QUE au fer à souder. On peut lui mettre un autocollant `private` pour que le stagiaire bricoleur ne se trompe pas et ne l'utilise pas !

Ici, c'est exactement pareil. `BattleManager::battle()`, c'est notre outil public, on peut s'en servir quand on en a besoin. `BattleManager::usedSpatiodriveBoosters()`, c'est un outil privé, il ne sert qu'à `battle()` et on ne doit pas avoir à s'en servir à l'extérieur de la boîte à outils.

Du coup, passons cette méthode sur `private` !

```php
class BattleManager {
    // ...
    private function usedSpatiodriveBoosters(Ship $ship)
    {
        $spatiodriveBoostersProbability = $ship->getSpatiodriveBooster() / 100;
        // On tire un nombre entre 1 et 100, s'il est inférieur à la probabilité du booster Spatiodrive, alors on retourne true :
        return mt_rand(1, 100) <= ($spatiodriveBoostersProbability * 100);
    }
}
```

Pour le reste, cette fois, rien n'est à changer dans notre code (ouf) !

### Quelques notes

**NOTE :** Quand on déplace des morceaux de code un peu partout, qu'on restructure un projet, qu'on renomme des choses, qu'on créée des classes etc., mais que rien ne change fondamentalement dans la logique de notre application, on appelle ça du **refactoring**, ou **refactoriser** (ou encore **réusiner**, mais personne ne dit ça, soyons sérieux, on est dans l'espace).

**NOTE 2:** Alors, j'ai bien compris cette histoire de private/public, mais pourquoi faire ? Est-ce que ça n'est pas mieux de tout laisser en public, et de ne me servir que de ce dont j'ai besoin, comme ça si jamais j'ai une méthode qui aurait du être private peut me servir à l'extérieur, eh bien je peux m'en servir tout de suite ?

Par exemple, pour ma boîte à outils : si jamais je ne compte pas la prêter. Mon étain, je sais que je ne peux m'en servir qu'avec mon fer à souder, pas besoin de mettre une étiquette pour s'en rappeler. Et puis, si jamais j'ai besoin de m'en servir malgré tout comme un fil de fer par exemple, je pourrais, au moins.

Mauvaise idée ! L'avantage de laisser `private` ce qui doit être privé, c'est que, le jour où vous faites une modification dans une méthode `private` par exemple, vous saurez que les changements n'affecteront que la classe et pas l'extérieur, puisque seule la classe peut utiliser cette méthode. Pour la boîte à outils : vous aviez changé de marque d'étain, et tout a capoté. Si c'est en `private`, vous savez que les dégâts ne seront que dans la boîte à outils. Si ça n'était pas private, vous n'aurez aucune idée de la portée des dégâts, où est-ce que vous aviez utilisé l'étain ailleurs dans le code, etc !

### Un nouveau service, ShipLoader
Pour les plus maniaques d'entre vous, quelque chose doit être en train de vous titiller : il reste UNE fonction dans `functions.php`. Le fichier est nommé au PLURIEL, et il n'y a qu'UNE fonction.

On va y remédier.

Il nous reste `getShips()` dans ce fichier, dans quel classe pourrions-nous l'insérer ?
- Dans `Ship` : bof, car la classe représente un seul Ship à la fois. Et puis c'est un Model : ça modélise un seul vaisseau. Ce serait comme si, imaginons un quartier avec 10 fois le même immeuble. Dans les plans d'architecture d'un immeuble, vous mettiez aussi les données de tout le quartier. Pas très efficace comme rangement !
- Dans `BattleManager`: cette classe ne gère que les batailles. Importer les protagonistes dedans n'est pas très cohérent non plus. Pour notre boîte à outils, c'est comme si j'avais la liste des autres modèles de boîte à outils de Bricorama dans ma boîte à outils. Pas très utile !

On va du coup créer un nouveau service : `ShipLoader` qui contiendra notre fonction `getShips()`.

Comme d'habitude : coupez-collez `getShips()` de `functions.php` et mettez la fonction dans la classe.

```php
// Fichier: /lib/ShipLoader.php
class ShipLoader {
    public function getShips() {

        $ships = [];

        $ship1 = new Ship();
        $ship1->setName("Jedi Starfighter");
        $ship1->setWeaponPower(5);
        $ship1->setSpatiodriveBooster(15);
        $ship1->setStrength(30);
        $ships['starfighter'] = $ship1;

        $ship2 = new Ship();
        $ship2->setName("X-Wing Fighter");
        $ship2->setWeaponPower(2);
        $ship2->setSpatiodriveBooster(2);
        $ship2->setStrength(70);
        $ships['x_wing_fighter'] = $ship2;

        $ship3 = new Ship();
        $ship3->setName("Super Star Destroyer");
        $ship3->setWeaponPower (10);
        $ship3->setSpatiodriveBooster(0);
        $ship3->setStrength(500);
        $ships['super_star_destroyer'] = $ship3;

        $ship4 = new Ship();
        $ship4->setName("RZ1 A-Wing Interceptor");
        $ship4->setWeaponPower(4);
        $ship4->setSpatiodriveBooster(4);
        $ship4->setStrength(50);
        $ships['rz1_a_wing_interceptor'] = $ship4;

        return $ships;
    } 
}
```

### Un peu de nettoyage dans les require
Oulà, il faut qu'on fasse un peu de ménage dans les classes et fichiers que l'on requiert de partout.

Pour commencer, `functions.php` ne me sert qu'à importer toutes mes classes. Le **seul** code présent dans ce fichier est dorénavant :
```php
// Fichier: functions.php
require_once __DIR__.'/lib/Ship.php';
require_once __DIR__.'/lib/BattleManager.php';
require_once __DIR__.'/lib/ShipLoader.php';
```

Ensuite, `index.php` : j'ai besoin de mes classes pour accéder à ma liste de vaisseaux. J'importe `functions.php` qui les possède :
```php
require __DIR__.'/functions.php';
$shipLoader = new ShipLoader();
$ships = $shipLoader->getShips();

// Suite du code...
```

Et idem pour `battle.php` :
```php
<?php
require __DIR__.'/functions.php';

$shipLoader = new ShipLoader();
$ships = $shipLoader->getShips();

// Suite du code...
```

Et voilà, le code est déjà plus propre ! Finalement, `functions.php` ne me sert plus qu'à importer mes classes. D'ailleurs, comme je n'ai pas le droit de déclarer deux fois une même classe, j'ai utilisé des `require_once` : c'est à dire que si jamais le fichier a déjà été importé, et qu'il est de nouveau demandé, on ne l'importera pas.

Testez ! Normalement, tout fonctionne comme avant. Ça y est ! Notre code est complètement codé en POO ! Finies les fonctions, place aux méthodes ! D'ailleurs, pour fêter ça, on va même renommer notre fichier `functions.php` en... `bootstrap.php`. Pensez à renommer également dans les require de  `battle.php` et `index.php` !

**NOTE :** Rien à voir avec la librairie Twitter Bootstrap ! Bootstrap, en anglais, veut dire "amorcer". C'est le fichier d'amorce de notre projet, tout simplement.

D'ailleurs, comme c'est l'amorce du projet et qu'on s'en sert de partout, on peut aussi mettre le `session_start()` à l'intérieur, et le retirer des autres fichiers. Voilà un beau nettoyage de code ! (Enfin... Refactoring).

## Chapitre 3 : Affiner le résultat d'une bataille avec une classe
Le cas le plus fréquent où l'on sait que l'on a besoin d'une classe, c'est lorsque l'on se trouve avec un array de données. En l'occurrence, il nous reste un array à traiter : celui du résultat de la bataille, dans `BattleManager::battle()`.

Rapellez-vous :
1. Dans `BattleManager`, j'ai du code comme ça :
   ```php
   return array(
            'winning_ship' => $winningShip,
            'losing_ship' => $losingShip,
            'used_spatiodrive_boosters' => $usedSpatiodriveBoosters,
        );
    ```
2. Dans `battle.php`, j'ai du code comme :
   ```php
    <p class="text-center">
        <?php if ($outcome['winning_ship'] == null) : ?>
            Les deux opposants se sont détruits lors de leur bataille épique.
        <?php else : ?>
            Le groupe de <?php echo $outcome['winning_ship']->getName(); ?>
            <?php if ($outcome['used_spatiodrive_boosters']) : ?>
                a utilisé son booster Spatiodrive pour détruire ladversaire !
            <?php else : ?>
                a été plus puissant et a détruit le groupe de <?php echo $outcome['losing_ship']->getName() ?>s
            <?php endif; ?>
        <?php endif; ?>
    </p>
    ```
Terrifiant ! Avec les arrays, on n'a aucune assurance des données retournées. Comment être parfaitement certains que notre variable `$outcome` contienne exactement un `winning_ship`, un `losing_ship`...

En utilisant une classe bien sûr !

### Créer la classe modèle BattleResult
Créons un Model (car c'est une représentation de données) dans `/lib`, nommé `BattleResult.php`, contenant la classe `BattleResult`.

Cette classe contiendra le résultat d'une bataille, c'est à dire pour l'instant les données suivantes : `winning_ship`, `losing_ship`, `used_spatiodrive_boosters`.

```php
// Fichier: /lib/BattleResult.php
class BattleResult {
    private $usedSpatiodriveBoosters;
    private $winningShip;
    private $losingShip;
}
```

Jetez un oeil à `Ship.php` et souvenez vous : comment avons-nous fait pour fournir notre classe en données ? En fait, on a utilisé deux stratégies : le **constructeur**, qui nous oblige à insérer des données à la création d'un objet, et les **setters**, plus flexibles.

Ici, utilisons la stratégie du **constructeur** pour **toutes** nos données : en effet, un objet `BattleResult`, donc un résultat de bataille, n'a de sens que si on connaît le vaisseau gagnant, le perdant, et si le booster a été utilisé !

```php
class BattleResult
{
    private $usedSpatiodriveBoosters;
    private $winningShip;
    private $losingShip;
    public function __construct($usedSpatiodriveBoosters, $winningShip, $losingShip)
    {
        $this->usedSpatiodriveBoosters = $usedSpatiodriveBoosters;
        $this->winningShip = $winningShip;
        $this->losingShip = $losingShip;
    }
}
```

Et hop, on a une belle classe `BattleResult` de prête avec de petits résultats de bataille en devenir.

Pour rendre les choses plus propres, on sait à l'avance les types qu'auront les paramètres de notre constructeur. Indiquons-les pour être sûrs de recevoir les bonnes données dans un résultat de bataille !

```php
class BattleResult {
    // ...
    public function __construct(bool $usedSpatiodriveBoosters, Ship $winningShip, Ship $losingShip) {
        // ...
    }
}
```

Maintenant, changeons le reste du code.

Commençons avec `BattleManager`, notre fichier qui retourne un résultat de bataille en array :


Remplacez ce code :
```php
class BattleManager
{
    // ...
    public function battle(Ship $ship1, $ship1Quantity, Ship $ship2, $ship2Quantity)
    {
        // ...
        // Tout en bas de la fonction ...
        return array(
            'winning_ship' => $winningShip,
            'losing_ship' => $losingShip,
            'used_spatiodrive_boosters' => $usedSpatiodriveBoosters,
        );
    }
}
```

Par ce code : 
```php
class BattleManager
{
    // ...
    public function battle(Ship $ship1, $ship1Quantity, Ship $ship2, $ship2Quantity)
    {
        // ...
        // Tout en bas de la fonction ...
        return new BattleResult($usedSpatiodriveBoosters, $winningShip, $losingShip);
    }
}
```

Et n'oubliez pas de rajouter dans `bootstrap.php` notre nouvelle classe : 
```php
// ...
require_once __DIR__.'/lib/BattleResult.php';
```

Enfin, quel fichier se sert de ce `BattleResult` déjà ? `battle.php` bien sûr ! Rapellez-vous cette ligne qui allait nous chercher le résultat de bataille pour le stocker dans une variable `$outcome` :
```php
$outcome = $battleManager->battle($ship1, $ship1Quantity, $ship2, $ship2Quantity);
```

Et pour la réutiliser ainsi :
```php
<?php if ($outcome['winning_ship']) : ?>
    <?php echo $outcome['winning_ship']->getName(); ?>
```

L'idée de tout ce que nous faisons, c'est de se débarasser de cet array.
Avant tout, si on suit la pile d'exécution, voyons ce qu'on devrait trouver dans `$outcome` :
1. `$outcome` est égal à `$battleManager->battle()`
2. `->battle()`, dans `BattleManager`, retourne un `new BattleResult()`
3. Donc, dans `$outcome`, on aura un `new BattleResult()`.
4. Je vérifie ce qu'il y a dans un objet `BattleResult` : c'est un objet qui a les attributs suivants : `usedSpatiodriveBoosters`, `winningShip`, `losingShip`.

Et voilà ! En POO, prenez le temps de prendre du recul sur votre code et remonter petit à petit les étapes d'exécution du code, sinon on se perd vite.

On comprend donc que `$outcome` est un objet de type `BattleResult`, et qu'il possède les attributs `$outcome->usedSpatiodriveBoosters`, `$outcome->winningShip`, `$outcome->losingShip`.


### Créer des getters

Avant toute chose, rapellez-vous que ces attributs sont en private ! Il va falloir créer des getters pour chacun d'eux au sein de `BattleResult` : `getUsedSpatiodriveBoosters()`, `getWinningShip()` et `getLosingShip()`. D'ailleurs, `getUsedSpatiodriveBoosters()` semble un peu moche et long à dire : vous pouvez pourquoi pas créer un getter nommé `wereBoostersUsed()` (qui veut dire "est-ce que les boosters ont été utilisé ?").

Parfait ! Il n'y a plus qu'à remplacer dans `battle.php` les arrays par cet objet `$outcome`. Par exemple : `$outcome['winning_ship']` deviendra `$outcome->getWinningShip()` et ainsi de suite.


### Commenter notre model BattleResult avec PHPDoc

N'oubliez pas de commenter votre code petit à petit, voici un exemple d'un `BattleResult.php` proprement documenté :

```php
class BattleResult
{
    private $usedSpatiodriveBoosters;
    private $winningShip;
    private $losingShip;

    /**
     * @param bool $usedSpatiodriveBoosters
     * @param Ship $winningShip
     * @param Ship $losingShip
     */
    public function __construct(bool $usedSpatiodriveBoosters, Ship $winningShip, Ship $losingShip)
    {
        $this->usedSpatiodriveBoosters = $usedSpatiodriveBoosters;
        $this->winningShip = $winningShip;
        $this->losingShip = $losingShip;
    }

    /**
     * @return Ship
     */
    public function getWinningShip() : Ship {
        return $this->winningShip;
    }

    /**
     * @return Ship
     */
    public function getLosingShip() : Ship {
        return $this->losingShip;
    }

    /**
     * @return bool
     */
    public function whereBoostersUsed() : bool {
        return $this->usedSpatiodriveBoosters;
    }
}
```

## Chapitre 4 : Déclarations de type et méthodes sémantiques
Si vous lancez un combat, et que vous actualisez (beaucoup, beaucoup, beaucoup) de fois, vous risquez de tomber sur un cas particulier. Le cas où deux vaisseaux se détruisent en même temps au même tour !

### Déclaration de types
Dans ce cas, pas de gagnant, et pas de `Ship` à donner au `BattleResult`.

Pourtant, si on jette un oeil à notre constructeur de `BattleResult` :

```php
public function __construct(bool $usedSpatiodriveBoosters, Ship $winningShip, Ship $losingShip) { /**/ }
```

Eh bien... On attend deux `Ship` ! On peut corriger ce problème en rajoutant un `?` devant le type : 
```php
public function __construct(bool $usedSpatiodriveBoosters, ?Ship $winningShip, ?Ship $losingShip) { /**/ }
```

Ce petit point d'interrogation veut dire : "je veux que tu créées un BattleResult avec ces trois variables à chaque fois, même si elles sont `null`". C'est tout !

Pour coder proprement, modifions aussi la documentation : `getLosingShip()` et `getWinningShip()` retournent dorénavant soit un `Ship`, soit... `null` !

```php
// Dans la classe BattleResult :

    /**
     * @return Ship|null
     */
    public function getLosingShip()
    {
        return $this->losingShip;
    }

    /**
     * @return Ship|null
     */
    public function getWinningShip()
    {
        return $this->winningShip;
    }
```

### Méthodes sémantiques
On peut rajouter des méthodes sémantiques, c'est à dire des méthodes simplement pratiques mais sans grande logique, qui sont là pour nous faciliter la vie. Par exemple, je sais que je ne peux pas utiliser mon objet `BattleResult` aussi facilement que ça: il faut que je pense aux cas où il n'y a pas de gagnants !

Pour savoir cela, j'ai deux choix :
1. Tester `if ( $battleResult->getWinningShip() ) { }` : si c'est vrai, c'est qu'il y a un vaisseau gagnant (et aussi un perdant du coup)
2. Créer une méthode dédiée plus lisible, comme `if ( $battleResult->isThereAWinner() ) { }` (en français: est-ce qu'il y a un gagnant), qui retourne `true` si... il y a un gagnant !

De plus, l'avantage du 2., est que la donnée retournée pourrait être un vrai `bool`, et pas un objet `Ship` ! (Bah oui, ma question c'est "est-ce qu'il y a un gagnant", pas "donne-moi le gagnant").

On peut donc ajouter à `BattleResult` la méthode suivante :

```php
class BattleResult {
    // ...

    /**
     * @return bool
     */
    public function isThereAWinner() : bool {
        return $this->getWinningShip() !== null;
    }
}
```

Et voilà ! Encore une fois, on ne code plus pour résoudre des bugs, mais pour se faciliter la vie. N'hésitez pas à rajouter des méthodes qui vous facilitent le code, vous permettent de vous y retrouver, etc. !

On peut donc enfin modifier correctement `battle.php` sur ses deux conditions `if` :

```php
// Fichier: battle.php
<h3 class="text-center audiowide">
    Gagnant :
    <?php if ($outcome->isThereAWinner()) : ?>
        <?php echo $outcome->getWinningShip()->getName(); ?>
    <?php else : ?>
        Personne
    <?php endif; ?>
</h3>
```

Et : 

```php
// Fichier : battle.php
<p class="text-center">
    <?php if (!$outcome->isThereAWinner()) : ?>
        Les deux opposants se sont détruits lors de leur bataille épique.
    <?php else : ?>
        Le groupe de <?php echo $outcome->getWinningShip()->getName(); ?>
        <?php if ($outcome->whereBoostersUsed()) : ?>
            a utilisé son booster Spatiodrive pour détruire ladversaire !
        <?php else : ?>
            a été plus puissant et a détruit le groupe de <?php echo $outcome->getLosingShip()->getName() ?>s
        <?php endif; ?>
    <?php endif; ?>
</p>
```
## Chapitre 5 : Les objets sont toujours passés par référence
Ajoutons une nouvelle fonctionnalité : afficher la résistance finale de nos vaisseaux (le perdant a bien sûr zéro ou moins, mais le gagnant, il lui reste combien ?)

C'est la classe `BattleResult` qui nous retourne les résultats. Et pour l'instant, elle ne nous retourne pas de variable contenant la santé de nos vaisseaux. On pourrait ajouter une variable "ship strength" ou quelque chose comme ça dans notre `BattleResult`, mais voyons quelque chose de plus intéressant.

Modifions un peu notre gestion de bataille `BattleManager` dans la méthode `battle()`, dans la boucle de combat :

```php
while ($ship1Health > 0 && $ship2Health > 0) {
    // ...
    $ship1Health = $ship1Health - ($ship2->getWeaponPower() * $ship2Quantity);
    $ship2Health = $ship2Health - ($ship1->getWeaponPower() * $ship1Quantity);
}
```

On a bien nos variables `$ship1Health` et `$ship2Health`, elles peuvent nous servir ! C'est la valeur en cours de la résistance du vaisseau lors de la bataille.

Le problème, c'est qu'elles ne sont stockées nulle-part.

Plutôt que de retourner ces valeurs brutes comme suggéré au début du chapitre, nous allons faire bien mieux : `$ship1` et `$ship2` sont des objets... On peut utiliser leurs setters pour changer la valeur de leur `strength` !

Modifiez le fichier `BattleManager` dans la méthode `battle()`, et ajoutez juste après la boucle du combat :

```php
while ($ship1Health > 0 && $ship2Health > 0) {
    // ...
    $ship1Health = $ship1Health - ($ship2->getWeaponPower() * $ship2Quantity);
    $ship2Health = $ship2Health - ($ship1->getWeaponPower() * $ship1Quantity);
}
// On met à jour la valeur finale de la résistance des vaisseaux dans l'objet lui-même :
$ship1->setStrength($ship1Health);
$ship2->setStrength($ship2Health);
```

Pour tester, mettez un `var_dump` et un `die`, en débuguant `$ship1` et `$ship2` juste en dessous du code que vous venez de taper. Essayez un combat.

Et voilà ! On voit que les deux vaisseaux ont une vie qui a changé. On peut récupérer cette donnée et l'afficher dans `battle.php` !

Ce que l'on vient de faire est peut-être plutôt simple et fonctionnel, mais c'est une grande avancée. En effet, jusqu'à présent, `battle()` ne faisait que *lire* nos données. C'est à dire qu'on lisait la force, la résistance... Et on faisait un combat, en retournant le résultat de quelques calculs. Maintenant, dans notre méthode, on est capable de **lire** des données ainsi que d'**écrire** des données.

C'est **complètement** différent de comme les fonctions et les arrays marchaient en PHP procédural par défaut. En effet, en passant des données d'un array dans une fonction, une copie des données de l'array auraient été modifiées dans la fonction, mais les données de l'array d'origine n'étaient jamais modifiées !

Concrètement, si on résume ce qui vient de se passer : je passe des objets `Ship` dans la méthode `BattleManager::battle`. Ils sont traités par la fonction, et ensuite... Ils en ressortent modifiés.

En PHP fonctionnel, ce comportement n'existe pas : si je passe une variable dans une fonction, elle est traitée par la fonction... Mais ensuite, sa valeur reste celle d'origine. La fonction ne modifie pas la variable elle-même directement.

Les objets, eux, sont passés "par référence" : ça veut dire qu'il n'y a qu'un et un seul objet `$ship1` qui existe, et quand on le passe dans une fonction, nous passons précisément cet objet - pas une copie ! Quand on passe un array ou une string à une fonction par contre, on passe en fait une *copie* de la valeur d'origine. Ainsi, tous les changements qui pourraient être faits dans la fonction ne sont pas appliqués à la variable d'origine. Pour les objets... Si !

**NOTE** : en réalité, on peut aussi passer des arrays et des strings par référence dans une fonction, en ajoutant le symbole `&` devant l'argument (par exemple: appeler `myFunction()` ainsi : `myFunction(&$var)`). Pour les objets on n'en a pas besoin évidemment, car ils sont toujours passés par référence.

Le point à retenir de tout ça, qui peut être positif comme négatif, c'est que lorsqu'un changement est effectué sur un objet quelque part dans le code, ce changement est opéré de partout dans l'application pour cet objet !

Pour illustrer tout cela, retirez vos `var_dump` de tests et ajoutez dans `battle.php` un endroit où afficher la résistance (`
ship->getStrength()`) des deux vaisseaux lors de l'affichage du résultat.

### Correction :
On peut mettre tout ça dans un petit `dl/dd` par exemple ! Dans `battle.php`, au dessus des `<h3>`  :

```php
<h3>Résistance restante finale:</h3>
<dl class="dl-horizontal">
    <dt><?php echo $ship1->getName(); ?></dt>
    <dd>Résistance : <?php echo $ship1->getStrength(); ?></dd>
    <dt><?php echo $ship2->getName(); ?></dt>
    <dd>Résistance : <?php echo $ship2->getStrength(); ?></dd>
</dl>
```

Et voilà ! Normalement, dans les résultats, on voit la nouvelle valeur de la résistance apparaître.

## Chapitre 6 : Récupérer des objets depuis une base de données

### Exercice (eh oui, il en faut !)

Vous allez modifier le `ShipLoader` de sorte à récupérer des vaisseaux issus d'une base de données. Ce qui implique plusieurs étapes à suivre :

1. Créez une base de données et une table de `Ship`. Vous trouverez la requête SQL complète juste après. Les `Ship` en base de données auront les même champs que leur classe Model, avec bien sûr un `id` auto-incrémenté.
2. Créer une méthode dans `ShipLoader` nommée `queryForShips()`. Elle sera privée, car elle ne sert qu'au `ShipLoader`.
3. Dans cette méthode, vous instancierez un `new PDO` qui se connecte à la base de données et récupère la liste des `Ship` de la base de données (rapellez-vous : prepare, execute...) dans un array `$ships`.
4. Dans la méthode `getShips()`, appelez la méthode privée `queryforShips()` pour mettre les résultats dans une variable: par exemple, `$shipsDb = $this->queryForShips();` et var_dumpez les résultats.
5. PDO nous retourne un array de tableaux avec les données de chaque `Ship` ! Mais il nous faut des... Objets `Ship`. Faites maintenant une boucle `foreach`, qui permette de prendre les données issues de la base de données, et de créer des objets.
6. Dans la boucle, vous mettrez les objets ainsi créés dans un tableau `$ships`.
7. Enfin, retournez simplement `$ships` !

### Requête SQL
```sql
CREATE TABLE `ship` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `weapon_power` int(4) NOT NULL,
 `spatiodrive_booster` int(4) NOT NULL,
 `strength` int(4) NOT NULL,
 `is_under_repair` tinyint(1) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

### Un peu d'aide ?
En fait, la classe `ShipLoader` ne contiendra plus grand chose par rapport au début. Voici la classe complète avec uniquement les commentaires :

```php
<?php
class ShipLoader
{
    /**
     * Retourne tous les ships sous forme d'objets Ships.
     * 
     * @return Ship[] Tableau d'objets Ship
     */
    public function getShips()
    {
        // 1. On prépare notre tableau de Ships
        $ships = [];

        // 2. On appelle la méthode privée queryForShips() qui nous retourne les Ships de la BDD
        // sous forme de tableau (passez $shipsData dans un var_dump() pour voir à quoi ça ressemble)
        $shipsData = "A REMPLACER !";

        // 3. On foreach le tableau de données qui vient de la BDD...
        // Remplacez évidemment $A et $B ;)
        foreach ($A as $B {

            // 4. .. pour créer des objets, et non plus des arrays!
            $ship = new Ship("??????");
            // ...
            // ...

            // 5. Notre objet créé, on l'ajoute au tableau de Ships.
            $ships[] = $ship;
        }

        // Enfin, on retourne le tableau de Ships !
        return $ships;
    }

    /**
     * Retrouve en BDD la liste des Ships.
     * 
     * @return array[] Tableau de tableaux de ships
     */
    private function queryForShips()
    {

        // 1. On se connecte à PDO
        $pdo = "À REMPLACER";

        // 2. On configure PDO (optionnel)
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 3. On prépare et exécute la requête
        // ...
        // ...

        // 4. On récupère les données (fetchAll car il y a plusieurs éléments)
        $shipsArray = "À REMPLACER";

        // 5. On retourne les données
        return $shipsArray;
    }
}
```

### Résumé
La classe `ShipLoader` ne contient plus de données en dur, ça y est ! En quelques minutes, on se trouve maintenant avec une classe qui récupère dynamiquement nos données réelles en base de données, une classe qui contient finalement moins de lignes qu'avant (bah oui, on n'a plus d'objets Ship à écrire à la main) et une intégration avec PDO (qui est une classe par ailleurs, maintenant on la comprend mieux !)

## Chapitre 7 : Gérer l'ID d'un objet
Si on teste notre application de nouveau, il y a un bug ! On a une erreur :
```
N'oubliez pas de séléctionner des vaisseaux pour  le combat !
```

Vous avez très certainement séléctionné un vaisseau pour combattre.... Et pourtant ! Que s'est-il passé ? Si on observe le code de `index.php`, regardons les `<select>` :

```php
<select class="center-block form-control dropdown-toggle" name="ship1_name">
    <option value="">Choisir un vaisseau</option>
    <?php foreach ($ships as $key => $ship) : ?>
        <?php if ($ship->isFunctional()) : ?>
            <option value="<?php echo $key; ?>"><?php echo $ship->getNameAndSpecs(); ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>
// ...
<select class="center-block form-control dropdown-toggle" name="ship2_name">
    <option value="">Choisir un vaisseau</option>
    <?php foreach ($ships as $key => $ship) : ?>
        <?php if ($ship->isFunctional()) : ?>
            <option value="<?php echo $key; ?>"><?php echo $ship->getNameAndSpecs(); ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>
```

On se  rend compte que  la `value` passée en `POST` pour les `<option>` des `<select>` sont une certaine variable `$key`. C'est quoi ça, déjà ?

En fait, jusqu'à présent, `getShips()` nous retournait un tableau de ce genre :

Le premier, en procédural :
```
[
    "jedi_ship" => [
        "name" => "Jedi Ship",
        "strength" => 10,
    ],
    "master_ship" => [
        "name" => "Master Ship",
        "strength" => 30,
    ],
]
```

Le second, en objet :
```
[
    "jedi_ship" => Object Ship,
    "master_ship" => Object Ship
]
```

Mais maintenant, notre fonction `getShip()` complètement orientée objet nous retourne :

```
[
    Object Ship, // id = 1, name  = "Jedi Ship"...
    Object Ship, // id = 2, name = "Master Ship"...
]
```

Dans les deux premiers cas, on avait des clés créées à la main (`jedi_ship`, `master_ship`...). Dans le troisième cas, aucune clé créé à la main (c'est normal, plus de données en dur). Du coup, il va falloir utiliser une clé issue de notre objet et mettre à jour notre code.

Quelle clé pourrait être idéale ? L'id bien sûr ! Maintenant que nous avons des donnéesde la base de données, on a de belles données bien formées avec des champs ID.

### Ajouter l'attribut ID et changer `index.php`
1. Notre Model doit ressembler à la table en base de données. Ajoutez donc un attribut `$id` et ses getters/setters.
2. Comme on a un nouvel élément à ajouter dans notre objet (`->setId()`), modifiez le `ShipLoader` dans la boucle qui créée les objets, et ajoutez `->setId()` de sorte à ce que nos objets aient bien un ID.
3. Retournons sur nos `<select>` dans `index.php`. Il va falloir opérer trois changements pour chacun : 
   1. Changer le `name` du `<select>`, qui est `ship1_name` et `ship2_name`, par `ship1_id`, `ship2_id`. Ce sera bien plus parlant !
   2. Changer le foreach : nous n'avons plus de tableau `key => value`, mais juste un tableau de `values` (les objets !). Changez-les comme ça :
    ```php
    <?php foreach ($ships as $ship) : ?>
    // ...
    <?php endforeach; ?>
    ```
    3. Enfin, changer l'`<option>`: pour sa `value`, nous n'avons plus accès à la `key`, mettez plutôt l'ID du ship (`$ship->getId()`).

Vérifiez que tout fonctionne !

### Changer les noms de variables dans `battle.php`
Plusieurs choses sont à changer dans `battle.php` :
1. Changez les noms de variables de façon adéquate (`$ship1Name`  et `$ship2Name` deviennent `$ship1Id` et `$ship2Id`). Attention à changer de partout dans le fichier là où c'est nécessaire !
2. Changez aussi les `$_POST['ship1_name']` et `$_POST['ship2_name']` en `$_POST['ship1_id']` et `$_POST['ship2_id']` : eh oui, on avait changé le `name` des `<select>` dans `index.php`.

### Récupérer un élément Ship
Si tout a bien été changé (ça doit buguer et c'est normal), vous devriez avoir dans `battle.php`, à un endroit, quelque chose comme :

```php
$ship1 = $ships[$ship1Id];
$ship2 = $ships[$ship2Id];
```

Ces deux lignes servaient à récupérer le `ship1` et le `ship2` dans le tableau `$ships`, par leur `key` dans le tableau. Maintenant, nous avons un tableau qui n'est plus associatif, nous n'avons plus de clé à donner au tableau : c'est un simple tableau d'objets.

Il faut pourtant récupérer les données de `ship1` et de `ship2` ! Comment faire ? Avec une requête SQL qu'on connaît bien : `SELECT * FROM ship WHERE id = :id`. Et quelle est la classe idéale pour ça ? Notre `ShipLoader` !

### Exercice :
Ajoutez une nouvelle méthode `public findOneById(int $id)`. Cette méthode prend donc un `int` en paramètres, devra instancier PDO pour se connecter à la base de données (spoiler : prenez un morceau du code qui se trouve déjà dans la méthode `queryForShips()` de la même classe pour faire ça), préparer/executer la requête (rapellez-vous les pseudo-variables !) pour récupérer l'élément en base de données grâce à l'id passé en paramètres de la fonction (il n'y a que UN élement : `fetch` et pas `fetchAll` !), et retourner cette donnée.

## Correction :
Essayez de le faire vous-même avant de voir la correction !
```php
/**
     * @param int $id
     * @return array
     */
    public function findOneById(int $id)
    {
        $pdo = new PDO('mysql:host=localhost;dbname=hbspaceships', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $pdo->prepare('SELECT * FROM ship WHERE id = :id');
        $statement->execute(array('id' => $id));
        $shipArray = $statement->fetch(PDO::FETCH_ASSOC);
        var_dump($shipArray);
        die;
    }
```

Regardez dans la correction : pour le moment, on ne retourne rien, on var_dump et die. Comme toujours en fait ! Dès que possible, on teste !

Comment appeler ce code ? On va maintenant modifier `battle.php` (c'est le fichier qui cherchait à récupérer nos `Ship`) pour appeler la méthode.

Étape 1 : modifier le code qui cherche les Ship. Changez ce code :
```php
$ship1 = $ships[$ship1Id];
$ship2 = $ships[$ship2Id];
```

Par ce code :

```php
$ship1 = $shipLoader->findOneById($ship1Id);
$ship2 = $shipLoader->findOneById($ship2Id);
```

On utilise l'objet `ShipLoader` qui a déjà été déclaré en haut du fichier, et on utilise sa nouvelle méthode `findOneById`.

Étape 2 : décalez ce morceau de code. Si vous regardez bien `battle.php`, on voit que pour le moment, on trouve `$ship1` et `$ship2` **après** le test `if` qui vérifient s'ils existent ! Pas très logique. Voici le test :

```php
if (!isset($ships[$ship1Id]) || !isset($ships[$ship2Id])) {
    $_SESSION['error'] = 'bad_ships';
    header('Location: index.php');
    die;
}
```
Le test dit : "s'il n'existe pas de `ship1Id` ni de `ship2Id` dans le tableau `ships`, alors on créée une erreur".

Plusieurs soucis ici : un tel tableau (tableau associatif de Ship) n'existe plus, et en plus, on va récupérer nos Ship après cette condition. Donc l'erreur sera toujours créée pour le moment. Modifions `battle.php`, sur le passage où on a les 3 `if` et le nouveau code avec `findOneById()` de cette façon :

```php
// D'abord, on teste si les ID sont présents
if (!$ship1Id || !$ship2Id) {
    $_SESSION['error'] = 'missing_data';
    header('Location: index.php');
    die;
}

// Ensuite, puisque les ID sont présents, on cherche en BDD nos Ship
$ship1 = $shipLoader->findOneById($ship1Id);
$ship2 = $shipLoader->findOneById($ship2Id);

// Ensuite, on teste si les deux Ship existent (ont été trouvé en BDD)
// On ne teste plus le tableau, ouf !
if (!isset($ship1) || !isset($ship2Id) ) {
    $_SESSION['error'] = 'bad_ships';
    header('Location: index.php');
    die;
}

// Enfin, on teste la quantité de Ship
if ($ship1Quantity <= 0 || $ship2Quantity <= 0) {
    $_SESSION['error'] = 'bad_quantities';
    header('Location: index.php');
    die;
}
```

Testez ! Si tout se passe bien, nous avons un Ship venu de la base de données qui est var_dumpé (le var_dump qui vient de `ShipLoader` dans `findOneById`).

Comme tout fonctionne, terminons notre affaire de `findOneById`.

### Transformer un array en un objet Ship
Le problème pour le moment, c'est que `findOneById` nous retourne un array : c'est normal, la donnée vient de la base de données avec PDO, on a donc un tableau de données.

Créons une méthode privée qui servira à convertir un array en un objet Ship :

```php
private function createShipFromData(array $shipData)
{

}
```

Dedans, on y met un code qu'on connaît déjà... Celui qui existe dans le foreach de `getShips` ! Ajoutez à notre nouvelle méthode `createShipFromData` le code suivant :

```php
private function createShipFromData(array $shipData)
{
    $ship = new Ship($shipData['name']);
    $ship->setId($shipData['id']);
    $ship->setWeaponPower($shipData['weapon_power']);
    $ship->setSpatiodriveBooster($shipData['spationdrive_booster']);
    $ship->setStrength($shipData['strength']);

    return $ship;
}
```

Et comme nous venons d'utiliser le code du foreach de `getShips`, nous pouvons modifier le foreach dans `getShips` comme cela :

```php
foreach ($shipsData as $shipData) {
    $ships[] = $this->createShipFromData($shipData);
}
```

Tout simplement !

Terminons également notre `findOneById()` qui retourne maintenant la donnée transformée en `Ship` grâce à notre nouvelle méthode :

```php
public function findOneById($id)
{
    $pdo = new PDO('mysql:host=localhost;dbname=hbspaceships', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $pdo->prepare('SELECT * FROM ship WHERE id = :id');
    $statement->execute(array('id' => $id));
    $shipArray = $statement->fetch(PDO::FETCH_ASSOC);
    return $this->createShipFromData($shipArray);
}
```

Dans `battle.php`, nos variables `ship1` et `ship2` devraient donc maintenant être des objets `Ship`. Par contre, ajoutons une petite validation : et si un utilisateur malveillant changeait l'id par un id inexistant ? Retournons `null` si aucun `Ship` n'a été trouvé pour l'id donné :

```php
public function findOneById($id)
{
    $pdo = new PDO('mysql:host=localhost;dbname=hbspaceships', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $pdo->prepare('SELECT * FROM ship WHERE id = :id');
    $statement->execute(array('id' => $id));
    $shipArray = $statement->fetch(PDO::FETCH_ASSOC);

    // Si aucun ship n'est trouvé en bdd...
    if (!$shipArray) {
        return null;
    }

    // Sinon, on retourne le ship transformé en objet Ship
    return $this->createShipFromData($shipArray);
}
```

Enfin (ouf!), modifions une dernière chose dans `battle.php` :  l'endroit où on teste, avec le `if`, si le Ship existe dans le tableau `$ship` :

Remplacez ce code :
```php
if (!isset($ships[$ship1Id]) || !isset($ships[$ship2Id])) {
    $_SESSION['error'] = 'bad_ships';
    header('Location: index.php');
    die;
}
```

Par ce code :
```php
if (!$ship1 || !$ship2) {
    $_SESSION['error'] = 'bad_ships';
    header('Location: index.php');
    die;
}
```

### PHPDoc

Pour finir, commentons correctement nos méthodes pour que notre éditeur de code comprenne correctement notre classe :

```php
class ShipLoader
{
    /**
     * Retourne tous les ships sous forme d'un tableau d'objets Ship
     * @return Ship[] Tableau d'objets Ship
     */
    public function getShips() { }

    /**
     * Retrouve en BDD la liste des ships sous forme d'un tableau de tableaux de données des ships
     * @return array[] Tableau de tableaux de ships
     */
    private function queryForShips() {}

    /**
     * Retrouve un Ship par son id
     * @param $id
     * @return Ship
     */
    public function findOneById($id) {}

    /**
     * Créée un objet Ship depuis un tableau de données d'un ship
     * @param array $shipData
     * @return Ship
     */
    private function createShipFromData(array $shipData) {}
}
```

Ouf ! Ça y est, un gros morceau de fait : utiliser une vraie base de données avec notre classe. Bravo !
Pour être sûrs que tout fonctionne, voici notre classe `ShipLoader` au complet :

```php
<?php
class ShipLoader
{
    /**
     * Retourne tous les ships sous forme d'un tableau d'objets Ship
     * @return Ship[] Tableau d'objets Ship
     */
    public function getShips()
    {
        // On prépare notre tableau de Ships
        $ships = [];

        // On appelle la méthode privée queryForShips() qui nous retourne les Ships de la BDD
        // sous forme de tableau (passez $shipsData dans un var_dump() pour voir à quoi ça ressemble)
        $shipsData = $this->queryForShips();

        // On foreach le tableau de données qui vient de la BDD...
        foreach ($shipsData as $shipData) {
            $ships[] = $this->createShipFromData($shipData);
        }

        // Enfin, on retourne le tableau de Ships !
        return $ships;
    }

    /**
     * Retrouve en BDD la liste des ships sous forme d'un tableau de tableaux de données des ships
     * @return array[] Tableau de tableaux de ships
     */
    private function queryForShips()
    {

        // On se connecte à PDO
        $pdo = new PDO('mysql:host=localhost;dbname=hbbattleships', 'root', 'root');

        // On configure PDO (optionnel)
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // On prépare et exécute la requête
        $statement = $pdo->prepare('SELECT * FROM ship');
        $statement->execute();

        // On récupère les données (fetchAll car il y a plusieurs éléments)
        $shipsArray = $statement->fetchAll(PDO::FETCH_ASSOC);

        // On retourne les données
        return $shipsArray;
    }

    /**
     * Retrouve un Ship par son id
     * @param $id
     * @return Ship
     */
    public function findOneById($id)
    {
        $pdo = new PDO('mysql:host=localhost;dbname=hbspaceships', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $pdo->prepare('SELECT * FROM ship WHERE id = :id');
        $statement->execute(array('id' => $id));
        $shipArray = $statement->fetch(PDO::FETCH_ASSOC);

        // Si aucun ship n'est trouvé en bdd...
        if (!$shipArray) {
            return null;
        }

        // Sinon, on retourne le ship transformé en objet Ship
        return $this->createShipFromData($shipArray);
    }

    /**
     * Créée un objet Ship depuis un tableau de données d'un ship
     * @param array $shipData
     * @return Ship
     */
    private function createShipFromData(array $shipData)
    {
        $ship = new Ship($shipData['name']);
        $ship->setId($shipData['id']);
        $ship->setWeaponPower($shipData['weapon_power']);
        $ship->setSpatiodriveBooster($shipData['spationdrive_booster']);
        $ship->setStrength($shipData['strength']);

        return $ship;
    }
}
```

## Chapitre 8 : Ne faire qu'une connexion à la BDD avec un attribut
Vous l'avez sans doute remarqué : nous appelons deux fois la base de données dans notre classe `ShipLoader`. C'est un problème évident : si on a une modification à faire sur l'appel de la base de données, on doit dédoubler le code.

Modifions un peu notre classe en ajoutant une méthode privée dédiée à PDO :

```php
/**
 * @return PDO
 */
private function getPDO()
{
    $pdo = new PDO('mysql:host=localhost;dbname=hbspaceships', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
```

Vous savez déjà ce qu'il vous reste à faire : remplacez le code qui appelle PDO dans `findOneById()` et `queryForShips()` de sorte à utiliser le PDO de la classe, et ne plus avoir à l'appeler à chaque fois :

```php
public function findOneById($id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM ship WHERE id = :id');
        $statement->execute(array('id' => $id));
        $shipArray = $statement->fetch(PDO::FETCH_ASSOC);
        // ...
```

```php
private function queryForShips()
    {
        $statement = $this->getPDO()->prepare('SELECT * FROM ship');
        $statement->execute();
        // ...
```

Retournez sur la page d'accueil. Nos données s'affichent toujours : rien n'a bougé, parfait !

Il nous reste encore un petit problème : et si une page devait appeler plusieurs fois `findOneById()` ou `queryForShips()` ? Il se trouverait que `getPDO()` serait appelé plusieurs fois et... Plusieurs connexions à la base de données seraient ouvertes en parallèle. C'est un gâchis de ressources !

### Prévenir la création de multiples instances de PDO
Comment garantir qu'un seul objet PDO n'a été créé ? En créant un attribut ! D'une manière que nous n'avons pas encore vu. Jusque-là, nos attributs ne nous servaient qu'à donner des propriétés à un Model, comme Ship et `name`, `weaponPower`...

Dans les classes services (c'est à dire, n'importe quelle classe dont le job principal est de *faire* quelque chose plutôt que de contenir de la data, comme les modèles), on utilise des attributs pour 2 raisons : 1/ contenir des options sur comment la classe doit se comporter, 2/ contenir des outils pour la classe... comme PDO.

Créez un attribut privé `private $pdo` dans notre `ShipLoader`.

Ensuite, modifions un peu `getPDO()` : testons d'abord si une instance de PDO existe dans notre nouvel attribut `$pdo`, si ça n'est pas le cas, alors on a le droit d'ouvrir une connexion !

```php
private function getPDO()
{
    if ($this->pdo === null) {
        $this->pdo = new PDO('mysql:host=localhost;dbname=hbspaceships', 'root');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    return $this->pdo;
}
```

Au premier appel de `getPDO()`, `$this->pdo` sera nul, donc on créée un objet `PDO` et on le met dans `$this->pdo`. Sinon, on retourne le `$this->pdo` existant !

C'est la première fois que nous voyons un attribut dans une de nos classes service. Et dans les classes services, les attributs ne servent pas à contenir des données, comme `name` pour `Ship`, mais à retenir des options et outils pour le bon fonctionnement du service !

Actualisez la page : aucune différence ne devrait apparaître et tout devrait fonctionner.

## Chapitre 9 : Best Practice: Configuration centralisée
Prochain problème : dans notre ShipLoader, notre connexion à la base de données et écrite en dur. C'est un souci pour deux raisons :
   1. Si ça fonctionne sur mon ordinateur, ça ne fonctionnera probablement pas en production (pas les même identifiants)
   2. Et si on avait besoin d'une connexion en BDD dans une autre classe ? On devrait réécrire la connexion, bof bof.

Voici l'objectif : déplacer la connexion de la base de données dans un endroit plus centralisé, de sorte à ce qu'on puisse la réutiliser. Petite note : la façon dont on  va procéder va être un point fondamental de la manière dont on va coder, proprement, nos projets en orienté objet !

### Passer aux objets la configuration dont ils ont besoin
En fait, si une classe service, comme ShipLoader, a besoin d'informations pour fonctionner, comme un mot de passe de BDD, nous devrions les lui donner immédiatement à la création de l'objet.

La façon la plus courante de faire est d'utiliser le constructeur : en effet, comme ça, je serai obligé de lui fournir les informations pour créer l'objet `$shipLoader` :

```php
class ShipLoader
{
    private $dbDsn;
    private $dbUser;
    private $dbPass;
    public function __construct($dbDsn, $dbUser, $dbPass)
    {
        $this->dbDsn = $dbDsn;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
    }
}
```

Et voilà ! Modifions aussi la méthode `getPDO()` :

```php
private function getPDO()
    {
        if ($this->pdo === null) {
            $this->pdo = new PDO($this->dbDsn, $this->dbUser, $this->dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $this->pdo;
    }
```

Qu'est-ce qu'il se passe ici ? Maintenant, `PDO` n'est plus instancié  avec des strings écrites en dur mais les valeurs de `dbDsn`, `dbUser`, `dbPass` appartenant à la classe `ShipLoader`.

Mais maintenant, quand on créée un `ShipLoader` (comme dans `index.php`), on a besoin de passer des arguments au constructeur de `new ShipLoader(....)` (entre les parenthèses donc).

Plutôt que d'écrire en dur dans l'instantiation de `ShipLoader`, nous allons créer un array de configuration contenant toutes les données utiles. Ajoutez dans `bootstrap.php :

```php
$configuration = [
    'db_dsn'  => 'mysql:host=localhost;dbname=hbbattleships',
    'db_user' => 'root',
    'db_pass' => null,
];
```

Puis, dans `index.php` et `battle.php`, remplacez ça :
```php
$shipLoader = new ShipLoader();
```

Par :

```php
$shipLoader = new ShipLoader(
    $configuration['db_dsn'],
    $configuration['db_user'],
    $configuration['db_pass']
);
```

Et voilà, tout fonctionne comme avant. En plus, on a une configuration centralisée dans `bootstrap.php` !

### La règle d'or
La grosse règle importante est la suivante : ne mettez jamais de configuration à l'intérieur d'un service. En effet, ça nous permet d'utiliser le service avec *n'importe quelle configuration*. Imaginez que vous avez plusieurs bases de données à tester, ou que vous vouliez utiliser le service dans plusieurs projets : votre code est maintenant bien plus flexible.

## Chapitre 10 : Best Practice: Connexion centralisée
Encore un autre problème : notre objet PDO est maintenant configurable directement dans `bootstrap.php`, mais on appelle encore notre PDO directement dans le service `ShipLoader`. C'est un problème si on ajoute un autre service, par exemple pour un modèle `Battle` et un service `BattleLoader`: on devra dupliquer le code. Donc si on a 50 tables, on aura 50 connexion séparées, outch !

Il ne nous faut qu'une seule connexion qui sera la seule utilisée par toutes les classes.

Voici l'objectif : déplacer l'appel à `new PDO()` en dehors du `ShipLoader`, de  sorte à ce qu'il soit créé en un endroit un peu plus central et accessible à tout le monde (enfin, toutes les classes). Comment ? En utilisant la même stratégie que pour la configuration. Si on veut utiliser quelque chose en dehors d'une classe service, dans ce même service, ajoutez un argument dans `__construct()` et passez le dedans.

## Ajouter un argument $pdo au constructeur
C'est parti ! Au lieu de passer 3 éléments de configuration de base de données au constructeur de `ShipLoader`, nous allons carrément passer un objet `PDO` en paramètres : `$pdo`.


Let's do it! Instead of passing in the 3 database options, we need to pass in the whole PDO object. Replace the 3 arguments with just one: $pdo. Give it a type-hint to be great programmers. Next, remove the three configuration properties. And back in __construct(), we already have a $pdo property, so set that with $this->pdo = $pdo.

Retirez les 3 attributs privés `$dbDsn`, `$dbUser`, `$dbPass` de la classe `ShipLoader`, ainsi que de son constructeur, et ajoutez uniquement un attribut `$pdo` à la place. On type `$pdo` de type `PDO`.

```php
class ShipLoader
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
```

Ensuite, on a dit qu'on allait déplacer notre création de `PDO` dans un autre endroit. Du coup, notre `getPDO()` va se simplifier :

```php
private function getPDO()
{
    return $this->pdo;
}
```

C'est maintenant simplement un getter pour l'attribut $pdo de notre classe !

Et du coup, où va se trouver notre appel à PDO ? Alors, réfléchissons un peu. Dans `index.php` et dans `battle.php`, j'ai ce nouveau code du chapitre précédent :

```php
$shipLoader = new ShipLoader(
    $configuration['db_dsn'],
    $configuration['db_user'],
    $configuration['db_pass']
);
```

Sauf que dorénavant, le constructeur de `ShipLoader` ne prend plus 3 paramètres, mais un seul, une instance de PDO.

On va donc instancier `new PDO` juste avant `new ShipLoader` de sorte à pouvoir le passer dans son constructeur. Changez donc ce code en :

```php
// On créée une instance de PDO
$pdo = new PDO(
    $configuration['db_dsn'],
    $configuration['db_user'],
    $configuration['db_pass']
);

// On configure PDO
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// On créée notre ShipLoader, en passant l'instance de PDO
$shipLoader = new ShipLoader($pdo);
```

Et... Voilà ! On a déplacé la configuration ET la connexion à l'extérieur du service. Maintenant, n'importe  quel service peut utiliser la connexion sans n'avoir rien à coder en dur dedans.

### Quelques rappels
Quelques rappels sur ces nouveaux concepts. N'incluez jamais de configuration (ex: config de PDO) ni de création d'objets services (ex: création de l'objet PDO) à l'intérieur d'un service. Cela rendrait le service dépendant de votre configuration/projet actuel, et ne pourrait pas être réutilisable facilement, que ce soit par vous même sur une autre machine (dev/prod), ou par d'autres, ou sur d'autres projets.

Quand on créée un service à l'intérieur d'une classe, on ne peut pas l'utiliser ou le contrôler facilement.

À la place, crééez tous vos objets services à un seul endroit et passez les d'un service à l'autre grâce au constructeur. Ce concept n'est pas toujours facile à tenir ! Vous tomberez souvent sur des projets ne respectant pas à la lettre ces préceptes - et ce n'est pas grave ! Vous apprenez ici les bonnes et meilleures pratiques pour être un développeur orienté objet, et vous essayerez de diriger  vos projets dans cette directioN.

Le point négatif de tout cela, c'est que maintenant, créer des objets service devient un peu plus compliqué (on passe de `new ShipLoader()` à une instanciation de PDO puis une injection de PDO dans le contrôleur...). On verra comment corriger ce problème dans les prochaines étapes avec une autre stratégie encore plus cool !

## Chapitre 11 : Service Container
Bonne nouvelle : on a gagné en flexibilité ! Mauvaise nouvelle : on doit créer des objets service à la main et c'est chiant à faire. Nous devons centraliser tout cela.

### Créer un Service Container
Pour cela, nous allons créer une classe un peu spéciale dont son seul travail est de créer nos objets service. Cette classe est appelée un Service Container, parce qu'elle est un... container. De services. Et c'est tout.

Dans le dossier `lib`, créez un nouveau fichier nommé `Container.php` :

```php
class Container {
    /**
     * @return PDO
     */
    public function getPDO()
    {
        $configuration = array(
            'db_dsn'  => 'mysql:host=localhost;dbname=hbbattleships',
            'db_user' => 'root',
            'db_pass' => null,
        );
        $pdo = new PDO(
            $configuration['db_dsn'],
            $configuration['db_user'],
            $configuration['db_pass']
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}
```

Ouf, maintenant que tout ce code est ici, plus besoin de le réécrire à la main à chaque fois comme on a dans `index.php` et `battle.php`. Justement, modifions un peu `index.php` et `battle.php` :

Tout en haut du fichier, ajoutez ces lignes et supprimez la ligne de `$pdo` déjà existante:

```php
$container = new Container();
$pdo = $container->getPDO();
```

N'oublions pas de rajouter dans la liste de nos imports, dans `bootstrap.php`, notre nouveau Container :

```php
// ...
require_once __DIR__.'/lib/Container.php';
```

Testez ! Tout devrait encore marcher.

### Centraliser la configuration
Bon, c'est très pratique et on a retiré de la duplication de code, mais on vient de faire un petit pas en arrière. On a encore de la configuration dans une classe, notre Container.

Pour fixer ça, on va ajouter un constructeur à notre classe `Container` et un attribut configuration :

```php
    private $configuration;
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }
```

Modifions aussi, du coup, l'instanciation de PDO dans `getPDO` :

```php
public function getPDO()
{
    $pdo = new PDO(
        $this->configuration['db_dsn'],
        $this->configuration['db_user'],
        $this->configuration['db_pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
```

Parfait ! `bootstrap.php` connaît déjà notre configuration dans une variable `$configuration`. On a juste à l'ajouter lorsque l'on instancie notre Container ! Modifiez un peu `index.php` et `battle.php` :

```php
$container = new Container($configuration);
$pdo = $container->getPDO();
```

Testez, tout devrait marcher.

## Chapitre 12 : Container: Forcer des objets uniques
## Chapitre 13 : Les containers à la rescouse