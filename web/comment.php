<?php

require "../bootstrap.php";

$post_id = htmlentities($_GET['id']);
$post = $entityManager->getRepository('ImieBook\Entity\Post')->find($post_id);

//add a comment
if(isset($_POST['comment'])){ 
    if(!empty($_POST) && !empty($_POST['message'])){
        $comment = new ImieBook\Entity\Comment();
        $comment->setMessage($_POST['message']);
        $comment->setDate(new DateTime());
        $comment->setAuthor($_SESSION['user']);
        $comment->setPost($post);

        $entityManager->persist($comment);
        $entityManager->flush($comment);
    }
}

//delete a given comment
if(isset($_GET['del']) && $_GET['del']){
    $comment_id = htmlspecialchars($_GET['comment_id']);
    $comment = $entityManager->getRepository('ImieBook\Entity\Comment')->find($comment_id);

    $entityManager->remove($comment);
    $entityManager->flush($comment);
}

//like a comment
if(isset($_GET['like']) && $_GET['like']){
    $comment_id = htmlspecialchars($_GET['comment_id']);
    $comment = $entityManager->getRepository('ImieBook\Entity\Comment')->find($comment_id);

    $commentLike = new ImieBook\Entity\CommentLike();
    $commentLike->setComment($comment);
    $commentLike->setUser($_SESSION['user']);
    $commentLike->setScore(1);
    //$commentLike->like();

    $entityManager->persist($commentLike);
    $entityManager->flush($commentLike);
}

//dislike a comment
if(isset($_GET['dislike']) && $_GET['dislike']){
    $comment_id = htmlspecialchars($_GET['comment_id']);
    $comment = $entityManager->getRepository('ImieBook\Entity\Comment')->find($comment_id);

    $commentLike = new ImieBook\Entity\CommentLike();
    $commentLike->setComment($comment);
    $commentLike->setUser($_SESSION['user']);
    $commentLike->dislike();

    $entityManager->persist($commentLike);
    $entityManager->flush($commentLike);
}



//$comments = $entityManager->getRepository('ImieBook\Entity\Comment')->findBy(array(),['date'=> 'ASC']);
$comments = $entityManager->getRepository('ImieBook\Entity\Comment')->findByPost($post);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>IMIEBook - Comment</title>
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
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <a href="#" class="pull-right">Link</a>
                                            <h4><?=$post->getSubject()?></h4>
                                            <?=$post->getDate()->format('Y-m-d H:i:s');?>
                                        </div>
                                        <div class="panel-body">
                                            <?=$post->getMessage();?>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php foreach ($comments as $comment) : ?>
                                    <div class="col-sm-push-2 col-sm-8">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <span class="author"><?=$comment->getAuthor()->getFirstname() . " " . $comment->getAuthor()->getLastname() ?></span>
                                                <?=$comment->getDate()->format('Y-m-d H:i:s')?><br/>
                                                <?=$comment->getMessage()?>
                                                <div>
                                                    <a href="comment.php?id=<?=$post_id?>&comment_id=<?=$comment->getId()?>&like=true" class="btn btn-default btn-sm" >
                                                        <span class="glyphicon glyphicon-thumbs-up"></span>
                                                        <?= $entityManager->getRepository('ImieBook\Entity\CommentLike')->countCommentLikes($comment); ?>
                                                    </a>
                                                    <a href="comment.php?id=<?=$post_id?>&comment_id=<?=$comment->getId()?>&dislike=true" class="btn btn-default btn-sm" >
                                                        <span class="glyphicon glyphicon-thumbs-down"></span>
                                                        <?= "-". $entityManager->getRepository('ImieBook\Entity\CommentLike')->countCommentDislikes($comment); ?>
                                                    </a>
                                                    <a href="comment.php?id=<?=$post_id?>&comment_id=<?=$comment->getId()?>&del=true" class="btn btn-default btn-sm pull-right" >
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>

                                <div class="col-sm-push-2 col-sm-8">
                                    <div class="well">
                                        <form class="form-horizontal" role="form" method="POST" action="comment.php?id=<?=$post_id?>">
                                            <h4>Commenter</h4>
                                            <div class="form-group" style="padding:14px;">
                                                <textarea class="form-control" name="message" placeholder="Message"></textarea>
                                            </div>
                                            <button class="btn btn-primary pull-right" name="comment" type="submit">Envoyer</button><ul class="list-inline"><li><a href=""><i class="glyphicon glyphicon-upload"></i></a></li><li><a href=""><i class="glyphicon glyphicon-camera"></i></a></li><li><a href=""><i class="glyphicon glyphicon-map-marker"></i></a></li></ul>
                                        </form>
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
