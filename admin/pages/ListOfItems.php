<?php
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : null;
    $searchResult = $dPersonModel->findAll($searchTerm);
    
    
    if ($searchResult['inlineAction'] == 'deleted') {
        header("Location:../". constant(BASE_URL) . 'admin/?page=records');        
    }
    
?>
<?php include_once 'template/header.php'; ?>
<?php include_once 'template/sidebar.php'; ?>

<aside class="right-side"> <!-- / Main content Wrapper -->    
    <section class="content"> <!-- Main content -->
        
    <div class="row">        
       
    <div class="col-md-12" style="margin-bottom: 20px;">
        <div class="col-md-6">
            <a href="?page=map" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> New Record </a>   
        </div>

        <div class="col-md-6">
            <form class="form-list-action" method="GET" action="<?php echo '?page=records'?>">
            <div id="custom-search-input">
                <div class="input-group col-md-12">  
                    <input type="hidden" name="page" value="records" />
                    <input style="height: 36px;" type="text" name="search" class="form-control input-mini" placeholder="Search" required="true"/>
                    <span class="input-group-btn">
                        <button class="btn btn-success btn-md" type="submit">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>                
                </div>
            </div>
            </form>
        </div>

    </div>

        <div class="col-md-12">            
            <section class="panel custom-panel">
                <header class="panel-heading">
                    Records
                </header>
                <div class="panel-body">     

<table border="0" class="table table-condensed table-bordered">
        <tr>
            <th>Code</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Gender</th>
            <th>Date Of Birth</th>
            <th>Date Of Death</th>
            <th>Grave</th>
            <th>Type</th>
            <th>Exp. Date</th>
            <th width="105px"> Actions </th>
        </tr>
    <?php foreach($searchResult['data'] as $result) {
        
        $grave = $result['graveCode'];     
        $type = $dPersonModel->graveParser($result['graveCode'])['type'];
                
    ?>
        <tr>
            <td> <?php echo $result['code'] ?> </td>
            <td> <?php echo ucfirst($result['lastName']) ?> </td>
            <td> <?php echo ucfirst($result['firstName']) ?> </td>
            <td> <?php echo ucfirst($result['middleName']) ?> </td>
            <td> <?php echo ucfirst($result['gender']) ?> </td>
            <td> <?php echo $type != 'private' ? date("M d, Y", strtotime($result['dateOfBirth'])) : 'n/a'; ?> </td>
            <td> <?php echo $type != 'private' ? date("M d, Y", strtotime($result['dateOfDeath'])) : 'n/a'; ?> </td>
            <td> <?php echo $grave ?> </td>
            <td> <?php
                echo $result['type_rent_or_tit'];
                
                if ($result['type_rent_or_tit'] == 'rental') {
                    
                    echo '<i style="display: block;">(' . $result['type_mnth_or_yr'] . ')</i>';                    
                }
                ?>
            </td>
            <td> <?php echo date("M d, Y", strtotime($result['graveExpirationDate'])); ?> </td>
            <td style="display: relative">
                
                <form class="form-action-inline" onsubmit="return alertConfirmation(this, 'Are you sure you want to delete this record?')" method="POST" action="<?php echo BASE_URL . '/admin/?page=records' ?>">                    
                    <input type="hidden" name="inline_action" value="delete">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                    <input type="hidden" name="graveCode" value="<?php echo $result['graveCode'] ?>">
                    <input type="hidden" name="graveLevel" value="<?php echo $result['level'] ?>">
                    <button type="submit" class="btn btn-sm btn-danger btn-success"><i class="fa fa-times"></i></button>
                </form>
                <a href="<?php echo BASE_URL . '/admin/?page=editrecord&id='.$result['id'] ?>" class="btn btn-sm btn-primary btn-success"><i class="fa fa-pencil"></i></a>
            </td>
        </tr>
    <?php } ?>
</table>
                    
<div class="col-md-12 page-content-header" style="text-align: right">
    <?php echo $searchResult['pagination']  ?>
</div>
                    
                    

                </div>
            </section>            
        </div>       
        
    </div>
               
        
    </section><!-- End Main content -->    
    <?php include_once 'template/footerContent.php'; ?>    
</aside> <!-- End Main content Wrapper-->

<?php include_once 'template/footer.php'; ?>