<?php
$this->title = "checkout";
$this->description = "checkout";

/**
 * @var Translator
 */
$translator = $translator;

/**
 * @var Visitor|Client|Administrator
 */
$person = $this->person;
$language = $person->getLanguage();
$country = $person->getCountry();
$currency = $person->getCurrency();
$measures = $person->getMeasures();
$basket = $person->getBasket();

$this->head = $this->generateFile('view/Checkout/files/head.php', []);
?>

<div class="checkout_page-container">
    <div class="checkout_page-inner">
        <div class="directory-container">
            <div class="directory-wrap">
                <p>checkout</p>
            </div>
        </div>

        <div class="address_summary_cart-container">
            <div class="address_summary_cart-inner">

                <div class="address_connection-block">
                    <div class="address_connection-inner">
                        <div class="connection-container">
                            <div class="signup-block">
                                <div class="signup-wrap">
                                    <div class="connection-title-block signup-title-block">
                                        <div class="connection-title-div">
                                            <span class="connection-title">new member</span>
                                            <div class="connection-title-button-div">
                                                <div class="connection-title-button-div">
                                                    <button class="connection-title-button remove-button-default-att">already registered?</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="hr-summary">
                                    <div class="connection-wrap-inner signup-wrap-inner">
                                        <form class="signup-form-tag">
                                            <div class="signup-sexe-div signup-input-block">

                                                <div class="signup-sexe-inner">
                                                    <div class="connection-input-container signup-input-container">
                                                        <label for="signup_lady" class="checkbox-label">lady
                                                            <input id="signup_lady" type="radio" name="sexe">
                                                            <span class="checkbox-checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="connection-input-container signup-input-container">
                                                        <label for="signup_sir" class="checkbox-label">sir
                                                            <input id="signup_sir" type="radio" name="sexe">
                                                            <span class="checkbox-checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="connection-input-container signup-input-container">
                                                        <label for="signup_other" class="checkbox-label">other
                                                            <input id="signup_other" type="radio" name="sexe">
                                                            <span class="checkbox-checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="signup-sexe-error-div">
                                                    <p class="comment"></p>
                                                </div>

                                            </div>

                                            <div class="signup-name-div signup-50-block  signup-input-block">

                                                <div class="connection-input-container signup-input-container">
                                                    <div class="input-wrap">
                                                        <label class="input-label" for="signup_firstname">first name</label>
                                                        <input id="signup_firstname" class="input-error input-tag" type="text" name="firstname" placeholder="first name" value="">
                                                        <p class="comment"></p>
                                                    </div>
                                                </div>
                                                <div class="connection-input-container signup-input-container">
                                                    <div class="input-wrap">
                                                        <label class="input-label" for="signup_lastname">last name</label>
                                                        <input id="signup_lastname" class="input-tag" type="text" name="lastname" placeholder="last name" value="">
                                                        <p class="comment"></p>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="signup-mail-div signup-input-block">

                                                <div class="connection-input-container signup-input-container">
                                                    <div class="input-wrap">
                                                        <label class="input-label" for="signup_email">email</label>
                                                        <input id="signup_email" class="input-tag" type="email" name="email" placeholder="email" value="">
                                                        <p class="comment"></p>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="signup-password-div signup-50-block  signup-input-block">

                                                <div class="connection-input-container signup-input-container">
                                                    <div class="input-wrap">
                                                        <label class="input-label" for="signup_password">password</label>
                                                        <input id="signup_password" class="input-tag" type="password" name="password" placeholder="password" value="">
                                                        <p class="comment"></p>
                                                    </div>
                                                </div>
                                                <div class="connection-input-container signup-input-container">
                                                    <div class="input-wrap">
                                                        <label class="input-label" for="signup_password_confirmation">password confirmation</label>
                                                        <input id="signup_password_confirmation" class="input-tag" type="password" name="password_confirmation" placeholder="password confirmation" value="">
                                                        <p class="comment"></p>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="signup-paperwork-div signup-50-block  signup-input-block">

                                                <div class="connection-input-container signup-input-container">
                                                    <div class="connection-chcekbox-div">
                                                        <label for="signup_terme" class="checkbox-label">I confirm that I have read and I agree to
                                                            I&Meim's terms and conditions including
                                                            its privacy notice.
                                                            <input id="signup_terme" type="checkbox" name="terme">
                                                            <span class="checkbox-checkmark"></span>
                                                            <p class="comment"></p>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="connection-input-container signup-input-container">
                                                    <div class="connection-chcekbox-div">
                                                        <label for="signup_newsletter" class="checkbox-label">Sign up for newsletter
                                                            <input id="signup_newsletter" class="newletter-input" type="checkbox" name="newsletter">
                                                            <span class="checkbox-checkmark"></span>
                                                            <div class="connection-checkbox-text-div">
                                                                By subscribing to I&Meim’s newsletter, I understand
                                                                and accept to receive emails from I&Meim’s with the
                                                                latest deals, sales, and updates by multiple form of
                                                                communication like email, phone and/or post.
                                                            </div>
                                                            <p class="comment"></p>
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="login-block">
                                <div class="login-wrap">
                                    <div class="connection-title-block signup-title-block">
                                        <div class="connection-title-div">
                                            <span class="connection-title">log in</span>
                                            <div class="connection-title-button-div">
                                                <div class="connection-title-button-div">
                                                    <button class="connection-title-button remove-button-default-att">new member?</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="hr-summary">
                                    <div class="connection-wrap-inner login-wrap-inner">
                                        <form class="login-form-tag">
                                            <div class="login-mail-password-div login-input-block">
                                                <div class="connection-input-container">
                                                    <div class="input-wrap">
                                                        <label class="input-label" for="login_email">email</label>
                                                        <input id="login_email" class="input-tag" type="email" name="email" placeholder="email" value="">
                                                        <p class="comment"></p>
                                                    </div>
                                                </div>
                                                <div class="connection-input-container">
                                                    <div class="input-wrap">
                                                        <label class="input-label" for="login_password">password</label>
                                                        <input id="login_password" class="input-tag" type="password" name="password" placeholder="password" value="">
                                                        <p class="comment"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="login-password-div  login-input-block">
                                            </div>
                                            <div class="login-remember-forgot-div login-input-block">
                                                <div class="connection-input-container login-remember-block">
                                                    <div class="connection-chcekbox-div">
                                                        <label for="login_remember" class="checkbox-label">remember me
                                                            <input id="login_remember" type="checkbox" name="remember">
                                                            <span class="checkbox-checkmark"></span>
                                                            <p class="comment"></p>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="connection-input-container login-forgot-block">
                                                    <a href="" target="_blank">forgot password</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="address-container">
                            <div class="form-wrap">
                                <div class="form-title-block address-title-block">
                                    <div class="form-title-div">
                                        <span class="form-title">shipping address</span>
                                    </div>
                                </div>
                                <hr class="hr-summary">
                                <div class="form-wrap-inner address-wrap-inner">
                                    <form class="address-form-tag">
                                        <div class="form-input-block form-double-input-block">
                                            <div class="form-input-container">
                                                <div class="input-wrap">
                                                    <label class="input-label" for="address_address">address</label>
                                                    <input id="address_address" class="input-error input-tag" type="text" name="address" placeholder="address" value="">
                                                    <p class="comment"></p>
                                                </div>
                                            </div>
                                            <div class="form-input-container">
                                                <div class="input-wrap">
                                                    <label class="input-label" for="address_appartement">apartment, suite, etc. (optional)</label>
                                                    <input id="address_appartement" class="input-tag" type="text" name="appartement" placeholder="apartment, suite, etc. (optional)" value="">
                                                    <p class="comment"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-input-block form-double-input-block">
                                            <div class="form-input-container">
                                                <div class="input-wrap">
                                                    <label class="input-label" for="address_province">state, province, region etc...</label>
                                                    <input id="address_province" class="input-error input-tag" type="text" name="province" placeholder="state, province, region etc..." value="">
                                                    <p class="comment"></p>
                                                </div>
                                            </div>
                                            <div class="form-input-container">
                                                <div class="input-wrap">
                                                    <label class="input-label" for="address_city">city</label>
                                                    <input id="address_city" class="input-tag" type="text" name="city" placeholder="city" value="">
                                                    <p class="comment"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-input-block form-double-input-block">
                                            <div class="form-input-container">
                                                <div class="form-input-dropdown-container">
                                                    <div class="dropdown-wrap">
                                                        <div class="dropdown-inner">
                                                            <div class="dropdown-head dropdown-arrow-close">
                                                                <span class="dropdown-title">country</span>
                                                            </div>
                                                            <div class="dropdown-checkbox-list">
                                                                <div class="dropdown-checkbox-block">
                                                                    <label class="checkbox-label">belgium
                                                                        <input type="radio" name="country">
                                                                        <span class="checkbox-checkmark"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="dropdown-checkbox-block">
                                                                    <label class="checkbox-label">france
                                                                        <input type="radio" name="country">
                                                                        <span class="checkbox-checkmark"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="dropdown-checkbox-block">
                                                                    <label class="checkbox-label">switzerland
                                                                        <input type="radio" name="country">
                                                                        <span class="checkbox-checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="comment"></p>
                                                </div>
                                            </div>
                                            <div class="form-input-container">
                                                <div class="input-wrap">
                                                    <label class="input-label" for="address_zipcode">postal code</label>
                                                    <input id="address_zipcode" class="input-tag" type="text" name="zipcode" placeholder="postal code" value="">
                                                    <p class="comment"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-input-block form-simple-input-block">
                                            <div class="form-input-container">
                                                <div class="input-wrap">
                                                    <label class="input-label" for="address_phone">phone</label>
                                                    <input id="address_phone" class="input-tag" type="tel" name="phone" placeholder="phone" value="">
                                                    <p class="comment"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="payement-div">
                            <div class="summary-detail-button-div">
                                <div class="summary-detail-button-inner">
                                    <button class="green-button standard-button remove-button-default-att">checkout</button>
                                </div>
                            </div>
                            <div class="summary-detail-safe_info-div">
                                <div class="summary-detail-safe_info-inner">
                                    <div class="safe_info-wrap">
                                        <ul class="safe_info-ul remove-ul-default-att">
                                            <li class="safe_info-li remove-li-default-att">
                                                <div class="img_text_down-wrap">
                                                    <div class="img_text_down-img-div">
                                                        <div class="img_text_down-img-inner">
                                                            <img src="<?= self::DIR_STATIC_FILES ?>icons8-card-security-150.png">
                                                        </div>
                                                    </div>
                                                    <div class="img_text_down-text-div">
                                                        <span>3D secure & <br>SSL encrypted payement</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="safe_info-li remove-li-default-att">
                                                <div class="img_text_down-wrap">
                                                    <div class="img_text_down-img-div">
                                                        <div class="img_text_down-img-inner">
                                                            <img src="<?= self::DIR_STATIC_FILES ?>icons8-headset-96.png">
                                                        </div>
                                                    </div>
                                                    <div class="img_text_down-text-div">
                                                        <span>customer service 24h/7 <br> response in 1h</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="safe_info-li remove-li-default-att">
                                                <div class="img_text_down-wrap">
                                                    <div class="img_text_down-img-div">
                                                        <div class="img_text_down-img-inner">
                                                            <img src="<?= self::DIR_STATIC_FILES ?>return-box.png">
                                                        </div>
                                                    </div>
                                                    <div class="img_text_down-text-div">
                                                        <span>free & <br>easy return</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="safe_info-li remove-li-default-att">
                                                <div class="img_text_down-wrap">
                                                    <div class="img_text_down-img-div">
                                                        <div class="img_text_down-img-inner">
                                                            <img src="<?= self::DIR_STATIC_FILES ?>icons8-van-96.png">
                                                        </div>
                                                    </div>
                                                    <div class="img_text_down-text-div">
                                                        <span>Track your<br> orders online</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="summary-detail-collapse-div">
                                <div class="summary-detail-collapse-inner">
                                    <div class="collapse-wrap">
                                        <ul class="remove-ul-default-att">
                                            <li class="remove-li-default-att">
                                                <div class="collapse-div">
                                                    <div class="collapse-title-div">
                                                        <div class="collapse-title">contact us</div>
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
                                                            <ul class="contact-ul remove-ul-default-att">
                                                                <li class="contact-li remove-li-default-att">

                                                                    <div class="img-text-wrap">
                                                                        <div class="img-text-img">
                                                                            <img src="<?= self::DIR_STATIC_FILES ?>icons8-phone-100.png">
                                                                        </div>
                                                                        <span class="img-text-span">+472 13 13 24</span>
                                                                    </div>
                                                                </li>
                                                                <li class="contact-li remove-li-default-att">

                                                                    <div class="img-text-wrap">
                                                                        <div class="img-text-img">
                                                                            <img src="<?= self::DIR_STATIC_FILES ?>icons8-secured-letter-100.png">
                                                                        </div>
                                                                        <span class="img-text-span">email@monsite.com</span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="remove-li-default-att">
                                                <div class="collapse-div">
                                                    <div class="collapse-title-div">
                                                        <div class="collapse-title">payement options</div>
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
                                                            <ul class="payement-ul remove-ul-default-att">
                                                                <li class="payement-li remove-li-default-att">
                                                                    <div class="img-text-wrap">
                                                                        <div class="img-text-img">
                                                                            <img src="<?= self::DIR_STATIC_FILES ?>visa-logo.png">
                                                                        </div>
                                                                        <span class="img-text-span">visa</span>
                                                                    </div>
                                                                </li>
                                                                <li class="payement-li remove-li-default-att">
                                                                    <div class="img-text-wrap">
                                                                        <div class="img-text-img">
                                                                            <img src="<?= self::DIR_STATIC_FILES ?>apple-pay-logo.png">
                                                                        </div>
                                                                        <span class="img-text-span">pay</span>
                                                                    </div>
                                                                </li>
                                                                <li class="payement-li remove-li-default-att">
                                                                    <div class="img-text-wrap">
                                                                        <div class="img-text-img">
                                                                            <img src="<?= self::DIR_STATIC_FILES ?>paypal.png">
                                                                        </div>
                                                                        <span class="img-text-span">paypal</span>
                                                                    </div>
                                                                </li>
                                                                <li class="payement-li remove-li-default-att">
                                                                    <div class="img-text-wrap">
                                                                        <div class="img-text-img">
                                                                            <img src="<?= self::DIR_STATIC_FILES ?>master-card.png">
                                                                        </div>
                                                                        <span class="img-text-span">masterCard</span>
                                                                    </div>
                                                                </li>
                                                                <li class="payement-li remove-li-default-att">
                                                                    <div class="img-text-wrap">
                                                                        <div class="img-text-img">
                                                                            <img src="<?= self::DIR_STATIC_FILES ?>maestro.png">
                                                                        </div>
                                                                        <span class="img-text-span">maestro</span>
                                                                    </div>
                                                                </li>
                                                                <li class="payement-li remove-li-default-att">
                                                                    <div class="img-text-wrap">
                                                                        <div class="img-text-img">
                                                                            <img src="<?= self::DIR_STATIC_FILES ?>amex.png">
                                                                        </div>
                                                                        <span class="img-text-span">american express</span>
                                                                    </div>
                                                                </li>
                                                            </ul>
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
                <div class="summary_cart-block">
                    <div class="summary_cart-inner">
                        <div class="cart-block">
                            <div class="cart-inner">
                                <div class="form-title-block cart-title-block">
                                    <div class="form-title-div">
                                        <span class="form-title">cart</span>
                                    </div>
                                    <div class="summary-detail-arrow-button-div">
                                        <div class="arrow-element-container">
                                            <div class="arrow-element-wrap">
                                                <span class="arrow-span"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="checkout_cart">
                                    <hr class="hr-summary">
                                    <?php
                                    $boxDatas = [
                                        "containerId" => "checkout_cart",
                                        "elements" => $basket->getMerge(),
                                        "country" => $country,
                                        "currency" => $currency,
                                    ];
                                    echo $cart = $this->generateFile('view/elements/cart.php', $boxDatas);
                                    ?>
                                    <!-- <div class="cart-wrap">
                                        <hr class="hr-summary">
                                        <ul class="cart-ul remove-ul-default-att">
                                            <li class="li-cart-element-container remove-li-default-att">
                                                <div class="basket_product-wrap">
                                                    <div class="cart-element-wrap">
                                                        <div class="cart-element-inner">

                                                            <div class="cart-element-detail-block">
                                                                <div class="cart-element-img-div">
                                                                    <img src="outside/brain/prod/picture01.jpeg">
                                                                </div>
                                                                <div class="cart-element-property-set">
                                                                    <div class="cart-element-property-div">
                                                                        <span>essential double coat</span>
                                                                    </div>
                                                                    <div class="cart-element-property-div">
                                                                        <span class="cart-element-property">color: </span>
                                                                        <span class="cart-element-value" style="color: #AF3134;">red</span>
                                                                    </div>
                                                                    <div class="cart-element-property-div">
                                                                        <span class="cart-element-property">size: </span>
                                                                        <span class="cart-element-value">s</span>
                                                                    </div>
                                                                    <div class="cart-element-property-div">
                                                                        <span class="cart-element-property">quantity: </span>
                                                                        <span class="cart-element-value">2</span>
                                                                    </div>
                                                                    <div class="cart-element-property-div cart-element-property-price-div">
                                                                        <span class="cart-element-property">price: </span>
                                                                        <span class="cart-element-value">$52.50 usd</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="cart-element-price-block">
                                                                <div class="cart-element-price-inner">
                                                                    <span>$52.50 usd</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="li-cart-element-container remove-li-default-att">
                                                <div class="box-wrap">
                                                    <div class="box-display-block">
                                                        <div class="cart-element-wrap">
                                                            <div class="cart-element-inner">

                                                                <div class="cart-element-detail-block">
                                                                    <div class="cart-element-img-div">
                                                                        <img src="<?= self::DIR_STATIC_FILES ?>box-gold-128.png">
                                                                    </div>
                                                                    <div class="cart-element-property-set box-property-set">
                                                                        <div class="box-property-set-inner">
                                                                            <div class="cart-element-property-div">
                                                                                <span>golden box</span>
                                                                            </div>
                                                                            <div class="cart-element-property-div">
                                                                                <span class="cart-element-property">item: </span>
                                                                                <span class="cart-element-value">3</span>
                                                                            </div>
                                                                            <div class="cart-element-property-div cart-element-property-price-div">
                                                                                <span class="cart-element-property">price: </span>
                                                                                <span class="cart-element-value">$52.50 usd</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="cart-element-price-block">
                                                                    <div class="cart-element-price-inner">
                                                                        <span>$52.50 usd</span>
                                                                    </div>
                                                                </div>

                                                                <div class="cart-element-arrow-block">
                                                                    <div class="cart-element-arrow-inner">
                                                                        <button class="cart-element-arrow-button remove-button-default-att">
                                                                            <div class="arrow-element-wrap">
                                                                                <span class="arrow-span"></span>
                                                                            </div>
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="box-product-set">
                                                        <ul class="box-product-set-ul remove-ul-default-att">
                                                            <li class="box-product-set-li remove-li-default-att">

                                                                <div class="box_product-wrap">
                                                                    <div class="cart-element-wrap">
                                                                        <div class="cart-element-inner">

                                                                            <div class="cart-element-detail-block">
                                                                                <div class="cart-element-img-div">
                                                                                    <img src="outside/brain/prod/picture01.jpeg">
                                                                                </div>
                                                                                <div class="cart-element-property-set">
                                                                                    <div class="cart-element-property-div">
                                                                                        <span>essential double coat</span>
                                                                                    </div>
                                                                                    <div class="cart-element-property-div">
                                                                                        <span class="cart-element-property">color: </span>
                                                                                        <span class="cart-element-value" style="color: #AF3134;">red</span>
                                                                                    </div>
                                                                                    <div class="cart-element-property-div">
                                                                                        <span class="cart-element-property">size: </span>
                                                                                        <span class="cart-element-value">s</span>
                                                                                    </div>
                                                                                    <div class="cart-element-property-div">
                                                                                        <span class="cart-element-property">quantity: </span>
                                                                                        <span class="cart-element-value">2</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </li>
                                                            <li class="box-product-set-li remove-li-default-att">

                                                                <div class="box_product-wrap">
                                                                    <div class="cart-element-wrap">
                                                                        <div class="cart-element-inner">

                                                                            <div class="cart-element-detail-block">
                                                                                <div class="cart-element-img-div">
                                                                                    <img src="outside/brain/prod/picture01.jpeg">
                                                                                </div>
                                                                                <div class="cart-element-property-set">
                                                                                    <div class="cart-element-property-div">
                                                                                        <span>essential double coat</span>
                                                                                    </div>
                                                                                    <div class="cart-element-property-div">
                                                                                        <span class="cart-element-property">color: </span>
                                                                                        <span class="cart-element-value" style="color: #AF3134;">red</span>
                                                                                    </div>
                                                                                    <div class="cart-element-property-div">
                                                                                        <span class="cart-element-property">size: </span>
                                                                                        <span class="cart-element-value">s</span>
                                                                                    </div>
                                                                                    <div class="cart-element-property-div">
                                                                                        <span class="cart-element-property">quantity: </span>
                                                                                        <span class="cart-element-value">2</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </li>
                                                            <li class="box-product-set-li remove-li-default-att">

                                                                <div class="box_product-wrap">
                                                                    <div class="cart-element-wrap">
                                                                        <div class="cart-element-inner">

                                                                            <div class="cart-element-detail-block">
                                                                                <div class="cart-element-img-div">
                                                                                    <img src="outside/brain/prod/picture01.jpeg">
                                                                                </div>
                                                                                <div class="cart-element-property-set">
                                                                                    <div class="cart-element-property-div">
                                                                                        <span>essential double coat</span>
                                                                                    </div>
                                                                                    <div class="cart-element-property-div">
                                                                                        <span class="cart-element-property">color: </span>
                                                                                        <span class="cart-element-value" style="color: #AF3134;">red</span>
                                                                                    </div>
                                                                                    <div class="cart-element-property-div">
                                                                                        <span class="cart-element-property">size: </span>
                                                                                        <span class="cart-element-value">s</span>
                                                                                    </div>
                                                                                    <div class="cart-element-property-div">
                                                                                        <span class="cart-element-property">quantity: </span>
                                                                                        <span class="cart-element-value">2</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </li>
                                                        </ul>
                                                    </div>

                                                </div>
                                            </li>

                                            <li class="li-cart-element-container remove-li-default-att">
                                                <div class="box-wrap">
                                                    <div class="box-display-block">
                                                        <div class="cart-element-wrap">
                                                            <div class="cart-element-inner">

                                                                <div class="cart-element-detail-block">
                                                                    <div class="cart-element-img-div">
                                                                        <img src="<?= self::DIR_STATIC_FILES ?>box-gold-128.png">
                                                                    </div>
                                                                    <div class="cart-element-property-set box-property-set">
                                                                        <div class="box-property-set-inner">
                                                                            <div class="cart-element-property-div">
                                                                                <span>golden box</span>
                                                                            </div>
                                                                            <div class="cart-element-property-div">
                                                                                <span class="cart-element-property">item: </span>
                                                                                <span class="cart-element-value">3</span>
                                                                            </div>
                                                                            <div class="cart-element-property-div cart-element-property-price-div">
                                                                                <span class="cart-element-property">price: </span>
                                                                                <span class="cart-element-value">$52.50 usd</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="cart-element-price-block">
                                                                    <div class="cart-element-price-inner">
                                                                        <span>$52.50 usd</span>
                                                                    </div>
                                                                </div>

                                                                <div class="cart-element-arrow-block">
                                                                    <div class="cart-element-arrow-inner">
                                                                        <button class="cart-element-arrow-button remove-button-default-att">
                                                                            <div class="arrow-element-wrap">
                                                                                <span class="arrow-span"></span>
                                                                            </div>
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="box-product-set">
                                                        <ul class="box-product-set-ul remove-ul-default-att">
                                                            <li class="box-product-set-li remove-li-default-att">
                                                                <div class="box_product-wrap">
                                                                    <div class="cart-element-wrap">
                                                                        <div class="cart-element-inner">

                                                                            <div class="cart-element-detail-block">
                                                                                <div class="cart-element-img-div">
                                                                                    <img src="outside/brain/prod/picture01.jpeg">
                                                                                </div>
                                                                                <div class="cart-element-property-set">
                                                                                    <div class="cart-element-property-div">
                                                                                        <span>essential double coat</span>
                                                                                    </div>
                                                                                    <div class="cart-element-property-div">
                                                                                        <span class="cart-element-property">color: </span>
                                                                                        <span class="cart-element-value" style="color: #AF3134;">red</span>
                                                                                    </div>
                                                                                    <div class="cart-element-property-div">
                                                                                        <span class="cart-element-property">size: </span>
                                                                                        <span class="cart-element-value">s</span>
                                                                                    </div>
                                                                                    <div class="cart-element-property-div">
                                                                                        <span class="cart-element-property">quantity: </span>
                                                                                        <span class="cart-element-value">2</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </li>
                                                            <li class="box-product-set-li remove-li-default-att">

                                                                <div class="box_product-wrap">
                                                                    <div class="cart-element-wrap">
                                                                        <div class="cart-element-inner">

                                                                            <div class="cart-element-detail-block">
                                                                                <div class="cart-element-img-div">
                                                                                    <img src="outside/brain/prod/picture01.jpeg">
                                                                                </div>
                                                                                <div class="cart-element-property-set">
                                                                                    <div class="cart-element-property-div">
                                                                                        <span>essential double coat</span>
                                                                                    </div>
                                                                                    <div class="cart-element-property-div">
                                                                                        <span class="cart-element-property">color: </span>
                                                                                        <span class="cart-element-value" style="color: #AF3134;">red</span>
                                                                                    </div>
                                                                                    <div class="cart-element-property-div">
                                                                                        <span class="cart-element-property">size: </span>
                                                                                        <span class="cart-element-value">s</span>
                                                                                    </div>
                                                                                    <div class="cart-element-property-div">
                                                                                        <span class="cart-element-property">quantity: </span>
                                                                                        <span class="cart-element-value">2</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </li>
                                                            <li class="box-product-set-li remove-li-default-att">

                                                                <div class="box_product-wrap">
                                                                    <div class="cart-element-wrap">
                                                                        <div class="cart-element-inner">

                                                                            <div class="cart-element-detail-block">
                                                                                <div class="cart-element-img-div">
                                                                                    <img src="outside/brain/prod/picture01.jpeg">
                                                                                </div>
                                                                                <div class="cart-element-property-set">
                                                                                    <div class="cart-element-property-div">
                                                                                        <span>essential double coat</span>
                                                                                    </div>
                                                                                    <div class="cart-element-property-div">
                                                                                        <span class="cart-element-property">color: </span>
                                                                                        <span class="cart-element-value" style="color: #AF3134;">red</span>
                                                                                    </div>
                                                                                    <div class="cart-element-property-div">
                                                                                        <span class="cart-element-property">size: </span>
                                                                                        <span class="cart-element-value">s</span>
                                                                                    </div>
                                                                                    <div class="cart-element-property-div">
                                                                                        <span class="cart-element-property">quantity: </span>
                                                                                        <span class="cart-element-value">2</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </li>
                                                        </ul>
                                                    </div>

                                                </div>
                                            </li>

                                        </ul>
                                    </div> -->
                                </div>
                            </div>
                            <hr class="hr-summary">
                            <div class="cart-discount-block">
                                <div class="form-title-block discount-title-block">
                                    <div class="form-title-div">
                                        <span class="form-title">discount codes</span>
                                    </div>
                                    <div class="summary-detail-arrow-button-div">
                                        <div class="arrow-element-container">
                                            <div class="arrow-element-wrap">
                                                <span class="arrow-span"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="discount_body" class="cart-discount-inner">
                                    <hr class="hr-summary">
                                    <div class="cart-discount-input-block">
                                        <div class="input_button_left-wrap">
                                            <div class="input_button_left-intput-block">
                                                <div class="input-wrap">
                                                    <label class="input-label" for="cart_discount">discount code</label>
                                                    <input id="cart_discount" class="input-tag" type="text" name="discount" placeholder="discount code" value="">
                                                    <p class="comment"></p>
                                                </div>
                                            </div>
                                            <div class="input_button_left-button-block">
                                                <button class="green-button standard-button remove-button-default-att">apply</button>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="hr-summary">


                                    <div class="sticker-set">

                                        <div class="sticker-container">
                                            <div class="sticker-wrap">
                                                <div class="sticker-content-div">jackets</div>
                                                <button class="sticker-button remove-button-default-att">
                                                    <span class="sticker-x-left"></span>
                                                    <span class="sticker-x-right"></span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="sticker-container">
                                            <div class="sticker-wrap">
                                                <div class="sticker-content-div">jackets</div>
                                                <button class="sticker-button remove-button-default-att">
                                                    <span class="sticker-x-left"></span>
                                                    <span class="sticker-x-right"></span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="sticker-container">
                                            <div class="sticker-wrap">
                                                <div class="sticker-content-div">jackets</div>
                                                <button class="sticker-button remove-button-default-att">
                                                    <span class="sticker-x-left"></span>
                                                    <span class="sticker-x-right"></span>
                                                </button>
                                            </div>
                                        </div>


                                        <div class="sticker-container">
                                            <div class="sticker-wrap">
                                                <div class="sticker-content-div">jackets</div>
                                                <button class="sticker-button remove-button-default-att">
                                                    <span class="sticker-x-left"></span>
                                                    <span class="sticker-x-right"></span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="sticker-container">
                                            <div class="sticker-wrap">
                                                <div class="sticker-content-div">jackets</div>
                                                <button class="sticker-button remove-button-default-att">
                                                    <span class="sticker-x-left"></span>
                                                    <span class="sticker-x-right"></span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="sticker-container">
                                            <div class="sticker-wrap">
                                                <div class="sticker-content-div">jackets</div>
                                                <button class="sticker-button remove-button-default-att">
                                                    <span class="sticker-x-left"></span>
                                                    <span class="sticker-x-right"></span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="sticker-container">
                                            <div class="sticker-wrap">
                                                <div class="sticker-content-div">jackets</div>
                                                <button class="sticker-button remove-button-default-att">
                                                    <span class="sticker-x-left"></span>
                                                    <span class="sticker-x-right"></span>
                                                </button>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="summary-block">
                            <?php
                            $datas = [
                                "basket" => $basket,
                                "country" => $country,
                            ];
                            echo $this->generateFile('view/Checkout/files/orderSummary.php', $datas);
                            ?>
                            <!-- <div class="summary-wrap">
                                <div class="summary-detail-block">
                                    <div class="summary-detail-title-block">
                                        <div class="summary-detail-title-div">
                                            <span class="summary-title">Order Summary</span>
                                        </div>
                                        <div class="summary-detail-arrow-button-div">
                                            <div class="arrow-element-container">
                                                <div class="arrow-element-wrap">
                                                    <span class="arrow-span"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="summary-detail-inner">
                                        <hr class="hr-summary">
                                        <div class="summary-detail-property-div">
                                            <ul class="summary-detail-property-lu remove-ul-default-att">
                                                <li class="summary-detail-property-li remove-li-default-att">
                                                    <div class="data-key_value-opposite-wrap">
                                                        <span class="data-key_value-key">total: </span>
                                                        <span class="data-key_value-value">$82.09 usd</span>
                                                    </div>
                                                </li>
                                                <li class="summary-detail-property-li remove-li-default-att">
                                                    <div class="summary-detail-property-shipping-div">
                                                        <div class="summary-detail-property-shipping-div">
                                                            <div class="data-key_value-opposite-wrap">
                                                                <span class="data-key_value-key">shipping: </span>
                                                                <span class="data-key_value-value" style="text-transform:initial;">(Select a country)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="summary-detail-property-li remove-li-default-att">
                                                    <div class="data-key_value-opposite-wrap">
                                                        <span class="data-key_value-key">
                                                            <span style="text-transform: uppercase;">VAT</span>
                                                            <span style="text-transform: lowercase">(included): </span>
                                                        </span>
                                                        <span class="data-key_value-value">$14.25 usd</span>
                                                    </div>
                                                </li>
                                                <li class="summary-detail-property-li remove-li-default-att">
                                                    <div class="data-key_value-opposite-wrap">
                                                        <span class="data-key_value-key">subtotal: </span>
                                                        <span class="data-key_value-value">$82.09 usd</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="summary-detail-button-div">
                                            <div class="summary-detail-button-inner">
                                                <button class="green-button standard-button remove-button-default-att">checkout</button>
                                            </div>
                                        </div>

                                        <div class="summary-detail-safe_info-div">
                                            <div class="summary-detail-safe_info-inner">
                                                <div class="safe_info-wrap">
                                                    <ul class="safe_info-ul remove-ul-default-att">
                                                        <li class="safe_info-li remove-li-default-att">
                                                            <div class="img_text_down-wrap">
                                                                <div class="img_text_down-img-div">
                                                                    <div class="img_text_down-img-inner">
                                                                        <img src="<?= self::DIR_STATIC_FILES ?>icons8-card-security-150.png">
                                                                    </div>
                                                                </div>
                                                                <div class="img_text_down-text-div">
                                                                    <span>3D secure & <br>SSL encrypted payement</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="safe_info-li remove-li-default-att">
                                                            <div class="img_text_down-wrap">
                                                                <div class="img_text_down-img-div">
                                                                    <div class="img_text_down-img-inner">
                                                                        <img src="<?= self::DIR_STATIC_FILES ?>icons8-headset-96.png">
                                                                    </div>
                                                                </div>
                                                                <div class="img_text_down-text-div">
                                                                    <span>customer service 24h/7 <br> response in 1h</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="safe_info-li remove-li-default-att">
                                                            <div class="img_text_down-wrap">
                                                                <div class="img_text_down-img-div">
                                                                    <div class="img_text_down-img-inner">
                                                                        <img src="<?= self::DIR_STATIC_FILES ?>return-box.png">
                                                                    </div>
                                                                </div>
                                                                <div class="img_text_down-text-div">
                                                                    <span>free & <br>easy return</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="safe_info-li remove-li-default-att">
                                                            <div class="img_text_down-wrap">
                                                                <div class="img_text_down-img-div">
                                                                    <div class="img_text_down-img-inner">
                                                                        <img src="<?= self::DIR_STATIC_FILES ?>icons8-van-96.png">
                                                                    </div>
                                                                </div>
                                                                <div class="img_text_down-text-div">
                                                                    <span>Track your<br> orders online</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="summary-detail-collapse-div">
                                            <div class="summary-detail-collapse-inner">

                                                <div class="collapse-wrap">
                                                    <ul class="remove-ul-default-att">
                                                        <li class="remove-li-default-att">

                                                            <div class="collapse-div">
                                                                <div class="collapse-title-div">
                                                                    <div class="collapse-title">contact us</div>
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

                                                                        <ul class="contact-ul remove-ul-default-att">
                                                                            <li class="contact-li remove-li-default-att">

                                                                                <div class="img-text-wrap">
                                                                                    <div class="img-text-img">
                                                                                        <img src="<?= self::DIR_STATIC_FILES ?>icons8-phone-100.png">
                                                                                    </div>
                                                                                    <span class="img-text-span">+472 13 13 24</span>
                                                                                </div>

                                                                            </li>
                                                                            <li class="contact-li remove-li-default-att">

                                                                                <div class="img-text-wrap">
                                                                                    <div class="img-text-img">
                                                                                        <img src="<?= self::DIR_STATIC_FILES ?>icons8-secured-letter-100.png">
                                                                                    </div>
                                                                                    <span class="img-text-span">email@monsite.com</span>
                                                                                </div>

                                                                            </li>
                                                                        </ul>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </li>
                                                        <li class="remove-li-default-att">
                                                            <div class="collapse-div">
                                                                <div class="collapse-title-div">
                                                                    <div class="collapse-title">payement options</div>
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
                                                                        <ul class="payement-ul remove-ul-default-att">
                                                                            <li class="payement-li remove-li-default-att">
                                                                                <div class="img-text-wrap">
                                                                                    <div class="img-text-img">
                                                                                        <img src="<?= self::DIR_STATIC_FILES ?>visa-logo.png">
                                                                                    </div>
                                                                                    <span class="img-text-span">visa</span>
                                                                                </div>
                                                                            </li>
                                                                            <li class="payement-li remove-li-default-att">
                                                                                <div class="img-text-wrap">
                                                                                    <div class="img-text-img">
                                                                                        <img src="<?= self::DIR_STATIC_FILES ?>apple-pay-logo.png">
                                                                                    </div>
                                                                                    <span class="img-text-span">pay</span>
                                                                                </div>
                                                                            </li>
                                                                            <li class="payement-li remove-li-default-att">
                                                                                <div class="img-text-wrap">
                                                                                    <div class="img-text-img">
                                                                                        <img src="<?= self::DIR_STATIC_FILES ?>paypal.png">
                                                                                    </div>
                                                                                    <span class="img-text-span">paypal</span>
                                                                                </div>
                                                                            </li>
                                                                            <li class="payement-li remove-li-default-att">
                                                                                <div class="img-text-wrap">
                                                                                    <div class="img-text-img">
                                                                                        <img src="<?= self::DIR_STATIC_FILES ?>master-card.png">
                                                                                    </div>
                                                                                    <span class="img-text-span">masterCard</span>
                                                                                </div>
                                                                            </li>
                                                                            <li class="payement-li remove-li-default-att">
                                                                                <div class="img-text-wrap">
                                                                                    <div class="img-text-img">
                                                                                        <img src="<?= self::DIR_STATIC_FILES ?>maestro.png">
                                                                                    </div>
                                                                                    <span class="img-text-span">maestro</span>
                                                                                </div>
                                                                            </li>
                                                                            <li class="payement-li remove-li-default-att">
                                                                                <div class="img-text-wrap">
                                                                                    <div class="img-text-img">
                                                                                        <img src="<?= self::DIR_STATIC_FILES ?>amex.png">
                                                                                    </div>
                                                                                    <span class="img-text-span">american express</span>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
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

                            </div> -->
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>