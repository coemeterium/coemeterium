<div class="form-group"> 
    <label class="f-label"> Username: </label>
    <label class="block clearfix">
        <input type="text" name="username" class="form-control" placeholder="Username" required=""
            value="<?php echo $data['username'] ?>"        
            <?php
                $disabled = isset($data['viewProfile']) || isset($data['editProfile']) || isset($data['changePassword']) ? 'disabled' : '';
                echo $disabled;
            ?>
        />
    </label>
</div>

<!-- Hide checking of username availability if view and edit profile -->
<?php if((!isset($data['viewProfile'])) && (!isset($data['editProfile'])) && (!isset($data['changePassword']))) { ?>

    <span class="check-username pull-right">
        <i class="alert"></i>
        <a href="javascript:void(0)" class="checkUsername">Check Availability</a>
    </span>
<?php } ?>

<?php if(isset($data['changePassword'])) { ?>
    <div class="form-group">
        <label class="f-label"> Old Password: </label>
        <label class="block clearfix">
            <input type="password" name="oldPassword" class="form-control" placeholder="" required="" />
        </label>
    </div>
<?php } ?>

<div class="form-group">
    <label class="f-label"> Password: </label>
    <label class="block clearfix">
        <input type="password" name="password" id="new_password" class="form-control" placeholder="" 
        <?php if (($_GET['page'] !== 'user-update') &&
            ($_GET['page'] !== 'profile-update')) { echo 'required=""'; }
        ?> 
        />
    </label>
</div>

<div class="form-group">
    <label class="f-label"> Confirm Password: </label>
    <label class="block clearfix">
        <input type="password" name="confirmPassword" id="confirm_new_password" class="form-control" placeholder="" 
        <?php if (($_GET['page'] !== 'user-update') &&
            ($_GET['page'] !== 'profile-update')) { echo 'required=""'; } 
        ?>
        />
    </label>
</div>