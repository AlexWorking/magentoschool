<?php

class Potoky_ImageAutoImport_Model_Observer
{
    public function execute()
    {
        $handle = fopen('media/autoimport/Crontest.txt', 'a');
        fwrite($handle, time() . '\n');
    }
}