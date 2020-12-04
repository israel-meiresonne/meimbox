<?php

/**
 * @param string $title             the title of the message
 *                                  + also used as title of the web page in the head tag
 * @param string $content           the message to display
 * @param string $btnText            the text to display on the button link
 * @param string $btnLink           link to place in the button link
 */
$this->title = $title;
/**
 * @var Translator */
$translator = $this->translator;
?>

<div class="main_content">
    <div class="main_content-inner">
        <div class="main_content-inner-msg_content">
            <div class="msg_content-head">
                <h1 class="msg_content-head-title"><?= $title ?></h1>
            </div>
            <div class="msg_content-body">
                <?= $content ?>
            </div>
        </div>
        <div class="main_content-inner-btn_content">
            <a class="remove-a-default-att" href="<?= $btnLink ?>">
                <button class="btn_content-btn cta-btn squared-standard-button"><?= $btnText ?></button>
            </a>
        </div>
    </div>
</div>