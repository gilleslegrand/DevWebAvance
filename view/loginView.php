<?php $title = 'Connexion'?>

<?php ob_start(); ?>
<h1>Se connecter</h1>

<form action="./index.php" method="post">
    <div>
        <label for="courriel">Courriel</label>
        <input type="email" id="courriel" name="courriel">
    </div>
    <div>
        <label for="mdp">Mot de passe</label>
        <input type="password" id="mdp" name="mdp">
    </div>
    <div>
        <label for="remember">Se souvenir de moi</label>
        <input type="checkbox" id="remember" name="remember">
    </div>
    
    <input type="hidden" name="action" value="authentifier">
    <input type="submit">
</form>
    <div id="g_id_onload"
        data-client_id="763838935468-g4bsnsdfu8v80j5porfvggs0uq81seji.apps.googleusercontent.com"
        data-login_uri="http://localhost/mvc/"
        data-auto_prompt="false">
    </div>
    <div class="g_id_signin"
        data-type="standard"
        data-size="large"
        data-theme="outline"
        data-text="sign_in_with"
        data-shape="rectangular"
        data-logo_alignment="left">
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>