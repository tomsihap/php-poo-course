<?php
session_start();
require __DIR__ . '/functions.php';
$ships = getShips();

$errorMessage = null;
if (isset($_SESSION['error'])) {
    switch ($_SESSION['error']) {
        case 'missing_data':
            $errorMessage = 'N\'oubliez pas de séléctionner des vaisseaux pour  le combat !';
            break;
        case 'bad_ships':
            $errorMessage = 'Vous essayez de combattre avec un vaisseau non enregistré dans les registres galactiques.';
            break;
        case 'bad_quantities':
            $errorMessage = 'Le nombre de vaisseaux demandé n\'est pas un nombre terrien, réessayez.';
            break;
        default:
            $errorMessage = 'Une perturbation dans la Force est apparue. Veuillez recommencer.';
    }

    unset($_SESSION['error']);
}
?>

<?php include('_partials/_header.php'); ?>

<?php if ($errorMessage !== null) : ?>
<div class="alert alert-danger" role="alert">
    <?= $errorMessage ?>
</div>
<?php endif; ?>

<h1><i class="fa fa-rocket" aria-hidden="true"></i> HB Battleships</h1>
<hr>
<p class="lead">Choisissez les vaisseaux à engager pour cette mission.</p>
<p>
    <ul>
        <li><small><strong>Weapon power :</strong> force d'attaque à chaque tour</small></li>
        <li><small><strong>Spatiodrive booster :</strong> pourcentage de chances de détruire automatiquement le vaisseau ennemi par la Force en un seul tour</small></li>
        <li><small><strong>Strength :</strong> Résistance du vaisseau</small></li>
    </ul>
</p>
<table class="table table-dark table-striped">
    <thead>
        <tr>
            <th>Vaisseau<br><small>Name</small></th>
            <th>Force d'attaque<br><small>Weapon power</small></th>
            <th>Booster Spatiodrive<br><small>Spatiodrive booster</small></th>
            <th>Résistance<br><small>Strength</small></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ships as $ship) : ?>
            <tr>
                <td><?= $ship['name'] ?></td>
                <td><?= $ship['weapon_power'] ?></td>
                <td><?= $ship['spatiodrive_booster'] ?></td>
                <td><?= $ship['strength'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<hr>
<div class="card">
    <div class="card-body">
        <form action="battle.php" method="POST">
            <h2 class="text-center">La mission :</h2>
            <input class="center-block form-control text-field" type="text" name="ship1_quantity" placeholder="Nombre de vaisseaux" />
            <select class="center-block form-control dropdown-toggle" name="ship1_name">
                <option value="">Choisir un vaisseau</option>
                <?php foreach ($ships as $key => $ship) : ?>
                    <option value="<?php echo $key; ?>"><?php echo $ship['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <p class="text-center"><strong>VERSUS</strong></p>
            <br>
            <input class="center-block form-control text-field" type="text" name="ship2_quantity" placeholder="Nombre de vaisseaux" />
            <select class="center-block form-control dropdown-toggle" name="ship2_name">
                <option value="">Choisir un vaisseau</option>
                <?php foreach ($ships as $key => $ship) : ?>
                    <option value="<?php echo $key; ?>"><?php echo $ship['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <button class="btn btn-danger float-right" type="submit">Engager le combat</button>
        </form>
    </div>
</div>

<?php include('_partials/_footer.php'); ?>