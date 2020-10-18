<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param $https_webroot https://mydomain.com + webroot
 * @param $dir_email_files https://mydomain.com + webroot + {dir to email files}
 */
/**
 * @var Translator */
$translator = $translator;
// $https_webroot = Configuration::get(Configuration::HTTPS_DOMAIN) . Configuration::getWebRoot();
// $dir_email_files = $this->dir_email_files;
$prod_https_dir = $https_webroot . $dir_prod_files;
$brand = "brand name";
?>

<html>

<head>
    <?= self::FONT_FAM_SPARTAN ?>
    <?= self::FONT_FAM_PT ?>
    <link rel="stylesheet" href="<?= $https_webroot . self::CSS_ELEMENTS ?>">
    <link rel="stylesheet" href="<?= $https_webroot . self::CSS_ROOT ?>">
    <link rel="stylesheet" href="<?= $https_webroot ?>content/css/emailConfirmation.css">
</head>

<body>
    <table class="main_content">
        <tr class="main_content-head main_content-child">
            <td>
                <table class="head_content">
                    <tr>
                        <td class="head_content-brand">
                            <h1><a href="<?= $https_webroot ?>" class="remove-a-default-att" target="_blank"><?= $brand ?></a></h1>
                        </td>
                    </tr>
                    <tr>
                        <td class="">
                            <table class="head_content-picture">
                                <tr>
                                    <td class="nada_20"></td>
                                    <td class="head_content-picture-td">
                                        <img src="<?= $dir_email_files ?>Mama_Bakery.png" alt="order in preparation">
                                    </td>
                                    <td class="nada_20"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="head_content-paragraph">
                                <tr>
                                    <td>
                                        <h1>
                                            <span class="sentence">hi james,</span>
                                            <br>
                                            <span class="sentence">your order is in preparation</span>
                                        </h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="line_height_low">
                                            <span class="sentence">thank</span> you for your confidence.
                                            <span>your order is currently in preparation. </span>
                                            <br>
                                            <span><span class="sentence">you</span> will receive a new message as soon as your order has been shipped. </span>
                                            <br>
                                            <span><span class="sentence">follow</span> the progress of your order <a href="" target="_blank" rel="noopener noreferrer">here</a> at any time.</span>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div class="table_separator-td-space"></div>
                <div class="table_separator-td-space"></div>
                <div class="table_separator-td-space"></div>
            </td>
        </tr>
        <tr>
            <td>
                <table class="main_content_secondary">
                    <tr class="main_content-body main_content-child">
                        <td>
                            <table class="body_content">
                                <tr>
                                    <td>
                                        <table class="body_content-info body_content-child">
                                            <tr>
                                                <td class="body_content-info-address body_content-info-td">
                                                    <h2 class="sentence">john doe</h2>
                                                    <p class="secondary_field_dark">
                                                        2754 Lucy Lane, East Enterprise Indiana, United State 89898
                                                    </p>
                                                </td>
                                                <td class="body_content-info-td">
                                                    <table class="body_content-info-delivery">
                                                        <tr>
                                                            <td>
                                                                <h2 class="delivery_label unbold_field">
                                                                    <span class="sentence">delivery:</span>
                                                                </h2>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h4 class="delivery_date unbold_field secondary_field_dark no_margin">
                                                                    20-22 september
                                                                </h4>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-barre"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="body_content-body body_content-child">
                                            <tr>
                                                <td class="body_content-body-number body_content-body-td">
                                                    <table class="table_default">
                                                        <tr>
                                                            <td>
                                                                <p class="secondary_field_dark"><span class="sentence">number</span> of item:</p>
                                                            </td>
                                                            <td>
                                                                <span>1000</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="table_separator-td-space"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td class="body_content-body-picture body_content-body-td">
                                                                <a href="<?= $https_webroot ?>item/3" target="_blank">
                                                                    <img src="<?= $prod_https_dir ?>picture01.jpeg" alt="name of the product">
                                                                </a>
                                                            </td>
                                                            <td class="body_content-body-td">
                                                                <table class="body_content-body-property">
                                                                    <tr>
                                                                        <td>
                                                                            <h4 class="property-title sentence no_margin">name of the product</h4>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <table class="table_default">
                                                                                <tr>
                                                                                    <td>
                                                                                        <span class="secondary_field_dark">property:</span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span>value</span>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td class="body_content-body-price body_content-body-td">
                                                                <span class="secondary_field_dark price_field">€ 99.90</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-barre"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="body_content-summary body_content-child">
                                            <tr class="body_content-summary-price">
                                                <td class="sentence secondary_field_dark">shipping</td>
                                                <td class="nada_60"></td>
                                                <td class="secondary_field_dark price_field">€ 7.50</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="table_separator-td-space"></div>
                                                </td>
                                            </tr>
                                            <tr class="body_content-summary-price">
                                                <td class="sentence secondary_field_dark">vat</td>
                                                <td class="nada_60"></td>
                                                <td class="secondary_field_dark price_field">€ 12.50</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="table_separator-td-space"></div>
                                                </td>
                                            </tr>
                                            <tr class="body_content-summary-price">
                                                <td class="sentence secondary_field_dark">subtotal</td>
                                                <td class="nada_60"></td>
                                                <td class="secondary_field_dark price_field">€ 145.50</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="table_separator-td-space"></div>
                                                </td>
                                            </tr>
                                            <tr class="body_content-summary-price">
                                                <td class="sentence">total</td>
                                                <td class="nada_60"></td>
                                                <td class="price_field">AUD 15000.50€</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-barre"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                    </td>
                                </tr>
                                <td>
                                    <table class="body_content-footer">
                                        <tr class="body_content-info-button">
                                            <td class="nada_33"></td>
                                            <td>
                                                <div>
                                                    <button class="green-button-reverse standard-button">see my order</button>
                                                </div>
                                            </td>
                                            <td class="nada_33"></td>
                                        </tr>
                                    </table>
                                </td>
                            </table>
                        </td>
                    </tr>
                    <tr class="main_content-footer main_content-child">
                        <td>
                            <table class="footer_content">
                                <tr>
                                    <td>
                                        <div class="table_separator-td-space"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="footer_content-thanks">
                                            <tr>
                                                <td>
                                                    <span class="sentence">thanks,</span>❤️
                                                    <br>
                                                    <span class="sentence"><?= $brand ?></span>'s team
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-barre"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                        <div class="table_separator-td-space"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="footer_content-contact">
                                            <tr>
                                                <td class="footer_content-contact-td">
                                                    <table class="footer_content-contact-support">
                                                        <tr class="footer_content-contact-support-title">
                                                            <td>
                                                                <h3 class="sentence">contact us</h3>
                                                            </td>
                                                        </tr>
                                                        <tr class="support_address mini_text">
                                                            <td>
                                                                <address class="secondary_field_clear sentence">
                                                                    <?= $brand ?> 1640, sint-genesius-rode, flemish brabant Belgium
                                                                </address>
                                                            </td>
                                                        </tr>
                                                        <!-- <tr>
                                                            <td>
                                                                <div class="table_separator-td-space"></div>
                                                            </td>
                                                        </tr> -->
                                                        <tr class="support_unsuscribe">
                                                            <td>
                                                                <table class="table_default mini_text">
                                                                    <tr>
                                                                        <td>
                                                                            <span class="secondary_field_clear">
                                                                                <span class="sentence">changed</span> your mind?:</span>
                                                                        </td>
                                                                        <td>
                                                                            <a href="" target="_blank">unsubscribe</a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="table_separator-td-space"></div>
                                                    <div class="table_separator-td-space"></div>
                                                    <div class="table_separator-td-space"></div>
                                                    <div class="table_separator-td-barre"></div>
                                                    <div class="table_separator-td-space"></div>
                                                    <div class="table_separator-td-space"></div>
                                                    <div class="table_separator-td-space"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="footer_content-contact-td">
                                                    <table class="footer_content-contact-media">
                                                        <tr class="footer_content-contact-media-title">
                                                            <td>
                                                                <h3 class="sentence">social media</h3>
                                                            </td>
                                                        </tr>
                                                        <tr class="footer_content-contact-media-message mini_text">
                                                            <td>
                                                                <p class="secondary_field_clear line_height_low">
                                                                    <span class="sentence">stay</span>
                                                                    up-to-date with current activities and future events or share with us your experience
                                                                    by following us on your favorite social media channels.
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="table_separator-td-space"></div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <table class="footer_content-contact-media-logo">
                                                                    <tr>
                                                                        <td>
                                                                            <a href="" target="_blank">
                                                                                <img src="<?= $dir_email_files ?>facebook2x.png" alt="facebook">
                                                                            </a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="" target="_blank">
                                                                                <img src="<?= $dir_email_files ?>instagram2x.png" alt="instagram">
                                                                            </a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="" target="_blank">
                                                                                <img src="<?= $dir_email_files ?>googleplus2x.png" alt="googleplus">
                                                                            </a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="" target="_blank">
                                                                                <img src="<?= $dir_email_files ?>twitter2x.png" alt="twitter">
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>