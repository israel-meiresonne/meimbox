<?php
/**
 * @var Translator */
$translator = $translator;
$secureInfo = $translator->translateStation("US26");
// $customerServInfo = $translator->translateStation("US27");
$deliveryInfo = $translator->translateStation("US28");
$trackInfo = $translator->translateStation("US138", (new Map(["br" => "<br>"])));
?>
<div class="safe_info-wrap">
    <ul class="safe_info-ul remove-ul-default-att">
        <li class="safe_info-li remove-li-default-att">
            <div class="img_text_down-wrap">
                <div class="img_text_down-img-div">
                    <div class="img_text_down-img-inner">
                        <img src="<?= self::$DIR_STATIC_FILES ?>icons8-card-security-150.png">
                    </div>
                </div>
                <div class="img_text_down-text-div">
                    <span><?= $secureInfo ?></span>
                </div>
            </div>
        </li>
        <li class="safe_info-li remove-li-default-att">
            <div class="img_text_down-wrap">
                <div class="img_text_down-img-div">
                    <div class="img_text_down-img-inner">
                        <img src="<?= self::$DIR_STATIC_FILES ?>icons8-van-96.png">
                    </div>
                </div>
                <div class="img_text_down-text-div">
                    <span><?= $trackInfo ?></span>
                </div>
            </div>
        </li>
        <?php
        /*
        <li class="safe_info-li remove-li-default-att">
            <div class="img_text_down-wrap">
                <div class="img_text_down-img-div">
                    <div class="img_text_down-img-inner">
                        <img src="<?= self::$DIR_STATIC_FILES ?>icons8-headset-96.png">
                    </div>
                </div>
                <div class="img_text_down-text-div">
                    <span><?= $customerServInfo ?></span>
                </div>
            </div>
        </li>
        */
        ?>
        <li class="safe_info-li remove-li-default-att">
            <div class="img_text_down-wrap">
                <div class="img_text_down-img-div">
                    <div class="img_text_down-img-inner">
                        <img src="<?= self::$DIR_STATIC_FILES ?>return-box.png">
                    </div>
                </div>
                <div class="img_text_down-text-div">
                    <span><?= $deliveryInfo ?></span>
                </div>
            </div>
        </li>
    </ul>
</div>