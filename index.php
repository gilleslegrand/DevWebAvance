<?php //Débogage afficher ce qui est reçu en paramètres
if(session_status() === PHP_SESSION_NONE)
{
    session_start();

    if(isset($_COOKIE["id"]))
    {
        require_once "controller\controllerUtilisateur.php";
        setUserSessionByCookies($_COOKIE["id"],$_COOKIE["token"]);
        
    }
}

//Est-ce qu'un paramètre action est présent
if (isset($_REQUEST['action'])) {
    //Est-ce que l'action demandée est la liste des produits
    if ($_REQUEST['action'] == 'produits') {
        //Ajoute le controleur de Produit
        require_once('controller/controllerProduit.php');
        //Appel la fonction listProduits contenu dans le controleur de Produit
        listProduits();
    }
    // Sinon est-ce que l'action demandée est la description d'un produit
    elseif ($_REQUEST['action'] == 'produit') {
        
        // Est-ce qu'il y a un id en paramètre
        if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {
            //Ajoute le controleur de Produit
            require_once('controller/controllerProduit.php');
            //Appel la fonction produit contenu dans le controleur de Produit
            produit($_REQUEST['id']);
        }
        else {
            //Si on n'a pas reçu de paramètre id, mais que la page produit a été appelé
            echo 'Erreur : aucun identifiant de produit envoyé';
        }
    } 
    elseif ($_REQUEST['action'] == 'categories') {
        require_once('controller/controllerCategorie.php');
        listcategories();
    }
    elseif($_REQUEST['action'] == 'produitscategorie')
    {
        if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {
            //Ajoute le controleur de Produit
            require_once('controller/controllerProduit.php');
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
            require_once('controller/controllerUtilisateur.php');

            getFormConnexion();
    }
    elseif($_REQUEST['action'] == 'authentifier' && isset($_REQUEST["mdp"]) && isset($_REQUEST["courriel"]))
    {
        require_once('controller/controllerUtilisateur.php');
        authentifier($_REQUEST["courriel"],$_REQUEST["mdp"]);
        if(isset($_REQUEST["remember"])&& isset($_SESSION["courriel"]))
        {
            require_once("controller\controllerAutoLogin.php");
            addAutologin($_SESSION["courriel"]); 
        }
        require_once('controller/controllerAccueil.php');
        //Appel la fonction listProduits contenu dans le controleur de Acceuil
        listProduits();
    }
    elseif($_REQUEST['action'] == 'nouvelutilisateur')
    {
        require_once('controller/controllerUtilisateur.php');
        if(!isEmailExist($_REQUEST["courriel"]))
        {
            createNewUser($_REQUEST["prenom"],$_REQUEST["nom"],$_REQUEST["courriel"],$_REQUEST["mdp"]);

            require_once('controller/controllerAccueil.php');
            //Appel la fonction listProduits contenu dans le controleur de Acceuil
            listProduits();
        }
        else
        {
            getFormInscriptionError();
        }
        
    }
    elseif($_REQUEST['action'] == 'deconnexion')
    {
        require_once('controller/controllerUtilisateur.php');
        deconnexion();
    }
    elseif($_REQUEST['action'] == 'inscription')
    {
        require_once "controller\controllerUtilisateur.php";
        getFormInscription();
        
    }
    elseif($_REQUEST['action'] == 'validationCourriel')
    {
        require_once('controller/controllerUtilisateur.php');

        if(checkTokenInscription($_REQUEST['token']))
        {
            getGoodValidationMessage();
        }
        else
        {
            getErrorValidationMessage();
        }
    }
}
elseif(isset($_REQUEST['credential'])&& isset($_REQUEST['g_csrf_token']))
{
    require_once('controller/controllerUtilisateur.php');
    authentificationGoogle($_REQUEST['credential'], $_REQUEST['g_csrf_token']);
} 
// Si pas de paramètre charge l'accueil
else {
    //Ajoute le controleur de Produit
    require_once('controller/controllerAccueil.php');
    //Appel la fonction listProduits contenu dans le controleur de Produit
    listProduits();
}