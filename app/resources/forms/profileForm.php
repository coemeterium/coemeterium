<script>
    function userVal(){
        

         var   v_firstname     = document.getElementById('firstname').value;
         var   v_lastname      = document.getElementById('lastname').value;
         var   v_password11      = document.getElementById('password11').value;
         var   v_password22      = document.getElementById('password22').value;                  
            
         var x = document.getElementById('email').value;
         var atpos=x.indexOf("@");
         var dotpos=x.lastIndexOf(".");        
            
         var illegal_char = /[^\w\s]/gi;
            
        
        if(illegal_char.test(v_firstname) == true){
           // $('#firstname_error').text('First Name contains illegal character!');
           alert('First Name contains illegal character!');
            return false;  
         }  

        else if(isNaN(v_firstname) == false){
            //$('#firstname_error').text('First Name is required!');
            alert('First Name must be string!');
            return false;
        }


        else if(illegal_char.test(v_lastname) == true){
           // $('#lastname_error').text('Last Name contains illegal character!');
           alert('Last Name contains illegal character!');
            return false;  
         } 

        else if(isNaN(v_lastname) == false){
            //$('#firstname_error').text('First Name is required!');
            alert('Last Name must be string!');
            return false;
        }

        /*else if(v_password11 != '' && v_password11 != v_password22){
            //$('#firstname_error').text('First Name is required!');
            alert('Password does not match the confirm password!');
            return false;
        } */

   }
</script>


<?php
    if ($data == null) {
        $data = array (
            "firstName" => null,
            "lastName" => null,
            "gender" => null,
            "address" => null,
            "mobileNo" => null,
            "email" => null,
            "bMonth" => "",
            "bDay" => "",
            "bYear" => "",
            "username" => null,
            "userType" => null
        );
    } else {
        $birthdate= (explode("-",$data['birthdate']));
        $data['bMonth'] = $birthdate[1];
        $data['bDay']   = $birthdate[2];
        $data['bYear']  = $birthdate[0];
    }
?>

    <div class="form-group">
        <label class="f-label">* First Name:</label>
        <label class="block clearfix">
            <input type="characters" name="firstName" class="form-control" 
                placeholder="Firstname" required="" id="firstname"
                value="<?php echo $data['firstName']?>"/>
        </label>
    </div>
        
    <div class="form-group">
        <label class="f-label">* Last Name:</label>
        <label class="block clearfix">
            <input type="text" name="lastName" class="form-control"
                placeholder="Enter your Last Name" required="" id="lastname" 
                value="<?php echo $data['lastName']?>"/>
        </label>
    </div>       

    <div class="form-group">
        <label class="f-label">* Gender:</label>
        <label class="block clearfix">
            <select name="gender" id="gender" class='form-control' style="width:auto;" required="">
                <option value="">Select</option>
                <option value="male" <?php if ($data['gender'] === 'male') { echo "selected selected";} ?>>Male</option>
                <option value="female" <?php if ($data['gender'] === 'female') { echo "selected selected";} ?>>Female</option>
            </select>
        </label>
    </div>

    <div class="form-group">        
        <label class="f-label">* Birthdate:</label>
        <label class="block clearfix">
            <span class="block input-icon input-icon-right">

                <select name="birthdate[month]" id="birthMonth" class='form-control' style="width:auto;float:left;margin-right:5px;" required="">
                    <option value="">Month</option>
                    <?php
                        for ($m = 1; $m <= 12; $m++){
                            if($m < 10){$m = '0'.$m;
                        }
                        $month = date('F', mktime(0, 0, 0, $m, 1, 2012));

                        echo " '<option value=\"$m\""; if($data['bMonth'] == $m) echo 'selected= "selected"'; echo ">";
                            echo "$month";
                        echo "</option>";
                    }?>
                </select>

                <select name="birthdate[day]" id="birthDay" class='form-control' style="width:auto;float:left;margin-right:5px;" required="">
                    <option value="">Day</option>
                    <?php
                        for($day="1"; $day <= 31;$day++){
                        if($day < 10){$day = '0'.$day;}
                            echo" '<option value=\"$day\"";                                                                            
                                if($data['bDay'] == $day) echo 'selected= "selected"';
                                echo ">";echo "$day";
                            echo "</option>";
                        }?>
                </select>

                <select name="birthdate[year]" id="birthYear" class='form-control' style="width:auto;" required="">
                    <option value="">Year</option>
                    <?php
                        $yearMax = date('Y') - 10;
                        for ($year=1940; $year <= $yearMax;$year++) {
                            echo" '<option value=\"$year\"";
                            if ($data['bYear'] == $year) echo 'selected= "selected"';echo ">";echo "$year";
                                echo "</option>";
                        }
                    ?>
                </select>
            </span>
        </label>
    </div>
          
    <div class="form-group">     
        <label class="f-label">* Address:</label>
        <label class="block clearfix">
                <input type="text" name="address" class="form-control" placeholder="Address" required="" 
                value="<?php echo $data['address']?>"/>
        </label>
    </div>

    <div class="form-group">        
        <label class="f-label">Mobile No.:</label>
        <label class="block clearfix">
                <input type="number" name="mobileNo" id="mobile_no" class='form-control' maxlength="9"
                value="<?php echo $data['mobileNo']?>"/>
        </label>
    </div>

    <div class="form-group">        
        <label class="f-label">* Email:</label>
        <label class="block clearfix">
            <input type="email" name="email" id="email" class='form-control' maxlength="250" required=""
                value="<?php echo $data['email']?>"/>
        </label>
    </div>