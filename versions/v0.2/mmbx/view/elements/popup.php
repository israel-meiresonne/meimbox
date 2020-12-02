<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * Build a complete pop up (with all its attribut and content)
 * @param string    $closeEventCode     event code to track popup's closure
 * @param string[]  $datas              map of attrribut needed to build a pop up
 *  $datas = [
 *      index => [
 *          "windowId" => string,
 *          "title" => string,
 *          "closeButtonId" => string,
 *          "content" => string,
 *          "laodingId" => string,
 *          "laodingClass" => string,
 *          "submitButtonId" => string, 🚨if empty means that there isn't any submit button
 *          "submitButtonTxt" = string,
 *          "submitIsDesabled" = boolean, set true to desable submit button else false or empty
 *          "submitClass" = string
 *          "submitButtonFunc" = string
 *      ]
 *  ];
 */
// $closeEventCode = (!empty($closeEventCode)) ? $closeEventCode : null;
/** Event */

?>

<div class="pop_up-wrap">
    <?php
    $windowId = (!empty($datas["windowId"])) ? 'id="' . $datas["windowId"] . '"' : null;
    $laodingId = (!empty($datas["laodingId"])) ? 'id="' . $datas["laodingId"] . '"' : null;
    $laodingClass = (!empty($datas["laodingClass"])) ? $datas["laodingClass"] : null;
    $forFormId = (!empty($datas["forFormId"])) ? 'for="' . $datas["forFormId"] . '"' : null;

    if (!empty($datas["submitButtonId"])) {
        $desabled = ($datas["submitIsDesabled"] == true) ? "disabled=true" : null;
        $desabledCls = (!empty($desabled)) ? "standard-button-desabled" : null;
        $submitBtnClass = (!empty($datas["submitClass"])) ? $datas["submitClass"] : null;
        $submitButtonFunc = (!empty($datas["submitButtonFunc"])) ? 'onclick="' . $datas["submitButtonFunc"] . '"' : null;
    }
    ?>
    <div <?= $windowId ?> class="pop_up-window">
        <div class="pop_up-inner">
            <div class="pop_up-title-block">
                <div class="pop_up-title-div">
                    <span class="form-title"><?= $datas["title"] ?></span>
                </div>
                <div class="pop_up-close-button-div">
                    <button id="<?= $datas["closeButtonId"] ?>" class="close_button-wrap popup_close_btn remove-button-default-att">
                        <div class="plus_symbol-wrap">
                            <span class="plus_symbol-vertical"></span>
                            <span class="plus_symbol-horizontal"></span>
                        </div>
                    </button>
                </div>
            </div>
            <hr class="hr-summary">
            <div class="pop_up-content-block">
                <div class="pop_up-content-block-inner">
                    <?= $datas["content"] ?>
                </div>
                <div <?= $laodingId ?> class="<?= $laodingClass ?> loading-img-wrap">
                    <img src="<?= self::$DIR_STATIC_FILES ?>loading.gif">
                </div>
                <?php
                if (!empty($datas["submitButtonId"])) : ?>
                    <div class="pop_up-validate_button-div">
                        <button id="<?= $datas["submitButtonId"] ?>" <?= $submitButtonFunc ?> <?= $forFormId ?> <?= $desabled ?> class="green-arrow <?= $submitBtnClass ?> <?= $desabledCls ?> remove-button-default-att"><?= $datas["submitButtonTxt"] ?></button>
                    </div>
                <?php
                endif; ?>
            </div>
        </div>
    </div>
</div>