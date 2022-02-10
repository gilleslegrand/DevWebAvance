<?php

require_once('model/CategorieManager.php');

function listcategories()
{
    $categorieManager = new categorieManager();
    $categories = $categorieManager->getcategories();

    require_once('view/categoriesView.php');
}