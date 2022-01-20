<?php

require('model/CategorieManager.php');

function listcategories()
{
    $categorieManager = new categorieManager();
    $categories = $categorieManager->getcategories();

    require('view/categoriesView.php');
}