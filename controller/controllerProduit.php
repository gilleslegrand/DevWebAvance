<?php

require('model/ProduitManager.php');

function listProduits()
{
    $produitManager = new ProduitManager();
    $produits = $produitManager->getProduits();

    require('view/produitsView.php');
}

function produit($idProduit)
{
    $produitManager = new ProduitManager();
    $produit = $produitManager->getProduit($idProduit);    

    require('view/produitView.php');
}

function ListProduitsCategorie($id)
{
    $produitManager = new ProduitManager();
    $produits=$produitManager->getProduitsCategorie($id);
    foreach($produits as $row)
    {
        $categorie=$row->get_categorie();
    }
    echo $categorie;
    require('view/produitsView.php');
}