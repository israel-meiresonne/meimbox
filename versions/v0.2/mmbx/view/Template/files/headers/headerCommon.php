<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param Visitor|User $person the current user
 */

/**
 * @var Visitor|User */
$person = $person;
$nbBasket = $person->getBasket()->getQuantity();
$isLogged = $person->hasCookie(Cookie::COOKIE_CLT);
$company = new Map(Configuration::getFromJson(Configuration::JSON_KEY_COMPANY));
$brandName = strtoupper($company->get(Map::brand));
// $homeLink = ControllerSecure::extractController(ControllerHome::class);
$homeLink = "";
$gridLink = ControllerSecure::extractController(ControllerGrid::class);

// $TagAddBoxFunc = "onclick=\"openPopUp('#box_pricing_window', setAddBoxAfter);\"";
$TagAddBoxFunc_sideMenu = "onclick=\"openPopUp('#box_pricing_window', setAddBoxAfter);evt('evt_cd_3');\"";
$TagAddBoxFunc_header = "onclick=\"openPopUp('#box_pricing_window', setAddBoxAfter);evt('evt_cd_5');\"";

$positionMap = new Map();
$positionMap->put(self::DIRECTION_TOP, Map::vertical);
$positionMap->put(self::DIRECTION_RIGHT, Map::side);

$logOutDatas = [
    "src" => self::$DIR_STATIC_FILES . 'log-out-100.png',
    "text" => "log out"
];
$logOutImg = $this->generateFile('view/view/BasicFiles/ImageTexte.php', $logOutDatas);
$logOutTouch = new Touch($logOutImg, 0, $positionMap);
$logOutTouch->setTagParams("onclick='logOut();'");

$homeImgDatas = [
    "src" => self::$DIR_STATIC_FILES . 'home-144.png',
    "text" => "menu"
];
$homeImg = $this->generateFile('view/view/BasicFiles/ImageTexte.php', $homeImgDatas);
$homeTouch = new Touch($homeImg, 0, $positionMap);
?>
<header>
    <nav class="navbar-computer">
        <div class="navbar-inner">
            <div class="navbar-block navbar-left-block">
                <ul class="navbar-ul remove-ul-default-att">
                    <li class="navbar-li remove-li-default-att left-block-li site-title">
                        <a href="<?= $homeLink ?>"><?= $brandName ?></a>
                    </li>
                </ul>
            </div>
            <div class="navbar-block navbar-center-block">
                <ul class="navbar-ul remove-ul-default-att">
                    <li class="navbar-li remove-li-default-att center-block-li">
                        <a href="<?= $gridLink ?>" class="remove-a-default-att" style="display: flex;">
                            <div class="header-button grey-tag-button standard-tag-button img-text-block">
                                <div class="img-text-wrap">
                                    <div class="img-text-img">
                                        <img src="<?= self::$DIR_STATIC_FILES ?>icons8-pill-yellow-red.png" alt="">
                                    </div>
                                    <span class="img-text-span">new drop</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="navbar-li remove-li-default-att center-block-li">
                        <div class="header-button grey-tag-button standard-tag-button img-text-block" <?= $TagAddBoxFunc_header ?>>
                            <div class="img-text-wrap">
                                <div class="img-text-img">
                                    <img src="<?= self::$DIR_STATIC_FILES ?>icons8-plus-math-96.png">
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
                    <?php else : ?>
                        <li class="navbar-li remove-li-default-att">
                            <div class="header-button grey-tag-button standard-tag-button img-text-block" onclick="openPopUp('#sign_form_pop');evt('evt_cd_7');">
                                <div class="img-text-wrap">
                                    <div class="img-text-img">
                                        <img src="<?= self::$DIR_STATIC_FILES ?>icons8-contacts-96.png">
                                    </div>
                                    <span class="img-text-span"></span>
                                </div>
                            </div>
                        </li>
                    <?php endif; ?>
                    <li class="navbar-li remove-li-default-att">
                        <div class="grey-tag-button standard-tag-button navbar-basket-block" onclick="openPopUp('#basket_pop', getBasketPop)">
                            <div class="img-text-block  navbar-basket-wrap">
                                <div class="img-text-wrap">
                                    <div class="img-text-img">
                                        <img src="<?= self::$DIR_STATIC_FILES ?>icons8-shopping-cart-96.png">
                                    </div>
                                    <span class="img-text-span basket-logo-span">
                                        <span data-basket="quantity"><?= $nbBasket ?></span>
                                    </span>
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
                    <label id="header_burger" class="burger-label" for="checkbox2" onclick="evt('evt_cd_2')">
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
                    <a href="<?= $homeLink ?>"><?= $brandName ?></a>
                </div>
            </div>
            <?php
            /*
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
            */
            ?>
            <div class="navbar-basket-block navbar-right-block flex-row">
                <div class="grey-tag-button standard-tag-button navbar-basket-block" onclick="openPopUp('#basket_pop', getBasketPop)">
                    <div class="img-text-block">
                        <div class="img-text-wrap">
                            <div class="img-text-img">
                                <img src="<?= self::$DIR_STATIC_FILES ?>icons8-shopping-cart-96.png">
                            </div>
                            <span class="img-text-span basket-logo-span"><span data-basket="quantity"><?= $nbBasket ?></span></span>
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
                            <?php
                            $addBoxDatas = [
                                "src" => self::$DIR_STATIC_FILES . 'icons8-plus-math-96.png',
                                "text" => "add box"
                            ];
                            $addBoxImg = $this->generateFile('view/view/BasicFiles/ImageTexte.php', $addBoxDatas);
                            $addBoxTouch = new Touch($addBoxImg, 0, $positionMap);
                            // $addBoxTouch->setTagParams($TagAddBoxFunc);
                            $addBoxTouch->setTagParams($TagAddBoxFunc_sideMenu);
                            ?>
                            <?= $addBoxTouch ?>
                        </li>
                        <li class="menu_top_content-li remove-li-default-att">
                            <?php
                            $newDropDatas = [
                                "src" => self::$DIR_STATIC_FILES . 'icons8-pill-yellow-red.png',
                                "text" => "new drop"
                            ];
                            $newDropImg = $this->generateFile('view/view/BasicFiles/ImageTexte.php', $newDropDatas);
                            $newDropTouch = new Touch($newDropImg, 0, $positionMap);
                            ?>
                            <a href="<?= $gridLink ?>" class="remove-a-default-att">
                                <?= $newDropTouch ?>
                            </a>
                        </li>
                        <?php if ($isLogged) : ?>
                            <li class="menu_top_content-li remove-li-default-att">
                                <?= $logOutTouch ?>
                            </li>
                        <?php else : ?>
                            <li class="menu_top_content-li remove-li-default-att">
                                <?php
                                $signInDatas = [
                                    "src" => self::$DIR_STATIC_FILES . 'icons8-contacts-96.png',
                                    "text" => "sign up"
                                ];
                                $signInImg = $this->generateFile('view/view/BasicFiles/ImageTexte.php', $signInDatas);
                                $signInTouch = new Touch($signInImg, 0, $positionMap);
                                $signInTouch->setTagParams("onclick=\"openPopUp('#sign_form_pop');evt('evt_cd_8')\"");
                                ?>
                                <?= $signInTouch ?>
                            </li>
                        <?php endif;
                        if ($isLogged) : ?>
                            <li class="menu_top_content-li remove-li-default-att">
                                <?= $homeTouch ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="side_menu_content-menu_bottom side_menu_content-childs">
                <div class="menu_bottom_content">
                    <ul class="menu_bottom_content-ul remove-ul-default-att">
                        <li class="menu_bottom_content-li remove-li-default-att">
                            <?php
                            $supportDatas = [
                                "src" => self::$DIR_STATIC_FILES . 'dashboard-chat-96.png',
                                "text" => "chat & support"
                            ];
                            $supportImg = $this->generateFile('view/view/BasicFiles/ImageTexte.php', $supportDatas);
                            $supportTouch = new Touch($supportImg, 0, $positionMap);
                            ?>
                            <?= $supportTouch ?>
                            <!-- <div class="touch-wrap transition_time">
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
                            </div> -->
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