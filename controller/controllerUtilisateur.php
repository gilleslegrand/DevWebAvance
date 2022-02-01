<?php

require('model/UtilisateurManager.php');

function getFormConnexion()
{
    require("view\loginView.php");
}

function authentifier($courriel,$mdp) 
{
    $userManager=new UtilisateurManager;
    if($userManager->verifyAuthentification($courriel,$mdp) != null)
    {
        $user=$userManager->verifyAuthentification($courriel,$mdp);
        require("controller\controllerAccueil.php");
        listProduits();
        $_SESSION["courriel"]=$user->get_courriel();
        $_SESSION["role"]=$user->get_role_utilisateur();
    }
}

function deconnexion() 
{

    session_unset();
    session_start();
    session_destroy();
    echo "session_destroy()";
    

    header("Location: http://localhost/mvc/index.php");
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
            header("Location: http://localhost/mvc/index.php");
      }
      else 
      {
            $user=$userManager->getUtilisateurParCourriel($payload["email"]);
            $_SESSION["courriel"]=$user->get_courriel();
            $_SESSION["role"]=$user->get_role_utilisateur();
            header("Location: http://localhost/mvc/index.php");
      }
      // If request specified a G Suite domain:
      //$domain = $payload['hd'];
    } else {
      echo "Connexion échouée";
    }
}
