<?php
require __DIR__ . '/bootstrap.php';
$shipLoader = new ShipLoader();
$ships = $shipLoader->getShips();

// On vérifie que les données du formulaire existent :
$ship1Id     = isset($_POST['ship1_id']) ? $_POST['ship1_id'] : null;
$ship1Quantity  = isset($_POST['ship1_quantity']) ? $_POST['ship1_quantity'] : 1;
$ship2Id      = isset($_POST['ship2_id']) ? $_POST['ship2_id'] : null;
$ship2Quantity  = isset($_POST['ship2_quantity']) ? $_POST['ship2_quantity'] : 1;

// On redirige avec une erreur en session.
if (!$ship1Id || !$ship2Id) {
    $_SESSION['error'] = 'missing_data';
    header('Location: index.php');
    die;
}

$ship1 = $shipLoader->findOneById($ship1Id);
$ship2 = $shipLoader->findOneById($ship2Id);

if (!isset($ships[$ship1Id]) || !isset($ships[$ship2Id])) {
    $_SESSION['error'] = 'bad_ships';
    header('Location: index.php');
    die;
}

if ($ship1Quantity <= 0 || $ship2Quantity <= 0) {
    $_SESSION['error'] = 'bad_quantities';
    header('Location: index.php');
    die;
}

$battleManager = new BattleManager();
$outcome = $battleManager->battle($ship1, $ship1Quantity, $ship2, $ship2Quantity);
?>

<?php include('_partials/_header.php'); ?>
<h1><i class="fa fa-rocket" aria-hidden="true"></i> HB Battleships</h1>
<hr>

<div class="card mb-2">
    <div class="card-body text-center">
        <h2>Le combat :</h2>
        <p>
            <!-- On affiche la quantité de vaisseaux (au pluriel si la quantité est supérieure à 1) -->
            <?php echo $ship1Quantity; ?> <?php echo $ship1->getName(); ?><?php echo $ship1Quantity > 1 ? 's' : ''; ?>
            <strong>VERSUS</strong>
            <?php echo $ship2Quantity; ?> <?php echo $ship2->getName(); ?><?php echo $ship2Quantity > 1 ? 's' : ''; ?>
        </p>
    </div>
</div>
<div class="card">
    <div class="card-body text-center">

        <h3>Résistance restante finale:</h3>
        <dl class="dl-horizontal">
            <dt><?php echo $ship1->getName(); ?></dt>
            <dd>Résistance : <?php echo $ship1->getStrength(); ?></dd>
            <dt><?php echo $ship2->getName(); ?></dt>
            <dd>Résistance : <?php echo $ship2->getStrength(); ?></dd>
        </dl>

        <h3 class="text-center audiowide">
            Gagnant :
            <?php if ($outcome->isThereAWinner()) : ?>
                <?php echo $outcome->getWinningShip()->getName(); ?>
            <?php else : ?>
                Personne
            <?php endif; ?>
        </h3>
        <p class="text-center">
            <?php if (!$outcome->isThereAWinner()) : ?>
                Les deux opposants se sont détruits lors de leur bataille épique.
            <?php else : ?>
                Le groupe de <?php echo $outcome->getWinningShip()->getName(); ?>
                <?php if ($outcome->whereBoostersUsed()) : ?>
                    a utilisé son booster Spatiodrive pour détruire l'adversaire !
                <?php else : ?>
                    a été plus puissant et a détruit le groupe de <?php echo $outcome->getLosingShip()->getName() ?>s
                <?php endif; ?>
            <?php endif; ?>
        </p>
    </div>
</div>

<a href="index.php">
    <p class="text-center"><i class="fa fa-undo"></i> Recommencer un combat</p>
</a>

<?php include('_partials/_footer.php'); ?>