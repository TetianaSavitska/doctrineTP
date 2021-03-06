<?php

require "../bootstrap.php";

$error=null;

//logout
if (!empty($_SESSION['user'])){
    unset($_SESSION['user']); 
    //redirection
    header("Location: login.php");
}

//traitement du fformulaire de connection
//si le form est soumis...
if(isset($_POST['login'])){

    $username = $_POST['username'];

    $user = $entityManager->getRepository('ImieBook\Entity\User')->findOneByEmail($username);
    if ($user != null){
        //hache le mot de passe et le compare à celui de la bdd
        if ( password_verify( $_POST['password'], $user->getPassword() ) ){
            $_SESSION['user'] = $user;

            //$_COOKIE pour la lecture
            //on stocke le token dans un cookie
            //on ne devrait placer ce cookie que si une case est cochée
            //pour l'instant, ce cookie ne sert à rien !!!
            //setcookie("remember_me", $user->getToken(), strtotime("+ 6 months"), "/");
            header("Location: post.php");
        }
        else {
            $error = "Not valid username or password!";
        }
    }else{
        $error = "Invalid username";
    }
    
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>IMIEBook - Login</title>
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="box">
            <div class="row row-offcanvas row-offcanvas-left">
                <!-- main right col -->
                <div class="column col-sm-12 col-xs-12" id="main">

                    <!-- top nav -->
                    <div class="navbar navbar-blue navbar-static-top">
                        <div class="navbar-header">
                            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a href="/" class="navbar-brand logo">b</a>
                        </div>
                        <nav class="collapse navbar-collapse" role="navigation">
                            <form class="navbar-form navbar-left" action="post.php">
                                <div class="input-group input-group-sm" style="max-width:360px;">
                                    <input type="text" class="form-control" placeholder="Search" name="search-word" id="srch-term">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" name="search" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                            <ul class="nav navbar-nav">
                                <li>
                                    <a href="post.php">Home</a>
                                </li>
                                <li title="Login">
                                    <a href="login.php"><span  class="glyphicon glyphicon-user"></span></a>
                                </li>
                                <li title="Sign Up">
                                    <a href="register.php"><span  class="glyphicon glyphicon-log-in"></span></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!-- /top nav -->

                    <div class="padding">
                        <div class="full col-sm-9">
                            <!-- content -->
                            <div class="row">
                                <div class="col-sm-push-2 col-sm-8">
                                    <div class="well">
                                        <form class="form-horizontal" role="form" method="POST">
                                            <h4>Login</h4>
                                            <div class="form-group">
                                                <input class="form-control" type="text" name="username" placeholder="Username" />
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="password" name="password" placeholder="password" />
                                            </div>
                                            <button class="btn btn-primary pull-right" name="login" type="submit">Send</button><ul class="list-inline"><li><a href=""><i class="glyphicon glyphicon-upload"></i></a></li><li><a href=""><i class="glyphicon glyphicon-camera"></i></a></li><li><a href=""><i class="glyphicon glyphicon-map-marker"></i></a></li></ul>
                                        </form>
                                    </div>
                                <?= isset($_POST['login']) ?  var_dump($user) : ""; ?>
                                <p><?=$error == null ? "" : $error;?></p>
                                </div>
                            </div><!--/row-->
                            <hr>
                        </div><!-- /col-9 -->
                    </div><!-- /padding -->
                </div>
                <!-- /main -->

            </div>
        </div>
    </div>
    <!-- script references -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>