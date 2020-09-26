<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * 
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
    <div id="<?= $inBodyId ?>" class="sign-body login-block <?= $bodiesCls ?>">
        <div class="login-wrap">
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