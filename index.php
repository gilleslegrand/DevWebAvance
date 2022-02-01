<?php


//Est-ce qu'un paramètre action est présent
if (isset($_REQUEST['action'])) {
    echo $_REQUEST['action'];
    //Est-ce que l'action demandée est la liste des produits
    if ($_REQUEST['action'] == 'produits') {
        //Ajoute le controleur de Produit
        require('controller/controllerProduit.php');
        //Appel la fonction listProduits contenu dans le controleur de Produit
        listProduits();
    }
    // Sinon est-ce que l'action demandée est la description d'un produit
    elseif ($_REQUEST['action'] == 'produit') {
        
        // Est-ce qu'il y a un id en paramètre
        if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {
            //Ajoute le controleur de Produit
            require('controller/controllerProduit.php');
            //Appel la fonction produit contenu dans le controleur de Produit
            produit($_REQUEST['id']);
        }
        else {
            //Si on n'a pas reçu de paramètre id, mais que la page produit a été appelé
            echo 'Erreur : aucun identifiant de produit envoyé';
        }
    } 
    elseif ($_REQUEST['action'] == 'categories') {
        require('controller/controllerCategorie.php');
        listcategories();
    }
    elseif($_REQUEST['action'] == 'produitscategorie')
    {
        if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {
            //Ajoute le controleur de Produit
            require('controller/controllerProduit.php');
            //Appel la fonction produit contenu dans le controleur de Produit
            listProduitsCategorie($_REQUEST['id']);
        }
        else 
        {
            //Si on n'a pas reçu de paramètre id, mais que la page produit a été appelé
            echo 'Erreur : aucun identifiant de produit envoyé';
        }
    }
    elseif($_REQUEST['action'] == 'connexion')
    {
            //Ajoute le controleur d'utilisateur
            require('controller/controllerUtilisateur.php');

            getFormConnexion();
    }
    elseif($_REQUEST['action'] == 'authentifier' && isset($_REQUEST["mdp"]) && isset($_REQUEST["courriel"]))
    {
        require('controller/controllerUtilisateur.php');
        authentifier($_REQUEST["courriel"],$_REQUEST["mdp"]);
    }
    elseif($_REQUEST['action'] == 'deconnexion')
    {
        require('controller/controllerUtilisateur.php');
        deconnexion();
    }
    
}
elseif(isset($_REQUEST['credential'])&& isset($_REQUEST['g_csrf_token']))
{
    require('controller/controllerUtilisateur.php');
    authentificationGoogle($_REQUEST['credential'], $_REQUEST['g_csrf_token']);
} 
// Si pas de paramètre charge l'accueil
else {
    //Ajoute le controleur de Produit
    require('controller/controllerAccueil.php');
    //Appel la fonction listProduits contenu dans le controleur de Produit
    listProduits();
}