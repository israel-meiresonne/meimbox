<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Map $element datas used to display element
 * $element[Map::link] => link to product's web page
 * $element[Map::picture] => string the https link of the picture
 * $element[Map::name]
 * $element[Map::price]
 * $element[Map::properties][Map::color]
 * $element[Map::properties][Map::size]
 * $element[Map::properties][Map::brand]
 * $element[Map::properties][Map::measureName]
 * $element[Map::properties][Map::cut]
 * $element[Map::properties][Map::nbItem]
 * $element[Map::properties][Map::max]
 * $element[Map::properties][Map::quantity]
 */

/**
 * @var Translator */
$translator = $translator;

$propToStations = [
    Map::color => "US10",
    Map::size => "US9",
    Map::brand => "US47",
    Map::measureName => "US48",
    Map::cut => "US52",
    Map::nbItem => "US53",
    Map::max => "US53",
    Map::quantity => "US54"
];
$propToStationsMap = new Map($propToStations);
?>

<tr>
    <td class="body_content-body-picture body_content-body-td">
        <?php
        if (!empty($element->get(Map::link))) : ?>
            <a href="<?= $element->get(Map::link) ?>" target="_blank">
                <img src="<?= $element->get(Map::picture) ?>" alt="name of the product">
            </a>
        <?php
        else : ?>
            <img src="<?= $element->get(Map::picture) ?>" alt="name of the product">
        <?php endif;
        ?>
    </td>
    <td class="body_content-body-td">
        <table class="body_content-body-property">
            <tr>
                <td>
                    <h4 class="property-title sentence no_margin"><?= $element->get(Map::name) ?></h4>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="table_default">
                        <?php
                        $propKeys = $propToStationsMap->getKeys();
                        $properties = $element->get(Map::properties);
                        foreach ($propKeys as $propKey) :
                            if (!empty($properties->get($propKey))) :
                                $field = null;
                                $value = null;
                                $station  = $propToStationsMap->get($propKey);
                                switch ($propKey):
                                    case Map::quantity:
                                    case Map::cut:
                                    case Map::measureName:
                                    case Map::brand:
                                    case Map::size:
                                    case Map::color:
                                        $propValue = $properties->get($propKey);
                                        $field = $translator->translateStation($station);
                                        $value = $translator->translateString($propValue);
                                        break;
                                    case Map::max:
                                        if (!empty($properties->get(Map::nbItem))) {
                                            $field = $translator->translateStation($station);
                                            $value = $properties->get(Map::nbItem) . "/" . $properties->get(Map::max);
                                        }
                                        break;
                                endswitch;
                                if (!empty($value)) : ?>
                                    <tr>
                                        <td>
                                            <span class="secondary_field_dark"><?= $field ?>:</span>
                                        </td>
                                        <td>
                                            <span><?= $value ?></span>
                                        </td>
                                    </tr>
                        <?php endif;
                            endif;
                        endforeach; ?>
                    </table>
                </td>
            </tr>
        </table>
    </td>
    <td class="body_content-body-price body_content-body-td">
        <span class="secondary_field_dark price_field"><?= $element->get(Map::price) ?></span>
    </td>
</tr>