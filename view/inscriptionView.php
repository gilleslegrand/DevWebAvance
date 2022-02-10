<?php $title = 'Inscription'?>

<?php ob_start(); ?>
<h1>Inscription</h1>

<form action="./index.php" method="post">
    <div>
        <label for="prenom">Prenom</label>
        <input type="text" id="prenom" name="prenom" required>
    </div>
    <div>
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" required>
    </div>
    <div>
        <label for="courriel">Courriel</label>
        <input type="email" id="courriel" name="courriel" required>
    </div>
    <div>
        <label for="mdp">Mot de passe</label>
        <input type="password" id="mdp" name="mdp" required> 
    </div>
    
    <input type="hidden" name="action" value="nouvelutilisateur" required>
    <input type="submit">
</form>


<?php $content = ob_get_clean(); ?>

<?php require_once('template.php'); ?>