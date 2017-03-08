<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <!--<div class="user-panel">
            <div class="pull-left image">
                <img src="img/26115.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>Hello, Jane</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div> -->
        <!-- search form -->
        <!--<form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form> -->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" style="margin-top: 40px;">
            <li class="<?php echo $sideBarActiveStatus('dashboard'); ?>">
                <a href="?page=dashboard">
                    <i class="fa fa-dashboard"></i> <span> Dashboard </span>
                </a>
            </li>
            <li class="<?php echo $sideBarActiveStatus('map'); ?>">
                <a href="?page=map">
                    <i class="fa fa-map-marker"></i> <span> Map </span>
                </a>
            </li>
            <li class="<?php echo $sideBarActiveStatus('records'); ?>">
                <a href="?page=records">
                    <i class="fa fa-user"></i> <span> Records </span>
                </a>
            </li>

            <!--<li class="<?php echo $sideBarActiveStatus('general'); ?>">
                <a href="?page=add-grave-to-db">
                    <i class="fa fa-square"></i> <span> Add Item to Database </span>
                </a>
            </li> -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>