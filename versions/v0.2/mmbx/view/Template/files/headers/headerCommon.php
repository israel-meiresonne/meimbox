<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Visitor|User $person the current user
 */
/**
 * @param Visitor|User */
$person = $person;
/*

    <?php
    $file = 'view/Template/files/headers/'.$this->header;
    echo $this->generateFile($file, ["person" => $person]);
    ?>
*/
?>

<header>
    <nav class="navbar-computer">
        <div class="navbar-inner">
            <div class="navbar-block navbar-left-block">
                <ul class="navbar-ul remove-ul-default-att">
                    <li class="navbar-li remove-li-default-att left-block-li site-title">
                        <a href="">meimbox</a>
                    </li>
                </ul>
            </div>

            <div class="navbar-block navbar-center-block">
                <ul class="navbar-ul remove-ul-default-att">
                    <li class="navbar-li remove-li-default-att center-block-li">
                        <div class="grey-tag-button standard-tag-button img-text-block">
                            <div class="img-text-wrap">
                                <div class="img-text-img">
                                    <img src="<?= self::$DIR_STATIC_FILES ?>icons8-pill-yellow-red.png" alt="">
                                </div>
                                <span class="img-text-span">new drop</span>
                            </div>
                        </div>
                    </li>

                    <li class="navbar-li remove-li-default-att center-block-li">
                        <div class="grey-tag-button standard-tag-button img-text-block" onclick="openPopUp('#box_pricing_window', setAddBoxAfter)">
                            <div class="img-text-wrap">
                                <div class="img-text-img">
                                    <img src="<?= self::$DIR_STATIC_FILES ?>icons8-plus-math-96.png" alt="">
                                </div>
                                <span class="img-text-span">add box</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="navbar-block navbar-right-block">
                <ul class="navbar-ul remove-ul-default-att">

                    <?php
                    if ($person->hasCookie(Cookie::COOKIE_CLT)) :
                    ?>
                        <li class="navbar-li remove-li-default-att">
                            <div class="grey-tag-button standard-tag-button img-text-block" onclick="console.log('open client menu')">
                                <div class="img-text-wrap">
                                    <div class="img-text-img">
                                        <img src="<?= self::$DIR_STATIC_FILES ?>icons8-squared-menu-100.png">
                                    </div>
                                    <span class="img-text-span"></span>
                                </div>
                            </div>
                        </li>
                    <?php
                    else :
                    ?>
                        <li class="navbar-li remove-li-default-att">
                            <div class="grey-tag-button standard-tag-button img-text-block" onclick="openPopUp('#sign_form_pop')">
                                <div class="img-text-wrap">
                                    <div class="img-text-img">
                                        <img src="<?= self::$DIR_STATIC_FILES ?>icons8-contacts-96.png">
                                    </div>
                                    <span class="img-text-span"></span>
                                </div>
                            </div>
                        </li>
                    <?php
                    endif;
                    ?>
                    <li class="navbar-li remove-li-default-att">
                        <div class="grey-tag-button standard-tag-button navbar-basket-block" onclick="openPopUp('#basket_pop', getBasketPop)">
                            <div class="img-text-block  navbar-basket-wrap">
                                <div class="img-text-wrap">
                                    <div class="img-text-img">
                                        <img src="<?= self::$DIR_STATIC_FILES ?>icons8-shopping-cart-96.png" alt="">
                                    </div>
                                    <span class="img-text-span basket-logo-span">(<span data-basket="quantity">3</span>)</span>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <nav class="navbar-mobile">
        <div class="navbar-inner">
            <div class="navbar-burger-block navbar-left-block flex-row">
                <div class="burger-container">
                    <input type="checkbox" id="checkbox2" class="checkbox2 visuallyHidden">
                    <label class="burger-label" for="checkbox2">
                        <div class="hamburger hamburger2">
                            <span class="bar bar1"></span>
                            <span class="bar bar2"></span>
                            <span class="bar bar3"></span>
                            <span class="bar bar4"></span>
                        </div>
                    </label>
                </div>
            </div>
            <div class="navbar-title-block navbar-center-block flex-row">
                <div class="site-title">
                    <a href="http://">meimbox</a>
                    <!-- <a href="">xxxxxxx</a> -->
                </div>
            </div>
            <!-- <div class="navbar-new_drop-block">

                    </div> -->
            <div class="navbar-new_drop-add_box-block">
                <div class="grey-tag-button standard-tag-button img-text-block">
                    <div class="img-text-wrap">
                        <div class="img-text-img">
                            <img src="<?= self::$DIR_STATIC_FILES ?>icons8-pill-yellow-red.png" alt="">
                        </div>
                        <span class="img-text-span">new drop</span>
                    </div>
                </div>

                <div class="grey-tag-button standard-tag-button img-text-block" onclick="openPopUp('#box_pricing_window', setAddBoxAfter)">
                    <div class="img-text-wrap">
                        <div class="img-text-img">
                            <img src="<?= self::$DIR_STATIC_FILES ?>icons8-plus-math-96.png" alt="">
                        </div>
                        <span class="img-text-span">add box</span>
                    </div>
                </div>
            </div>

            <div class="navbar-basket-block navbar-right-block flex-row">
                <div class="grey-tag-button standard-tag-button navbar-basket-block" onclick="openPopUp('#basket_pop', getBasketPop)">
                    <!-- <div class="grey-tag-button standard-tag-button navbar-basket-block" onclick="getBasketPop(()=>{openPopUp('#basket_pop')})"> -->
                    <div class="img-text-block">
                        <div class="img-text-wrap">
                            <div class="img-text-img">
                                <img src="<?= self::$DIR_STATIC_FILES ?>icons8-shopping-cart-96.png" alt="">
                            </div>
                            <span class="img-text-span basket-logo-span"><span data-basket="quantity">3</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="collapse-container"></div>
    </nav>
</header>