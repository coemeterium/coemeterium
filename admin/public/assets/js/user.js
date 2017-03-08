$(document).ready(function() {
    
    //Change Password onForm Submit
    $('#form-change-password').submit(function() {
        
        var ret = true;
        var newPassword = $('#new_password');
        var confirmPassword = $('#confirm_new_password');

        if (newPassword.val() !== '' && (confirmPassword.val() !== newPassword.val())) {

            alert("Password did not match.");
            newPassword.css({border: '1px solid red'});
            confirmPassword.css({border: '1px solid red'});

            ret = false;
        }

        return ret;  

    });  
});