<?php
    $searchTerm = isset($_GET['srch-term']) ? $_GET['srch-term'] : '';
    $dPersonId = isset($_GET['id']) ? $_GET['id'] : 0;
    $details = $dPersonModel->findById($dPersonId);
    
    $data = $details['data']['data'];
    $type = $details['type'];
        
    $images = $dPersonModel->findImagesByRecordId($dPersonId);      
?>

<?php include_once 'user/template/header.php' ?>

<div id="map_wrapper">

<div id="user-map-search-result">   
    

    
    <?php include_once 'common/map_svg.php'; ?>  
    <div id="svg_pointer"> <!-- start pointer svg-->
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="45.5px"
            height="60px" viewBox="0 0 35.5 55" enable-background="new 0 0 35.5 55" xml:space="preserve">

        <g id="marker" style="display: block">
            <path fill="none" stroke="#000000" stroke-width="3" d="M41.7,82.13"/>
                <g>
                    <path fill="#F75048" d="M17.512,54.424c0.398-7.353,4.658-19.296,10.833-26.813c3.364-4.095,4.911-8.087,4.911-10.509
                        c0-8.411-7.084-15.229-15.824-15.229h-0.001c-8.74,0-15.825,6.819-15.825,15.229c0,2.422,1.547,6.414,4.912,10.509
                        c6.175,7.517,10.435,19.46,10.833,26.813H17.512z"/>
                    <path fill="#FFFFFF" d="M18.087,55h-1.313l-0.03-0.546c-0.383-7.081-4.492-18.924-10.704-26.488C2.324,23.442,1,19.389,1,17.103
                        C1,8.388,8.371,1.297,17.431,1.297s16.432,7.091,16.432,15.806c0,2.286-1.325,6.34-5.04,10.863
                        C22.608,35.53,18.5,47.373,18.117,54.454L18.087,55L18.087,55z M17.432,2.449c-8.393,0-15.22,6.574-15.22,14.654
                        c0,1.999,1.252,5.856,4.783,10.154c5.278,6.425,9.073,15.875,10.436,23.053c1.364-7.178,5.158-16.628,10.438-23.053
                        c3.53-4.298,4.783-8.156,4.783-10.154C32.651,9.022,25.824,2.449,17.432,2.449L17.432,2.449z"/>
                </g>
        </g>
        <g id="dot">
            <circle fill="#FFFFFF" cx="17.947" cy="16.232" r="6.858"/>
        </g>
        <g id="letter_arial_font" display="none">
            <g display="inline">
                <path d="M22.132,62.03l17.594-45.813h6.531l18.75,45.813h-6.906l-5.344-13.875H33.601L28.569,62.03H22.132z M35.351,43.218h15.531
                L46.101,30.53c-1.459-3.854-2.542-7.021-3.25-9.5c-0.584,2.938-1.406,5.854-2.469,8.75L35.351,43.218z"/>
            </g>
        </g>
        </svg>
    </div> <!-- end pointer svg-->  
    
</div>   
    <div id="map-left-sidebar">
        
        <div class="header-placeholder">
            <a href="?page=search&srch-term=<?php echo $searchTerm; ?>" class="map-back-to-homepage" > <i class="fa fa-arrow-left"></i> Back </a>
        </div>
        
        <div id="search_result_location_details">
                       
          <table border="0" padding="5" cellspacing="5" id="search_result_location_details_table">
              <tr>
                  <td>Name:</td>
                  <td><?php echo ucfirst($data['lastName'] . ', ' .$data['firstName'] . ' ' . $data['middleName']) ?></td>
              </tr>
              <tr>
                  <td>Gender:</td>
                  <td><?php echo ucfirst($data['gender']) ?></td>
              </tr>
              <tr>
                  <td>Address:</td>
                  <td><?php echo $data['address'] ?></td>
              </tr>
              <tr>
                  <td>Place Of Birth:</td>
                  <td><?php echo $data['placeOfBirth'] ?></td>
              </tr>
              
              <?php if ($type != 'private') { ?>              
                <tr>
                    <td>Date of Birth:</td>
                    <td><?php echo date("M d, Y", strtotime($data['dateOfBirth'])); ?></td>
                </tr>
              <?php } ?>
              
              <?php if ($type != 'private') { ?>   
              <tr>
                  <td>Date of Death:</td>
                  <td><?php echo date("M d, Y", strtotime($data['dateOfDeath'])); ?></td>
              </tr>
              <?php } ?>
              
              <?php if ($type != 'private') { ?>   
              <tr>
                  <td>Caused of Death:</td>
                  <td><?php echo $data['causedOfDeath'] ?></td>
              </tr>
              <?php } ?>
              
          </table>           
          <input type="hidden" id="search-item-id" value="<?php echo $dPersonId ?>"><!--reference for ajax request-->
          <input type="hidden" name="selectedGrave" id="selectedGrave"  value="<?php echo $data['graveCode'] ?>"/>
        </div>
      

    </div>
    
    
</div>

<div id="map-loader"></div>

<div class="modal fade custom-modal" tabindex="-1" role="dialog" id='show_images'>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> Info </h4>
      </div>
      <div class="modal-body">
          
          
          <div id="primary details">
                <table border="0" padding="5" cellspacing="5" id="search_result_location_details_table">
                    <tr>
                        <td>Name:</td>
                        <td><?php echo ucfirst($data['lastName'] . ', ' .$data['firstName'] . ' ' . $data['middleName']) ?></td>
                    </tr>
                    
                    <?php if ($type != 'private') { ?>   
                    <tr>
                        <td>Date of Birth:</td>
                        <td><?php echo date("M d, Y", strtotime($data['dateOfBirth'])); ?></td>
                    </tr>
                    <?php } ?>   
                    
                    <?php if ($type != 'private') { ?>  
                    <tr>
                        <td>Date of Death:</td>
                        <td><?php echo date("M d, Y", strtotime($data['dateOfDeath'])); ?></td>
                    </tr>
                    <?php }?>  
              <tr>
                  <td>Type:</td>
                  <td>
                      <?php 
                      
                      $rental = $data['type_rent_or_tit'];
                      
                      echo $rental;
                      
                      if ($rental == 'rental') {
                          echo "<b style='display: block;'>" . $data['type_mnth_or_yr'] . "</b>";                           
                      }
                              
                    ?>
                  </td>
              </tr>
                </table>            
          </div>
          
          <h5 class="divider"></h5>
                    
          <div class="images">
              
              
              <?php if ($images['rows'] > 0) {?>
              
                <?php foreach ($images['data'] as $image) { ?>
                    <img class="att-grave-image" src="<?php echo '../bucket/grave/' . $image['fileName']; ?>">
                <?php } ?>
                        
              <?php } else { ?>
                  <b> No image</b>
              <?php } ?>
              
          </div>
          
          
          
         
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php include_once 'user/template/footerMap.php' ?>