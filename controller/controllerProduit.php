<?php

require_once('model/ProduitManager.php');

function listProduits()
{
    $produitManager = new ProduitManager();
    $produits = $produitManager->getProduits();

    require_once('view/produitsView.php');
}

function produit($idProduit)
{
    $produitManager = new ProduitManager();
    $produit = $produitManager->getProduit($idProduit);    

    require_once('view/produitView.php');
}

function ListProduitsCategorie($id)
{
    $produitManager = new ProduitManager();
    $produits=$produitManager->getProduitsCategorie($id);
    
    $noElement="";

    if(count($produits))
    {
        $categorie=$produits[0]->get_categorie();
    }
    else
    {
        $noElement = "Aucun élément dans cette catégorie";
    }
   

    require_once('view/produitsView.php');
}