<?php
    $searchTerm = isset($_GET['srch-term']) ? $_GET['srch-term'] : '';
    $searchResult = $dPersonModel->findByName($searchTerm);
?>
<?php include_once 'user/template/header.php' ?>
<?php include_once 'user/template/nav.php' ?>

<div class="container content">

<div class="search-results-header-label">Search Results...</div>
<?php if ($searchResult['data'] != null) { ?>
    
<table border="0" class="search_results">
  <tbody>

    <?php foreach($searchResult['data'] as $result) { ?>
        <tr>
            <td> <div class="user-icon"> <i class="fa fa-user"></i> </div> </td>
            <td>                
                <h4> <?php echo ucfirst($result['lastName']. ', ' . $result['firstName']); ?> </h4>
                <ul class="data-results">
                    <li> <span class="label">Gender:</span><span class="result"><?php echo $result['gender']; ?></span> </li>
                    <li> <span class="label">Address:</span><span class="result"><?php echo $result['address']; ?></span> </li>
                </ul>
            </td>
            <td style="display: relative">
                <button type="button" class="btn btn-sm btn-default enter_access_code background-blue"
                    data-id="<?php echo $result['id'] ?>"
                    data-fullname="<?php echo ucfirst($result['lastName']. ', ' . $result['firstName']); ?>"
                    data-address="<?php echo $result['address']; ?>"
                    data-dateofbirth="<?php echo date("M d, Y", strtotime($result['dateOfBirth'])); ?>"
                    data-dateofdeath="<?php echo date("M d, Y", strtotime($result['dateOfDeath'])); ?>"
                    data-searchterm="<?php echo $searchTerm ?>"
                >
                    View Complete Details and Location
                    <i class="fa fa-arrow-right"></i>
                </button>
                <!--<div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownActions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">                    
                      <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownActions">
                      <li><a href="#">Enter Code</a></li>
                      <li><a href="?page=map&id=<?php echo $result['id']. '&srch-term=' . $searchTerm; ?>">View Location</a></li>
                    </ul>
                </div> -->
            </td>
        </tr>
    <?php } ?>                        
  </tbody>
</table>

<div class="col-md-12 page-content-header" style="text-align: right">
    <?php echo $searchResult['pagination']  ?>
</div>
            
<?php } else {  ?>
    <div class="colorpicker-hue">
        
    </div>
<?php } ?>
    
</div>

<div class="modal fade" tabindex="-1" role="dialog" id='complete_details_modal'>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header background-blue">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Please enter your form number</h4>
      </div>
      <div class="modal-body">
          
            <div class="alert alert-danger" id="access-code-error" style="display: none">
              <strong>Error!</strong> Code is Incorrect
            </div>
          
        <table id="access-code-pub-details">
            <tr>
                <td>Name:</td>
                <td id="access-code-label-name"></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td id="access-code-label-address"></td>
            </tr>
        </table>
          
          <form id="form-enter-access-code">
              <input name="formNumber" class="form-control" id="inputFormNumber" placeholder="Enter Form Number"/>
              <input type="hidden" name="inputDPersonId" id="inputDPersonId" value="">
              <input type="hidden" name="inputSearchTermRef" id="inputSearchTermRef" value="">
              <button class="btn btn-md">Submit</button>
          </form>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php include_once 'user/template/footer.php' ?>