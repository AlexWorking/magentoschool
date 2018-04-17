<?php

require_once(Mage::getModuleDir('controllers','Mage_Adminhtml') . DS . 'Catalog' . DS . 'ProductController.php');
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4/17/2018
 * Time: 11:04 AM
 */
class Potoky_ImageAutoImport_Adminhtml_Catalog_ProductController
    extends Mage_Adminhtml_Catalog_ProductController
{
    public function importImagesAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}