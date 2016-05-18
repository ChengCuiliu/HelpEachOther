<?php
session_start();
if (isset($_SESSION['henuid'])) {
  if ($_SESSION['henuid']==1) {
    include('./layout/administrateHeader.inc.php');
 }else{
  include('./layout/loggedHeader.inc.php');
}
  $henuid=$_SESSION['henuid'];
}else{
  include('./layout/header.inc.php');
}

require_once('includes/connection.inc.php');
require_once('includes/function.php');

if(isset($_GET["page"]))
  $page = (int)$_GET["page"];
else
  $page = 1;

$setLimit = 20;
$pageLimit = ($page * $setLimit) - $setLimit;


if(isset($_GET["cate"]))
{
  $cate = $_GET["cate"];
  $countsql="SELECT COUNT(*) FROM post  WHERE PostStatus=0 && PostCategory=$cate";
}else{
  $countsql="SELECT COUNT(*) FROM post  WHERE PostStatus=0 ";
}

$countresult=$conn->
query($countsql);
$countrow=$countresult->fetch_row();
$total=$countrow[0];

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="images/logo.ico">

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
  <link href="css/common.css" rel="stylesheet">
  <link href="css/forum.css" rel="stylesheet">
  <title>河大帮帮网
    <?php if(isset($title)) {echo "&#8212;{$title}"; }?></title>
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  <div class="container">
    <div >
      <h2>
        最新发布帖子
        <a class="addpost" href="<?php if (isset($_SESSION['henuid'])){?>
          editPost.php?hId=
          <?php echo $_SESSION['henuid'];} else {?>
          login.php
          <?php }?>
          " class="more">
          发帖
          <span aria-hidden="true">&raquo;</span>
        </a>
      </h2>
      <h6>
        <a class="addpost" href="forum.php?cate=0" >
          (需要帮助的/</a>
          <a class="addpost" href="forum.php?cate=1" >
            提供帮助的/</a>
            <a class="addpost" href="forum.php" >
              所有)</a>

            </h6>

            <table class="table">
              <tr>
                <th><h3>标题</h3></th>
                <th><h3>种类</h3></th>
                <th><h3>价格</h3></th>
                <th><h3>评论</h3></th>
                <th><h3>发帖人</h3></th>
                <th><h3>发贴日期</h3></th>
              </tr>
              <?php

              if(isset($_GET["cate"]))
              {
                $cate = $_GET["cate"];
                $sql="SELECT * FROM post WHERE PostCategory=$cate ORDER BY PostId DESC LIMIT ".$pageLimit." , ".$setLimit;
              }else{
                $sql="SELECT * FROM post  ORDER BY PostId DESC LIMIT ".$pageLimit." , ".$setLimit;
              }



              $result=$conn->
              query($sql) or die($conn->error);

              while ($row=$result->fetch_assoc()) {
                $postId=$row['PostId'];
                $postcategory=$row['PostCategory'];
                if ($postcategory==0) {
                  $postcategory="我需要帮助";
                }else{
                  $postcategory="我能提供帮助";
                }
                $price=$row['Price'];
                $postTtitle=$row['PostTitle'];
                $posttime=$row['PostTime'];
                $hId=$row['HenuId'];

                $sqla="SELECT UserName FROM account WHERE HenuId=$hId";
                $accountResult=$conn->query($sqla) or die($conn->error);
                $account=$accountResult->fetch_assoc();

                $sqlb="SELECT * FROM postcomment WHERE PostId=$postId";
                $commentResult=$conn->query($sqlb) or die($conn->error);

                $sqlb="SELECT COUNT(*) FROM postcomment WHERE PostId=$postId";
                $countResult=$conn->query($sqlb) or die($conn->error);
                $countRow=$countResult->fetch_row();
                $count=$countRow[0];


                ?>
                <tr>
                  <td><h3><a href="post.php?postId=<?php echo $postId; ?> "><?php echo $postTtitle;?></a>
                  </h3></td>
                  <td><h3><?php echo $postcategory; ?></h3></td>
                  <td><h3><?php echo $price; ?>元</h3></td>
                  <td><h3><a href="post.php?postId=<?php echo $postId; ?>"><?php echo $count;?></a>
                  </h3></td>
                  <td><h3><a href="account.php?hId=<?php echo $hId;?> "><?php echo $account['UserName'];?></a> </h3> </td>
                  <td><h3><?php echo $posttime; ?></h3></td>
                </tr>
                <?php
              }?></table>
            </div>
          </div>
          <div class="pagination">
            <?php
            echo displayPaginationBelow($setLimit,$page,$total);
            ?>
          </div>
          <footer>
            <?php  include('./layout/footer.inc.php');?></footer>

            <script src="js/jquery.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/ie10-viewport-bug-workaround.js"></script>

          </body>
          </html>
