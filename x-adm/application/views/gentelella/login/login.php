<div class="animate form login_form">
    <section class="login_content">
        <?php echo form_open($form_action,'role="form"'); ?>
            <h1>Login Form</h1>
            <div>
                <input type="text" class="form-control" placeholder="Username" name="username" required="" />
            </div>
            <div>
                <input type="password" class="form-control" placeholder="Password" name="password" required="" />
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-dark submit fs12px">Log in</button>
                </div>
                <div class="col">
                    <button class="btn btn-dark reset_pass fs12px">Forgot?</button>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="separator">
                <p class="change_link">New to site?
                    <a href="#signup" class="to_register"> Create Account </a>
                </p>
                <div class="clearfix"></div>
                <br />
                <div>
                    <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                    <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
            </div>
        <?php echo form_close(); ?>
    </section>
</div>
<div id="register" class="animate form registration_form">
    <section class="login_content">
        <form>
            <h1>Create Account</h1>
            <div>
                <input type="text" class="form-control" placeholder="Username" required="" />
            </div>
            <div>
                <input type="email" class="form-control" placeholder="Email" required="" />
            </div>
            <div>
                <input type="password" class="form-control" placeholder="Password" required="" />
            </div>
            <div>
                <a class="btn btn-default submit" href="index.html">Submit</a>
            </div>
            <div class="clearfix"></div>
            <div class="separator">
                <p class="change_link">Already a member ?
                    <a href="#signin" class="to_register"> Log in </a>
                </p>
                <div class="clearfix"></div>
                <br />
                <div>
                    <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                    <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
            </div>
        </form>
    </section>
</div>