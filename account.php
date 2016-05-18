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

$hid=$henuid;

if(isset($_GET['HId']))
{
  $hid = intval($_GET['HId']);
}

$sqla="SELECT * FROM account WHERE HenuId=$hid";
$accountResult=$conn->query($sqla) or die($conn->error);
$account=$accountResult->fetch_assoc();
$Name=$account['UserName'];
$email=$account['Email'];
$phone=$account['Phone'];
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
  <link href="css/myaccount.css" rel="stylesheet">

  <title>河大帮帮网<?php if(isset($title)) {echo "&#8212;{$title}"; }?></title>
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  <div class="container">
    <h2>用户名：<?php echo $Name; ?></h2>
    <h3>河大学号：<?php echo $hid; ?></h3>
    <h3>邮箱：<?php echo $email; ?></h3>
    <h3>手机号码：<?php echo $phone; ?></h3>

    <br>

    <h3>TA的物品</h3>

    <?php
    $sql="SELECT * FROM item WHERE HenuId=$hid ORDER BY ItemId DESC limit 1,10";
    $result=$conn->query($sql) or die($conn->error);
    ?>

    <table class="table">
      <tr>
        <th><h4>名称</h4></th>
        <th><h4>价格</h4></th>
        <th><h4>属性</h4></th>
        <th><h4>发货方式</h4></th>
        <th><h4>支付方式</h4></th>
      </tr>
      <?php
      while ($row=$result->fetch_assoc()){
       $itemid=$row['ItemId'];
       $itemName=$row['ItemName'];
       $price=$row['Price'];
       $property=$row['Property'];
       if ($property==1) {
         $property= "出售";
       }elseif ($property==2)
       {
        $property= "出租";
      }else{
        $property= "免费";
      }
      $itemPrice=$row['Price'];
      $shipment=$row['Shipment'];
      if ($shipment==1) {
        $shipment= "送货上门";
      }else{
       $shipment= "买家自取";
     }
     $payment=$row['Payment'];
     if ($payment==0) {
      $payment= "免费";
    }elseif ($payment==1){
      $payment= "货到付款";
    }elseif ($payment==2){
      $payment= "提前支付";
    }elseif ($payment==2){
      $payment= "一天一付";
    }else{
      $payment= "租完总付";
    }

    ?>
    <tr>
      <td><h4><a href="item.php?itemid=<?php echo $itemid; ?>"><?php echo $itemName;?></a></h4></td>
      <td><h4><?php echo $itemPrice;?></h4></td>
      <td><h4><?php echo $property;?></h4></td>
      <td><h4><?php echo $shipment;?></h4></td>
      <td><h4><?php echo $payment;?></h4></td>
    </tr>
    <?php
  }?>
</table>


<h3>TA的帖子   <a href="editPost.php?hId=<?php echo $hid;?>" class="more">发帖<span aria-hidden="true">&raquo;</span>
</a></h3>

<?php

$sql="SELECT * FROM post WHERE HenuId=$hid ORDER BY PostId DESC limit  1,10";

$result=$conn->query($sql) or die($conn->error);
?>

<table class="table">
  <tr>
   <th><h4>标题</h4></th>
   <th><h4>评论</h4></th>
   <th><h4>发帖时间</h4></th>
 </tr>
 <?php
 while ($row=$result->fetch_assoc()) {
  $postId=$row['PostId'];
  $postTtitle=$row['PostTitle'];
  $postTime=$row['PostTime'];
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
    <td><h4><a href="post.php?postId=<?php echo $postId; ?>"><?php echo $postTtitle;?></a></h4></td>
    <td><h4><a href="post.php?postId=<?php echo $postId; ?>"><?php echo $count;?></a></h4></td>
    <td><h4><?php echo $postTime;?></h4></td>
  </tr>
  <?php
}?>
</table>
</div>
<footer>
  <?php  include('./layout/footer.inc.php');?>
</footer>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>
