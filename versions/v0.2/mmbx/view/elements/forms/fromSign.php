<?php
require_once 'controller/ControllerCheckout.php';
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $redirLink redirect link when success
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
?>
<div class="sign-head">
    <div id="<?= $upHeadId ?>" class="sign-head-button-div sign-head-button-selected <?= $headsCls ?>">
        <button class="sign-up-head-button sign-head-button remove-button-default-att" onclick="toggleSign('<?= $upHeadx ?>' , '<?= $upBodyx ?>', '<?= $headsx ?>', '<?= $bodiesx ?>')">new member</button>
    </div>
    <div id="<?= $inHeadId ?>" class="sign-head-button-div <?= $headsCls ?>">
        <button class="sign-in-head-button sign-head-button remove-button-default-att" onclick="toggleSign('<?= $inHeadx ?>' , '<?= $inBodyx ?>', '<?= $headsx ?>', '<?= $bodiesx ?>')">sign in</button>
    </div>
</div>
<div class="sign-bodies">
    <div id="<?= $upBodyId ?>" class="sign-body signup-block <?= $bodiesCls ?>">
        <div class="signup-wrap">
            <div class="connection-wrap-inner signup-wrap-inner">
                <div id="<?= $upFormid ?>" class="signup-form-tag">
                    <input type="hidden" name="<?= ControllerSecure::INPUT_REDIRECT ?>" value="<?= $redirLink ?>">
                    <div class="signup-sexe-div signup-input-block">
                        <?php
                        $errorid = ModelFunctionality::generateDateCode(25);
                        $errorx = "#$errorid";
                        ?>
                        <div class="signup-sexe-inner">
                            <div class="connection-input-container signup-input-container">
                                <label class="checkbox-label">lady
                                    <input type="radio" name="<?= Visitor::INPUT_SEX ?>" value="lady" data-errorx="<?= $errorx ?>" data-errortype="<?= self::ER_TYPE_COMMENT ?>">
                                    <span class="checkbox-checkmark"></span>
                                </label>
                            </div>
                            <div class="connection-input-container signup-input-container">
                                <label class="checkbox-label">sir
                                    <input type="radio" name="<?= Visitor::INPUT_SEX ?>" value="sir" data-errorx="<?= $errorx ?>" data-errortype="<?= self::ER_TYPE_COMMENT ?>">
                                    <span class="checkbox-checkmark"></span>
                                </label>
                            </div>
                            <div class="connection-input-container signup-input-container">
                                <label class="checkbox-label">other
                                    <input type="radio" name="<?= Visitor::INPUT_SEX ?>" value="other" data-errorx="<?= $errorx ?>" data-errortype="<?= self::ER_TYPE_COMMENT ?>">
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
                            <div class="input-wrap">
                                <?php
                                $errorid = ModelFunctionality::generateDateCode(25);
                                $errorx = "#$errorid";
                                ?>
                                <label class="input-label" for="signup_firstname">first name</label>
                                <input id="signup_firstname" class="input-error input-tag" type="text" name="<?= Visitor::INPUT_FIRSTNAME ?>" placeholder="first name" data-errorx="<?= $errorx ?>" data-errortype="<?= self::ER_TYPE_COMMENT ?>">
                                <p id="<?= $errorid ?>" class="comment"></p>
                            </div>
                        </div>
                        <div class="connection-input-container signup-input-container">
                            <div class="input-wrap">
                                <?php
                                $errorid = ModelFunctionality::generateDateCode(25);
                                $errorx = "#$errorid";
                                ?>
                                <label class="input-label" for="signup_lastname">last name</label>
                                <input id="signup_lastname" class="input-tag" type="text" name="<?= Visitor::INPUT_LASTNAME ?>" placeholder="last name" data-errorx="<?= $errorx ?>" data-errortype="<?= self::ER_TYPE_COMMENT ?>">
                                <p id="<?= $errorid ?>" class="comment"></p>
                            </div>
                        </div>
                    </div>
                    <div class="signup-mail-div signup-input-block">
                        <div class="connection-input-container signup-input-container">
                            <div class="input-wrap">
                                <?php
                                $errorid = ModelFunctionality::generateDateCode(25);
                                $errorx = "#$errorid";
                                ?>
                                <label class="input-label" for="signup_email">email</label>
                                <input id="signup_email" class="input-tag" type="email" name="<?= Visitor::INPUT_EMAIL ?>" placeholder="email" data-errorx="<?= $errorx ?>" data-errortype="<?= self::ER_TYPE_COMMENT ?>">
                                <p id="<?= $errorid ?>" class="comment"></p>
                            </div>
                        </div>

                    </div>
                    <div class="signup-password-div signup-50-block  signup-input-block">
                        <div class="connection-input-container signup-input-container">
                            <div class="input-wrap">
                                <?php
                                $errorid = ModelFunctionality::generateDateCode(25);
                                $errorx = "#$errorid";
                                ?>
                                <label class="input-label" for="signup_password">password</label>
                                <input id="signup_password" class="input-tag" type="password" name="<?= Visitor::INPUT_PASSWORD ?>" placeholder="password" data-errorx="<?= $errorx ?>" data-errortype="<?= self::ER_TYPE_COMMENT ?>">
                                <p id="<?= $errorid ?>" class="comment"></p>
                            </div>
                        </div>
                        <div class="connection-input-container signup-input-container">
                            <div class="input-wrap">
                                <?php
                                $errorid = ModelFunctionality::generateDateCode(25);
                                $errorx = "#$errorid";
                                ?>
                                <label class="input-label" for="signup_password_confirmation">password confirmation</label>
                                <input id="signup_password_confirmation" class="input-tag" type="password" name="<?= Visitor::INPUT_CONFIRM_PASSWORD ?>" placeholder="password confirmation" data-errorx="<?= $errorx ?>" data-errortype="<?= self::ER_TYPE_COMMENT ?>">
                                <p id="<?= $errorid ?>" class="comment"></p>
                            </div>
                        </div>
                    </div>
                    <div class="signup-paperwork-div signup-50-block  signup-input-block">
                        <div class="connection-input-container signup-input-container">
                            <div class="connection-chcekbox-div">
                                <?php
                                $errorid = ModelFunctionality::generateDateCode(25);
                                $errorx = "#$errorid";
                                ?>
                                <label for="signup_terme" class="checkbox-label">I confirm that I have read and I agree to
                                    I&Meim's terms and conditions including
                                    its privacy notice.
                                    <input id="signup_terme" type="checkbox" name="<?= Visitor::INPUT_CONDITION ?>" data-errorx="<?= $errorx ?>" data-errortype="<?= self::ER_TYPE_COMMENT ?>">
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
                                <label for="signup_newsletter" class="checkbox-label">Sign up for newsletter
                                    <input id="signup_newsletter" class="newletter-input" type="checkbox" name="<?= Visitor::INPUT_NEWSLETTER ?>" data-errorx="<?= $errorx ?>" data-errortype="<?= self::ER_TYPE_COMMENT ?>">
                                    <span class="checkbox-checkmark"></span>
                                    <div class="connection-checkbox-text-div">
                                        By subscribing to I&Meim’s newsletter, I understand
                                        and accept to receive emails from I&Meim’s with the
                                        latest deals, sales, and updates by multiple form of
                                        communication like email, phone and/or post.
                                    </div>
                                    <p id="<?= $errorid ?>" class="comment"></p>
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="sign-button-div">
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
                    <input type="hidden" name="<?= ControllerSecure::INPUT_REDIRECT ?>" value="<?= $redirLink ?>">
                    <div class="login-mail-password-div login-input-block">
                        <div class="connection-input-container">
                            <div class="input-wrap">
                                <?php
                                $errorid = ModelFunctionality::generateDateCode(25);
                                $errorx = "#$errorid";
                                ?>
                                <label class="input-label" for="login_email">email</label>
                                <input id="login_email" class="input-tag" type="email" name="<?= Visitor::INPUT_EMAIL ?>" placeholder="email" data-errorx="<?= $errorx ?>" data-errortype="<?= self::ER_TYPE_COMMENT ?>">
                                <p id="<?= $errorid ?>" class="comment"></p>
                            </div>
                        </div>
                        <div class="connection-input-container">
                            <div class="input-wrap">
                                <?php
                                $errorid = ModelFunctionality::generateDateCode(25);
                                $errorx = "#$errorid";
                                ?>
                                <label class="input-label" for="login_password">password</label>
                                <input id="login_password" class="input-tag" type="password" name="<?= Visitor::INPUT_PASSWORD ?>" placeholder="password" data-errorx="<?= $errorx ?>" data-errortype="<?= self::ER_TYPE_COMMENT ?>">
                                <p id="<?= $errorid ?>" class="comment"></p>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="login-password-div  login-input-block">
                    </div> -->
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
                    <div class="sign-button-div">
                        <button id="<?= $inSbtnid ?>" class="blue-button standard-button remove-button-default-att" onclick="signIn('<?= $inFormx ?>','<?= $inSbtnx ?>')">sign in</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sign_form-loading loading-img-wrap">
        <img src="content/brain/permanent/loading.gif">
    </div>
</div>