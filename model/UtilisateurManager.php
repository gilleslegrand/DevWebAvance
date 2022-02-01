<?php

require("model\Manager.php");

require("model\Utilisateur.php");
//La classe UtilisateurManager qui interagit avec la table utilisateur

class UtilisateurManager extends Manager {
    
    public function verifyAuthentification($courriel,$mdp)
    {
        if($this->getUtilisateurParCourriel($courriel)!=null)
        {
            $user=$this->getUtilisateurParCourriel($courriel);
            if(password_verify($mdp, $user->get_mdp()))
            {
                return $user;
            }
        }

        return null;
    }

    public function getUtilisateurParCourriel($courriel)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT * From tbl_utilisateur where courriel=?");
        
        $req->execute(array($courriel));
        $user = array();
       
        while($data = $req->fetch())
        {
            array_push($user, new Utilisateur($data));
        }

        $req->closeCursor();
        if(count($user))
        {
            return $user[0];
        }
        return null;
    }

    public function addGoogleUser($courriel, $prenom, $nom)
    {
        $db = $this->dbConnect();
        $mdp_hash = password_hash('google', PASSWORD_DEFAULT);
        $req = $db->prepare("INSERT INTO tbl_utilisateur (nom,prenom,courriel,mdp,est_actif, role_utilisateur, type_utilisateur,token)
        VALUES(?,?,?,?,1,1,1,'')");
        
        $req->execute(array($nom, $prenom, $courriel,$mdp_hash));
        $req->closeCursor();

        return $this->getUtilisateurParCourriel($courriel);
    }

}