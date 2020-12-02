<?php
// require_once 'controller/ControllerCheckout.php';
// require_once 'model/special/Map.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 */
$upHeadId = ModelFunctionality::generateDateCode(25);
$upHeadx = "#" . $upHeadId;
$upBodyId = ModelFunctionality::generateDateCode(25);
$upBodyx = "#" . $upBodyId;

$inHeadId = ModelFunctionality::generateDateCode(25);
$inHeadx = "#" . $inHeadId;
$inBodyId = ModelFunctionality::generateDateCode(25);
$inBodyx = "#" . $inBodyId;

$headsCls = ModelFunctionality::generateDateCode(25);
$headsx = ".$headsCls";
$bodiesCls = ModelFunctionality::generateDateCode(25);
$bodiesx = ".$bodiesCls";

$upFormid  = ModelFunctionality::generateDateCode(25);
$upFormx  = "#$upFormid";
$upSbtnid = ModelFunctionality::generateDateCode(25);
$upSbtnx = "#$upSbtnid";

$inFormid  = ModelFunctionality::generateDateCode(25);
$inFormx  = "#$inFormid";
$inSbtnid = ModelFunctionality::generateDateCode(25);
$inSbtnx = "#$inSbtnid";

/** Event */
$upCheckboxRadioEvent = "onclick=\"evtInp(this, 'evt_cd_42')\"";
// $upCheckboxEvent = "onclick=\"evtCheck($(this).find('input'), 'evt_cd_42')\"";
$upCheckboxEvent = "onclick=\"evtCheck(this, 'evt_cd_42')\"";
$upInputEvent = "onblur=\"evtInp(this, 'evt_cd_43')\"";

$inCheckboxEvent = "onclick=\"evtCheck(this, 'evt_cd_44')\"";
$inInputEvent = "onblur=\"evtInp(this, 'evt_cd_45')\"";

?>
<div class="sign-head">
    <div id="<?= $upHeadId ?>" class="sign-head-button-div sign-head-button-selected <?= $headsCls ?>">
        <button class="sign-up-head-button sign-head-button remove-button-default-att" onclick="toggleSign('<?= $upHeadx ?>' , '<?= $upBodyx ?>', '<?= $headsx ?>', '<?= $bodiesx ?>');evt('evt_cd_40')">new member</button>
    </div>
    <div id="<?= $inHeadId ?>" class="sign-head-button-div <?= $headsCls ?>">
        <button class="sign-in-head-button sign-head-button remove-button-default-att" onclick="toggleSign('<?= $inHeadx ?>' , '<?= $inBodyx ?>', '<?= $headsx ?>', '<?= $bodiesx ?>');evt('evt_cd_41')">sign in</button>
    </div>
</div>
<div class="sign-bodies">
    <div id="<?= $upBodyId ?>" class="sign-body signup-block <?= $bodiesCls ?>">
        <div class="signup-wrap">
            <div class="connection-wrap-inner signup-wrap-inner">
                <div id="<?= $upFormid ?>" class="signup-form-tag">
                    <div class="signup-sexe-div signup-input-block">
                        <?php
                        $errorid = ModelFunctionality::generateDateCode(25);
                        $errorx = "#$errorid";
                        ?>
                        <div class="signup-sexe-inner">
                            <div class="connection-input-container signup-input-container">
                                <label class="checkbox-label">lady
                                    <input type="radio" <?= $upCheckboxRadioEvent ?> name="<?= Visitor::INPUT_SEX ?>" value="lady" data-errorx="<?= $errorx ?>" data-errortype="<?= self::ER_TYPE_COMMENT ?>">
                                    <span class="checkbox-checkmark"></span>
                                </label>
                            </div>
                            <div class="connection-input-container signup-input-container">
                                <label class="checkbox-label">sir
                                    <input type="radio" <?= $upCheckboxRadioEvent ?> name="<?= Visitor::INPUT_SEX ?>" value="sir" data-errorx="<?= $errorx ?>" data-errortype="<?= self::ER_TYPE_COMMENT ?>">
                                    <span class="checkbox-checkmark"></span>
                                </label>
                            </div>
                            <div class="connection-input-container signup-input-container">
                                <label class="checkbox-label">other
                                    <input type="radio" <?= $upCheckboxRadioEvent ?> name="<?= Visitor::INPUT_SEX ?>" value="other" data-errorx="<?= $errorx ?>" data-errortype="<?= self::ER_TYPE_COMMENT ?>">
                                    <span class="checkbox-checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div class="signup-sexe-error-div">
                            <p id="<?= $errorid ?>" class="comment"></p>
                        </div>
                    </div>
                    <div class="signup-name-div signup-50-block  signup-input-block">
                        <div class="connection-input-container signup-input-container">
                            <?php
                            $datas = [
                                "inpId" => ModelFunctionality::generateDateCode(25),
                                "inpType" => Map::text,
                                "inpName" => Visitor::INPUT_FIRSTNAME,
                                "inpTxt" => "first name",
                                "errortype" => self::ER_TYPE_COMMENT,
                                "inpAttr" => $upInputEvent
                            ];
                            echo $this->generateFile('view/elements/inputs/input.php', $datas);
                            ?>
                        </div>
                        <div class="connection-input-container signup-input-container">
                            <?php
                            $datas = [
                                "inpId" => ModelFunctionality::generateDateCode(25),
                                "inpType" => Map::text,
                                "inpName" => Visitor::INPUT_LASTNAME,
                                "inpTxt" => "last name",
                                "errortype" => self::ER_TYPE_COMMENT,
                                "inpAttr" => $upInputEvent
                            ];
                            echo $this->generateFile('view/elements/inputs/input.php', $datas);
                            ?>
                        </div>
                    </div>
                    <div class="signup-mail-div signup-input-block">
                        <div class="connection-input-container signup-input-container">
                            <?php
                            $datas = [
                                "inpId" => ModelFunctionality::generateDateCode(25),
                                "inpType" => Map::email,
                                "inpName" => Visitor::INPUT_EMAIL,
                                "inpTxt" => "email",
                                "errortype" => self::ER_TYPE_COMMENT,
                                "inpAttr" => $upInputEvent
                            ];
                            echo $this->generateFile('view/elements/inputs/input.php', $datas);
                            ?>
                        </div>
                    </div>
                    <div class="signup-password-div signup-50-block  signup-input-block">
                        <div class="connection-input-container signup-input-container">
                            <?php
                            $datas = [
                                "inpId" => ModelFunctionality::generateDateCode(25),
                                "inpType" => Map::password,
                                "inpName" => Visitor::INPUT_PASSWORD,
                                "inpTxt" => "password",
                                "errortype" => self::ER_TYPE_COMMENT,
                                "inpAttr" => null
                            ];
                            echo $this->generateFile('view/elements/inputs/input.php', $datas);
                            ?>
                        </div>
                        <div class="connection-input-container signup-input-container">
                            <?php
                            $datas = [
                                "inpId" => ModelFunctionality::generateDateCode(25),
                                "inpType" => Map::password,
                                "inpName" => Visitor::INPUT_CONFIRM_PASSWORD,
                                "inpTxt" => "password confirmation",
                                "errortype" => self::ER_TYPE_COMMENT,
                                "inpAttr" => null
                            ];
                            echo $this->generateFile('view/elements/inputs/input.php', $datas);
                            ?>
                        </div>
                    </div>
                    <div class="signup-paperwork-div signup-50-block  signup-input-block">
                        <div class="connection-input-container signup-input-container">
                            <div class="connection-chcekbox-div">
                                <?php
                                $errorid = ModelFunctionality::generateDateCode(25);
                                $errorx = "#$errorid";
                                ?>
                                <label class="checkbox-label">I confirm that I have read and I agree to
                                    I&Meim's terms and conditions including
                                    its privacy notice.
                                    <input <?= $upCheckboxEvent ?> type="checkbox" name="<?= Visitor::INPUT_CONDITION ?>" data-errorx="<?= $errorx ?>" data-errortype="<?= self::ER_TYPE_COMMENT ?>">
                                    <span class="checkbox-checkmark"></span>
                                    <p id="<?= $errorid ?>" class="comment"></p>
                                </label>
                            </div>
                        </div>
                        <div class="connection-input-container signup-input-container">
                            <div class="connection-chcekbox-div">
                                <?php
                                $errorid = ModelFunctionality::generateDateCode(25);
                                $errorx = "#$errorid";
                                ?>
                                <label class="checkbox-label">Sign up for newsletter
                                    <input class="newletter-input" <?= $upCheckboxEvent ?> type="checkbox" name="<?= Visitor::INPUT_NEWSLETTER ?>" data-errorx="<?= $errorx ?>" data-errortype="<?= self::ER_TYPE_COMMENT ?>">
                                    <span class="checkbox-checkmark"></span>
                                    <div class="connection-checkbox-text-div">
                                        by subscribing to I&Meim’s newsletter, I understand
                                        and accept to receive emails from I&Meim’s with the
                                        latest deals, sales, and updates by multiple form of
                                        communication like email, phone and/or post.
                                    </div>
                                    <p id="<?= $errorid ?>" class="comment"></p>
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="form-submit-button-div">
                        <button id="<?= $upSbtnid ?>" class="blue-button standard-button remove-button-default-att" onclick="signUp('<?= $upFormx ?>','<?= $upSbtnx ?>')">sign up</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="<?= $inBodyId ?>" class="sign-body login-block <?= $bodiesCls ?>">
        <div class="login-wrap">
            <div class="connection-wrap-inner login-wrap-inner">
                <div id="<?= $inFormid ?>" class="login-form-tag">
                    <div class="login-mail-password-div login-input-block">
                        <div class="connection-input-container">
                            <?php
                            $datas = [
                                "inpId" => ModelFunctionality::generateDateCode(25),
                                "inpType" => Map::email,
                                "inpName" => Visitor::INPUT_EMAIL,
                                "inpTxt" => "email",
                                "errortype" => self::ER_TYPE_COMMENT,
                                "inpAttr" => $inInputEvent
                            ];
                            echo $this->generateFile('view/elements/inputs/input.php', $datas);
                            ?>
                        </div>
                        <div class="connection-input-container">
                            <?php
                            $datas = [
                                "inpId" => ModelFunctionality::generateDateCode(25),
                                "inpType" => Map::password,
                                "inpName" => Visitor::INPUT_PASSWORD,
                                "inpTxt" => "password",
                                "errortype" => self::ER_TYPE_COMMENT,
                                "inpAttr" => null
                            ];
                            echo $this->generateFile('view/elements/inputs/input.php', $datas);
                            ?>
                        </div>
                    </div>
                    <div class="login-remember-forgot-div login-input-block">
                        <div class="connection-input-container login-remember-block">
                            <div class="connection-chcekbox-div">
                                <label for="login_remember" class="checkbox-label">remember me
                                    <input id="login_remember" <?= $inCheckboxEvent ?> type="checkbox" name="remember">
                                    <span class="checkbox-checkmark"></span>
                                    <p class="comment"></p>
                                </label>
                            </div>
                        </div>
                        <div class="connection-input-container login-forgot-block">
                            <a href="" target="_blank">forgot password</a>
                        </div>
                    </div>
                    <div class="form-submit-button-div">
                        <button id="<?= $inSbtnid ?>" class="blue-button standard-button remove-button-default-att" onclick="signIn('<?= $inFormx ?>','<?= $inSbtnx ?>')">sign in</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sign_form-loading loading-img-wrap">
        <img src="<?= self::$DIR_STATIC_FILES ?>loading.gif">
    </div>
</div>