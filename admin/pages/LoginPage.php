<html>
    <head>
        <title> Admin - Coemeterium </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../public/assets/js/jquery.2.1.1.min.js"></script>           
        <link rel="stylesheet" href="public/assets/css/font-awesome.min.css" />
        <link rel="stylesheet" href="public/assets/css/login.css" type="text/css"/>        
    </head>
    <body>
        
        <div class="login-logo">
            <img src="public/assets/img/logo.png"/>
        </div>
        <form method="POST" action="?page=login" accept-charset="UTF-8" class="login">

            <fieldset>    
                <legend class="legend"> Login as Admin <i class="fa fa-user"></i></legend>

                <div class="input">
                    <input type="text" name="username" placeholder="Username" required />
                  <span><i class="fa fa-envelope-o"></i></span>
                </div>

                <div class="input">
                    <input type="password" name="password" placeholder="Password" required />
                  <span><i class="fa fa-lock"></i></span>
                </div>

                <input type="hidden" name="userType" value="admin">
                <button type="submit" class="submit"><i class="fa fa-long-arrow-right"></i></button>
            </fieldset>

            <?php if(isset($_GET['error'])) { ?>
                <div class="feedback" style="opacity: 1; display: block"> Incorrect Username or Password </div>
            <?php } ?>  
        </form>
        
    </body>
    
    <footer>
        <script src="public/assets/js/login.js"></script> 
    </footer>
</html>
