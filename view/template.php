

<?php $baseURL = "/mvc/"?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="<?= $baseURL;?>inc/css/style.css" rel="stylesheet" /> 
        <script src="https://accounts.google.com/gsi/client" async defer></script>
    </head>
        
    <body>
    <?php //Débogage afficher ce qui est reçu en paramètres
        echo "----------------------------<br/>";
        echo "Paramètres reçus:<br/><pre>";
        print_r($_REQUEST);
        echo "----------------------------<br/>";
        print_r($_SESSION);
        echo "</pre>----------------------------<br/>";
        

        if(isset($_SESSION["courriel"]))
        {
            echo "Bienvenue ".  $_SESSION['courriel'];

        }
    ?>
        <nav>
            <ul>
            <?php 
                if(!isset($_SESSION["courriel"]))
                {
                    ?>
                        <li><a href="<?= $baseURL;?>connexion">Se connecter</a></li>
                    <?php 
                }
                else
                {
                    ?>
                        <li><a href="<?= $baseURL;?>deconnexion">Se déconnecter</a></li>
                    <?php
                }
            ?>
                
                <li><a href="<?= $baseURL;?>index.php">Accueil</a></li>
                <li><a href="<?= $baseURL;?>produits">Les produits</a></li>
                <li><a href="<?= $baseURL;?>categories">Les catégories</a></li>
                <li><a href="<?= $baseURL;?>inscription">Inscription</a></li>
            </ul>
        </nav>
        <?= $content ?>
    </body>
</html>