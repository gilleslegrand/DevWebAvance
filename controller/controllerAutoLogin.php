<?php
    require_once('model/UtilisateurManager.php');
    require_once('model\AutologinManager.php');

    function addAutologin($courriel) 
    {
        $userManager=new UtilisateurManager;
        $autoLogin= new AutologinManager;

        $id=getIdByEmail($courriel);
        $token="";

        $token=$autoLogin->insertAutologin($id);

        setcookie("token", $token, time()+(86400*30));
        setcookie("id", $id, time()+(86400*30));
    }