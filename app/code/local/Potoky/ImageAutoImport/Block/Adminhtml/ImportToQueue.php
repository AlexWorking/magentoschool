<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4/17/2018
 * Time: 1:03 PM
 */
class Potoky_ImageAutoImport_Block_Adminhtml_ImportToQueue extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'imageautoimport';
        $this->_controller = 'adminhtml';
        $this->_mode = 'importtoqueue';

        parent::__construct();
    //comment
        $this->removeButton('back')
            ->removeButton('reset')
            ->_updateButton('save', 'label', $this->__('Check Data'))
            ->_updateButton('save', 'id', 'upload_button')
            ->_updateButton('save', 'onclick', 'postToQueue();');
    }

    public function getHeaderText()
    {
        return Mage::helper('imageautoimport')->__('Import to Queue');
    }
}