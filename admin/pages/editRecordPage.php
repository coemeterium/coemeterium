<?php 

$recId = isset($_GET['id']) ? $_GET['id'] : 0; 
$editRecord = $item->updateRecordAction($recId);
$data = $editRecord['data'];
$infoType = $editRecord['type'];

$birthdate= (explode("-",$data['dateOfBirth']));
    $data['bMonth'] = $birthdate[1];
    $data['bDay']   = $birthdate[2];
    $data['bYear']  = $birthdate[0];
    
$dateOfDeath = (explode("-",$data['dateOfDeath']));
    $data['dMonth'] = $dateOfDeath[1];
    $data['dDay']   = $dateOfDeath[2];
    $data['dYear']  = $dateOfDeath[0];

if ($editRecord['isSave']) {
    header("Location:../". constant(BASE_URL) . 'admin/?page=records');      
}



//label
$headerLabel = 'Edit Record';
$graveLabel = 'Grave No.';
if ($infoType == 'private') {    
    $headerLabel = 'Edit Lot Owner Information';
    $graveLabel = 'Lot No.';
}


include_once 'template/header.php';
include_once 'template/sidebar.php';
?>

<div id="big-loader"> <span> Loading... <span> </div>
<aside class="right-side"> <!-- / Main content Wrapper -->    
    <section class="content content-admin-map"> <!-- Main content -->
        
    <div class="row">                
        <div class="col-md-12">   
            
                        
            
                <form class="col-md-7" name="add-record" id="form-add-record" method="POST" action="<?php echo BASE_URL . '/admin/?page=editrecord&id=' . $recId ?>" enctype="multipart/form-data">
                           
                    
                        <h3> <?php echo $headerLabel ?> </h3>
                    
                        <input type="hidden" name="originalGrave" value="<?php echo $data['graveCode'] ?>">
                        <input type="hidden" name="originalGraveLevel" value="<?php echo $data['level'] ?>">
                        
                        <div class="form-group">
                            <label class="f-label"><?php echo $graveLabel ?> : <b id="label-grave-id"><?php echo $data['graveCode'] ?></b>  </label>
                            <!--<button type="button" class="btn btn-sm btn-success" id="show-change-grave-modal"> Change Grave </button> -->
                            <label class="block clearfix">
                                <input type="hidden" name="grave" id="input-grave-id-label" value="<?php echo $data['graveCode'] ?>">
                            </label>
                        </div>
                    
                        <div class="form-group">
                            <label class="f-label">* Level: <b id="label-grave-id"></b>  </label>
                            <label class="block clearfix">
                                <input type="hidden" id="edit-record-original-level" name="original-level"  value="<?php echo $data['level'] ?>">
                                <select class="form-control" name="grave_level" id="edit-record-available-level" required="true">
                                    <option value="<?php echo $data['level'] ?>" selected="selected"> <?php echo $data['level'] ?> </option>
                                </select>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label">* Last Name:</label>
                            <label class="block clearfix">
                                <input type="text" name="lastName" class="form-control" required="" value="<?php echo $data['lastName'] ?>"/>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label">* First Name:</label>
                            <label class="block clearfix">
                                <input type="text" name="firstName" class="form-control" required="" value="<?php echo $data['firstName'] ?>"/>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label"> Middle Name:</label>
                            <label class="block clearfix">
                                <input type="text" name="middleName" class="form-control" value="<?php echo $data['middleName'] ?>"/>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label">* Gender:</label>
                            <label class="block clearfix">
                                <select name="gender" class='form-control' required="">
                                    <option value="">Select</option>
                                    <option value="male" <?php echo $data['gender'] == 'male' ? 'selected' : ''?>>Male</option>
                                    <option value="female" <?php echo $data['gender'] == 'female' ? 'selected' : ''?>>Female</option>
                                </select>                                
                            </label>
                        </div>
                        
                        <?php if ($infoType != 'private') { ?>
                        
                        <div class="form-group">        
                            <label class="f-label">* Date of Birth:</label>
                            <label class="block clearfix">
                                <span class="block input-icon input-icon-right">

                                    <select name="birthdate[month]" id="birthMonth" class='form-control' style="width:auto;float:left;margin-right:5px;">
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

                                    <select name="birthdate[day]" id="birthDay" class='form-control' style="width:auto;float:left;margin-right:5px;">
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

                                    <select name="birthdate[year]" id="birthYear" class='form-control' style="width:auto;">
                                        <option value="">Year</option>
                                        <?php
                                            $yearMax = date('Y') - 10;
                                            for ($year=1900; $year <= $yearMax;$year++) {
                                                echo" '<option value=\"$year\"";
                                                if ($data['bYear'] == $year) echo 'selected= "selected"';echo ">";echo "$year";
                                                    echo "</option>";
                                            }
                                        ?>
                                    </select>
                                </span>
                            </label>
                        </div> 
                        <?php } ?>
                        
                        <?php if ($infoType != 'private') { ?>
                        
                        <div class="form-group">        
                            <label class="f-label">* Date of Death:</label>
                            <label class="block clearfix">
                                <span class="block input-icon input-icon-right">

                                    <select name="dateOfDeath[month]" id="birthMonth" class='form-control' style="width:auto;float:left;margin-right:5px;">
                                        <option value="">Month</option>
                                        <?php
                                            for ($m = 1; $m <= 12; $m++){
                                                if($m < 10){$m = '0'.$m;
                                            }
                                            $month = date('F', mktime(0, 0, 0, $m, 1, 2012));

                                            echo " '<option value=\"$m\""; if($data['dMonth'] == $m) echo 'selected= "selected"'; echo ">";
                                                echo "$month";
                                            echo "</option>";
                                        }?>
                                    </select>

                                    <select name="dateOfDeath[day]" id="birthDay" class='form-control' style="width:auto;float:left;margin-right:5px;">
                                        <option value="">Day</option>
                                        <?php
                                            for($day="1"; $day <= 31;$day++){
                                            if($day < 10){$day = '0'.$day;}
                                                echo" '<option value=\"$day\"";                                                                            
                                                    if($data['dDay'] == $day) echo 'selected= "selected"';
                                                    echo ">";echo "$day";
                                                echo "</option>";
                                            }?>
                                    </select>

                                    <select name="dateOfDeath[year]" id="birthYear" class='form-control' style="width:auto;">
                                        <option value="">Year</option>
                                        <?php
                                            $yearMax = date('Y') + 37;
                                            for ($year=1900; $year <= $yearMax;$year++) {
                                                echo" '<option value=\"$year\"";
                                                if ($data['dYear'] == $year) echo 'selected= "selected"';echo ">";echo "$year";
                                                    echo "</option>";
                                            }
                                        ?>
                                    </select>
                                </span>
                            </label>
                        </div>  
                        <?php } ?>
                        
                        <div class="form-group">
                            <label class="f-label"> Address:</label>
                            <label class="block clearfix">
                                <textarea name="address" class="form-control" required=""/><?php echo $data['address'] ?></textarea>
                            </label>
                        </div>
                        
                        
                        
                        <div class="form-group">
                            <label class="f-label"> Place of Birth:</label>
                            <label class="block clearfix">
                                <textarea name="placeOfBirth" class="form-control" required=""/><?php echo $data['placeOfBirth'] ?></textarea>
                            </label>
                        </div>
                        
                        <?php if ($infoType != 'private') { ?>
                        
                        <div class="form-group">
                            <label class="f-label">* Caused of Death:</label>
                            <label class="block clearfix">
                                <textarea name="causedOfDeath" class="form-control" required=""/><?php echo $data['causedOfDeath'] ?></textarea>
                            </label>
                        </div>
                        
                        <?php }?>
                        
                        
                        <div class="form-group">
                            <label class="f-label">* Type:</label>

                            <select name="type_rent_or_tit" class='form-control' required="" id="type_rent_or_tit" style="margin-bottom: 12px;">
                                <option value="rental" <?php echo $data['type_rent_or_tit'] == 'rental' ? 'selected' : '' ?>>Rental</option> 
                                <option value="titled" <?php echo $data['type_rent_or_tit'] == 'titled' ? 'selected' : '' ?>>Titled</option> 
                            </select> 
                            
                            <select name="type_mnth_or_yr" class='form-control' id="monthly_or_yearly_selectbox" style="display: <?php echo $data['type_rent_or_tit'] == 'rental' ? 'block' : 'none' ?> ?>">
                                <option value="monthly" <?php echo $data['type_mnth_or_yr'] == 'monthly' ? 'selected' : '' ?>>Monthly</option> 
                                <option value="yearly" <?php echo $data['type_mnth_or_yr'] == 'yearly' ? 'selected' : '' ?>>Yearly</option> 
                            </select>
                            
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label">* Expiration Date:</label>
                            <label class="block clearfix">
                                <input type="date" name="dateExpiration" class="form-control" value="<?php echo $data['graveExpirationDate'] ?>" placeholder="YYYY-MM-DD"/>
                            </label>
                        </div>
                    
                        <div class="form-group">
                            <label class="f-label">* Remarks:</label>
                            <label class="block clearfix">
                                <textarea type="text" name="remarks" class="form-control"/><?php echo $data['remarks'] ?></textarea>
                            </label>
                        </div>
                        
                        <div class="form-group attach-image-container" id="images-wrapper">
                            <label class="f-label">* Image:</label>
                            <div id="form-attach-image">
                                <label class="block clearfix">
                                    <input type="file" name="attachment_1" id="attachment_1"/>
                                </label>
                            </div>
                            
                            <a href="#" class="pull-right btn btn-sm btn-danger" id="attach-another-image">Attach another Image</a>
                        </div>
                        
                        <div class="form-group">
                            <input type="hidden" name="attachmentCounter" id="attachmentCounter" value="1"/>
                            <button type="submit" class="btn btn-sm btn-success"> Save </button>
                            <a href="?page=items" class="btn btn-sm btn-success"> Cancel </a>
                        </div>
                    
                </form>                 
        </div>        
    </div>       
       
        
        
    <!-- Choose Grave -->   
    <input type="hidden" id="grave-js-action-flag" value="editRecord">
    <div class="modal fade custom-modal" tabindex="-1" role="dialog" id='change-grave-modal'>
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"> New Record </h4>
          </div>
          <div class="modal-body">
              
              
            <?php include_once '../common/map_svg.php'; ?> 
              

          </div>

        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    
    
    
               
        
    </section><!-- End Main content -->    
    <?php include_once 'template/footerContent.php'; ?>    
</aside> <!-- End Main content Wrapper-->

<?php include_once 'template/footer.php'; ?>