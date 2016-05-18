<?php

session_start();
if (isset($_SESSION['henuid'])) {
  if ($_SESSION['henuid']==1) {
   include('./layout/administrateHeader.inc.php');
 }else{
  include('./layout/loggedHeader.inc.php');
}
}else{
  include('./layout/header.inc.php');
}
$message="";
require_once('includes/connection.inc.php');

if(!isset($_GET['postId']))
{
 echo "查看帖子信息出错！";
}else{

  $postId = intval($_GET['postId']);

  $sql="SELECT * FROM post WHERE PostId= $postId ";
  $result=$conn->query($sql) or die($conn->error);
  $row=$result->fetch_assoc();
  $postTitle=$row['PostTitle'];
  $PostContent=$row['PostContent'];
  $postCategory=$row['PostCategory'];
  if ($postCategory==0) {
    $postcategory="我需要帮助";
  }else{
    $postcategory="我能提供帮助";
  }
  $hId=$row['HenuId'];

  $sqla="SELECT * FROM account WHERE HenuId=$hId";
  $accountResult=$conn->query($sqla) or die($conn->error);
  $account=$accountResult->fetch_assoc();
  $username=$account['UserName'];


  if (isset($_POST['commit'])) {

    if (!isset($_SESSION['henuid'])){
      $message='请登录后进行操作！';
    }else{
     $henuid=$_SESSION['henuid'];
     date_default_timezone_set("Asia/Shanghai");
     $commentTime=date('Y-m-d H:i:s');
     $postCommentContent=$conn->real_escape_string($_POST['comment']);

     $sqlC="INSERT INTO postcomment(PostId,HenuId,PostCommentContent,PostCommentTime)VALUES('$postId','$henuid','$postCommentContent','$commentTime')";
     if ($conn->query($sqlC)) {
      $message="添加评论成功!";
    }
    else {
     $message="添加评论失败!";
   }
 }
}
}
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
  <link href="css/post.css" rel="stylesheet">

  <title>河大帮帮网
    <?php if(isset($title)) {echo "&#8212;{$title}"; }?></title>
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>

  <div class="container">
    <div>
      <div class="col-sm-2 ">
        <h3><a href="account.php?hId=<?php echo $hId;?>"><?php echo $username; ?></a></h3>
      </div>

      <div  class="col-sm-9">

        <div>
          <h2>标题：</h2><h3 ><?php echo $postTitle; ?>【帖子类型：<?php echo $postcategory; ?>】</h3>
          <br>
          <div class="content"><h2>内容：</h2><h3><?php echo $PostContent; ?></h3>
          </div>

        </div>

        <div >
          <br><br><br><br>
          <h3>评论</h3>
          <?php  if ($message) {   echo "<h5>$message</h5>";  }  ?>
          <form method="post">
            <textarea  name="comment" placeholder="写下你的评论~" rows="3" required></textarea>
            <button name="commit" type="submit">提交</button>
          </form>
        </div>
        <?php

        $commentsql="SELECT * FROM postcomment t,account d WHERE t.HenuId=d.HenuId && PostId=$postId  ORDER BY postCommentId LIMIT 0 , 100";

        $result=$conn->query($commentsql) or die($conn->error);

        while ($row=$result->fetch_assoc()) {
         $commentHenuId=$row['HenuId'];
         $postCommentContent=$row['PostCommentContent'];
         $postCommentTime=$row['PostCommentTime'];
         $username=$row['UserName'];
         ?>
         <div >
          <hr>
          <h4><a href="account.php?HId=<?php echo $commentHenuId;?>" ><?php echo $username; ?></a></h4>
          <h4 ><?php echo $postCommentContent; ?></h4>
          <h4 class="text-right"><?php echo $postCommentTime;?></h4>

        </div>
        <?php
      }
      ?>
    </div >
  </div>
</div>


<footer>
  <?php  include('./layout/footer.inc.php');?></footer>

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>
