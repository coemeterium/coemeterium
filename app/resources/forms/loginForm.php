<?php if(isset($_GET['error'])) { ?>
<div class="alert alert-danger">
    <a class="close" data-dismiss="alert" href="#">x</a>
    <span>Incorrect Username or Password!</span>
</div>
<?php } ?>

<fieldset>
        <label class="block clearfix">
            <span class="block input-icon input-icon-right">
            <input type="text" name="username" class="form-control" placeholder="Username" required="" />
            <i class="ace-icon fa fa-user"></i>
            </span>
        </label>

        <label class="block clearfix">
            <span class="block input-icon input-icon-right">
            <input type="password" name="password" class="form-control" placeholder="Password" required=""/>
            <i class="ace-icon fa fa-keyboard-o"></i>
            </span>
        </label>
                
        <input type="hidden" name="loginAttempt" value="<?php echo $loginAttempt ?>">
        <input type="hidden" name="userType" value="<?php echo $loginAs; ?>">

        <div class="space"></div>

        <div class="clearfix">
            <!--<label class="inline">
            <input type="checkbox" class="ace" />
            <span class="lbl"> Remember Me</span>
            </label> -->
            <button type="submit" class="width-100 pull-right btn btn-sm btn-primary login">
                <i class="ace-icon fa fa-key"></i>
                <span class="bigger-110">Login</span>
            </button>
        </div>

            <div class="space-4"></div>
</fieldset>