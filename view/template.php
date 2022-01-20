<?php $baseURL = "/mvc/"?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="<?= $baseURL;?>inc/css/style.css" rel="stylesheet" /> 
    </head>
        
    <body>
        <nav>
            <ul>
                <li><a href="<?= $baseURL;?>index.php">Accueil</a></li>
                <li><a href="<?= $baseURL;?>produits">Les produits</a></li>
            </ul>
        </nav>
        <?= $content ?>
    </body>
</html>