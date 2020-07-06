<?php

/**
 * This class is used to build all website's page and content any attribute.
 * It help to keep the View clean and easy to read.
 */
class PageContent
{
    const GRID_USED_INSIDE = "grid.php";
    const WHITE_RGB = "#ffffff";

    private $MAX_PRODUCT_CUBE_DISPLAYABLE = "MAX_PRODUCT_CUBE_DISPLAYABLE";
    private $COLOR_TEXT_08 = "COLOR_TEXT_08";
    private $COLOR_TEXT_05 = "COLOR_TEXT_05";

    function __construct($dbMap)
    {
        $this->MAX_PRODUCT_CUBE_DISPLAYABLE = $dbMap["constantMap"][$this->MAX_PRODUCT_CUBE_DISPLAYABLE]["stringValue"];
        $this->COLOR_TEXT_08 = $dbMap["constantMap"][$this->COLOR_TEXT_08]["stringValue"];
        $this->COLOR_TEXT_05 = $dbMap["constantMap"][$this->COLOR_TEXT_05]["stringValue"];
    }

    /*—————————————————————————————— GRID PAGE DOWN —————————————————————————*/
    /**
     * To get the content of the grid page following the URL params
     * @param Search $search the search that content all the criterion of the search, 
     * its Products result and a map where is ordered each product by criterion
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @param Model $model model interface
     * @return string grid page following the search criteriion
     */
    public function getGridPage($search, $translator, $model)
    {
        $language = $model->getLanguage();
        $country = $model->getCountry();
        $currency = $model->getCurrency();
        $dbMap = $model->getDbMap();

        $fileName = self::GRID_USED_INSIDE;

        /* —————————————————————————————————————————————————— STICKERS DOWN ————————————————————————————————————————————————————————————————— */
        $stickers = self::buildFilterStickers($search->getStickers($language, $translator), $translator);
        /* —————————————————————————————————————————————————— STICKERS UP ——————————————————————————————————————————————————————————————————— */

        /* —————————————————————————————————————————————————— FILTER DROPDOWN DOWN —————————————————————————————————————————————————————————— */
        // ORDER
        $orderIsChecked[0] = GeneralCode::clean($_GET["order"]) == Search::NEWEST ? 'checked="true"' : "";
        $orderIsChecked[1] = GeneralCode::clean($_GET["order"]) == Search::OLDER ? 'checked="true"' : "";
        $orderIsChecked[2] = GeneralCode::clean($_GET["order"]) == Search::HIGHT_TO_LOW ? 'checked="true"' : "";
        $orderIsChecked[3] = GeneralCode::clean($_GET["order"]) == Search::LOW_TO_HIGHT ? 'checked="true"' : "";

        // TYPE
        $typeSearchKeys = ["product_types", "functions"];
        $typeStation = 7;
        $typeDropdown = self::buildFilterDropdown($search, $typeSearchKeys, $typeStation, $translator, $dbMap);

        // CATEGORY
        $catSearchKeys = ["categories"];
        $catStation = 8;
        $catDropdown = self::buildFilterDropdown($search, $catSearchKeys, $catStation, $translator, $dbMap);

        // SIZE
        $sizeSearchKeys = ["sizes"];
        $sizeStation = 9;
        $sizeDropdown = self::buildFilterDropdown($search, $sizeSearchKeys, $sizeStation, $translator, $dbMap);

        // COLOR
        $colorSearchKeys = ["colors"];
        $colorStation = 10;
        $colorDropdown = self::buildFilterDropdown($search, $colorSearchKeys, $colorStation, $translator, $dbMap);
        /* —————————————————————————————————————————————————— FILTER DROPDOWN UP ———————————————————————————————————————————————————————————— */
        /* —————————————————————————————————————————————————— FILTER PRICE DOWN ————————————————————————————————————————————————————————————— */

        $minPriceValue = 'value="' . $search->getMinPrice() . '"';
        $maxPriceValue =  'value="' . $search->getMaxPrice() . '"';

        /* —————————————————————————————————————————————————— FILTER PRICE UP ——————————————————————————————————————————————————————————————— */

        /* —————————————————————————————————————————————————— PRODUCT BUILD DOWN ————————————————————————————————————————————————————————————— */
        $products = $search->getProducts();
        $productsStr = self::getGridProducts($products, $country, $currency, $translator);

        /* —————————————————————————————————————————————————— PRODUCT BUILD UP ——————————————————————————————————————————————————————————————— */
        /* —————————————————————————————————————————————————— PAGE BUILD DOWN ———————————————————————————————————————————————————————————————— */
        $page =
            '<div class="grid-inner">
                <div class="filter-block-mobile">
                    <div id="filter_button" class="filter-button-block">
                        <div class="img-text-block">
                            <div class="img-text-wrap">
                                <div class="img-text-img">
                                    <img src="/outside/brain/permanent/icons8-setting-80.png">
                                </div>
                                <span class="img-text-span">' . $translator->translateStation($fileName, 1) . '</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="directory-wrap">
                    <p>women \ collection \ category</p>
                    <!-- <p>women \ collection1 \ collection2 \ category</p> -->
                </div>

                <div class="search-sticker-block">
                    <div class="sticker-empty-div filter-block"></div>
                    <div class="search-sticker-div">
                        <div class="sticker-set">';

        $page .= $stickers;

        $page .= '     </div>
                    </div>
                </div>
                <div class="grid-item-container">
                    <div id="filter_block" class="filter-block">
                        <p>' . $translator->translateStation($fileName, 1) . '</p>
                        <from id="grid_filter">
                            <div class="filter-dropdown-set">
                                <div class="filter-dropdown-inner">
                                    <div class="dropdown-container">
                                        <div class="dropdown-wrap">
                                            <div class="dropdown-inner">
                                                <div class="dropdown-head dropdown-arrow-close">
                                                    <span class="dropdown-title">' . $translator->translateStation($fileName, 2) . '</span>
                                                </div>
                                                <div class="dropdown-checkbox-list">
                                                    <div class="dropdown-checkbox-block">
                                                        <label class="checkbox-label">' . $translator->translateStation($fileName, 3) . '
                                                            <input type="radio" name="order" value="' . Search::NEWEST . '" ' . $orderIsChecked[0] . '>
                                                            <span class="checkbox-checkmark"></span>
                                                        </label>
                                                    </div>

                                                    <div class="dropdown-checkbox-block">
                                                        <label class="checkbox-label">' . $translator->translateStation($fileName, 4) . '
                                                            <input type="radio" name="order" value="' . Search::OLDER . '" ' . $orderIsChecked[1] . '>
                                                            <span class="checkbox-checkmark"></span>
                                                        </label>
                                                    </div>

                                                    <div class="dropdown-checkbox-block">
                                                        <label class="checkbox-label">' . $translator->translateStation($fileName, 6) . '
                                                            <input type="radio" name="order" value="' . Search::LOW_TO_HIGHT . '" ' . $orderIsChecked[3] . '>
                                                            <span class="checkbox-checkmark"></span>
                                                        </label>
                                                    </div>

                                                    <div class="dropdown-checkbox-block">
                                                        <label class="checkbox-label">' . $translator->translateStation($fileName, 5) . '
                                                            <input type="radio" name="order" value="' . Search::HIGHT_TO_LOW . '" ' . $orderIsChecked[2] . '>
                                                            <span class="checkbox-checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';

        $page .= '                  <div class="dropdown-container">';
        $page .= $typeDropdown;
        $page .= '                  </div>';

        $page .= '                  <div class="dropdown-container">';
        $page .= $catDropdown;
        $page .= '                  </div>';

        $page .= '                  <div class="dropdown-container">';
        $page .= $sizeDropdown;
        $page .= '                  </div>';

        $page .= '                  <div class="dropdown-container">';
        $page .= $colorDropdown;
        $page .= '                  </div>';

        $page .=
            '                   
                                    <div class="dropdown-container">
                                        <div class="dropdown-wrap">
                                            <div class="dropdown-inner">
                                                <div class="dropdown-head dropdown-arrow-close">
                                                    <span class="dropdown-title">' . $translator->translateStation($fileName, 11) . '</span>
                                                </div>
                                                <div class="dropdown-checkbox-list">
                                                    <div id="min_price_input" class="input-container">
                                                        <div class="input-wrap">
                                                            <label class="input-label" for="filter_minPrice">' . $translator->translateStation($fileName, 12) . '</label>
                                                            <input id="filter_minPrice" class="input-error input-tag" type="number" name="minprice" ' . $minPriceValue . ' placeholder="' . $translator->translateStation($fileName, 12) . '">
                                                        </div>
                                                    </div>
                                                    <div id="max_price_input" class="input-container">
                                                        <div class="input-wrap">
                                                            <label class="input-label" for="filter_maxPrice">' . $translator->translateStation($fileName, 13) . '</label>
                                                            <input id="filter_maxPrice" class="input-error input-tag" type="number" name="maxprice" ' . $maxPriceValue . ' placeholder="' . $translator->translateStation($fileName, 13) . '">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="apply-button-container">
                                    <button id="filter_button" class="green-button remove-button-default-att">' . $translator->translateStation($fileName, 14) . '</button>
                                </div>
                            </div>
                        </from>
                        <div class="filter-hide-container">
                            <span id="filter_hide_button" class="filter-hide-span">' . $translator->translateStation($fileName, 15) . '</span>
                        </div>
                    </div>
                    <div class="item-space">
                        <ul class="remove-ul-default-att">';

        $page .= $productsStr;
        $page .= '      </ul>';

        $page .= '          <div id="prodGrid_loading" class="loading-img-wrap">
                                <img src="/outside/brain/permanent/loading.gif">
                            </div>';
        $page .=
            '       </div>
                </div>
            </div>';
        /* —————————————————————————————————————————————————— PAGE BUILD UP —————————————————————————————————————————————————————————————————— */

        return $page;
    }

    /**
     * Build sticker HTML element with a list of sticker name as defined in
     *  /outside/css/elements.css#STICKERS
     * @param string[] $stickers map that return the input value for each sticker inside.
     * $stickToValues => [
     *          sticker => value
     *      ]
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @return string HTML sticker elements
     */
    public function buildFilterStickers($stickers, $translator)
    {
        $elements = "";
        foreach ($stickers as $sticker => $value) {
            $valueAtt = 'value="' . $value . '"';
            $stickerFunc = 'onclick="removeSticker(' . "'" . $value . "'" . ')"';
            $elements .=
                '<div class="sticker-container">
                    <div class="sticker-wrap">
                        <div ' . $valueAtt . ' class="sticker-content-div">' . $translator->translateString($sticker) . '</div>
                        <button ' . $stickerFunc . ' class="sticker-button remove-button-default-att">
                            <span class="sticker-x-left"></span>
                            <span class="sticker-x-right"></span>
                        </button>
                    </div>
                </div>';
        }
        return $elements;
    }


    /**
     * Extract from $search's searchMap the searche criterion witch will be used
     *  as dropdown label
     * @param Search $search the search that content all the criterion of the search, 
     * its Products result and a map where is ordered each product by criterion
     * @param string[] $searcMapKeys list of searchMap key
     * @return string[] list of label for a dropdown
     */
    private function getCheckedLabels($search, $searcMapKeys)
    {
        $labels = [];
        $searchMap = $search->getSearchMap();
        foreach ($searcMapKeys as $key) {
            $criterions = array_keys($searchMap[$key]);
            $labels = GeneralCode::fillArrayWithArray($labels, $criterions);
        }
        return $labels;
    }

    /**
     * Principale manager of the build of a dropdown by extracting value in 
     * différente variable and calling buildDropdown() to finalize the 
     * building of the dropdown
     * @param Search $search the search that content all the criterion of the search, 
     * its Products result and a map where is ordered each product by criterion
     * @param string[] $searcMapKeys list of searchMap key
     * @param int $station the id of the station where to get the translation
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @param string[string[...]] $dbMap The database tables in mapped format specified in file 
     * oop/model/special/dbMap.txt
     * @return string complete HTML dropdown elements for filter ready to be displayed
     */
    private function buildFilterDropdown($search, $searchMapKeys, $station, $translator, $dbMap)
    {
        $checkedLabels = self::getCheckedLabels($search, $searchMapKeys);
        $dropdownName = $translator->translateStation(self::GRID_USED_INSIDE, $station);
        /**
         * $labelInputNames => [
         *          label => searchMapKey
         *      ]
         */
        $labelInputNames = [];
        foreach ($searchMapKeys as $searchMapKey) {
            foreach ($dbMap[$searchMapKey] as $label) {
                $labelInputNames[$label] = $searchMapKey;
            }
        }
        ksort($labelInputNames);
        sort($checkedLabels);
        return self::buildDropdown($dropdownName, $checkedLabels, $labelInputNames, $translator);
    }

    /**
     * Build a HTML dropdown with each label given in param by using the 
     * label as input's name and value
     * @param string $dpdName name of the dropdown element
     * @param string[] $checkedLabels list of checked input label
     * @param string[] $labels list of input label that return a input value
     * $labelInputNames => [
     *          label => input_value
     *      ]
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @return string[string[...]] $dbMap The database tables in mapped format specified in file 
     * oop/model/special/dbMap.txt
     */
    private function buildDropdown($dpdName, $checkedLabels, $labels, $translator)
    {
        $elements =
            '<div class="dropdown-wrap">
                <div class="dropdown-inner">
                    <div class="dropdown-head dropdown-arrow-close">
                        <span class="dropdown-title">' . $dpdName . '</span>
                    </div>
                    <div class="dropdown-checkbox-list">';
        $inputId = 0;
        foreach ($labels as $label => $searchMapKey) { // box item
            $checkedAtt = in_array($label, $checkedLabels) ? 'checked="true"' : "";
            $inputName = $searchMapKey . "_" . $inputId;
            $elements .=
                '       <div class="dropdown-checkbox-block">
                            <label class="checkbox-label">' . $translator->translateString($label) . '
                                <input type="checkbox" name="' . $inputName . '" value="' . $label . '" ' . $checkedAtt . '>
                                <span class="checkbox-checkmark"></span>
                            </label>
                        </div>';
            $inputId++;
        }
        $elements .=
            '       </div>
                </div>
            </div>';
        return $elements;
    }

    /**
     * Build the final list of products ready to be displayed as grid
     * @param boxProduct|basketProduct $product list of product to display
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @param Country $country The current Country of the Visitor
     * @param Currency $currency The current Currency of the Visitor
     * @return string a HTML product element displayable
     */
    public function getGridProducts($products, $country, $currency, $translator)
    {
        $productsStr = "";
        foreach ($products as $product) {
            $productsStr .= '<li class="remove-li-default-att article-li">';
            $productsStr .= self::buildProduct($product, $country, $currency, $translator);
            $productsStr .= '</li>';
        }
        return $productsStr;
    }

    /**
     * to get an empty product grid when there's no product matching the crriterion 
     * inside the Search
     * @return string an empty product grid
     */
    public function emptyGrid()
    {
        return "<h1>There is no product to matching your search</h1>";
    }

    /**
     * Build only one HTML product displayable
     * @param boxProduct|basketProduct $product 
     * @param Country $country The current Country of the Visitor
     * @param Currency $currency The current Currency of the Visitor
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @return string a HTML product displayable
     */
    private function buildProduct($product, $country, $currency, $translator)
    {
        $prodID = $product->getProdID();
        $pictures = $product->getPictures();
        $pictureStr = "";
        $i = 0;
        foreach ($pictures as $picture) {
            switch ($i) {
                case 0:
                    $pictureStr .=
                        '<div class="product-img-wrap product-img-first">
                            <img src="/outside/brain/prod/' . $picture . '">
                        </div>';
                    $i++;
                    break;
                case 1;
                    $pictureStr .=
                        '<div class="product-img-wrap product-img-second">
                            <img src="/outside/brain/prod/' . $picture . '">
                        </div>';
                    $i++;
                    break;
            }
        }

        $prodName = $translator->translateString($product->getProdName());

        $colorRGB = self::checkColorRGB($product->getColorRGB());

        $colorName = $translator->translateString($product->getColorName());

        $priceStr = self::buildProductPrice($product, $country, $currency);

        $cubeBorder = ($colorRGB == self::WHITE_RGB) ? "cube-border" : "";
        $currentColorCubeStr =
            '<li class="remove-li-default-att">
                <div class="cube-container">
                    <a href="/inside/item/?prodID=' . $prodID . '">
                        <div class="cube-wrap cube-selected">
                            <div class="cube-item-color ' . $cubeBorder . '" style="background: ' . $colorRGB . ';"></div>
                        </div>
                    </a>
                </div>
            </li>';
        $sameNameProducts = $product->getSameNameProd();
        $otherColorCube = "";
        $i = 0;
        foreach ($sameNameProducts as $sameNameProduct) { // $i = 1 + 5 + 1
            $sameColorRGB = $sameNameProduct->getColorRGB();
            $sameCubeBorder = ($sameNameProduct->getColorRGB() == self::WHITE_RGB) ? "cube-border" : "";
            if ($i <= $this->MAX_PRODUCT_CUBE_DISPLAYABLE) {
                $otherColorCube .=
                    '<li class="remove-li-default-att">
                        <div class="cube-container">
                            <div class="cube-wrap">
                                <a href="/inside/item/?prodID=' . $sameNameProduct->getProdID() . '">
                                    <div class="cube-item-color ' . $sameCubeBorder . '" style="background: ' . $sameColorRGB . ';"></div>
                                </a>
                            </div>
                        </div>
                    </li>';
            } else {
                $otherColorCube .=
                    '<li class="remove-li-default-att">
                        <div class="cube-container">
                            <div class="cube-wrap">
                                <a href="/inside/item/?prodID=' . $sameNameProduct->getProdID() . '">
                                    <div class="cube-item-color cube-more_color">
                                        <img src="/outside/brain/permanent/icons8-plus-math-96.png">
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>';
                break;
            }
            $i++;
        }

        /* —————————————————————————————————————————————————— PREPARE BUILDING UP ——————————————————————————————————————————————————————————— */
        /* —————————————————————————————————————————————————— BUILDING ELEMENT DOWN ————————————————————————————————————————————————————————— */

        $element =
            '<article class="product-article-wrap">
                <div class="product-img-set">
                    <a href="/inside/item/?prodID=' . $prodID . '">';
        $element .= $pictureStr;
        $element .=
            '       </a>
                </div>
                <div class="product-detail-block">
                    <div class="detail-text-div">
                        <h4>';

        $element .= '<span>' . $prodName . ' | <span style="color:' . $colorRGB . ';">' . $colorName . '</span></span>';

        $element .=
            '           </h4>
                    </div>
                    <div class="detail-price-div">';

        $element .= $priceStr;
        $element .=
            '
                    </div>
                    <div class="detail-color-div">
                        <ul class="remove-ul-default-att">';
        $element .= $currentColorCubeStr;
        $element .= $otherColorCube;
        $element .=
            '
                        </ul>
                    </div>
                </div>
            </article>';

        return $element;
    }

    /**
     * Builds a displayable price for boxproduct and basketproduct by calling 
     * "buildBoxProductPrice()" and "buildBasketProductPrice()"
     * @param boxProduct|basketProduct $product 
     * @param Country $country The current Country of the Visitor
     * @param Currency $currency The current Currency of the Visitor
     * @return string a displayable price for boxproduct and basketproduct
     */
    private function buildProductPrice($product, $country, $currency)
    {
        $priceStr = $product->isBasketProduct() ? self::buildBasketProductPrice($product->getPrice($country, $currency))
            : self::buildBoxProductPrice($product->getBoxesPrices($country, $currency));
        return $priceStr;
    }

    /**
     * Build a displayable box product price
     * @param string[...string[Price[]]]
     *  return  => [
     *      price*100 => [
     *          "boxColor" => string,
     *          "sizeMax" => int,
     *          "boxColorRGB" => string,
     *          "priceRGB" => string,
     *          "textualRGB" => string,
     *          "price" => Price([price÷sizeMax], Country);
     *     ]
     * @return string a displayable box product price
     */
    private function buildBoxProductPrice($boxesPrices)
    {
        // Helper::printLabelValue('$boxesPrices', $boxesPrices);
        $nbPrice = count($boxesPrices);
        $i = 0;
        $priceStr =
            '
            <div class="piano-wrap">
                <div class="piano-displayable-set">
                    <ul class="piano-ul-displayable remove-ul-default-att">';

        foreach ($boxesPrices as $index => $datas) {
            // $priceRGB = $datas["boxColorRGB"] != self::WHITE_RGB ? $datas["boxColorRGB"] : $this->COLOR_TEXT_08;
            $priceRGB = $datas["priceRGB"];
            $price = $datas["price"]->getFormated();
            $displayNone = ($i != ($nbPrice - 1)) ? 'style="display:none;"' : "";
            $priceStr .=
                '       
                        <li class="piano-li-displayable remove-li-default-att" ' . $displayNone . '>
                            <p style="color:' . $priceRGB . ';">' . $price . '</p>
                        </li>';
            $i++;
        }

        $priceStr .=
            '               
                    </ul>
                </div>
                <div class="piano-button-set">
                    <ul class="piano-ul-button remove-ul-default-att">';

        $i = 0;
        foreach ($boxesPrices as $index => $datas) {
            $selectedClass = ($i != ($nbPrice - 1)) ? "" : "piano-selected-button";
            $pianoBtnId = GeneralCode::generateCode(30);
            $animatePiano = "animatePiano(" . "'$pianoBtnId'" . ")";
            $priceStr .=
                '
                        <li id="' . $pianoBtnId . '" onclick="' . $animatePiano . '" class="piano-li-button remove-li-default-att ' . $selectedClass . '">
                            <div class="piano-button remove-button-default-att" style="background:' . $datas["boxColorRGB"] . '; ">
                                <span class="piano-button-span" style="color:' . $datas["textualRGB"] . ';">' .  $datas["boxColor"] . '</span>
                            </div>
                        </li>';
            $i++;
        }
        $priceStr .=
            '                       
                    </ul>
                </div>
            </div>';
        return $priceStr;
    }

    /**
     * Build a displayable basket product price
     * @param Price $price a basket product Price
     * @return string a displayable basket product price
     */
    private function buildBasketProductPrice($price)
    {
        $priceStr = '<p>' . $price->getFormated() . '</p>';
        return $priceStr;
    }

    /**
     * Builds displayables cube with a list of product
     * @param int $max maximum number of cubes to display
     * @param boxProduct|basketProduct $products list of product
     * @param int $prodID the index of the selected cube
     * @return string displayables cube
     */
    private function buildProductCube($prodID, $max, $products)
    {
        $products = $products;
        $colorCube = "";
        $i = 0;
        foreach ($products as $product) { // $i = 1 + 5 + 1
            $colorRGB = $product->getColorRGB();
            $cubeBorder = ($product->getColorRGB() == self::WHITE_RGB) ? "cube-border" : "";
            $selectedCube = ($prodID == $product->getProdID()) ? ' cube-selected' : "";
            if ($i <= $max) {
                $colorCube .=
                    '<li class="remove-li-default-att">
                        <div class="cube-container">
                            <div class="cube-wrap' . $selectedCube . '">
                                <a href="/inside/item/?prodID=' . $product->getProdID() . '">
                                    <div class="cube-item-color ' . $cubeBorder . '" style="background:' . $colorRGB . ';"></div>
                                </a>
                            </div>
                        </div>
                    </li>';
            } else {
                $colorCube .=
                    '<li class="remove-li-default-att">
                        <div class="cube-container">
                            <div class="cube-wrap">
                                <a href="/inside/item/?prodID=' . $product->getProdID() . '">
                                    <div class="cube-item-color cube-more_color">
                                        <img src="/outside/brain/permanent/icons8-plus-math-96.png">
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>';
                break;
            }
            $i++;
        }

        return $colorCube;
    }

    /**
     * Check if the color is visible and return it else return a default 
     * visible color
     * @param string $colorRGB RGB color into format \^#[a-z0-9]{6}$\
     * @return string a visible RGB color
     */
    private function checkColorRGB($colorRGB)
    {
        return ($colorRGB != self::WHITE_RGB) ? $colorRGB : $this->COLOR_TEXT_05;
    }

    /*—————————————————————————————— GRID PAGE UP ———————————————————————————*/
    /*—————————————————————————————— ITEM PAGE DOWN —————————————————————————*/
    /**
     * To get the content of the item page following the URL params
     * @param Search $search the search that content all the criterion of the search, 
     * its Products result and a map where is ordered each product by criterion
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @param Model $model model interface
     * @return string grid page following the search criteriion
     */
    public function getItemPage($search, $translator, $model)
    {
        $country = $model->getCountry();
        $currency = $model->getCurrency();
        $isoLang = $model->getLanguage()->getIsoLang();
        $dbMap = $model->getDbMap();

        $product = $search->getProducts()[0];
        $prodID = $product->getProdID();
        $prodPictures = $product->getPictures();
        $picElements = [];
        foreach ($prodPictures as $index => $picture) {
            $element =
                '
                <article class="slider-article">
                    <img src="/outside/brain/prod/' . $picture . '">
                </article>';

            $picElements[$index] = $element;
        }
        $pictureSliderClass = "showed_product_slider";
        $pictureSliderStr = self::buildSlider($picElements, $pictureSliderClass);

        $prodName = $translator->translateString($product->getProdName());
        $colorRGB = self::checkColorRGB($product->getColorRGB());
        // $colorRGB =  ($colorRGB != self::WHITE_RGB) ? $colorRGB : $this->COLOR_TEXT_05;

        $colorName = $translator->translateString($product->getColorName());
        $priceStr = self::buildProductPrice($product, $country, $currency);

        $sameNameProducts = $product->getSameNameProd();
        $sameNameProducts[$prodID] = $product;
        ksort($sameNameProducts);
        $maxDisplayable = count($sameNameProducts) + 1;
        $otherColorCube = self::buildProductCube($prodID, $maxDisplayable, $sameNameProducts);

        $sizeInputName = Size::SIZE;
        $dpdName = $translator->translateStation(self::GRID_USED_INSIDE, 9);
        $checkedLabels = [];
        $labels = GeneralCode::fillValueWithValue($product->getSizes());
        $sizeDpd = self::buildRadioDropdown($sizeInputName, $dpdName, $checkedLabels, $labels, $translator);

        $measures = $model->getMeasures();
        $customDpdName = $translator->translateStation(self::GRID_USED_INSIDE, 17);
        $customDpPrice = (new Price(0, $currency))->getFormated();
        $customBrandLabel = $translator->translateStation(self::GRID_USED_INSIDE, 18);
        $customMeasureLabel = $translator->translateStation(self::GRID_USED_INSIDE, 19);
        $customBrandButton = $translator->translateStation(self::GRID_USED_INSIDE, 20);
        $customMeasureButton = "";
        if (count($measures) > 0) {
            $addMsrBtnTxt = $translator->translateStation(self::GRID_USED_INSIDE, 21);
            $managerBtnTxt = $translator->translateStation(self::GRID_USED_INSIDE, 22);
            $customMeasureButton =
                '
                <div id="measurement_button_div" class="customize_choice-button-container">
                    <div class="custom_selected-container"></div>
                    <button id="add_measurement_button" style="display:none;" class="green-button remove-button-default-att">' . $addMsrBtnTxt . '</button>
                    <button id="manage_measurement_button" class="green-button remove-button-default-att">' . $managerBtnTxt . '</button>
                </div>';
        } else {
            $addMsrBtnTxt = $translator->translateStation(self::GRID_USED_INSIDE, 21);
            $managerBtnTxt = $translator->translateStation(self::GRID_USED_INSIDE, 22);
            $customMeasureButton =
                '
                <div id="measurement_button_div" class="customize_choice-button-container">
                    <div class="custom_selected-container"></div>
                    <button id="add_measurement_button" class="green-button remove-button-default-att">' . $addMsrBtnTxt . '</button>
                    <button id="manage_measurement_button" style="display:none;" class="green-button remove-button-default-att">' . $managerBtnTxt . '</button>
                </div>';
        }

        $cutInputName = Size::CUT;
        $cutDpdName = $translator->translateStation(self::GRID_USED_INSIDE, 23);
        $cutCheckedLabels = [];
        $cutLabels = GeneralCode::fillValueWithValue(array_keys($dbMap["cuts"]));
        $cutDpd = self::buildRadioDropdown($cutInputName, $cutDpdName, $cutCheckedLabels, $cutLabels, $translator);

        $submitButton = "";
        switch ($product->getType()) {
            case BoxProduct::BOX_TYPE:
                $buttonTxt = $translator->translateStation(self::GRID_USED_INSIDE, 24);
                $submitButton =
                    '
                    <div class="add-button-container product-data-line">
                        <button id="add_to_box" class="green-button remove-button-default-att">' . $buttonTxt . '</button>
                    </div>';
                break;
            case BasketProduct::BASKET_TYPE:
                $buttonTxt = $translator->translateStation(self::GRID_USED_INSIDE, 25);
                $submitButton =
                    '
                    <div class="add-button-container product-data-line">
                        <button id="add_to_cart" class="green-button remove-button-default-att">' . $buttonTxt . '</button>
                    </div>';
                break;
        }

        $secureInfo = $translator->translateStation(self::GRID_USED_INSIDE, 26);
        $customerServInfo = $translator->translateStation(self::GRID_USED_INSIDE, 27);
        $deliveryInfo = $translator->translateStation(self::GRID_USED_INSIDE, 28);

        $descriptionTitle = $translator->translateStation(self::GRID_USED_INSIDE, 29);
        $description = $product->getDescription($isoLang);
        $shippingTitle = $translator->translateStation(self::GRID_USED_INSIDE, 30);
        $shippingTxt = $translator->translateStation(self::GRID_USED_INSIDE, 31);

        $suggestTitle = $translator->translateStation(self::GRID_USED_INSIDE, 32);
        $sugestSlider = self::buildSuggestSlider($suggestTitle, $product, $translator, $model);

        $brandRefPopUp = self::buildBrandPopUp($translator, $dbMap);
        $managerPopUp = self::buildMeasureManagerPopUp($measures, $translator, $dbMap);

        $page =
            '            
            <div class="item_page-inner">
                <div class="directory-wrap">
                    <p>women \ collection \ coat \ essential double coat</p>
                </div>
        
                <div class="product-block">
                <div class="product-block-inner">
                    <div class="product-pictures-div">
                        <div class="product-pictures-inner">';
        $page .= $pictureSliderStr;
        $page .=
            '
                        </div>
                    </div>
                    <div class="product-details-div">
                        <div class="product-details-inner">
                            <div class="product-datas-block">
                                <div class="product-name-div product-data-line">
                                    <h3>
                                        <span>' . $prodName . ' | <span style="color:' . $colorRGB . ';">' . $colorName . '</span></span>
                                    </h3>
                                </div>
                                <div class="product-price-div product-data-line">
                                    <h3>' . $priceStr . '</h3>
                                </div>
                                <div class="detail-color-div product-data-line">
                                    <ul class="remove-ul-default-att">';
        $page .= $otherColorCube;
        $page .=
            '
                                    </ul>
                                </div>
                                <div class="product-size-container product-data-line">
                                    <div class="product-size-inner">
                                        <div class="product-size-dropdown-container">';

        $page .= $sizeDpd;
        $page .=
            '
                                        </div>
                                        <div class="product-size-customize-container">
                                            <div class="product-size-customize-block">

                                                <div class="dropdown_checkbox-wrap">
                                                    <div class="dropdown_checkbox-inner">
                                                        <div class="dropdown_checkbox-head">
                                                            <div class="dropdown_checkbox-title">
                                                                <div class="dropdown_checkbox-checkbox-block">
                                                                    <label class="checkbox-label" for="customize_size">' . $customDpdName . '
                                                                        <input id="customize_size" type="checkbox" name="customize_size">
                                                                        <span class="checkbox-checkmark"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="customize-price-block">
                                                                    <span class="customize-price-span">' . $customDpPrice . '</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown_checkbox-checkbox-list">
                                                            <div class="customize_choice-block">
                                                                <div class="customize_choice-measure-block">
                                                                    <div class="dropdown-checkbox-block">
                                                                        <label class="checkbox-label" for="measurement_brand">' . $customBrandLabel . '
                                                                            <input id="measurement_brand" type="radio" name="size_measurement" value="choose_brand" checked>
                                                                            <span class="checkbox-checkmark"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="dropdown-checkbox-block">
                                                                        <label class="checkbox-label" for="measurement_own">' . $customMeasureLabel . '
                                                                            <input id="measurement_own" type="radio" name="size_measurement" value="measurement_button_div">
                                                                            <span class="checkbox-checkmark"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <hr class="hr-summary">
                                                                <div class="customize_choice-button-block">
                                                                    <div id="choose_brand" class="customize_choice-button-container">
                                                                        <div class="custom_selected-container"></div>
                                                                        <button id="choose_brand_button" class="green-button remove-button-default-att">' . $customBrandButton . '</button>
                                                                    </div>';

        $page .= $customMeasureButton;
        $page .=
            '
                                                                </div>
                                                            </div>
                                                            <div class="customize_choice-block">
                                                                <div class="customize-choice-cut">';

        $page .= $cutDpd;
        $page .=
            '

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>';
        $page .= $submitButton;
        $page .=
            '
                            </div>
                            <div class="product-safe_info-block">
                                <div class="safe_info-wrap">
                                    <ul class="safe_info-ul remove-ul-default-att">
                                        <li class="safe_info-li remove-li-default-att">
                                            <div class="img_text_down-wrap">
                                                <div class="img_text_down-img-div">
                                                    <div class="img_text_down-img-inner">
                                                        <img src="/outside/brain/permanent/icons8-card-security-150.png">
                                                    </div>
                                                </div>
                                                <div class="img_text_down-text-div">
                                                    <span>' . $secureInfo . '</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="safe_info-li remove-li-default-att">
                                            <div class="img_text_down-wrap">
                                                <div class="img_text_down-img-div">
                                                    <div class="img_text_down-img-inner">
                                                        <img src="/outside/brain/permanent/icons8-headset-96.png">
                                                    </div>
                                                </div>
                                                <div class="img_text_down-text-div">
                                                    <span>' . $customerServInfo . '</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="safe_info-li remove-li-default-att">
                                            <div class="img_text_down-wrap">
                                                <div class="img_text_down-img-div">
                                                    <div class="img_text_down-img-inner">
                                                        <img src="/outside/brain/permanent/return-box.png">
                                                    </div>
                                                </div>
                                                <div class="img_text_down-text-div">
                                                    <span>' . $deliveryInfo . '</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="product-description-block">
                                <div class="product-description-inner">

                                    <div class="collapse-wrap">
                                        <ul class="remove-ul-default-att">
                                            <li class="remove-li-default-att">

                                                <div class="collapse-div">
                                                    <div class="collapse-title-div">
                                                        <div class="collapse-title">' . $descriptionTitle . '</div>
                                                        <div class="collapse-symbol">
                                                            <div class="plus_symbol-container">
                                                                <div class="plus_symbol-wrap">
                                                                    <span class="plus_symbol-vertical"></span>
                                                                    <span class="plus_symbol-horizontal"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="collapse-text-div collapse-text-hidded">
                                                        <div class="collapse-text-inner">
                                                            ' . $description . '
                                                        </div>
                                                    </div>
                                                </div>

                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="collapse-div">
                                                    <div class="collapse-title-div">
                                                        <div class="collapse-title">' . $shippingTitle . '</div>
                                                        <div class="collapse-symbol">
                                                            <div class="plus_symbol-container">
                                                                <div class="plus_symbol-wrap">
                                                                    <span class="plus_symbol-vertical"></span>
                                                                    <span class="plus_symbol-horizontal"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="collapse-text-div collapse-text-hidded">
                                                        <div class="collapse-text-inner">
                                                            ' . $shippingTxt . '
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                <div class="suggest-block">';
        $page .= $sugestSlider;
        $page .=
            '
                </div>
                <div class="full_screen-block">
                    <div class="size_customizer-block">
                        <div class="product-size-customize-block">
                            <div id="customize_brand_reference" class="customize-brand_reference-block">';
        $page .= $brandRefPopUp;
        $page .=
            '
                            </div>
                            <div id="customize_measure" class="customize_measure-block">';
        $page .= $managerPopUp;
        $page .=
            '
                            </div>
                        </div>
                    </div>
                </div>
        
            </div>';


        return $page;
    }

    /**
     * Builds a complete displayable slider
     * @param string[] $elements list of slider content
     * @param string $sliderId a spacificate class for the slider
     * @return string a complete displayable slider
     */
    private function buildSlider($elements, $sliderClass =  "suggest_slider_nb_window_wrapper")
    {
        $slider =
            '
            <div class="' . $sliderClass . ' slider-wrap">
                <button class="slider-left-button remove-button-default-att"></button>
                <div class="slider-window">
                    <div class="item-set">
                        <div class="slider-nb_acticle-width_indicator"></div>
                        <ul class="silder-ul-container remove-ul-default-att">';

        foreach ($elements as $element) {
            $slider .= '<li class="silder-li-container remove-li-default-att">';
            $slider .= $element;
            $slider .= '</li>';
        }
        $slider .=
            '
                        </ul>
                    </div>
                </div>
                <button class="slider-right-button remove-button-default-att"></button>
            </div>';


        return $slider;
    }

    /**
     * Build a displayable slider with a title
     * @param $title the slider's title
     * @param $elemnts list of slider's content
     * @return string a displayable slider with its title
     */
    private function buildSliderWithTiltle($title, $elements)
    {
        $slider =
            '
            <div class="suggest-silder-container">
                <div class="suggest-title-div">
                    <h3 class="suggest-title">' . $title . '</h3>
                </div>';
        $slider .= self::buildSlider($elements);
        $slider .=
            '
            </div>';

        return $slider;
    }

    /**
     * Build a slider with similar product that the product passed in param
     * @param $title the slider's title
     * @param Boxproduct|BasketProduct $product
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @param Model $model model interface
     */
    private function buildSuggestSlider($title, $product, $translator, $model)
    {
        $country = $model->getCountry();
        $currency = $model->getCurrency();
        $criterions = [
            "collections" => $product->getCollections(),
            "product_types" => [Boxproduct::BOX_TYPE, BasketProduct::BASKET_TYPE],
            "functions" => $product->getFunctions(),
            "categories" => $product->getCategories(),
            "order" => Search::NEWEST
        ];
        $search = $model->getSystemSearch($criterions);
        $searchProducts = $search->getProducts();
        $sliderElements = [];
        foreach ($searchProducts as $searchProduct) {
            $searchProductStr = self::buildProduct($searchProduct, $country, $currency, $translator);
            array_push($sliderElements, $searchProductStr);
        }
        return self::buildSliderWithTiltle($title, $sliderElements);
    }

    /**
     * Build a HTML dropdown with each label given in param by using the 
     * label as input's name and value
     * @param string $inputName the input's name
     * @param string $dpdName name of the dropdown element translated into 
     * Visisitor's language
     * @param string[] $checkedLabels list of checked input label
     * @param string[] $labels list of input label that return a input value
     * $labelInputNames => [
     *          label => input_value
     *      ]
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @return string[string[...]] $dbMap The database tables in mapped format specified in file 
     * oop/model/special/dbMap.txt
     */
    private function buildRadioDropdown($inputName, $dpdName, $checkedLabels, $labels, $translator)
    {
        $elements =
            '<div class="dropdown-wrap">
                <div class="dropdown-inner">
                    <div class="dropdown-head dropdown-arrow-close">
                        <span class="dropdown-title">' . $dpdName . '</span>
                    </div>
                    <div class="dropdown-checkbox-list">';
        // $inputId = 0;
        foreach ($labels as $label => $inputValue) { // box item
            $checkedAtt = in_array($label, $checkedLabels) ? 'checked="true"' : "";
            $inputName = strtolower(str_replace(" ", "", $inputName));
            $elements .=
                '       <div class="dropdown-checkbox-block">
                            <label class="checkbox-label">' . $translator->translateString($label) . '
                                <input type="radio" name="' . $inputName . '" value="' . $inputValue . '" ' . $checkedAtt . '>
                                <span class="checkbox-checkmark"></span>
                            </label>
                        </div>';
            // $inputId++;
        }
        $elements .=
            '       </div>
                </div>
            </div>';
        return $elements;
    }

    /**
     * Build a complete pop up (with all its attribut and content)
     *  $popUpDatas = [
     *      index => [
     *          "windowId" => string,
     *          "title" => string,
     *          "closeButtonId" => string,
     *          "content" => string,
     *          "laodingId" => string,
     *          "submitButtonId" => string,
     *          "submitButtonTxt" = string,
     *          "submitIsDesabled" = boolean,
     *          "submitClass" = string
     *          "submitButtonFunc" = string
     *      ]
     *  ];
     * @return string a complete pop up (with all its attribut and content)
     */
    private function buildPopUp($popUpDatas)
    {
        $popUp =
            '
            <div class="pop_up-wrap">';
        foreach ($popUpDatas as $datas) {
            $windowId = (!empty($datas["windowId"])) ? 'id="' . $datas["windowId"] . '"' : null;
            $desabled = ($datas["submitIsDesabled"] == true) ? "disabled=true" : null;
            $submitBtnClass = (!empty($datas["submitClass"])) ? "green-arrow-desabled" : null;
            $laodingId = (!empty($datas["laodingId"])) ? 'id="' . $datas["laodingId"] . '"' : null;
            $forFormId = (!empty($datas["forFormId"])) ? 'for="' . $datas["forFormId"] . '"' : null;
            $submitButtonFunc = (!empty($datas["submitButtonFunc"])) ? 'onclick="' . $datas["submitButtonFunc"] . '"' : null;
            $popUp .=
                '
                <div ' . $windowId . ' class="pop_up-window">
                    <div class="pop_up-inner">
                        <div class="pop_up-title-block">
                            <div class="pop_up-title-div">
                                <span class="form-title">' . $datas["title"] . '</span>
                            </div>
                            <div class="pop_up-close-button-div">
                                <button id="' . $datas["closeButtonId"] . '" class="close_button-wrap remove-button-default-att">
                                    <div class="plus_symbol-wrap">
                                        <span class="plus_symbol-vertical"></span>
                                        <span class="plus_symbol-horizontal"></span>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <hr class="hr-summary">
                        <div class="pop_up-content-block">
                            ' . $datas["content"] . '

                            <div ' . $laodingId . ' class="loading-img-wrap">
                                <img src="/outside/brain/permanent/loading.gif">
                            </div>
                            <div class="pop_up-validate_button-div">
                                <button id="' . $datas["submitButtonId"] . '" '. $submitButtonFunc .' ' . $forFormId . ' ' . $desabled . ' class="green-arrow ' . $submitBtnClass . ' remove-button-default-att">' . $datas["submitButtonTxt"] . '</button>
                            </div>
                        </div>
                    </div>
                </div>';
        }
        $popUp .=
            '
            </div>';
        return $popUp;
    }

    /**
     * Build the brand reference pop up
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @param string[string[...]] $dbMap The database tables in mapped format specified in file 
     * oop/model/special/dbMap.txt
     * @return string brand reference pop up
     */
    private function buildBrandPopUp($translator, $dbMap)
    {
        $popUpDatas = [];
        $popUpDatas[0]["title"] = $translator->translateStation(self::GRID_USED_INSIDE, 33);
        $popUpDatas[0]["closeButtonId"] = "brand_reference_close_button";
        $popUpDatas[0]["laodingId"] = "brandPopUp_loading";
        $popUpDatas[0]["submitButtonId"] = "brand_validate_button";
        $popUpDatas[0]["submitButtonTxt"] = $translator->translateStation(self::GRID_USED_INSIDE, 34);
        $popUpDatas[0]["submitIsDesabled"] = true;
        $popUpDatas[0]["submitClass"] = "green-arrow-desabled";
        $contentTitle = $translator->translateStation(self::GRID_USED_INSIDE, 35);
        $content =
            '
            <div class="brand_reference-content">
                <div class="brand_reference-info-div">
                    <p>' . $contentTitle . '</p>
                </div>
                <div class="brand_reference-grid-container">';

        foreach ($dbMap["brandsMeasures"] as $brandName => $brandDatas) {
            // $dataBrand = GeneralCode::encodeInputString($brandName);
            $dataBrand = [
                // Size::BRAND_NAME_KEY => GeneralCode::encodeInputString($brandName)
                Size::BRAND_NAME_KEY => $brandName
            ];
            $dataBrand_json = json_encode($dataBrand);

            $content .=
                '
                    <div class="brand_reference-grid-img-block" data-brand=\'' . $dataBrand_json . '\'>
                        <div class="first-img-div">
                            <img src="/outside/brain/brand/' . $brandDatas["brandsPictures"][1] . '">
                        </div>
                        <div class="second-img-div">
                            <img src="/outside/brain/brand/' . $brandDatas["brandsPictures"][2] . '">
                        </div>
                    </div>';
        }
        $content .=
            '                                         
                </div>
            </div>';
        $popUpDatas[0]["content"] = $content;
        $popUp = self::buildPopUp($popUpDatas);
        return $popUp;
    }

    /**
     * Build the measure manager pop up
     * @param Measure[] $measures list of Visitor's Measures
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @param string[string[...]] $dbMap The database tables in mapped format specified in file 
     * oop/model/special/dbMap.txt
     * @return string measure manager pop up
     */
    private function buildMeasureManagerPopUp($measures, $translator, $dbMap)
    {
        // MANAGER POP UP
        $popUpDatas[0]["windowId"] = "mange_measure_window";
        $popUpDatas[0]["title"] = $translator->translateStation(self::GRID_USED_INSIDE, 22);
        $popUpDatas[0]["closeButtonId"] = "close_measure_manager";
        $popUpDatas[0]["submitButtonId"] = "measure_select_button";
        $popUpDatas[0]["submitButtonTxt"] = $translator->translateStation(self::GRID_USED_INSIDE, 34);
        $popUpDatas[0]["submitIsDesabled"] = true;
        $popUpDatas[0]["submitClass"] = "green-arrow-desabled";
        $popUpDatas[0]["laodingId"] = "measurePopUp_loading";

        $managerContent = '<div class="customize_measure-content">';
        $managerContent .= (count($measures) > 0) ? self::buildMeasureManagerContent($measures, $translator) : null;
        $managerContent .= '</div>';

        $popUpDatas[0]["content"] = $managerContent;

        $popUpDatas[1]["windowId"] = "add_measure_window";
        $popUpDatas[1]["title"] = $translator->translateStation(self::GRID_USED_INSIDE, 36);
        $popUpDatas[1]["closeButtonId"] = "measure_adder_close_button";
        $popUpDatas[1]["submitButtonId"] = "save_measure_button";
        $popUpDatas[1]["submitButtonTxt"] = $translator->translateStation(self::GRID_USED_INSIDE, 37);
        $popUpDatas[1]["submitIsDesabled"] = true;
        $popUpDatas[1]["submitClass"] = "green-arrow-desabled";
        $popUpDatas[1]["laodingId"] = "add_measurePopUp_loading";
        $popUpDatas[1]["forFormId"] = "add_measure_form";
        $popUpDatas[1]["submitButtonFunc"] = "saveMsr()";

        $measureContent = '<div class="customize_measure-content">';
        $measureContent .= self::buildMeasureAdderContent($translator, $dbMap);
        $measureContent .= '</div>';

        $popUpDatas[1]["content"] = $measureContent;
        $popUp = self::buildPopUp($popUpDatas);
        return $popUp;
    }

    /**
     * Build the measure manager's content
     * @param Measure[] $measures list of Visitor's Measures
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @return string the measure manager's content
     */
    public function buildMeasureManagerContent($measures, $translator)
    {
        $elements = self::getMeasureManagetTitleANDbutton($measures, $translator);

        $measureCartDatas = self::buildMeasureCartElements4CartWrap($measures, $translator);
        $managerContent =
            '
                <div class="customize_measure-content-inner">
                    <div class="customize_measure-info-div">
                    ' . $elements[View::TITLE_KEY] . '
                    </div>';
        $managerContent .= self::buildCartWrap($measureCartDatas, $translator);
        $managerContent .=
            '
                    <div id="manager_add_measurement" class="manager_add_measurement">
                    ' . $elements[View::BUTTON_KEY] . '
                    </div>
                </div>';

        return $managerContent;
    }

    /**
     * Build the measure adder's content
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @param string[string[...]] $dbMap The database tables in mapped format specified in file 
     * oop/model/special/dbMap.txt
     * @param Measure $measures Visitor's Measures
     * @return string the measure adder's content
     */
    public function buildMeasureAdderContent($translator, $dbMap, $measure = null)
    {
        $supportedUnits = MeasureUnit::getSUPPORTED_UNIT();

        $bustTranslate = $translator->translateStation(self::GRID_USED_INSIDE, 39);
        $armTranslate = $translator->translateStation(self::GRID_USED_INSIDE, 40);
        $waistTranslate = $translator->translateStation(self::GRID_USED_INSIDE, 41);
        $hipTranslate = $translator->translateStation(self::GRID_USED_INSIDE, 42);
        $inseamTranslate = $translator->translateStation(self::GRID_USED_INSIDE, 43);
        $measurreNameTranslate = $translator->translateStation(self::GRID_USED_INSIDE, 16);
        $contentTitle = $translator->translateStation(self::GRID_USED_INSIDE, 38);

        if (!empty($measure)) {
            $measureName = "value='" . $measure->getMeasureName() . "'";
            $bustVal = "value=" . $measure->getbust()->getValue();
            $hipVal = "value=" . $measure->gethip()->getValue();
            $armVal = "value=" . $measure->getarm()->getValue();
            $inseamVal = "value=" . $measure->getInseam()->getValue();
            $waistVal = "value=" . $measure->getwaist()->getValue();
            $unitNameObj = $measure->getwaist()->getUnitName();
            $getUnitSymbol = $measure->getwaist()->getUnit();

            $measure_id = $measure->getMeasureID();
            $inputMeasureID = '<input type="hidden" name="' . Measure::MEASURE_ID_KEY . '" value="'. $measure_id .'">';
                    
            // $dataMeasure = [
            //     Measure::MEASURE_ID_KEY => $measure->getMeasureID()
            // ];
            // $dataMeasure_json = json_encode($dataMeasure);
            // $dataMeasureAttr = 'data-measure=\'' . $dataMeasure_json . '\'';
        } else {
            $measureName = null;
            $bustVal = null;
            $hipVal = null;
            $armVal = null;
            $inseamVal = null;
            $waistVal = null;
            $unitNameObj = null;
            $inputMeasureID = null;
        }

        $addMeasureCheckbox = "";
        foreach ($supportedUnits as $unitName) {
            $measureUnit = $dbMap["measureUnits"][$unitName]["measureUnit"];
            $unitNameChecked = ((!empty($unitNameObj) && $unitName == $unitNameObj)) ? "checked=true" : "";
            $addMeasureCheckbox .=
                '
                    <div class="checkbox-container">
                        <label class="checkbox-label" for="measure_unit_' . $unitName . '">' . $measureUnit . '
                            <input id="measure_unit_' . $unitName . '" data-unit="' . $measureUnit . '" type="radio" name="' . MeasureUnit::INPUT_MEASURE_UNIT . '" value="' . $unitName . '" ' . $unitNameChecked . '>
                            <span class="checkbox-checkmark"></span>
                        </label>
                    </div>';
        }

        $measureContent =
            '
            <div class="customize_measure-content-inner">
                <div class="customize_measure-info-div">
                    <p>' . $contentTitle . '</p>
                </div>

                <div class="customize_measure-input-block">
                    <div class="measure_body-img-container">
                        <img src="/outside/brain/permanent/body-measure-women.png">
                    </div>
                    <div class="measure_input-container">
                        <div class="measure_input-container-inner">
                            <form id="add_measure_form">
                                '. $inputMeasureID .'
                                <div class="measure_input-div">
                                    <div class="measure_input-checkbox-conatiner">
                                        <div class="checkbox_set-wrap">
                                            <div class="checkbox_set-content-div">';

        $measureContent .= $addMeasureCheckbox;
        $measureContent .=
            '
                                            </div>
                                            <div class="checkbox_error-div">
                                                <p class="comment"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="measure_input-div">
                                        <div class="input-container">
                                            <div class="input-wrap">
                                                <label class="input-label" for="">' . $measurreNameTranslate . '</label>
                                                <span class="input-unit"></span>
                                                <input class="input-tag" type="text" ' . $measureName . ' name="' . Measure::INPUT_MEASURE_NAME . '" placeholder="' . $measurreNameTranslate . '">
                                                <p class="comment"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="measure_input-input-group">
                                        <div class="input-container">
                                            <div class="input-wrap">
                                                <label class="input-label" for="">' . $bustTranslate . '</label>
                                                <span class="input-unit">'. $getUnitSymbol .'</span>
                                                <input class="input-tag" type="text" ' . $bustVal . ' name="' . Measure::INPUT_BUST . '" placeholder="' . $bustTranslate . '">
                                                <p class="comment"></p>
                                            </div>
                                        </div>
                                        <div class="input-container">
                                            <div class="input-wrap">
                                                <label class="input-label" for="">' . $armTranslate . '</label>
                                                <span class="input-unit">'. $getUnitSymbol .'</span>
                                                <input class="input-tag" type="text" ' . $armVal . ' name="' . Measure::INPUT_ARM . '" placeholder="' . $armTranslate . '">
                                                <p class="comment"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="measure_input-div">
                                    <div class="measure_input-input-group">
                                        <div class="input-container">
                                            <div class="input-wrap">
                                                <label class="input-label" for="">' . $waistTranslate . '</label>
                                                <span class="input-unit">'. $getUnitSymbol .'</span>
                                                <input class="input-tag" type="text" ' . $waistVal . ' name="' . Measure::INPUT_WAIST . '" placeholder="' . $waistTranslate . '">
                                                <p class="comment"></p>
                                            </div>
                                        </div>
                                        <div class="input-container">
                                            <div class="input-wrap">
                                                <label class="input-label" for="">' . $hipTranslate . '</label>
                                                <span class="input-unit">'. $getUnitSymbol .'</span>
                                                <input class="input-tag" type="text" ' .  $hipVal  . ' name="' . Measure::INPUT_HIP . '" placeholder="' . $hipTranslate . '">
                                                <p class="comment"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="measure_input-div">
                                    <div class="input-container">
                                        <div class="input-wrap">
                                            <label class="input-label" for="">' . $inseamTranslate . '</label>
                                            <span class="input-unit">'. $getUnitSymbol .'</span>
                                            <input class="input-tag" type="text" ' . $inseamVal . ' name="' . Measure::INPUT_INSEAM . '" placeholder="' . $inseamTranslate . '">
                                            <p class="comment"></p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>';

        return $measureContent;
    }

    /**
     * To get elements inside Measure Manager
     * @param Measure[] $measures list of Visitor's Measures
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @return string elements inside Measure Manager
     *      $elements = [
     *      View::TITLE_KEY => '<p>somthing...</p>';
     *      View::BUTTON_KEY => '<button id="manager_add_measurement_button" </button>'
     *      ]
     */
    public function getMeasureManagetTitleANDbutton($measures, $translator)
    {
        $maxMeasure = Visitor::getMAX_MEASURE();
        $nbMeasure = count($measures);

        $managerContentTitle = $translator->translateStation(self::GRID_USED_INSIDE, 45);
        $managerAddMeasureBtn = $translator->translateStation(self::GRID_USED_INSIDE, 44);

        $measureRation = " ($nbMeasure/$maxMeasure)";
        $maxMeasureAlert = $translator->translateStation(MyError::ERROR_FILE, 7) . $measureRation;

        $btnAction = ($nbMeasure >= Visitor::getMAX_MEASURE()) ? 'onclick="popAlert(\'' . $maxMeasureAlert . '\')"' : 'onclick="managerSwitchMeasure()"';

        $elements[View::TITLE_KEY] = '<p>' . $managerContentTitle . $measureRation . ':</p>';
        $elements[View::BUTTON_KEY] = '<button id="manager_add_measurement_button" ' . $btnAction . ' class="green-button remove-button-default-att">' . $managerAddMeasureBtn . '</button>';

        return $elements;
    }

    /**
     * Build a cart with a set of cart elemnt passed in param
     * @param string[] $contents property content of cart element
     *      $cartDatas = [
     *           index => [
     *               "content" => string,
     *               "removeBtn" => string,
     *               "priceBlockContent" => string,
     *               "editBtn" => string
     *           ]
     *      ]
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @return 
     */
    private function buildCartWrap($cartDatas, $translator)
    {
        $editBtnTranslate = $translator->translateStation(self::GRID_USED_INSIDE, 49);
        $wrapper =
            '
            <div class="cart-wrap">
                <ul class="remove-ul-default-att">';
        foreach ($cartDatas as $datas) {
            if (!empty($datas["priceBlockContent"])) {
                $priceBlock =
                    '
                        <div class="cart-element-price-block">
                            <div class="cart-element-price-inner">
                                ' . $datas["priceBlockContent"] . '
                            </div>
                        </div>';
            } else {
                $editBlockClass = "no_price_block";
            }

            if (!empty($datas["removeBtn"])) {
                $removeBtn = $datas["removeBtn"];
            } else {
                $removeBtn =
                    '
                        <button class="close_button-wrap remove-button-default-att">
                            <div class="plus_symbol-wrap">
                                <span class="plus_symbol-vertical"></span>
                                <span class="plus_symbol-horizontal"></span>
                            </div>
                        </button>';
            }

            if (!empty($datas["editBtn"])) {
                $editBtn = $datas["editBtn"];
            } else {
                $editBtn = '<button class="cart-element-edit-button remove-button-default-att">' . $editBtnTranslate . '</button>';
            }

            $wrapper .=
                '
                    <li class="li-cart-element-container remove-li-default-att">
                        <div class="cart-element-wrap">
                            <div class="cart-element-inner">
                                <div class="cart-element-remove-button-block">
                                ' . $removeBtn . '
                                </div>

                                <div class="cart-element-detail-block">
                                    <div class="cart-element-property-set">
                                        ' . $datas["content"] . '
                                    </div>
                                </div>

                                <div class="cart-element-edit-block ' . $editBlockClass . '">
                                    <div class="cart-element-edit-inner">
                                    ' . $editBtn . '
                                    </div>
                                </div>

                                ' . $priceBlock . '
                            </div>
                        </div>
                    </li>';
        }

        $wrapper .=
            '
                </ul>
            </div>';

        return $wrapper;
    }

    /**
     * Build cart element with measure
     * @param Measure[] $measures list of Visitor's Measures
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @return string[] list of Measure into cart format
     *      $cartDatas = [
     *           index => [
     *               "content" => string,
     *               "removeBtn" => string,
     *               "priceBlockContent" => string,
     *               "editBtn" => string
     *           ]
     *      ]
     */
    private function buildMeasureCartElements4CartWrap($measures, $translator)
    {
        $bustTranslate = $translator->translateStation(self::GRID_USED_INSIDE, 39);
        $hipTranslate = $translator->translateStation(self::GRID_USED_INSIDE, 42);
        $armTranslate = $translator->translateStation(self::GRID_USED_INSIDE, 40);
        $inseamTranslate = $translator->translateStation(self::GRID_USED_INSIDE, 43);
        $waistTranslate = $translator->translateStation(self::GRID_USED_INSIDE, 41);
        $editBtnTranslate = $translator->translateStation(self::GRID_USED_INSIDE, 49);

        $cartDatas = [];

        foreach ($measures as $measure) {
            $measure_id = $measure->getMeasureID();
            $measureName = $measure->getMeasureName();
            $bustVal = $measure->getbust()->getFormated();
            $hipVal = $measure->gethip()->getFormated();
            $armVal = $measure->getarm()->getFormated();
            $inseamVal = $measure->getInseam()->getFormated();
            $waistVal = $measure->getwaist()->getFormated();

            $dataMeasure = [
                Measure::MEASURE_ID_KEY => $measure_id
            ];
            $dataMeasure_json = json_encode($dataMeasure);

            $measureSelector = 'onclick="selectMeasurement(\'' . $measure_id . '\')" data-measure_id="' . $measure_id . '"';

            $removeBtnFunc = 'onclick="removeMsr(\'' . $measure_id . '\')" data-measure_id=\'' . $measure_id . '\' data-measure=\'' . $dataMeasure_json . '\'';

            $editBtnFunc = 'onclick="getMsrAdder(\'' . $measure_id . '\')" data-measure_id=\'' . $measure_id . '\' data-measure=\'' . $dataMeasure_json . '\'';

            $cartContent =
                '
                    <div class="manager-measure-property-set" ' . $measureSelector . '  data-measure=\'' . $dataMeasure_json . '\'>
                        <div class="measure-property-title cart-element-property-div">
                            <span>' . $measureName . '</span>
                        </div>
                        <div class="double-flex-50-parent">
                            <div class="cart-element-property-div double-flex-50-child">
                                <span class="cart-element-property">' . $bustTranslate . ': </span>
                                <span class="cart-element-value">' . $bustVal . '</span>
                            </div>
                            <div class="cart-element-property-div double-flex-50-child">
                                <span class="cart-element-property">' . $hipTranslate . ': </span>
                                <span class="cart-element-value">' . $hipVal . '</span>
                            </div>
                        </div>
                        <div class="double-flex-50-parent">
                            <div class="cart-element-property-div double-flex-50-child">
                                <span class="cart-element-property">' . $armTranslate . ': </span>
                                <span class="cart-element-value">' . $armVal . '</span>
                            </div>
                            <div class="cart-element-property-div double-flex-50-child">
                                <span class="cart-element-property">' . $inseamTranslate . ': </span>
                                <span class="cart-element-value">' . $inseamVal . '</span>
                            </div>
                        </div>
                        <div class="double-flex-50-parent">
                            <div class="cart-element-property-div">
                                <span class="cart-element-property">' . $waistTranslate . ': </span>
                                <span class="cart-element-value">' . $waistVal . '</span>
                            </div>
                        </div>
                    </div>';

            $removeBtn =
                '
                    <button ' . $removeBtnFunc . ' class="close_button-wrap remove-button-default-att">
                        <div class="plus_symbol-wrap">
                            <span class="plus_symbol-vertical"></span>
                            <span class="plus_symbol-horizontal"></span>
                        </div>
                    </button>';

            $editBtn = '<button class="cart-element-edit-button remove-button-default-att" ' . $editBtnFunc . ' >'  . $editBtnTranslate . '</button>';

            $key = $measure->getDateInSec();
            $cartDatas[$key]["content"] = $cartContent;
            $cartDatas[$key]["removeBtn"] = $removeBtn;
            $cartDatas[$key]["editBtn"] = $editBtn;
        }
        // krsort($cartDatas);
        return $cartDatas;
    }

    /**
     * To get selected brand html sticker
     * @param string brandName the brand's name
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @return string selected brand html stickers
     */
    public function getBrandSticker($brandName, $translator)
    {
        $stickerTitle = $translator->translateStation(self::GRID_USED_INSIDE, 46);
        $stickerName = $translator->translateStation(self::GRID_USED_INSIDE, 47);

        $stickerDatas["inputName"] = Size::BRAND_NAME_KEY;
        $stickerDatas["inputValue"] = $brandName;
        $stickerDatas["stickerTitle"] = $stickerTitle;
        $stickerDatas["removeBtnId"] = null;
        $stickerDatas["btnFunc"] = null;
        $stickerDatas["content"] =
            '
            <div class="sticker-content-div">
                <div class="data-key_value-wrap">
                    <span class="data-key_value-key">' . $stickerName . ':</span>
                    <span class="data-key_value-value">' . $brandName . '</span>
                </div>
            </div>';

        $sticker = self::buildStickerWithTitle($stickerDatas);

        // $sticker =
        //     '
        //     <div class="custom_selected-inner">
        //         <input name="' . Size::BRAND_NAME_KEY . '" type="hidden" value="' . $brandName . '">
        //         <div class="custom_selected-title-div">
        //             <p class="custom_selected-title">' . $stickerTitle . ':</p>
        //         </div>
        //         <div class="sticker-container">
        //             <div class="sticker-wrap">
        //                 <div class="sticker-content-div">
        //                     <div class="data-key_value-wrap">
        //                         <span class="data-key_value-key">' . $stickerName . ':</span>
        //                         <span class="data-key_value-value">' . $brandName . '</span>
        //                     </div>
        //                 </div>
        //                 <button class="sticker-button remove-button-default-att">
        //                     <span class="sticker-x-left"></span>
        //                     <span class="sticker-x-right"></span>
        //                 </button>
        //             </div>
        //         </div>
        //     </div>';

        return $sticker;
    }

    /**
     * To get selected brand html sticker
     * @param Measure $measure Visitor's measure
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @return string selected measure html stickers
     */
    public function getMeasureSticker($measure, $translator)
    {
        $measure_id = $measure->getMeasureID();
        $measureName = $measure->getMeasureName();
        $stickerTitle = $translator->translateStation(self::GRID_USED_INSIDE, 46);
        $stickerName = $translator->translateStation(self::GRID_USED_INSIDE, 48);

        $stickerDatas["inputName"] = Measure::MEASURE_ID_KEY;
        $stickerDatas["inputValue"] = $measure_id;
        $stickerDatas["stickerTitle"] = $stickerTitle;
        $stickerDatas["removeBtnId"] = null;
        $stickerDatas["btnFunc"] = null;
        $stickerDatas["content"] =
            '
            <div class="sticker-content-div">
                <div class="data-key_value-wrap">
                    <span class="data-key_value-key">' . $stickerName . ':</span>
                    <span class="data-key_value-value">' . $measureName . '</span>
                </div>
            </div>';

        $sticker = self::buildStickerWithTitle($stickerDatas);
        return $sticker;
    }

    /**
     * Build a sticker with a title and an input
     * $datas = [
     *      "inputName" => string,
     *      "inputValue" => string,
     *      "stickerTitle" => string,
     *       
     *      "content" => string,
     *      "removeBtnId" => string,
     *      "btnFunc" => string,{ex: "myFunction(param)"}
     * ]
     */
    private function buildStickerWithTitle($datas)
    {
        $stickerDatas = [
            "content" => $datas["content"],
            "removeBtnId" => $datas["removeBtnId"],
            "btnFunc" => $datas["btnFunc"]
        ];
        $stickerWithTitle =
            '
            <div class="custom_selected-inner">
                <input name="' . $datas["inputName"] . '" type="hidden" value="' . $datas["inputValue"] . '">
                <div class="custom_selected-title-div">
                    <p class="custom_selected-title">' . $datas["stickerTitle"] . ':</p>
                </div>
                <div class="sticker-container">';

        $stickerWithTitle .= self::buildSticker($stickerDatas);
        $stickerWithTitle .=
            '
                </div>
            </div>';

        return $stickerWithTitle;
    }

    /**
     * @param string[] 
     * $datas = [
     *      "content" => string,
     *      "removeBtnId" => string,
     *      "btnFunc" => string,{ex: "myFunction(param)"}
     * ]
     */
    private function buildSticker($datas)
    {
        $removeBtnId = (!empty($datas["removeBtnId"])) ? 'id="' . $datas["removeBtnId"] . '"' : null;
        $btnFunc = (!empty($datas["btnFunc"])) ? 'onclick="' . $datas["btnFunc"] . '"' : null;
        $sticker =
            '
            <div class="sticker-wrap">
                <div class="sticker-content-div">
                    ' . $datas["content"] . '
                </div>
                <button ' . $removeBtnId . ' ' . $btnFunc . ' class="sticker-button remove-button-default-att">
                    <span class="sticker-x-left"></span>
                    <span class="sticker-x-right"></span>
                </button>
            </div>';

        return $sticker;
    }


    /*—————————————————————————————— ITEM PAGE UP ———————————————————————————*/
}
