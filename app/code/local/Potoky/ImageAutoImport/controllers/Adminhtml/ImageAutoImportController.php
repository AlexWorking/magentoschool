<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4/19/2018
 * Time: 10:56 AM
 */
class Potoky_ImageAutoImport_Adminhtml_ImageAutoImportController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function validateAction()
    {
            $this->loadLayout();
            $this->renderLayout();
            return;

            try {
                /** @var $import Mage_ImportExport_Model_Import */
                $import = Mage::getModel('importexport/import');
                $validationResult = $import->validateSource($import->setData($data)->uploadSource());

                if (!$import->getProcessedRowsCount()) {
                    $resultBlock->addError($this->__('File does not contain data. Please upload another one'));
                } else {
                    if (!$validationResult) {
                        if ($import->getProcessedRowsCount() == $import->getInvalidRowsCount()) {
                            $resultBlock->addNotice(
                                $this->__('File is totally invalid. Please fix errors and re-upload file')
                            );
                        } elseif ($import->getErrorsCount() >= $import->getErrorsLimit()) {
                            $resultBlock->addNotice(
                                $this->__('Errors limit (%d) reached. Please fix errors and re-upload file', $import->getErrorsLimit())
                            );
                        } else {
                            if ($import->isImportAllowed()) {
                                $resultBlock->addNotice(
                                    $this->__('Please fix errors and re-upload file or simply press "Import" button to skip rows with errors'),
                                    true
                                );
                            } else {
                                $resultBlock->addNotice(
                                    $this->__('File is partially valid, but import is not possible'), false
                                );
                            }
                        }
                        // errors info
                        foreach ($import->getErrors() as $errorCode => $rows) {
                            $error = $errorCode . ' ' . $this->__('in rows:') . ' ' . implode(', ', $rows);
                            $resultBlock->addError($error);
                        }
                    } else {
                        if ($import->isImportAllowed()) {
                            $resultBlock->addSuccess(
                                $this->__('File is valid! To start import process press "Import" button'), true
                            );
                        } else {
                            $resultBlock->addError(
                                $this->__('File is valid, but import is not possible'), false
                            );
                        }
                    }
                    $resultBlock->addNotice($import->getNotices());
                    $resultBlock->addNotice($this->__('Checked rows: %d, checked entities: %d, invalid rows: %d, total errors: %d', $import->getProcessedRowsCount(), $import->getProcessedEntitiesCount(), $import->getInvalidRowsCount(), $import->getErrorsCount()));
                }
            } catch (Exception $e) {
                $resultBlock->addNotice($this->__('Please fix errors and re-upload file'))
                    ->addError($e->getMessage());
            }
            $this->renderLayout();
    }
}