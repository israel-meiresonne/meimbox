<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Visitor|User $person the current user
 */
/**
 * @param Visitor|User */
$person = $person;
$isLogged = $person->hasCookie(Cookie::COOKIE_CLT);
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
                        <div class="header-button grey-tag-button standard-tag-button img-text-block">
                            <div class="img-text-wrap">
                                <div class="img-text-img">
                                    <img src="<?= self::$DIR_STATIC_FILES ?>icons8-pill-yellow-red.png" alt="">
                                </div>
                                <span class="img-text-span">new drop</span>
                            </div>
                        </div>
                    </li>

                    <li class="navbar-li remove-li-default-att center-block-li">
                        <div class="header-button grey-tag-button standard-tag-button img-text-block" onclick="openPopUp('#box_pricing_window', setAddBoxAfter)">
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
                    if ($isLogged) :
                    ?>
                        <li class="navbar-li remove-li-default-att">
                            <?php
                            $positionMap = new Map();
                            $positionMap->put(self::DIRECTION_TOP, Map::vertical);
                            $positionMap->put(self::DIRECTION_RIGHT, Map::side);
                            $logOutDatas = [
                                "src" => self::$DIR_STATIC_FILES . 'log-out-100.png',
                                "text" => "log out"
                            ];
                            $logOutImg = $this->generateFile('view/view/BasicFiles/ImageTexte.php', $logOutDatas);
                            $homeImgDatas = [
                                "src" => self::$DIR_STATIC_FILES . 'home-144.png',
                                "text" => "menu"
                            ];
                            $homeImg = $this->generateFile('view/view/BasicFiles/ImageTexte.php', $homeImgDatas);
                            $logOutTouch = new Touch($logOutImg, 4, $positionMap);
                            $homeTouch = new Touch($homeImg, 44, $positionMap);
                            $liMap = new Map([$homeTouch, $logOutTouch]);
                            $contentMiniPop = $this->generateFile('view/view/BasicFiles/ulList.php', ["liMap" => $liMap]);
                            $menuPop = new MiniPopUp(self::DIRECTION_BOTTOM, $contentMiniPop);
                            $menuPopId = $menuPop->getId();
                            ?>
                            <div class="header-button grey-tag-button standard-tag-button img-text-block" onclick="openMiniPop('#<?= $menuPopId ?>')">
                                <div class="img-text-wrap">
                                    <div class="img-text-img">
                                        <img src="<?= self::$DIR_STATIC_FILES ?>icons8-squared-menu-100.png">
                                        <?= $menuPop ?>
                                    </div>
                                    <span class="img-text-span"></span>
                                </div>
                            </div>
                        </li>
                    <?php
                    else :
                    ?>
                        <li class="navbar-li remove-li-default-att">
                            <div class="header-button grey-tag-button standard-tag-button img-text-block" onclick="openPopUp('#sign_form_pop')">
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
                                    <span class="img-text-span basket-logo-span"><span data-basket="quantity">3</span></span>
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
                    <!-- <button id="header_burger" class="header_burger remove-button-default-att"> -->
                    <input type="checkbox" id="checkbox2" class="checkbox2 visuallyHidden">
                    <label id="header_burger" class="burger-label" for="checkbox2">
                        <div class="hamburger hamburger2">
                            <span class="bar bar1"></span>
                            <span class="bar bar2"></span>
                            <span class="bar bar3"></span>
                            <span class="bar bar4"></span>
                        </div>
                    </label>
                    <!-- </button> -->
                </div>
            </div>
            <div class="navbar-title-block navbar-center-block flex-row">
                <div class="site-title">
                    <a href="http://">meimbox</a>
                </div>
            </div>
            <!-- <div class="navbar-new_drop-block">

                    </div> -->
            <div class="navbar-new_drop-add_box-block">
                <div class="header-button grey-tag-button standard-tag-button img-text-block">
                    <div class="img-text-wrap">
                        <div class="img-text-img">
                            <img src="<?= self::$DIR_STATIC_FILES ?>icons8-pill-yellow-red.png" alt="">
                        </div>
                        <span class="img-text-span">new drop</span>
                    </div>
                </div>

                <div class="header-button grey-tag-button standard-tag-button img-text-block" onclick="openPopUp('#box_pricing_window', setAddBoxAfter)">
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
    <div class="side_menu back_blur">
        <div class="side_menu_content">
            <div class="side_menu_content-menu_top side_menu_content-childs">
                <div class="menu_top_content">
                    <ul class="menu_top_content-ul remove-ul-default-att">
                        <li class="menu_top_content-li remove-li-default-att">
                            <div class="touch-wrap transition_time">
                                <div class="touch-notif">
                                    <div class="notif-wrap notif_top notif_right">
                                        <div class="notif_content back_blue">
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="touch-content">
                                    <div class="img-text-wrap">
                                        <div class="img-text-img">
                                            <img src="<?= self::$DIR_STATIC_FILES ?>icons8-plus-math-96.png">
                                        </div>
                                        <span class="img-text-span">add box</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="menu_top_content-li remove-li-default-att">
                            <div class="touch-wrap transition_time">
                                <div class="touch-notif">
                                    <div class="notif-wrap notif_top notif_right">
                                        <div class="notif_content back_blue">
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="touch-content">
                                    <div class="img-text-wrap">
                                        <div class="img-text-img">
                                            <img src="<?= self::$DIR_STATIC_FILES ?>icons8-pill-yellow-red.png">
                                        </div>
                                        <span class="img-text-span">new drop</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php
                        if ($isLogged) : ?>
                            <li class="menu_top_content-li remove-li-default-att">
                                <div class="touch-wrap transition_time" onclick="console.log('log out')">
                                    <div class="touch-notif">
                                        <div class="notif-wrap notif_top notif_right">
                                            <div class="notif_content back_blue">
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="touch-content">
                                        <div class="img-text-wrap">
                                            <div class="img-text-img">
                                                <img src="<?= self::$DIR_STATIC_FILES ?>log-out-100.png">
                                            </div>
                                            <span class="img-text-span">log out</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php else : ?>
                            <li class="menu_top_content-li remove-li-default-att">
                                <div class="touch-wrap transition_time" onclick="openPopUp('#sign_form_pop')">
                                    <div class="touch-notif">
                                        <div class="notif-wrap notif_top notif_right">
                                            <div class="notif_content back_blue">
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="touch-content">
                                        <div class="img-text-wrap">
                                            <div class="img-text-img">
                                                <img src="<?= self::$DIR_STATIC_FILES ?>icons8-contacts-96.png">
                                            </div>
                                            <span class="img-text-span">sign up</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endif;
                        if ($isLogged) : ?>
                            <li class="menu_top_content-li remove-li-default-att">
                                <div class="touch-wrap transition_time">
                                    <div class="touch-notif">
                                        <div class="notif-wrap notif_top notif_right">
                                            <div class="notif_content back_blue">
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="touch-content">
                                        <div class="img-text-wrap">
                                            <div class="img-text-img">
                                                <img src="<?= self::$DIR_STATIC_FILES ?>icons8-squared-menu-100.png">
                                            </div>
                                            <span class="img-text-span">menu</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="side_menu_content-menu_bottom side_menu_content-childs">
                <div class="menu_bottom_content">
                    <ul class="menu_bottom_content-ul remove-ul-default-att">
                        <li class="menu_bottom_content-li remove-li-default-att">
                            <div class="touch-wrap transition_time">
                                <div class="touch-notif">
                                    <div class="notif-wrap notif_top notif_right">
                                        <div class="notif_content back_blue">
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="touch-content">
                                    <div class="img-text-wrap">
                                        <div class="img-text-img">
                                            <img src="<?= self::$DIR_STATIC_FILES ?>dashboard-chat-96.png">
                                        </div>
                                        <span class="img-text-span">chat & support</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="menu_bottom_content-li remove-li-default-att">
                            <a href="" target="_blank">about</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>