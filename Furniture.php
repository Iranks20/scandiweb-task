<?php

class Furniture extends Product
{
    private $height;
    private $width;
    private $length;

    public function getDimensions()
    {
        return $this->height . 'x' . $this->width . 'x' . $this->length;
    }

    public function setDimensions($height, $width, $length)
    {
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    protected function getProductType()
    {
        return 'furniture';
    }
}
