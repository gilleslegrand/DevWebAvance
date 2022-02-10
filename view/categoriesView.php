<?php $title = 'Catégories'?>

<?php ob_start(); ?>
<h1>Les catégories</h1>

<?php foreach($categories as $categorie) { ?>
    <div>
        <h3>Catégorie: <?= htmlspecialchars($categorie->get_categorie()) ?> </h3>        
        <p>Description: <?= htmlspecialchars($categorie->get_description()) ?> </p>
        <a href=<?php echo "produitscategorie/" . $categorie->get_id_categorie() ?>>Voir les produits</a>        
        <hr>
    </div>
<?php } ?>

<?php $content = ob_get_clean(); ?>

<?php require_once('template.php'); ?>