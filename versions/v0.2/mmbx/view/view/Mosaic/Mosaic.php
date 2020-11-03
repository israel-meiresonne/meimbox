<?php
require_once 'framework/View.php';

class Mosaic extends View
{

    /**
     * Holds the mosaic to display
     * @var string
     */
    private $mosaic;

    /**
     * Holds couples of width/file
     * + NOTE: with is in percentage
     * + Map[index][Map::width]   =>  {int}       the width of the mosaic
     * + Map[index][Map::file]    =>  {string}    the path of the picture file
     * @var Map
     */
    private $mosaicMap;

    /**
     * Holds a two dim map filled of stone following their width and height
     * @var Map
     */
    private $stoneMap;

    /**
     * Holds sample of all stones created in placeStone()
     * @var Map
     * + $stones[objHash][Map::file]      {string}    
     * + $stones[objHash][Map::width]     {int}       holds the width of the stone
     * + $stones[objHash][Map::height]    {int}       holds the height of the stone
     * + $stones[objHash][Map::rowStart]  {int}       holds the row where the stone begin in stoneMap
     * + $stones[objHash][Map::colStart]  {int}       holds the column where the stone begin in stoneMap
     * + $stones[objHash][Map::rowEnd]    {int}       holds the row where the stone end in stoneMap
     * + $stones[objHash][Map::colEnd]    {int}       holds the column where the stone end in stoneMap
     */
    private $stones;

    /**
     * Holds Mosaic's css classes
     * @var Map
     * + [width{int}] => cssClass {string}
     */
    private $classes;

    /**
     * Holds Mosaic's css tag
     * @var string
     */
    private $style;

    /**
     * Holds additional css to apply on mosaic
     * @var string
     */
    private $addtionalCss;

    /**
     * Holds Mosaic's javascript code
     * @var string
     */
    private $js;

    private $files;
    private $min;
    private $max;
    private $step;

    /**
     * Holds the last rondom width generated
     * @var int
     */
    private $rand;


    /**
     * Holds mosaic's container class
     * @var strong
     */
    private $containerClass = "mosaic_container";

    /**
     * Holds mosaic's sizer class
     * @var strong
     */
    private $sizerClass = "mosaic_sizer";

    /**
     * Holds mosaic's stone class
     * @var strong
     */
    private $stoneClass = "mosaic_stone";

    /**
     * Holds prefix for css class to place on stone tag
     * @var string
     */
    // private const CLASS_STONE_WIDTH = 'grid-item--width';
    private const CLASS_STONE_WIDTH = 'stone_width';

    /**
     * Holds the max width of the screan to fit Mosaic on it
     * @var int
     */
    private const MAX_WIDTH = 100;

    /**
     * Constructor
     * @param string[]  $files                      the file to display in the Mosaic
     * @param Map       $configMap                  the file to display in the Mosaic
     * $configMap[Map::containerClass] => {string}  holds mosaic's container class
     * $configMap[Map::sizerClass] => {string}      holds mosaic's sizer class
     * $configMap[Map::stoneClass] => {string}      holds mosaic's stone class
     * $configMap[Map::css] => {string}             
     * @param int       $min                        the min width in percentage of a stone of the Mosaic
     * @param int       $max                        the max width in percentage of a stone of the Mosaic
     * @param int       $step                       width of Mosaic's stone have to be multiple of step
     */
    // public function __construct($files, $min = 5, $max = 25, $step = 5)
    public function __construct($files, Map $configMap, $min = 5, $max = 25)
    {
        $this->files = $files;
        $this->min = $min;
        $this->max = $max;
        $this->step = $min;
        $this->containerClass = $configMap->get(Map::containerClass);
        $this->sizerClass = $configMap->get(Map::sizerClass);
        $this->stoneClass = $configMap->get(Map::stoneClass);
        $this->addtionalCss = $configMap->get(Map::css);
        $this->setMosaicMap();
    }

    /**
     * To set the mosaicMap
     * @param string[]  $files  the file to display in the Mosaic
     * @param int       $min    the min width in percentage of a stone of the Mosaic
     * @param int       $max    the max width in percentage of a stone of the Mosaic
     * @param int       $step   width of Mosaic's stone have to be multiple of step
     */
    // private function setMosaicMap($files, $min = 5, $max = 25, $step = 5)
    private function setMosaicMap()
    {
        $this->getStoneMap(); // just to set stoneMap
        $stones = $this->getStones();

        $map = [];
        $hashes = $stones->getKeys();
        foreach ($hashes as $hash) {
            $width = $stones->get($hash, Map::width);
            $file = $stones->get($hash, Map::file);
            $stone = [Map::width => $width, Map::file => $file];
            array_push($map, $stone);
        }
        $this->mosaicMap = new Map($map);
    }

    /**
     * To set stoneMap
     */
    private function setStoneMap()
    {
        $stoneMap = new Map();

        $files = $this->getFiles();
        $min = $this->getMin();
        $max = $this->getMax();
        $step = $this->getStep();

        $row = 0;
        $col = 0;
        $currentWidth = 0;
        $i = 0;
        $nbFile = count($files);
        while (($i < $nbFile) && ($currentWidth < self::MAX_WIDTH)) {
            $file = $files[$i];
            $stillingW = (self::MAX_WIDTH - $currentWidth);
            $max = ($stillingW < $max) ? $stillingW : $max;
            $width = $this->generateWidth($min, $max, $step);
            $this->placeStone($stoneMap, $row,  $col, $file, $width);
            $currentWidth += $width;
            $col += ($width);
            $files[$i] = null;
            unset($files[$i]);
            $i++;
        }

        $row = 1;
        $col = 0;
        foreach ($files as $file) {
            $position = $this->getNextPosition($stoneMap, $row, $col);
            $row = $position->get(Map::row);
            $col = $position->get(Map::col);
            $stone = $stoneMap->get($row, $col);
            if (!empty($stone)) {
                throw new Exception("This position($row, $col) must be empty");
            }
            $widthAvailable = $this->getMaxWidth($stoneMap, $row, $col);
            if ($widthAvailable <= 0) {
                throw new Exception("The width available must be positive");
            }
            if ($widthAvailable < $min) {
                throw new Exception("The width available ($widthAvailable) must be greater than min width ($min)");
            }
            $maxWidth = ($widthAvailable < $max) ? $widthAvailable : $max;
            $width = $this->generateWidth($min, $maxWidth, $step);
            $this->placeStone($stoneMap, $row,  $col, $file, $width);
        }
        $this->stoneMap = $stoneMap;
    }

    /**
     * Build a map that holds the position of file in mosaic
     * @param string[]  $files  the file to display in the Mosaic
     * @param int       $min    the min width in percentage of a stone of the Mosaic
     * @param int       $max    the max width in percentage of a stone of the Mosaic
     * @param int       $step   width of Mosaic's stone have to be multiple of step
     * @return Map 
     */
    private function getStoneMap()
    {
        (!isset($this->stoneMap)) ? $this->setStoneMap() : null;
        return $this->stoneMap;
    }

    /**
     * To get the max wdth available to receive a stone
     * @return int the max wdth available to receive a stone
     */
    private function getMaxWidth(Map $stoneMap, $row, $colStart)
    {
        $colEnd = $colStart;
        $stone = $stoneMap->get($row, $colEnd);
        $foundMax = ((!empty($stone)) || ($colEnd >= self::MAX_WIDTH));
        while (!$foundMax) {
            $colEnd++;
            // $nextCol = $colEnd + 1;
            $stone = $stoneMap->get($row, $colEnd);
            if ((!empty($stone)) || ($colEnd >= self::MAX_WIDTH)) {
                $foundMax = true;
            }
        }
        $maxWidth = ($colEnd - $colStart);
        return $maxWidth;
    }

    /**
     * To get the next empty position in the stoneMap
     * @return Map
     * + $position[Map::row]    {int}   row of the next empty position
     * + $position[Map::col]    {int}   column of the next empty position
     */
    private function getNextPosition(Map $stoneMap, $row, $col)
    {
        $found = false;
        $position = new Map();
        while (!$found) {
            $stone = $stoneMap->get($row, $col);
            if (!empty($stone)) {
                $col = ($stone->get(Map::colEnd));
                if ($col >= self::MAX_WIDTH) {
                    $col = 0;
                    $row++;
                }
            } else {
                $position->put($col, Map::col);
                $position->put($row, Map::row);
                $found = true;
            }
        }
        return $position;
    }

    /**
     * To place a stone of the mosaic in a stoneMap
     * + $stone[Map::width]     {int}       holds the width of the stone
     * + $stone[Map::height]    {int}       holds the height of the stone
     */
    private function placeStone(Map $stoneMap, $rowStart, $colStart, $file, $width)
    {
        $stone = new Map();
        $infos = getimagesize($file);
        $fileW = $infos[0];
        $fileH = $infos[1];
        $ratio = $fileW / $fileH;
        $height = (int) ($width / $ratio);
        $stone->put($file, Map::file);
        $stone->put($width, Map::width);
        $stone->put($height, Map::height);

        $rowEnd = ($rowStart + ($height));
        $colEnd = ($colStart + ($width));
        $stone->put($rowStart, Map::rowStart);
        $stone->put($colStart, Map::colStart);
        $stone->put($rowEnd, Map::rowEnd);
        $stone->put($colEnd, Map::colEnd);

        for ($row = $rowStart; $row < $rowEnd; $row++) {
            for ($col = $colStart; $col < $colEnd; $col++) {
                $stoneMap->put($stone, $row, $col);
            }
        }
        $this->addStone($stone);
    }

    /**
     * To generate a random width for a stone of the Mosaic
     * @return int a random width for a stone of the Mosaic
     */
    private function generateWidth($min, $max, $step)
    {
        $width = (int) (rand($min, $max) / $step);
        $width *= $step;
        if ($min != $max) {
            while ($this->rand == $width) {
                $width = (int) (rand($min, $max) / $step);
                $width *= $step;
            }
        }
        $this->rand = $width;
        return $width;
    }

    /**
     * To set Mosaic in displayable format
     * + NOTE: also set attribut $classes
     * @param string the file to display in the Mosaic
     */
    private function setMosaic()
    {
        $this->mosaic = "";
        $mosaicMap = $this->getMosaicMap();
        $keys = $mosaicMap->getKeys();
        $this->classes = new Map();
        foreach ($keys as $key) :
            $width = $mosaicMap->get($key, Map::width);
            $file = $mosaicMap->get($key, Map::file);
            $widthClass = self::CLASS_STONE_WIDTH . $width;
            (!in_array($width, $this->classes->getKeys())) ? $this->classes->put($widthClass, $width) : null;
            $stoneDatas = [
                "stoneClass" => $this->getStoneClass(),
                "widthClass" => $widthClass,
                "picture" => $file
            ];
            $this->mosaic .= $this->generateFile('view/view/Mosaic/files/stone.php', $stoneDatas);
        endforeach;
    }

    /**
     * To set css style tag of the mosaic
     */
    private function setStyle()
    {
        $classes = $this->getClasses();
        $classes->sortKeyAsc();
        $widths = $classes->getKeys();
        $stoneClass = $this->getStoneClass();
        $sizerClass = $this->getSizerClass();
        $i = 0;
        $this->style = "<style>\n";
        foreach ($widths as $width) :
            $class = $classes->get($width);
            if ($i == 0) {
                $this->style .=
                    // ".grid-sizer, .grid-item { width: $width%; }\n";
                    ".$sizerClass, .$stoneClass { width: $width%; }\n";
                $i++;
            } else {
                $this->style .= ".$class { width: $width%; }\n";
            }
        endforeach;
        $this->style .= $this->getAddtionalCss();
        $this->style .= "\n</style>";
    }

    /**
     * To set $js
     */
    private function setJs()
    {
        $datasJs = [
            "containerClass" => $this->getContainerClass(),
            "stoneClass" => $this->getStoneClass(),
            "sizerClass" => $this->getSizerClass()
        ];
        $this->js = $this->generateFile('view/view/Mosaic/files/mosaicJs.php', $datasJs);
    }

    /**
     * To get the mosaic in a displayable format
     * @return string the mosaic in a displayable format
     */
    private function getMosaic()
    {
        (!isset($this->mosaic)) ? $this->setMosaic() : null;
        return $this->mosaic;
    }

    /**
     * To get mosaicMap
     * @return Map the mosaicMap
     */
    private function getMosaicMap()
    {
        if (!isset($this->mosaicMap)) {
            throw new Exception("The attribut 'mosaicMap' is not setted");
        }
        return $this->mosaicMap;
    }

    /**
     * To get $stones
     * @return Map $stones
     */
    private function getStones()
    {
        (!isset($this->stones)) ? ($this->stones = new Map()) : null;
        return $this->stones;
    }

    /**
     * To add a stone in stones
     * @param Map $stone a stone of the mosaic
     */
    private function addStone(Map $stone)
    {
        $stones = $this->getStones();
        $keys = $stones->getKeys();
        $hash = spl_object_hash($stone);
        (!in_array($hash, $keys)) ? $stones->put($stone->getMap(), $hash) : null;
    }

    /**
     * To get mosaic's css classes
     * @return Map mosaic's css classes
     */
    private function getClasses()
    {
        if (!isset($this->classes)) {
            throw new Exception("The attribut 'classes' is not setted");
        }
        return $this->classes;
    }

    /**
     * To get Mosaic's css style tag
     * @return string Mosaic's css style tag
     */
    private function getStyle()
    {
        (!isset($this->style)) ? $this->setStyle() : null;
        return $this->style;
    }

    /**
     * To get additional css code
     * @return string additional css code
     */
    private function getAddtionalCss()
    {
        return $this->addtionalCss;
    }

    /**
     * To get Mosaic's javaScript code
     * @return string 
     */
    private function getJs()
    {
        (!isset($this->js)) ? $this->setJs() : null;
        return $this->js;
    }

    /**
     * To get Files
     * @return string[] Files
     */
    private function getFiles()
    {
        return $this->files;
    }

    /**
     * To get Min
     * @return int Min
     */
    private function getMin()
    {
        return $this->min;
    }

    /**
     * To get Max
     * @return int Max
     */
    private function getMax()
    {
        return $this->max;
    }

    /**
     * To get Step
     * @return int Step
     */
    private function getStep()
    {
        return $this->step;
    }

    /**
     * To get mosaic's containerClass class
     * @return string mosaic's containerClass class
     */
    private function getContainerClass()
    {
        return $this->containerClass;
    }

    /**
     * To get mosaic's stoneClass class
     * @return string mosaic's stoneClass class
     */
    private function getStoneClass()
    {
        return $this->stoneClass;
    }

    /**
     * To get mosaic's sizerClass class
     * @return string mosaic's sizerClass class
     */
    private function getSizerClass()
    {
        return $this->sizerClass;
    }


    public function getDisplayableStoneMap($files, $min, $max, $step)
    {
        $nullHash = 0;
        // $nullColor = "ffffff";
        $nullColor = "000000";
        $stoneMap = $this->getStoneMap($files, $min, $max, $step);
        $rows = $stoneMap->getKeys();
        $cols = array_keys($stoneMap->get($rows[0]));
        $hashColorMap = new Map();

        $stones = $this->getStones();
        var_dump(count($stones->getMap()));

        $table = "<table style='width: 100%; height: 100vh;'>";
        $table .= "<th>-</th>";
        foreach ($cols as $col) {
            $col = ($col < 10) ? "0" . $col : $col;
            $table .= "<th>$col</th>";
        }

        foreach ($rows as $row) {
            $table .= "<tr>";
            $table .= "<td>$row</td>";
            foreach ($cols as $col) {
                $stone = $stoneMap->get($row, $col);
                $hash = (!empty($stone)) ? spl_object_hash($stone) : $nullHash;
                if (!in_array($hash, $hashColorMap->getKeys())) {
                    $color = (!empty($stone)) ? $this->random_color() : $nullColor;
                    $hashColorMap->put($color, $hash);
                } else {
                    $color = $hashColorMap->get($hash);
                }
                if ((!empty($stone))) {
                    $file  = $stone->get(Map::file);
                    $table .= "<td style='background-color: #$color;'><img style='width: 100%;' src='/versions/v0.2/mmbx/$file'></td>";
                } else {
                    $table .= "<td style='background-color: #$color;'></td>";
                }
            }
            $table .= '</tr>';
        }
        $table .= "</table>";
        return $table;
    }

    private function random_color_part()
    {
        return str_pad(dechex(mt_rand(10, 200)), 2, '0', STR_PAD_LEFT);
    }

    private function random_color()
    {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }

    public function __toString()
    {

        // $mosaic = '<div class="grid">
        //             <div class="grid-sizer"></div>';
        // $mosaic .= $this->getMosaic();
        // $mosaic .= $this->getStyle();
        // $mosaic .= $this->getJs();
        // $mosaic .= '</div>';

        $mosaicDatas = [
            "mosaic" => $this->getMosaic(),
            "style" => $this->getStyle(),
            "js" => $this->getJs(),
            "containerClass" => $this->getContainerClass(),
            "sizerClass" => $this->getSizerClass()
        ];
        $mosaic = $this->generateFile('view/view/Mosaic/files/mosaic.php', $mosaicDatas);

        return $mosaic;
        // $mosaic = '<div class="grid">
        //             <div class="grid-sizer"></div>';
        // $mosaic .= $this->getMosaic();
        // $mosaic .= $this->getStyle();
        // $mosaic .= $this->getJs();
        // $mosaic .= '</div>';
        // return $mosaic;
    }
}
