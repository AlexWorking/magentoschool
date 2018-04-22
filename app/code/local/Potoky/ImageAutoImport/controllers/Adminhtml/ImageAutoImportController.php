<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4/19/2018
 * Time: 10:56 AM
 */
class Potoky_ImageAutoImport_Adminhtml_ImageAutoImportController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function validateAction()
    {
        try {
            /** @var $import Mage_ImportExport_Model_Import */
            $import = Mage::getModel('importexport/import');
            $sourceFile = $import->setData('entity', 'import_to_queue')->uploadSource();
            $sourceAdapter = Mage_ImportExport_Model_Import_Adapter::findAdapterFor($sourceFile);
            $adapter = Mage::getModel('importexport/import_entity_product');
            $adapter->setSource($sourceAdapter);
            $colNames = $adapter->getSource()->getColNames();
            while ($sourceAdapter->valid()) {
                $look = $sourceAdapter->current();
                $sourceAdapter->next();
            }

        } catch (Exception $e) {
                $e->getMessage();
        }
        $this->loadLayout();
        $this->renderLayout();
    }
}
