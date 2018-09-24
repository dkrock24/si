<?php include_once "template/libraries.php";?>

<div class="row membership">
    <div class="col-lg-8 col-md-6 hidden-sm hidden-xs membership-brand">
        <div class="brand-wrapper">
            <div class="brand-container">
                <a href="">
                    <img class="brand-logo" src="../../../asstes/Backend/html/assets/img/logo.png" alt="Yima - Admin Web App" />
                </a>
                <div class="brand-title">
                    Bienvenido a Grunt
                </div>
                <div class="brand-subtitle">
                    Login o Registrese Para administrar tu empresa.
                </div>
                <div class="brand-description">
                    Logging in is usually used to enter a specific page, which trespassers cannot see. Once the user is logged in,
                        the login token may be used to track what actions the user has taken while connected to the site. 
                    Logging out may be performed explicitly by the user taking some actions, such as entering the appropriate command,
                        or clicking a website link labelled as such. 
                </div>
                <div class="brand-action">
                    <input type="button" class="btn btn-primary" value="Create a Support Ticket">
                </div>
                <ul class="brand-links">
                    <li>
                        <a href="">Terms & Conditions</a>
                    </li>
                    <li>
                        <a href="">License Agreement</a>
                    </li>
                    <li>
                        <a href="">Contact</a>
                    </li>
                    <li>
                        <a href="">Support</a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12 membership-container">
        <a class="hidden" id="toregister"></a>
        <a class="hidden" id="tologin"></a>
        <a href="" class="hidden-lg hidden-md">
            <img class="brand-logo" src="../../../asstes/Backend/html/assets/img/logo.png" alt="Yima - Admin Web App" />
        </a>
        <div class="login animated">
        <form action="login" method="post">
            <div class="membership-title">Already have an account?</div>
            <div class="membership-input">
                <input type="text" class="form-control" name="usuario" placeholder="Usuario" />
            </div>
            <div class="membership-input">
                <input type="password" class="form-control" name="passwd" placeholder="Password" />
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="membership-input">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox">
                                <span class="text">Remember Me</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="membership-forgot pull-right">
                        <a href="">Forgot Password?</a>
                    </div>
                </div>
            </div>

            <div class="membership-submit">
                <input type="submit" class="btn btn-primary btn-lg btn-block" value="Sign In">
            </div>

        </form>

            <div class="membership-signup">
                <div class="signup-title">Do not Have an account?</div>
                <a href="#toregister">Sign Up Now To Access All of Our Goodies!</a>
            </div>
        </div>
        <div class="register animated">
            <div class="membership-title">Create your account</div>
            <div class="membership-input">
                <input type="text" class="form-control" placeholder="Username" />
            </div>
            <div class="membership-input">
                <input type="text" class="form-control" placeholder="Password" />
            </div>
            <div class="membership-input">
                <input type="text" class="form-control" placeholder="Confirm Password" />
            </div>
            <div class="hr-space space-xl"></div>

            <div class="membership-title">Personal Information</div>
            <div class="membership-input">
                <input type="text" class="form-control" placeholder="Name" />
            </div>
            <div class="membership-input">
                <input type="text" class="form-control" placeholder="Family" />
            </div>
            <div class="membership-input">
                <div class="checkbox">
                    <label>
                        <input type="checkbox">
                        <span class="text">I agree to <a href="">Terms of Service</a> and <a href="">Privacy Policy</a></span>
                    </label>
                </div>
            </div>
            <div class="hr-space space-xl"></div>
            <div class="membership-submit">
                <input type="button" class="btn btn-primary btn-lg btn-block" value="Sign Up">
            </div>

            <div class="membership-signup">
                <div class="signup-title">Already have an account?</div>
                <a href="#tologin">Login using your account info!</a>
            </div>
        </div>
    </div>
</div>

<?php include_once "template/footer.php"; ?>