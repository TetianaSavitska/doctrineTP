<?php

require "../bootstrap.php";

//if update is set get the data to modify
$button= "Post";
$id_modif = null;
$mod = isset($_GET['mod']) && $_GET['mod'];
if($mod){
    $id_modif = htmlspecialchars($_GET['id']);
    $post = $entityManager->getRepository('ImieBook\Entity\Post')->find($id_modif);
    $subject = $post->getSubject();
    $message = $post->getMessage();
    $date =  $post->setDate(new DateTime());
    $button = "Update";
}

//add or update new post
if( isset($_POST['post'])){
    if(!empty($_POST) && !empty($_POST['title']) && !empty($_POST['message'])){
        if(!empty($_GET['update']) && $_GET['update']){
            $id_modif = $_GET['id'];
            $post = $entityManager->getRepository('ImieBook\Entity\Post')->find(htmlspecialchars($id_modif)); 
        }else{ 
            $post = new ImieBook\Entity\Post();
        }
        $post->setSubject(htmlspecialchars($_POST['title']));
        $post->setMessage(htmlspecialchars($_POST['message']));
        $post->setDate(new DateTime());
        $post->setAuthor($_SESSION['user']);

        $entityManager->persist($post);
        $entityManager->flush($post);
    }
}


//delete a given posts
if(isset($_GET['del']) && $_GET['del']){
    $id = htmlspecialchars($_GET['id']);
    $post = $entityManager->getRepository('ImieBook\Entity\Post')->find($id);
    $comments = $entityManager->getRepository('ImieBook\Entity\Comment')->findByPost($post);

    $entityManager->remove($post);
    $entityManager->flush($post);
}


if(!empty($_GET) && !empty($_GET['search-word'])){
    //search by word
    $word = $_GET['search-word'];
    //$posts = $entityManager->getRepository('ImieBook\Entity\Post')->findBy(['subject'=> $word]);
    $posts = $entityManager->getRepository("ImieBook\Entity\Post")->findSubjectsByWord($word);
}else{
    //find all post and order by date
    //$posts = $entityManager->getRepository('ImieBook\Entity\Post')->findAll();
    $posts = $entityManager->getRepository('ImieBook\Entity\Post')->findBy(array(),['date'=> 'DESC']);  
}

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

                                <!-- main col left -->
                                <div class="col-sm-5">
                                    <div class="well">
                                        <form class="form-horizontal" role="form" method="POST" action="post.php?id=<?=$id_modif?>&update=<?=$mod?>">
                                            <h4>What's New</h4>
                                            <div class="form-group" style="padding:14px;">
                                                <input type="text" class="form-control" name="title" placeholder="Title" value="<?=$mod ? $subject : ''?>"/>
                                                <hr/>
                                                <textarea class="form-control" name="message" placeholder="Message"><?=$mod ? $message : ''?></textarea>
                                            </div>
                                            <button class="btn btn-primary pull-right" name="post" type="submit"><?=$button?></button><ul class="list-inline"><li><a href=""><i class="glyphicon glyphicon-upload"></i></a></li><li><a href=""><i class="glyphicon glyphicon-camera"></i></a></li><li><a href=""><i class="glyphicon glyphicon-map-marker"></i></a></li></ul>
                                        </form>
                                    </div>
                                </div>

                                <!-- main col right -->
                                <div class="col-sm-7">
                                    <?php foreach ($posts as $post): ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading"> 
                                                <a href="comment.php?id=<?=$post->getId()?>" class="pull-right btn btn-default btn-sm">
                                                Link 
                                                </a>
                                                <h4><a href="comment.php?id=<?=$post->getId()?>"><?=$post->getSubject()?></a></h4>
                                                <p> Posted by <span class="author"><?=$post->getAuthor()->getFirstname() . " " . $post->getAuthor()->getLastname() ?></span></p>
                                                <?=$post->getDate()->format('Y-m-d H:i:s');?>
                                            </div>
                                            <div class="panel-body">
                                                <?=$post->getMessage();?>
                                            </div>
                                            <div class="panel-heading">
                                                <a href="comment.php?id=<?=$post->getId()?>" class="btn btn-default btn-sm">
                                                    <span class="glyphicon glyphicon-comment"></span>
                                                </a>
                                                <a href="post.php?id=<?=$post->getId()?>&mod=true" class="btn btn-default btn-sm" >
                                                    <span class="glyphicon glyphicon-pencil"></span>
                                                </a>
                                                <a href="post.php?id=<?=$post->getId()?>&del=true" class="btn btn-default btn-sm" >
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </a>
                                                <a href="post.php" class="btn btn-default btn-sm" title="Like">
                                                    <span class="glyphicon glyphicon-thumbs-up"></span>
                                                </a>
                                                <a href="post.php" class="btn btn-default btn-sm" title="Dislike">
                                                    <span class="glyphicon glyphicon-thumbs-down"></span>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
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
