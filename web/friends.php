<?php

require "../bootstrap.php";

$friends = $entityManager->getRepository("ImieBook\Entity\User")->findAll();
//$friends = $entityManager->getRepository("ImieBook\Entity\User")->findFriends($user);

if(isset($_GET['add']) && $_GET['add']){
    $friend_id = htmlspecialchars($_GET['friend_id']);
    $friend = $entityManager->getRepository('ImieBook\Entity\User')->find($friend_id);

    $user = $_SESSION['user'];
    $user->setMyFriends($friend);

    $entityManager->persist($user);
    $entityManager->flush($user);
}

//$friends = $entityManager->getRepository("ImieBook\Entity\User")->findFriends($_SESSION['user']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>IMIEBook</title>
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
                            <form class="navbar-form navbar-left" action="post.php" method="GET">
                                <div class="input-group input-group-sm" style="max-width:360px;">
                                    <input type="text" class="form-control" placeholder="Search" name="search-word" id="srch-term">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" name="search" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                            <ul class="nav navbar-nav">
                                <?php if (!empty($_SESSION['user'])): ?>
                                    <li>
                                        <a href="post.php">Home</a>
                                    </li>
                                    <li>
                                        <a href="friends.php">My friends</a>
                                    </li>
                                    <li title="Logout">
                                        <a href="login.php"><span  class="glyphicon glyphicon-user"></span>Logout</a>
                                    </li>
                                <?php else: ?>
                                    <li title="Login">
                                        <a href="login.php"><span  class="glyphicon glyphicon-user"></span>Login</a>
                                    </li>
                                    <li title="Sign Up">
                                        <a href="register.php"><span  class="glyphicon glyphicon-log-in"></span></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                    <!-- /top nav -->

                    <div class="padding">
                        <div class="full col-sm-9">
                            <!-- content -->
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading"> 
                                        <h3><?=$_SESSION['user']->getFirstname()?>'s friends</h3>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th >Name</th>
                                                    <th >Email</th>
                                                    <th >Birthday</th>
                                                    <th >Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($friends as $friend) : ?>
                                                <tr>
                                                    <td><?=$friend->getFirstname() . " " . $friend->getLastName()?></td>
                                                    <td><?=$friend->getEmail()?></td>
                                                    <td><?=$friend->getBirthdate()->format("d-m-Y")?></td>
                                                    <td><?=$friend->getDescription()?></td>
                                                    <td>
                                                        <a href="friends.php?friend_id=<?=$friend->getId()?>&add=true" class="btn btn-default btn-sm">
                                                            <span class="glyphicon glyphicon-plus"></span>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="friends.php?friend_id=<?=$friend->getId()?>&add=true" class="btn btn-default btn-sm">
                                                            <span class="glyphicon glyphicon-remove"></span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
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