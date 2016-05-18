<<<<<<< HEAD
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
$message="";
$com="";

require_once('includes/function.php');

if(isset($_GET['itemid']))
{
  $itemid = intval($_GET['itemid']);
}
else
{
  $itemid = 68;
}

if(isset($_GET["page"]))
  $page = (int)$_GET["page"];
else
  $page = 1;

$setLimit = 100;
$pageLimit = ($page * $setLimit) - $setLimit;

require_once('includes/connection.inc.php');

$getCommentCount="SELECT COUNT(*) FROM itemcomment WHERE ItemId= $itemid ";
$commentCount=$conn->
query($getCommentCount);
$commentCountRow=$commentCount->fetch_row();
$total=$commentCountRow[0];

if ($total==0) {
  $com="暂无评论!";
}

$itemsql="SELECT * FROM item WHERE ItemId= $itemid ";
$itemResult=$conn->query($itemsql) or die($conn->error);
  #$numRows=$result->num_rows;
$itemRow=$itemResult->fetch_assoc();

$itemcateid=$itemRow['CateId'];
$sqlc="SELECT * FROM itemcategory WHERE CateId=$itemcateid";
$resultc=$conn->query($sqlc)or die($conn->error);
$row=$resultc->fetch_assoc();
$catename=$row['CateName'];
$name=$itemRow['ItemName'];
$status=$itemRow['Status'];
$property=$itemRow['Property'];
if ($property==1) {
 $property= "出售";
}elseif ($property==2)
{
  $property= "出租";
  $despoit=$itemRow['Despoit'];
}else{
  $property= "免费";
}

$shipment=$itemRow['Shipment'] ;
if ($shipment==1) {
  $shipment= "送货上门";
}else{
 $shipment= "买家自取";
}

$payment=$itemRow['Payment'] ;
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

$hid=$itemRow['HenuId'];
$sqlc="SELECT * FROM account WHERE HenuId=$hid";
$resultc=$conn->query($sqlc)or die($conn->error);
$row=$resultc->fetch_assoc();
$username=$row['UserName'];

$photosql="SELECT * FROM itemphoto WHERE ItemId= $itemid ";
$photoResult=$conn->query($photosql) or die($conn->error);

$getPhotoCount="SELECT COUNT(*) FROM itemphoto WHERE ItemId= $itemid ";
$photoCount=$conn->query($getPhotoCount);
$photoCountRow=$photoCount->fetch_row();
$photoNum=$photoCountRow[0];

if (isset($_POST['commit'])) {
  if (!isset($_SESSION['henuid'])){
   $com='请登录后进行操作！';
 }else{
   $henuid=$_SESSION['henuid'];
   date_default_timezone_set("Asia/Shanghai");
   $commentTime=date('Y-m-d H:i:s');

   $itemCommentContent=$conn->real_escape_string($_POST['comment']);

   $sqlC="INSERT INTO itemcomment(ItemId,HenuId,ItemCommentContent,ItemCommentTime)VALUES('$itemid','$henuid','$itemCommentContent','$commentTime')";
   if ($conn->query($sqlC)) {
     $com== "添加评论成功!";
   }
   else {
    $com== "添加评论失败!";
  }
}
}
if (isset($_POST['addToCart'])) {

  if (!isset($_SESSION['henuid'])){
    $message='请登录后进行操作！';
  }else{
    $henuid=$_SESSION['henuid'];
/*
    $itemCount=$conn->real_escape_string($_POST['itemCount']);
    if ($itemCount
      <=0) {
      $message= "请输入有效数字！";
  }else{
*/
    $sqld="SELECT * FROM cart WHERE ItemId= $itemid &&HenuId=$henuid";
    if ($conn->query($sqld)) {
      $dresult=$conn->query($sqld) or die ($conn->error);
      $itemNum=$dresult->num_rows;

      if ($itemNum==0) {
        $sqle="INSERT INTO cart(ItemId,HenuId)VALUES('$itemid','$henuid')";
        if ($conn->query($sqle)) {
         $message="已成功添加至购物车!";
       }else{
        $message="添加到购物车失败!";
      }
    }else{
      $message="该物品已添加过!";
    }
  }
 /* }else{
    $sqlf="UPDATE cart SET ItemCount=ItemCount+$itemCount WHERE HenuId=$henuid && ItemId=$itemid";
    if ($conn->query($sqlf)) {
      $message="再次添加到购物车成功!";
    }else
    {
     $message= "再次添加到购物车失败!";
   }
 }
}*/
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
  <link href="css/item.css" rel="stylesheet">

  <title>河大帮帮网
    <?php if(isset($title)) {echo "&#8212;{$title}"; }?></title>
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]--> </head>
      <body>
        <div class="container" id="wrapper">
          <div class="col-sm-8">
            <div id="side-carousel" class="carousel slide row" data-ride="carousel">
              <ol class="carousel-indicators">

                <?php
                for ($i=0; $i < $photoNum; $i++) {
                  ?>
                  <li data-target="#side-carousel" data-slide-to="<?php echo $i; ?>
                    " class="
                    <?php if ($i==0) echo "active"; ?>"></li>
                    <?php
                  }
                  ?></ol>

                  <div class="carousel-inner photoBorder" role="listbox">

                    <?php
                    $index=0;
                    while ($photoRow=$photoResult->
                      fetch_assoc()) {
                     $data=$photoRow['PhotoData'];
                   $type=$photoRow['PhotoType'];
                   ?>
                   <div class="item <?php if($index==0)  echo "active";?>
                    ">
                    <img class="img-responsive photo" src="data:<?php echo $type?>
                    ;base64,
                    <?php echo base64_encode( $data ); ?>" alt=""></div>
                    <?php
                    $index++;
                  }
                  ?>

                  <a class="left carousel-control" href="#side-carousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#side-carousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>

                </div>
              </div>

              <div>
                <div >
                  <h3>评论</h3>
                  <?php  if ($com) {   echo "<h3>$com</h3>
                  ";  }  ?>
                  <form method="post">
                    <textarea  name="comment" placeholder="写下你的评论~" rows="3" required></textarea>
                    <button name="commit" type="submit" >提交</button>
                  </form>
                </div>
                <?php

                $commentsql="SELECT * FROM itemcomment t,account d WHERE t.HenuId=d.HenuId && ItemId=$itemid ORDER BY ItemCommentId LIMIT ".$pageLimit." , ".$setLimit;
                $result=$conn->
                query($commentsql) or die($conn->error);

                while ($row=$result->fetch_assoc()) {
                 $commentHenuId=$row['HenuId'];
                 $username=$row['UserName'];
                 $itemCommentContent=$row['ItemCommentContent'];
                 $itemCommentTime=$row['ItemCommentTime'];
                 ?>
                 <div >
                  <hr>
                  <h3>
                    <a href="account.php?HId=<?php echo $commentHenuId;?>
                      " >
                      <?php echo $username; ?></a>
                    </h3>
                    <h3>
                      <?php echo $itemCommentContent; ?></h3>
                      <h3 class="text-right">
                        <?php echo $itemCommentTime;?></h3>

                      </div>
                      <?php
                    }
                    ?>
                    <div class="pagination">
                      <?php
                      echo displayPaginationBelow($setLimit,$page,$total);
                      ?></div>
                      <?php
                      ?></div>

                    </div>

                    <div class="col-sm-3">
                      <div >
                        <h2 class="text-left">
                          ￥
                          <?php echo $itemRow['Price'] ?></h2>
                          <hr>
                          <p>
                            <div >
                              <ul class="list-unstyled">
                                <li>
                                  <h3>
                                    物品名称：
                                    <?php echo  $name;?></h3>
                                  </li>
                                  <li>
                                    <h3>
                                      物品类别：
                                      <?php  echo $catename; ?>
                                    </h3>
                                  </li>
                                  <li>
                                    <h3>
                                      物品性质：
                                      <?php echo $property;?>
                                    </h3>
                                  </li>

                                  <?php
                                  if (isset($despoit)) {
                                    ?>
                                    <li>
                                      <h3>
                                        押金：
                                        <?php echo $despoit;?>
                                      </h3>
                                    </li>
                                    <?php
                                  }
                                  ?>
                                  <li>
                                    <h3>
                                      发货方式：
                                      <?php echo $shipment;?></h3>
                                    </li>
                                    <li>
                                      <h3>
                                        支付方式：
                                        <?php echo $payment; ?></h3>
                                      </li>
                                      <?php if (!isset($_SESSION['henuid'])) {?>
                                      <li>
                                        <h3>登录后方可查看发布者信息
                                        </h3>
                                      </li>
                                      <?php }else{?>
                                      <li>
                                        <h3>
                                          发布者：
                                          <a href="account.php?HId=<?php echo $itemRow['HenuId'] ?>
                                            ">
                                            <?php echo $username;    ?>
                                          </h3>
                                        </a>
                                      </li>

                                      <?php }?>
                                    </ul>
                                  </div>
                                </div>

                                <hr>
                                <h3>
                                  <?php echo $itemRow['ItemDes'] ?></h3>
                                  <hr>

                                  <?php
                                  if ( isset($henuid) && $hid==$henuid) {?>
                                  <li>
                                    <h3>这是您发布的物品
                                    </h3>
                                  </li>
                                  <?php }elseif ($status==1) {?>
                                  <li><h3>此物品已被下订单</h3></li>
                                  <?php }elseif ($status==2) {?>
                                  <li> <h3>此物品正在出租中</h3></li>
                                  <?php }elseif ($status==3) {?>
                                  <li> <h3>此物品已售出</h3></li>
                                  <?php }elseif ($property!="出租") {?>

                                  <form class="input-group" method="post">
                                    <button name="addToCart" class="btn btn-default" type="submit">
                                      <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                                      加入购物车
                                    </button>
                                    <a href="order.php?itemid=<?php echo $itemid; ?>" class="btn btn-primary" role="button">
                                      立即购买</a>
                                    </form>
                                    <?php
                                  }  else{
                                    ?>
                                    <form class="input-group" method="post">
                                      <span class="input-group-btn">
                                        <a  class="btn btn-primary" href="order.php?itemid=<?php echo $itemid; ?>" role="button">确认租入</a>
                                      </span>
                                    </form>
                                    <?php
                                  }
                                  ?>

                                  <?php  if ($com) {   echo "<h5>$message</h5>
                                  ";  }  ?>
                                </p>
                              </div>
                            </div>

                            <footer>
                              <?php  include('./layout/footer.inc.php');?></footer>

                              <script src="js/jquery.min.js"></script>
                              <script src="js/bootstrap.min.js"></script>
                              <script src="js/ie10-viewport-bug-workaround.js"></script>
                              <script src="js/holder.min.js"></script>

                            </body>
                            </html>
=======
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
$message="";
$com="";

require_once('includes/function.php');

if(isset($_GET['itemid']))
{
  $itemid = intval($_GET['itemid']);
}
else
{
  $itemid = 68;
}

if(isset($_GET["page"]))
  $page = (int)$_GET["page"];
else
  $page = 1;

$setLimit = 100;
$pageLimit = ($page * $setLimit) - $setLimit;

require_once('includes/connection.inc.php');

$getCommentCount="SELECT COUNT(*) FROM itemcomment WHERE ItemId= $itemid ";
$commentCount=$conn->
query($getCommentCount);
$commentCountRow=$commentCount->fetch_row();
$total=$commentCountRow[0];

if ($total==0) {
  $com="暂无评论!";
}

$itemsql="SELECT * FROM item WHERE ItemId= $itemid ";
$itemResult=$conn->query($itemsql) or die($conn->error);
  #$numRows=$result->num_rows;
$itemRow=$itemResult->fetch_assoc();

$itemcateid=$itemRow['CateId'];
$sqlc="SELECT * FROM itemcategory WHERE CateId=$itemcateid";
$resultc=$conn->query($sqlc)or die($conn->error);
$row=$resultc->fetch_assoc();
$catename=$row['CateName'];
$name=$itemRow['ItemName'];
$status=$itemRow['Status'];
$property=$itemRow['Property'];
if ($property==1) {
 $property= "出售";
}elseif ($property==2)
{
  $property= "出租";
  $despoit=$itemRow['Despoit'];
}else{
  $property= "免费";
}

$shipment=$itemRow['Shipment'] ;
if ($shipment==1) {
  $shipment= "送货上门";
}else{
 $shipment= "买家自取";
}

$payment=$itemRow['Payment'] ;
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

$hid=$itemRow['HenuId'];
$sqlc="SELECT * FROM account WHERE HenuId=$hid";
$resultc=$conn->query($sqlc)or die($conn->error);
$row=$resultc->fetch_assoc();
$username=$row['UserName'];

$photosql="SELECT * FROM itemphoto WHERE ItemId= $itemid ";
$photoResult=$conn->query($photosql) or die($conn->error);

$getPhotoCount="SELECT COUNT(*) FROM itemphoto WHERE ItemId= $itemid ";
$photoCount=$conn->query($getPhotoCount);
$photoCountRow=$photoCount->fetch_row();
$photoNum=$photoCountRow[0];

if (isset($_POST['commit'])) {
  if (!isset($_SESSION['henuid'])){
   $com='请登录后进行操作！';
 }else{
   $henuid=$_SESSION['henuid'];
   date_default_timezone_set("Asia/Shanghai");
   $commentTime=date('Y-m-d H:i:s');

   $itemCommentContent=$conn->real_escape_string($_POST['comment']);

   $sqlC="INSERT INTO itemcomment(ItemId,HenuId,ItemCommentContent,ItemCommentTime)VALUES('$itemid','$henuid','$itemCommentContent','$commentTime')";
   if ($conn->query($sqlC)) {
     $com== "添加评论成功!";
   }
   else {
    $com== "添加评论失败!";
  }
}
}
if (isset($_POST['addToCart'])) {

  if (!isset($_SESSION['henuid'])){
    $message='请登录后进行操作！';
  }else{
    $henuid=$_SESSION['henuid'];
/*
    $itemCount=$conn->real_escape_string($_POST['itemCount']);
    if ($itemCount
      <=0) {
      $message= "请输入有效数字！";
  }else{
*/
    $sqld="SELECT * FROM cart WHERE ItemId= $itemid &&HenuId=$henuid";
    if ($conn->query($sqld)) {
      $dresult=$conn->query($sqld) or die ($conn->error);
      $itemNum=$dresult->num_rows;

      if ($itemNum==0) {
        $sqle="INSERT INTO cart(ItemId,HenuId)VALUES('$itemid','$henuid')";
        if ($conn->query($sqle)) {
         $message="已成功添加至购物车!";
       }else{
        $message="添加到购物车失败!";
      }
    }else{
      $message="该物品已添加过!";
    }
  }
 /* }else{
    $sqlf="UPDATE cart SET ItemCount=ItemCount+$itemCount WHERE HenuId=$henuid && ItemId=$itemid";
    if ($conn->query($sqlf)) {
      $message="再次添加到购物车成功!";
    }else
    {
     $message= "再次添加到购物车失败!";
   }
 }
}*/
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
  <link href="css/item.css" rel="stylesheet">

  <title>河大帮帮网
    <?php if(isset($title)) {echo "&#8212;{$title}"; }?></title>
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]--> </head>
      <body>
        <div class="container" id="wrapper">
          <div class="col-sm-8">
            <div id="side-carousel" class="carousel slide row" data-ride="carousel">
              <ol class="carousel-indicators">

                <?php
                for ($i=0; $i < $photoNum; $i++) {
                  ?>
                  <li data-target="#side-carousel" data-slide-to="<?php echo $i; ?>
                    " class="
                    <?php if ($i==0) echo "active"; ?>"></li>
                    <?php
                  }
                  ?></ol>

                  <div class="carousel-inner photoBorder" role="listbox">

                    <?php
                    $index=0;
                    while ($photoRow=$photoResult->
                      fetch_assoc()) {
                     $data=$photoRow['PhotoData'];
                   $type=$photoRow['PhotoType'];
                   ?>
                   <div class="item <?php if($index==0)  echo "active";?>
                    ">
                    <img class="img-responsive photo" src="data:<?php echo $type?>
                    ;base64,
                    <?php echo base64_encode( $data ); ?>" alt=""></div>
                    <?php
                    $index++;
                  }
                  ?>

                  <a class="left carousel-control" href="#side-carousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#side-carousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>

                </div>
              </div>

              <div>
                <div >
                  <h3>评论</h3>
                  <?php  if ($com) {   echo "<h3>$com</h3>
                  ";  }  ?>
                  <form method="post">
                    <textarea  name="comment" placeholder="写下你的评论~" rows="3" required></textarea>
                    <button name="commit" type="submit" >提交</button>
                  </form>
                </div>
                <?php

                $commentsql="SELECT * FROM itemcomment t,account d WHERE t.HenuId=d.HenuId && ItemId=$itemid ORDER BY ItemCommentId LIMIT ".$pageLimit." , ".$setLimit;
                $result=$conn->
                query($commentsql) or die($conn->error);

                while ($row=$result->fetch_assoc()) {
                 $commentHenuId=$row['HenuId'];
                 $username=$row['UserName'];
                 $itemCommentContent=$row['ItemCommentContent'];
                 $itemCommentTime=$row['ItemCommentTime'];
                 ?>
                 <div >
                  <hr>
                  <h3>
                    <a href="account.php?HId=<?php echo $commentHenuId;?>
                      " >
                      <?php echo $username; ?></a>
                    </h3>
                    <h3>
                      <?php echo $itemCommentContent; ?></h3>
                      <h3 class="text-right">
                        <?php echo $itemCommentTime;?></h3>

                      </div>
                      <?php
                    }
                    ?>
                    <div class="pagination">
                      <?php
                      echo displayPaginationBelow($setLimit,$page,$total);
                      ?></div>
                      <?php
                      ?></div>

                    </div>

                    <div class="col-sm-3">
                      <div >
                        <h2 class="text-left">
                          ￥
                          <?php echo $itemRow['Price'] ?></h2>
                          <hr>
                          <p>
                            <div >
                              <ul class="list-unstyled">
                                <li>
                                  <h3>
                                    物品名称：
                                    <?php echo  $name;?></h3>
                                  </li>
                                  <li>
                                    <h3>
                                      物品类别：
                                      <?php  echo $catename; ?>
                                    </h3>
                                  </li>
                                  <li>
                                    <h3>
                                      物品性质：
                                      <?php echo $property;?>
                                    </h3>
                                  </li>

                                  <?php
                                  if (isset($despoit)) {
                                    ?>
                                    <li>
                                      <h3>
                                        押金：
                                        <?php echo $despoit;?>
                                      </h3>
                                    </li>
                                    <?php
                                  }
                                  ?>
                                  <li>
                                    <h3>
                                      发货方式：
                                      <?php echo $shipment;?></h3>
                                    </li>
                                    <li>
                                      <h3>
                                        支付方式：
                                        <?php echo $payment; ?></h3>
                                      </li>
                                      <?php if (!isset($_SESSION['henuid'])) {?>
                                      <li>
                                        <h3>登录后方可查看发布者信息
                                        </h3>
                                      </li>
                                      <?php }else{?>
                                      <li>
                                        <h3>
                                          发布者：
                                          <a href="account.php?HId=<?php echo $itemRow['HenuId'] ?>
                                            ">
                                            <?php echo $username;    ?>
                                          </h3>
                                        </a>
                                      </li>

                                      <?php }?>
                                    </ul>
                                  </div>
                                </div>

                                <hr>
                                <h3>
                                  <?php echo $itemRow['ItemDes'] ?></h3>
                                  <hr>

                                  <?php
                                  if ( isset($henuid) && $hid==$henuid) {?>
                                  <li>
                                    <h3>这是您发布的物品
                                    </h3>
                                  </li>
                                  <?php }elseif ($status==1) {?>
                                  <li><h3>此物品已被下订单</h3></li>
                                  <?php }elseif ($status==2) {?>
                                  <li> <h3>此物品正在出租中</h3></li>
                                  <?php }elseif ($status==3) {?>
                                  <li> <h3>此物品已售出</h3></li>
                                  <?php }elseif ($property!="出租") {?>

                                  <form class="input-group" method="post">
                                    <button name="addToCart" class="btn btn-default" type="submit">
                                      <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                                      加入购物车
                                    </button>
                                    <a href="order.php?itemid=<?php echo $itemid; ?>" class="btn btn-primary" role="button">
                                      立即购买</a>
                                    </form>
                                    <?php
                                  }  else{
                                    ?>
                                    <form class="input-group" method="post">
                                      <span class="input-group-btn">
                                        <a  class="btn btn-primary" href="order.php?itemid=<?php echo $itemid; ?>" role="button">确认租入</a>
                                      </span>
                                    </form>
                                    <?php
                                  }
                                  ?>

                                  <?php  if ($com) {   echo "<h5>$message</h5>
                                  ";  }  ?>
                                </p>
                              </div>
                            </div>

                            <footer>
                              <?php  include('./layout/footer.inc.php');?></footer>

                              <script src="js/jquery.min.js"></script>
                              <script src="js/bootstrap.min.js"></script>
                              <script src="js/ie10-viewport-bug-workaround.js"></script>
                              <script src="js/holder.min.js"></script>

                            </body>
                            </html>
>>>>>>> e769018c1717fa08580e854e5f18736d73757250
