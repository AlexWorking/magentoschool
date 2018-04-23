<?php

class Potoky_ImageAutoImport_Model_ImageInfo extends Mage_Core_Model_Abstract
{
    private $_adapter;

    private $_rows = [];

    protected function _construct()
    {
        $this->_init('imageautoimport/imageinfo');
    }

    private function _setRows()
    {
        while ($this->_adapter->valid()) {
            $key = $this->_adapter->key();
            $row = $this->_adapter->current();
            $this->_rows[$key] = $row;
            $this->_adapter->next();
        }
    }

    public function setAdapter($sourceFile)
    {
        $this->_rows = [];
        $this->_adapter = Mage_ImportExport_Model_Import_Adapter::findAdapterFor($sourceFile);
        $this->_setRows();
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
                sprintf(
                    "%s" . Mage::HELPER('imageautoimport')->__("Column name error(s):") . '%s%s',
                    '<pre>',
                    '</br>',
                    $errorMessage
                ),
                 1
            );
        }
        return $this;
    }

    public function validateRows()
    {
        $product = Mage::getModel('catalog/product');
        $errorMessage = '';
        foreach ($this->_rows as $key => $row) {
            $rowErrorMessage = '';
            $hasBeen = sprintf(
                "%s" . Mage::HELPER('imageautoimport')->__("You have errors(s) in row %s:%s"),
                '<p><pre>',
                $key + 1,
                '</br>'
            );
            if (!$product->loadByAttribute('sku', $row['sku'])) {
                $errorMessage .= sprintf(
                    "%s" . Mage::HELPER('imageautoimport')->__("Product with sku \"%s\" doesn't exist.%s"),
                    $hasBeen,
                    $row['sku'],
                    '</br>'
                );
                $hasBeen = '';
            }
            if (!file_exists($row['url'])) {
                $errorMessage .= sprintf(
                    "%s" . Mage::HELPER('imageautoimport')->__("File pointed to by \"%s\" URL does not exist or the URL is not valid.%s"),
                    $hasBeen,
                    $row['url'],
                    '</br>'
                );
            }
            $errorMessage .= ($rowErrorMessage != '') ? $rowErrorMessage. '</br></pre></p>' : '';
        }
        if (!empty($errorMessage)) {
            throw new Exception($errorMessage, 2);
        }
        return $this;
    }
}