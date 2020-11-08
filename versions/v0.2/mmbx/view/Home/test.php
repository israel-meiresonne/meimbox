<?php
var_dump($datasMap);
/**
 * @var View */
$this->addFbPixel(Pixel::TYPE_CUSTOM, Pixel::EVENT_VIEW_PRODUCT_GRID, $datasMap);
$this->addFbPixel(Pixel::TYPE_CUSTOM, Pixel::EVENT_LP_TIME_UP, $datasMap);
// $this->addFbPixel(Pixel::TYPE_TRACK, Pixel::EVENT_VIEW_CONTENT);
