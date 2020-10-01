<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 */
$errorid = ModelFunctionality::generateDateCode(25);
$errorx = "#$errorid";
?>
<label class="checkbox-label">Sign up for newsletter
    <input class="newletter-input" type="checkbox" name="<?= Visitor::INPUT_NEWSLETTER ?>" data-errorx="<?= $errorx ?>" data-errortype="<?= self::ER_TYPE_COMMENT ?>">
    <span class="checkbox-checkmark"></span>
    <div class="connection-checkbox-text-div">
        By subscribing to I&Meim’s newsletter, I understand
        and accept to receive emails from I&Meim’s with the
        latest deals, sales, and updates by multiple form of
        communication like email, phone and/or post.
    </div>
    <p id="<?= $errorid ?>" class="comment"></p>
</label>