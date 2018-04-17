<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4/17/2018
 * Time: 1:03 PM
 */
class Potoky_ImageAutoImport_Block_Adminhtml_Catalog_Form extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'form';
        $this->_controller = 'catalog_product';

        $this->_updateButton('save', 'label', Mage::helper('form')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('form')->__('Delete'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
    }

    public function getHeaderText()
    {
        return Mage::helper('form')->__('My Form Container');
    }
}