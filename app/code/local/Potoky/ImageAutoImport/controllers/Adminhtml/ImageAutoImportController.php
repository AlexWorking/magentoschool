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
        Mage::getSingleton('adminhtml/session')->unsetData('resultMessage');
    }

    public function validateAction()
    {
        try {
            $import = Mage::getModel('importexport/import');
            $sourceFile = $import->setData('entity', 'import_to_queue')->uploadSource();
            $imageInfo = Mage::getModel('imageautoimport/imageinfo');
            $imageInfo->setAdapter($sourceFile)
                ->validateColNames()
                ->validateRows();

            Mage::getSingleton('adminhtml/session')->setData(
                'resultMessage',
                Mage::Helper('imageautoimport')->__('Images were successfully added to queue!'));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->setData('resultMessage', $e->getMessage());
        }
        $this->_redirect('*/*/index');
    }
}
