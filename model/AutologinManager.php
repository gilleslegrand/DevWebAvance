<?php

// Ce fichier sert à communiquer avec la BD et construire les objets pour les retourner au controleur.
// Ces fonctions sont généralement appelé par le routeur (index.php) ou d'autres contrôleursl.

require_once("model/Manager.php");
require_once("model\AutoLogin.php");
require_once("model\Util.php");


class AutologinManager extends Manager
{
    public function getAutoLoginById($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM tbl_autologin where id_utilisateur=?');

        $req->execute(array($id));
        $autologin = array();
       
        while($data = $req->fetch())
        {
            array_push($autologin, new Autologin($data));
        }

        $req->closeCursor();
        if(count($autologin))
        {
            return $autologin;
        }
        return null;
    }

    public function restartAutologin($id)
    {
        $util=new Util;
        $token=$util->getToken(16);
        $date=new DateTime();
        $date->modify('+1 month');
        $oneMonthDate= $date->format('Y-m-d');
        $token_hash = password_hash($token, PASSWORD_DEFAULT);

        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE tbl_autologin SET est_valide=1, token_hash=?, date_expiration=? where id_utilisateur=?');

        $req->execute(array($token_hash,$oneMonthDate,$id));

        $req->closeCursor();

        return $token;
    }

    public function insertAutologin($id)
    {
        $util=new Util;
        $token=$util->getToken(16);
        $date=new DateTime();
        $date->modify('+1 month');
        $oneMonthDate= $date->format('Y-m-d');
        $token_hash = password_hash($token, PASSWORD_DEFAULT);

        $db = $this->dbConnect();
        $req = $db->prepare("INSERT INTO tbl_autologin (id_utilisateur,token_hash, est_valide, date_expiration)
        VALUES(?,?,1,?)");
        
        $req->execute(array($id, $token_hash, $oneMonthDate));
        $req->closeCursor();

        return $token;
    }

    public function unValid($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE tbl_autologin SET est_valide=0 where id_utilisateur=?');

        $req->execute(array($id));

        $req->closeCursor();
    }
}