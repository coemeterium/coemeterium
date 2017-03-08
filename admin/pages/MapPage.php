<?php 

$newRecord = $item->addItemAction();
$checkExpiredGrave = $item->searchExpiredGrave();

if ($newRecord) {
    header("Location:../". constant(BASE_URL) . 'admin/?page=records');      
}

include_once 'template/header.php';
include_once 'template/sidebar.php';
?>

<div id="big-loader"> <span> Loading... <span> </div>
            
  
<?php if ($checkExpiredGrave['rows'] > 0) { ?>            
   
<div id="expired-grave-notification">
    <div class="header">
        <h4>Today: Expired Grave</h4>
        <i class="fa fa-times" id="close-expired-grave-notification"></i>
    </div>
    <div class="content">
        <table>
        <?php foreach ($checkExpiredGrave['data'] as $expGrave) { ?>            
            <tr>
                <td data-code="<?php echo $expGrave['graveCode'] ?>" id="expired-grave-notf">
                    <a target="_blank" href="/?page=map&id=<?php echo $expGrave['id']?>&srch-term=<?php echo $expGrave['lastName']?>">
                    <span><?php echo $expGrave['graveCode'] ?></span>
                    <div> <?php echo ucfirst($expGrave['lastName'] . ', ' . $expGrave['firstName']) ?> </div>
                    </a>
                </td>
            </tr>
        <?php } ?>
        </table>     
    </div>
</div>
<?php } ?>            
            
            
<aside class="right-side"> <!-- / Main content Wrapper -->    
    <section class="content content-admin-map"> <!-- Main content -->
        
    <div class="row">
                
        <div class="col-md-12" id="map-svg-container">            
            <?php include_once '../common/map_svg.php'; ?>
        </div>        
    </div>   
        
  
    <!-- Grave Details Modal -->   
    <div class="modal fade custom-modal modal-lg" tabindex="-1" role="dialog" id='grave_all_details_modal'>
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"> Details </h4>
          </div>
          <div class="modal-body">
              
              <button type="button" class="btn btn-md btn-primary" id="btn-new-record"> <i class="fa fa-plus"></i> New Record </button>
              
              <table id="grave-d-person">
                  <tr>
                      
                  </tr>
              </table>
              

              

          </div>

        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
       
        
        
    <!-- New Record Modal -->   
    <input type="hidden" id="grave-js-action-flag" value="newRecord">
    <div class="modal fade custom-modal" tabindex="-1" role="dialog" id='add_record'>
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"> New Record </h4>
          </div>
          <div class="modal-body">
              
              
                <form name="add-record" id="form-add-record" method="POST" action="<?php echo BASE_URL . '/admin/?page=map' ?>" enctype="multipart/form-data">
                                            
                        <div class="form-group">
                            <label class="f-label" id="lot-number-label"><span>* Grave No:</span> <b id="label-grave-id"></b>  </label>
                            <label class="block clearfix">
                                <input type="hidden" name="grave" id="input-grave-id-label">
                            </label>
                        </div>
                    
                        <div class="form-group">
                            <label class="f-label">* Level: <b id="label-grave-id"></b>  </label>
                            <label class="block clearfix">
                                <select class="form-control" name="grave_level" id="new-record-available-level" required="true">                                                                      
                                </select>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label">* Last Name:</label>
                            <label class="block clearfix">
                                <input type="text" name="lastName" class="form-control"/>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label">* First Name:</label>
                            <label class="block clearfix">
                                <input type="text" name="firstName" class="form-control" required=""/>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label"> Middle Name:</label>
                            <label class="block clearfix">
                                <input type="text" name="middleName" class="form-control"/>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label">* Gender:</label>
                            <label class="block clearfix">
                                <select name="gender" class='form-control' required="">
                                    <option value="">Select</option> 
                                    <option value="male">Male</option> 
                                    <option value="female">Female</option> 
                                </select>                                
                            </label>
                        </div>
                    
                        <div class="form-group">        
                            <label class="f-label field-private-only">* Date Of Birth:</label>
                            <label class="block clearfix">

                                    <select name="birthdate[month]" id="birthMonth" class='form-control field-private-only' style="width:auto;float:left;margin-right:5px;" required="">
                                        <option value="">Month</option>
                                        <?php
                                            for ($m = 1; $m <= 12; $m++){
                                                if($m < 10){$m = '0'.$m;
                                            }
                                            $month = date('F', mktime(0, 0, 0, $m, 1, 2012));

                                            echo " '<option value=\"$m\""; echo ">";
                                                echo "$month";
                                            echo "</option>";
                                        }?>
                                    </select>

                                    <select name="birthdate[day]" id="birthDay" class='form-control field-private-only' style="width:auto;float:left;margin-right:5px;" required="">
                                        <option value="">Day</option>
                                        <?php
                                            for($day="1"; $day <= 31;$day++){
                                            if($day < 10){$day = '0'.$day;}
                                                echo" '<option value=\"$day\"";                                                                           
                                                    echo ">";echo "$day";
                                                echo "</option>";
                                            }?>
                                    </select>

                                    <select name="birthdate[year]" id="birthYear" class='form-control field-private-only' style="width:auto;" required="">
                                        <option value="">Year</option>
                                        <?php
                                            $yearMax = date('Y') - 10;
                                            for ($year=1900; $year <= $yearMax;$year++) {
                                                echo" '<option value=\"$year\"";
                                                echo ">";echo "$year";
                                                    echo "</option>";
                                            }
                                        ?>
                                    </select>
                            </label>
                        </div>
                    
                        <div class="form-group">        
                            <label class="f-label field-private-only">* Date Of Death:</label>
                            <label class="block clearfix">

                                    <select name="dateOfDeath[month]" id="birthMonth" class='form-control field-private-only' style="width:auto;float:left;margin-right:5px;" required="">
                                        <option value="">Month</option>
                                        <?php
                                            for ($m = 1; $m <= 12; $m++){
                                                if($m < 10){$m = '0'.$m;
                                            }
                                            $month = date('F', mktime(0, 0, 0, $m, 1, 2012));

                                            echo " '<option value=\"$m\""; echo ">";
                                                echo "$month";
                                            echo "</option>";
                                        }?>
                                    </select>

                                    <select name="dateOfDeath[day]" id="birthDay" class='form-control field-private-only' style="width:auto;float:left;margin-right:5px;" required="">
                                        <option value="">Day</option>
                                        <?php
                                            for($day="1"; $day <= 31;$day++){
                                            if($day < 10){$day = '0'.$day;}
                                                echo" '<option value=\"$day\"";                                                                           
                                                    echo ">";echo "$day";
                                                echo "</option>";
                                            }?>
                                    </select>

                                    <select name="dateOfDeath[year]" id="birthYear" class='form-control field-private-only' style="width:auto;" required="">
                                        <option value="">Year</option>
                                        <?php
                                            $yearMax = date('Y') + 23;
                                            for ($year=1900; $year <= $yearMax;$year++) {
                                                echo" '<option value=\"$year\"";
                                                echo ">";echo "$year";
                                                    echo "</option>";
                                            }
                                        ?>
                                    </select>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label"> Address:</label>
                            <label class="block clearfix">
                                <textarea name="address" class="form-control" required=""/> </textarea>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label"> Place of Birth:</label>
                            <label class="block clearfix">
                                <textarea name="placeOfBirth" class="form-control" required=""/> </textarea>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="f-label field-private-only">* Caused of Death:</label>
                            <label class="block clearfix">
                                <textarea name="causedOfDeath" class="form-control field-private-only" required=""/> </textarea>
                            </label>
                        </div>
                        
                    
                        <div class="form-group">
                            <label class="f-label">* Type:</label>
							
                            <select name="type_rent_or_tit" class='form-control' required="" id="type_rent_or_tit" style="margin-bottom: 12px;">
								<option value="">-Select-</option> 
                                <option value="rental">Rental</option> 
                                <option value="titled">Titled</option> 
                            </select> 
							
                            <select name="type_mnth_or_yr" class='form-control' id="monthly_or_yearly_selectbox" style="display:none">
                                    <option value="monthly">Monthly</option> 
                                    <option value="yearly">Yearly</option> 
                            </select>
                        </div>
						
                       <div class="form-group" id="field-exp-date" style="display: none;">
                            <label class="f-label">* Expiration Date:</label>
                            <label class="block clearfix">
                                <input type="date" name="dateExpiration" class="form-control" class="date-picker" placeholder="YYYY-MM-DD"/>
                            </label>
                        </div>
                    
                        <div class="form-group">
                            <label class="f-label">* Remarks:</label>
                            <label class="block clearfix">
                                <textarea type="text" name="remarks" class="form-control"/></textarea>
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
                            <a href="#" class="btn btn-sm btn-success" data-dismiss="modal" aria-label="Close"> Cancel </a>
                        </div>
                    
                </form>
              

          </div>

        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    
    
    
               
        
    </section><!-- End Main content -->    
    <?php include_once 'template/footerContent.php'; ?>    
</aside> <!-- End Main content Wrapper-->

<?php include_once 'template/footer.php'; ?>