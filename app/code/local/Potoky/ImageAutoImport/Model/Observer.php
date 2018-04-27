<?php

class Potoky_ImageAutoImport_Model_Observer
{
    public function assignImages(Varien_Event_Observer $observer)
    {
        //$handle = fopen('media/autoimport/Crontest.txt', 'a');
        //fwrite($handle, time() . '\n');
        $importData = Mage::getModel('imageautoimport/imageinfo')
            ->getCollection()
            ->addFieldToFilter('status', array('in' => array('In Queue', 'Retrial')))
            ->setOrder('loading_at', 'ASC');
        foreach ($importData as $row) {
            try {
                if ($row['status'] == 'Retrial' && $row['loading_at'] + 86400 < time()) {
                    continue;
                }
                $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $row['product_sku']);
                if (!$product) {
                    throw new Exception(sprintf(
                            Mage::Helper('imageautoimport')->__("Product with sku %s does not exist"),
                            $row['sku']
                        ), 1000001
                    );
                }

                $imageTypes = null;
                if ($product->getSmallImage() === false) {
                    $imageTypes[] = 'smallimage';
                }
                if ($product->getThumbnail() === false) {
                    $imageTypes[] = 'thumbnail';
                }
                if ($product->getImage() === false) {
                    $imageTypes[] = 'image';
                }

                $product->addImageToMediaGallery($row['image_url'], $imageTypes);
                $product->save();
            } catch (Exception $e) {
                $row->setData(['error_message' => $e->getMessage()]);
            }
        }
    }
}