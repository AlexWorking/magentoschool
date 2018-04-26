<?php

class Potoky_ImageAutoImport_Model_Observer
{
    public function assignImages(Varien_Event_Observer $observer)
    {
        //$handle = fopen('media/autoimport/Crontest.txt', 'a');
        //fwrite($handle, time() . '\n');
        $importData = Mage::getModel('imageautoimport/imageinfo')
            ->getCollection()
            ->addFieldToFilter('status', array('in' => array('In Queue', 'Retrial')));
        if(null > -5) {
            echo 'True';
        } else {
            echo 'False';
        }
        foreach ($importData as $row) {
            try {
                $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $row['product_sku']);
                if (!$product) {
                    throw new Exception(sprintf(
                            Mage::Helper('imageautoimport')->__("Product with sku %s does not exist"),
                            $row['sku']
                        ), 1000001
                    );
                }
            } catch (Exception $e) {

            }
        }
    }
}