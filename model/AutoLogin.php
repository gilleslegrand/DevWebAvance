<?php

//La classe categorie représente les champs présents dans la table categorie.

class AutoLogin {
    private $_id_autologin;
    private $_id_utilisateur; 
    private $_token_hash;
    private $_est_Valide;
    private $_date_expiration;

    public function __construct($params = array()){
  
        foreach($params as $k => $v){

            $methodName = "set_" . $k;
            if(method_exists($this, $methodName)) {
                $this->$methodName($v);
            }   
        }
    }
    
    /**
     * Get the value of _id_autologin
     */ 
    public function get_id_autologin()
    {
        return $this->_id_autologin;
    }

    /**
     * Set the value of _id_autologin
     *
     * @return  self
     */ 
    public function set_id_autologin($_id_autologin)
    {
        $this->_id_autologin = $_id_autologin;

        return $this;
    }

    /**
     * Get the value of _id_utilisateur
     */ 
    public function get_id_utilisateur()
    {
        return $this->_id_utilisateur;
    }

    /**
     * Set the value of _id_utilisateur
     *
     * @return  self
     */ 
    public function set_id_utilisateur($_id_utilisateur)
    {
        $this->_id_utilisateur = $_id_utilisateur;

        return $this;
    }

    /**
     * Get the value of _token_hash
     */ 
    public function get_token_hash()
    {
        return $this->_token_hash;
    }

    /**
     * Set the value of _token_hash
     *
     * @return  self
     */ 
    public function set_token_hash($_token_hash)
    {
        $this->_token_hash = $_token_hash;

        return $this;
    }

    /**
     * Get the value of _est_Valide
     */ 
    public function get_est_Valide()
    {
        return $this->_est_Valide;
    }

    /**
     * Set the value of _est_Valide
     *
     * @return  self
     */ 
    public function set_est_Valide($_est_Valide)
    {
        $this->_est_Valide = $_est_Valide;

        return $this;
    }

    /**
     * Get the value of _date_expiration
     */ 
    public function get_date_expiration()
    {
        return $this->_date_expiration;
    }

    /**
     * Set the value of _date_expiration
     *
     * @return  self
     */ 
    public function set_date_expiration($_date_expiration)
    {
        $this->_date_expiration = $_date_expiration;

        return $this;
    }
}