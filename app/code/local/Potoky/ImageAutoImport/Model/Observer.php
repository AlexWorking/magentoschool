<?php

class Potoky_ImageAutoImport_Model_Observer
{
    public function importImages(Varien_Event_Observer $observer)
    {
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
                            Mage::Helper('imageautoimport')->__("Product with sku %s does not exist anymore"),
                            $row['product_sku']
                        ), 1000001
                    );
                }

                switch ($header = get_headers($row['image_url'])[0]) {
                    case 'HTTP/1.1 200 OK':
                        $this->pinImageToProduct($row['image_url'], $product);
                        $row->setData([
                            'loading_at'    => strftime('%Y-%m-%d %H:%M:%S', time()),
                            'status'        => 'Loaded',
                        ]);
                        $row->save();
                        break;
                    case 'HTTP/1.0 404 Not Found':
                        $row->setData([
                            'loading_at'    => strftime('%Y-%m-%d %H:%M:%S', time()),
                            'status'        => 'Retrial',
                            'error_message' => 'HTTP/1.0 404 Not Found'
                        ]);
                        $row->save();
                        break;
                    default:
                        $row->setData([
                            'loading_at'    => strftime('%Y-%m-%d %H:%M:%S', time()),
                            'status'        => 'Error',
                            'error_message' => $header
                        ]);
                        $row->save();
                        break;
                }

                $imageTypes = null;
                if ($product->getSmallImage() === null) {
                    $imageTypes[] = 'smallimage';
                }
                if ($product->getThumbnail() === null) {
                    $imageTypes[] = 'thumbnail';
                }
                if ($product->getImage() === null) {
                    $imageTypes[] = 'image';
                }

                $product->addImageToMediaGallery($row['image_url'], $imageTypes);
                $product->save();
            } catch (Exception $e) {
                $row->setData(['error_message' => $e->getMessage()]);
            }
        }
    }

    private function pinImageToProduct($imageUrl, $product)
    {

    }
}