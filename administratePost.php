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

require_once('includes/connection.inc.php');
require_once('includes/function.php');


$message="";
$delnum=0;
$total=0;
$postnum=0;
$henuid=null;
if(isset($_GET["page"]))
  $page = (int)$_GET["page"];
else
  $page = 1;

$setLimit = 8;
$pageLimit = ($page * $setLimit) - $setLimit;

$sql="SELECT COUNT(*) FROM post ";
$result=$conn->query($sql);
$numrows=$result->fetch_row();
$total=$numrows[0];

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
  <link href="css/cart.css" rel="stylesheet">

  <title>河大帮帮网
    <?php if(isset($title)) {echo "&#8212;{$title}"; }?></title>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">

      var checkall=document.getElementsByName("dell[]");
            function select(){                          //全选
              for(var $i=0;$i<checkall.length;$i++){
                checkall[$i].checked=true;
              }
            }
            function fanselect(){                        //反选
              for(var $i=0;$i<checkall.length;$i++){
                if(checkall[$i].checked){
                  checkall[$i].checked=false;
                }else{
                  checkall[$i].checked=true;
                }
              }
            }
            function noselect(){                          //全不选
              for(var $i=0;$i<checkall.length;$i++){
                checkall[$i].checked=false;
              }
            }
          </script></head>
          <body>
            <div class="container">
              <h3>所有帖子</h3>

              <?php
              if(isset($_GET['del'])){
                $postId=$_GET['del'];
                $sql5="DELETE FROM postcomment WHERE PostId=$postId";
                $conn->query($sql5) or die($conn->error);
                $sql6="DELETE FROM post WHERE  PostId=$postId";
                $result=$conn->query($sql6) or die($conn->error) ;
              }

              if(isset($_GET['fin'])){
                $postId=$_GET['fin'];
                $sql7="UPDATE post SET PostStatus=1 WHERE PostId=$postId";
                $conn->query($sql7) or die($conn->error);
              }


              $sql="SELECT * FROM post ORDER BY PostId DESC  LIMIT ".$pageLimit." , ".$setLimit;

              $result=$conn->query($sql) or die($conn->error);
              ?>
              <form method="post">
                <table class="table">
                  <tr>
                   <th><h4>标题</h4></th>
                   <th><h4>种类</h4></th>
                   <th><h4>价格</h4></th>
                   <th><h4>评论</h4></th>
                   <th><h4>发帖时间</h4></th>
                   <th><h4>状态</h4></th>
                   <th><h4>删除</h4></th>

                 </tr>
                 <?php

                 while ($row=$result->fetch_assoc()) {
                  $postnum++;
                  $postId=$row['PostId'];
                  $postTitle=$row['PostTitle'];
                  $postcategory=$row['PostCategory'];
                  if ($postcategory==0) {
                    $postcategory="我需要帮助";
                  }else{
                    $postcategory="我能提供帮助";
                  }
                  $price=$row['Price'];
                  $poststatus=$row['PostStatus'];
                  if ($poststatus==0) {
                    $poststatus="未结贴";
                  }else{
                    $poststatus="已结贴";
                  }
                  $postTime=$row['PostTime'];
                  $hId=$row['HenuId'];

                  $sqlb="SELECT COUNT(*) FROM postcomment WHERE PostId=$postId";
                  $countResult=$conn->query($sqlb) or die($conn->error);
                  $countRow=$countResult->fetch_row();
                  $count=$countRow[0];
                  ?>
                  <tr>
                    <td><h4><a href="post.php?postId=<?php echo $postId; ?>"><?php echo $postTitle;?></a></h4></td>
                    <td><h4><?php echo $postcategory;?></h4></td>
                    <td><h4><?php echo $price;?></h4></td>
                    <td><h4><a href="post.php?postId=<?php echo $postId; ?>"><?php echo $count;?></a></h4></td>
                    <td><h4><?php echo $postTime;?></h4></td>
                    <td><h4><?php echo $poststatus;?></h4></td>
                    <td><h4> <a onclick="return confirm('确定要删除帖子<?php echo $postTitle;?>吗？')" href="myaccount.php?del=<?php echo $postId;?>">删除 </a>
                    </h4></td>
                  </tr>
                  <?php

                }?>
              </table>
            </form>
          </div>
          <div class="pagination">
            <?php
            echo displayPaginationBelow($setLimit,$page,$total);
            ?></div>
            <footer>
              <?php  include('./layout/footer.inc.php');?>
            </footer>

            <script src="js/jquery.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/ie10-viewport-bug-workaround.js"></script>

          </body>

          </html>
