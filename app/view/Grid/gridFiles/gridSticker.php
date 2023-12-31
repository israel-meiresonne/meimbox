<?php
require_once 'model/special/Search.php';

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string[] $stickers map that return the input value for each sticker inside.
 * $stickers => [
 *          sticker{string} => value
 *      ]
 * sticker => sticker's displayed name
 * @param Translator $translator the View's translator. NOTE: it's the only
 *  instance of this class in the whole system.
 */

if (isset($executeObj)) {
    foreach ($executeObj as $funcs) {
        ${$funcs["var"]} = ${$funcs["obj"]}->{$funcs["function"]}(${$funcs["param"]});
    }
}

foreach ($stickers as $sticker => $value) : 
    $json = htmlentities(json_encode(["sticker_value" => $value]));
?>
    <div class="sticker-container">
        <div class="sticker-wrap">
            <div value="<?= $value ?>" class="sticker-content-div">
                <?= $translator->translateString($sticker) ?>
            </div>
            <button onclick="evt('evt_cd_130','<?= $json ?>');removeSticker('<?= $value ?>')" class="sticker-button remove-button-default-att">
                <span class="sticker-x-left"></span>
                <span class="sticker-x-right"></span>
            </button>
        </div>
    </div>
<?php endforeach; ?>