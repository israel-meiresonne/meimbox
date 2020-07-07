<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string[] $stickers map that return the input value for each sticker inside.
 * $stickToValues => [
 *          sticker{string} => value
 *      ]
 * sticker => sticker's displayed name
 * @param Translator $translator the View's translator. NOTE: it's the only
 *  instance of this class in the whole system.
 */
foreach ($stickers as $sticker => $value) :
    // $valueAtt = 'value="' . $value . '"';
    // $stickerFunc = 'onclick="removeSticker(' . "'" . $value . "'" . ')"';
?>
    <div class="sticker-container">
        <div class="sticker-wrap">
            <div value="<?= $value ?>" class="sticker-content-div"><?= $translator->translateString($sticker) ?></div>
            <button onclick="removeSticker('<?= $value ?>')" class="sticker-button remove-button-default-att">
                <span class="sticker-x-left"></span>
                <span class="sticker-x-right"></span>
            </button>
        </div>
    </div>
<?php endforeach; ?>