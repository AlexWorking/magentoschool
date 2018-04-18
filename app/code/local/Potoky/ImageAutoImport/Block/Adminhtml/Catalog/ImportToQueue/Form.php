<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4/18/2018
 * Time: 12:10 PM
 */
class Potoky_ImageAutoImport_Block_Adminhtml_Catalog_ImportToQueue_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
                'id' => 'importimages_form',
                'action' => $this->getData('action'),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            )
        );

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}