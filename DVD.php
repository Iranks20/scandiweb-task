<?php

class DVD extends Product
{
    private $size;

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    protected function getProductType()
    {
        return 'dvd';
    }
}
