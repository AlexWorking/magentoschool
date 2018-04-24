<?php

class Potoky_ImageAutoImport_Block_Adminhtml_ImportToQueue extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('imageautoimport/imageinfo')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/flow', array('_current'=>true));
    }
}