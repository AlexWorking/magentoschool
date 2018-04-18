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
        $this->_blockGroup = 'potoky_imageautoimport';
        $this->_controller = 'adminhtml_catalog';
        $this->_mode = 'importtoqueue';

        parent::__construct();


        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
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