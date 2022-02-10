<?php
require_once('model/ProduitManager.php');
require_once('model/UtilisateurManager.php');
require_once('model\AutologinManager.php');

function getFormConnexion()
{
    require_once("view\loginView.php");
}

function getFormInscription()
{
    require_once('view\inscriptionView.php');
}

function getFormInscriptionError()
{
    require_once('view\inscriptionErrorView.php');
}

function getGoodValidationMessage()
{
    //Nouvel objet de type ProduitManager 
    $produitManager = new ProduitManager();
    
    //Crée une variable $produits qui sera utilisée dans la vue.
    //Cette variable contiendra un array d'objet de type Produit. 
    $produits = $produitManager->getProduits();
    require_once('view\validationView.php');
}

function getErrorValidationMessage()
{
    //Nouvel objet de type ProduitManager 
    $produitManager = new ProduitManager();
    
    //Crée une variable $produits qui sera utilisée dans la vue.
    //Cette variable contiendra un array d'objet de type Produit. 
    $produits = $produitManager->getProduits();
    require_once('view\validationViewError.php');
}

function authentifier($courriel,$mdp) 
{
    $userManager=new UtilisateurManager;
    if($userManager->verifyAuthentification($courriel,$mdp) != null)
    {
        $user=$userManager->verifyAuthentification($courriel,$mdp);
        echo $user->get_courriel();
        $_SESSION["courriel"]=$user->get_courriel();
        $_SESSION["role"]=$user->get_role_utilisateur();
        require_once("controller\controllerAccueil.php");
        listProduits();
    }
}

function deconnexion() 
{
    if(isset($_COOKIE['id']))
    {
        $autologin=new AutologinManager;
        $autologin->unValid($_COOKIE['id']);

        setcookie("token","", time()-(86400*30));
        setcookie("id", "", time()-(86400*30));
    }
    
    session_unset();
    session_destroy();


    require_once('controller/controllerAccueil.php');
            //Appel la fonction listProduits contenu dans le controleur de Acceuil
            listProduits();
}

function authentificationGoogle($credential, $token)
{
    session_start();
    require_once 'vendor/autoload.php';
    $CLIENTID="763838935468-g4bsnsdfu8v80j5porfvggs0uq81seji.apps.googleusercontent.com";
    // Get $id_token via HTTPS POST.
    
    $client = new Google_Client(['client_id' => $CLIENTID]);  // Specify the CLIENT_ID of the app that accesses the backend
    $payload = $client->verifyIdToken($credential);
    if ($payload) {
      $userid = $payload['sub'];
      print_r($payload);
      $userManager=new UtilisateurManager;
      if($userManager->getUtilisateurParCourriel($payload["email"])==null)
      {
            $user=$userManager->addGoogleUser($payload["email"], $payload["given_name"], $payload["family_name"]);

            $_SESSION["courriel"]=$user->get_courriel();
            $_SESSION["role"]=$user->get_role_utilisateur();
            require_once('controller/controllerAccueil.php');
            //Appel la fonction listProduits contenu dans le controleur de Acceuil
            listProduits();
      }
      else 
      {
            $user=$userManager->getUtilisateurParCourriel($payload["email"]);
            $_SESSION["courriel"]=$user->get_courriel();
            $_SESSION["role"]=$user->get_role_utilisateur();
            require_once('controller/controllerAccueil.php');
            //Appel la fonction listProduits contenu dans le controleur de Acceuil
            listProduits();
      }
      // If request specified a G Suite domain:
      //$domain = $payload['hd'];
    } else {
      echo "Connexion échouée";
    }
}

function getIdByEmail($courriel) 
{
    $userManager=new UtilisateurManager;
    $user=$userManager->getUtilisateurParCourriel($courriel);
    return $user->get_id_utilisateur();
}

function setUserSessionByCookies($id,$token)
{   
    $userManager=new UtilisateurManager();
    if($userManager->verifyCookie($id,$token)!=null)
    {
        $user=$userManager->getUtilisateurParId($_COOKIE["id"]);
        $_SESSION["courriel"]=$user->get_courriel();
        $_SESSION["role"]=$user->get_role_utilisateur();
    }
}

function createNewUser($prenom,$nom,$courriel,$mdp)
{
    $userManager=new UtilisateurManager();
    $user=$userManager->insertNewUser($prenom,$nom,$courriel,$mdp);

    sendEmail($courriel, $user->get_token());
}

function isEmailExist($courriel)
{
    $userManager=new UtilisateurManager;
    $user=$userManager->getUtilisateurParCourriel($courriel);

    if($user==null)
    {
        return false;
    }
    return true;
}

function sendEmail($courriel,$token)
{
    $from="your@email-address.com";
    $to=$courriel;
    $subject="Validation";
    $message="http://localhost/mvc/index.php?action=validationCourriel&token=$token";
    $headers= "From: $from\r\n";

    if(mail($to,$subject,$message,$headers))
    {
        echo "test";
    }
    else 
    {
        echo "pas test ";
        print_r(error_get_last());
    }
}

function checkTokenInscription($token)
{
    $userManager=new UtilisateurManager;

    if($userManager->setActiveWithToken($token)!=null)
    {
        return true;
    }
    return false;
}