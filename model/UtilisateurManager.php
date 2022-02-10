<?php

require_once("model\Manager.php");

require_once("model\Utilisateur.php");
require_once("model\AutologinManager.php");
require_once("model\Util.php");
//La classe UtilisateurManager qui interagit avec la table utilisateur

class UtilisateurManager extends Manager {
    
    public function verifyAuthentification($courriel,$mdp)
    {
        if($this->getUtilisateurParCourriel($courriel) != null)
        {
            $user=$this->getUtilisateurParCourriel($courriel);
            
            if(password_verify($mdp, $user->get_mdp()) && $user->get_est_actif())
            {
                return $user;
            }
        }

        return null;
    }

    public function verifyCookie($id,$token)
    {
        $autologinManager=new AutologinManager;
        if($autologinManager->getAutoLoginById($id) != null)
        {
            $autologin=$autologinManager->getAutoLoginById($id);
            foreach($autologin as $row)
            {
                    if(password_verify($token, $row->get_token_hash()))
                {
                    return $row;
                }
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

    public function getUtilisateurParToken($token)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT * From tbl_utilisateur where token=?");
        
        $req->execute(array($token));
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


    public function getUtilisateurParId($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT * From tbl_utilisateur where id_utilisateur=?");
        
        $req->execute(array($id));
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
        $req = $db->prepare("INSERT INTO tbl_utilisateur (nom,prenom,courriel,mdp,est_actif, role_utilisateur, type_utilisateur,token)
        VALUES(?,?,?,'',1,0,1,'')");
        
        $req->execute(array($nom, $prenom, $courriel));
        $req->closeCursor();

        return $this->getUtilisateurParCourriel($courriel);
    }

    public function insertNewUser($prenom, $nom, $courriel, $mdp)
    {
        $util=new Util;
        $token=$util->getToken(16);
        $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

        $db = $this->dbConnect();
        $req = $db->prepare("INSERT INTO tbl_utilisateur (nom,prenom,courriel,mdp,est_actif, role_utilisateur, type_utilisateur,token)
        VALUES(?,?,?,?,0,0,0,?)");
        
        $req->execute(array($nom, $prenom, $courriel, $mdp_hash, $token));
        $req->closeCursor();

        return $this->getUtilisateurParCourriel($courriel);
    }

    public function setActiveWithToken($token)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("UPDATE tbl_utilisateur SET est_actif=1 WHERE token=?");
        
        $req->execute(array($token));
        $req->closeCursor();

        return $this->getUtilisateurParToken($token);
    }
}