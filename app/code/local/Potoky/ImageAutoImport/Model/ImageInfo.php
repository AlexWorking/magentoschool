<?php

class Potoky_ImageAutoImport_Model_ImageInfo extends Mage_Core_Model_Abstract
{
    private $_adapter;

    private $_rows = [];

    protected function _construct()
    {
        $this->_init('imageautoimport/imageinfo');
    }

    public function setAdapter($sourceFile)
    {
        $this->_adapter = Mage_ImportExport_Model_Import_Adapter::findAdapterFor($sourceFile);
        return $this;
    }

    public function validateColNames()
    {
        $colNames = $this->_adapter->getColNames();
        $errorMessage = '';
        foreach ($colNames as $colName) {
            if (!in_array($colName, ['sku', 'url'])) {
                $errorMessage .= sprintf(
                    "\"%s\"" . Mage::HELPER('imageautoimport')->__(" is not a valid column name.</br>"),
                    $colName
                );
            }
        }
        if (!empty($errorMessage)) {
            throw new Exception(
                sprintf('<pre> Column name error(s):</br>%s', $errorMessage)
                , 1
            );
        }
        return $this;
    }

    public function validateRows()
    {
        $product = Mage::getModel('catalog/product');
        $errorMessage = '';
        while ($this->_adapter->valid()) {
            $rowErrorMessage = '';
            $hasBeen = sprintf(
                "%s" . Mage::HELPER('imageautoimport')->__("You have errors in row %s:</br>"),
                '<pre>',
                $this->_adapter->key() + 1
            );
            $row = $this->_adapter->current();
            if (!$product->loadByAttribute('sku', $row['sku'])) {
                $errorMessage .= sprintf(
                    "%s" . Mage::HELPER('imageautoimport')->__("Product with sku \"%s\" doesn't exist.</br>"),
                    $hasBeen,
                    $row['sku']);
                $hasBeen = '';
            }
            if (!file_exists($row['url'])) {
                $errorMessage .= sprintf(
                    "%s" . Mage::HELPER('imageautoimport')->__("File pointed to by \"%s\" URL does not exist or this URL is not valid.</br>"),
                    $hasBeen,
                    $row['url']);
            }
            $this->_rows[] = $row;
            $errorMessage .= ($rowErrorMessage != '') ? $rowErrorMessage. '</br></pre>' : '';
            $this->_adapter->next();
        }
        if (!empty($errorMessage)) {
            throw new Exception($errorMessage, 2);
        }
        return $this;
    }
}