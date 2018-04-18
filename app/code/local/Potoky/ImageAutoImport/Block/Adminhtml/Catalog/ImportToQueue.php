<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4/17/2018
 * Time: 1:03 PM
 */
class Potoky_ImageAutoImport_Block_Adminhtml_Catalog_ImportToQueue extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'imageautoimport';
        $this->_controller = 'adminhtml_catalog';
        $this->_mode = 'importtoqueue';

        parent::__construct();


        $this->removeButton('back')
            ->removeButton('reset')
            ->_updateButton('save', 'label', $this->__('Check Data'))
            ->_updateButton('save', 'id', 'upload_button')
            ->_updateButton('save', 'onclick', 'editForm.postToFrame();');
    }

    public function getHeaderText()
    {
        return Mage::helper('imageautoimport')->__('Import to Queue');
    }

    public function getFormActionUrl()
    {
        return $this->getUrl('*/*/save', array('id' => '2'));
    }
}