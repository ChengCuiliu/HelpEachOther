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

 $itemid=0;
 if(isset($_GET['itemid']))
 {
  $itemid = intval($_GET['itemid']);
}

$message="";
$useraddress="";
$lease=0;
$time2=null;

$items="SELECT * FROM itemorder  WHERE OrderId = (SELECT MAX(OrderId) FROM itemorder WHERE ItemId= $itemid)";
$itemResults=$conn->query($items) or die($conn->error);
$itemRows=$itemResults->fetch_assoc();
$userid=$itemRows['UserId'];


$n="SELECT UserName FROM account WHERE HenuId= $userid ";
$r=$conn->query($n) or die($conn->error);
$s=$r->fetch_assoc();
$ordername=$s['UserName'];

$orderlease=$itemRows['Lease'];
$orderaddress=$itemRows['UserAddress'];
$orderstatus=$itemRows['Status'];
$birthtime=$itemRows['BirthTime'];
$dealtime=$itemRows['DealTime'];

$itemsql="SELECT * FROM item WHERE ItemId= $itemid ";
$itemResult=$conn->query($itemsql) or die($conn->error);
$itemRow=$itemResult->fetch_assoc();

$itemcateid=$itemRow['CateId'];
$price=$itemRow['Price'];
$payid=$itemRow['PayId'];
$status=$itemRow['Status'];

$sqlc="SELECT * FROM itemcategory WHERE CateId=$itemcateid";
$resultc=$conn->query($sqlc)or die($conn->error);
$row=$resultc->fetch_assoc();
$catename=$row['CateName'];
$name=$itemRow['ItemName'];
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
 $address=$itemRow['Address'];
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

if (isset($_POST['finish'])) {
  if ($orderstatus==1) {
    $message="订单已处理，请处理其他订单。";
  }else{
   date_default_timezone_set("Asia/Shanghai");
   $time=date('Y-m-d H:i:s');
   $sql="UPDATE itemorder SET Status=1, DealTime='$time' WHERE ItemId=$itemid&&UserId=$userid";
   $result=$conn->query($sql)or die($conn->error);

   if ( $property=="出租") {
    $sql="UPDATE item SET Status=2 WHERE ItemId=$itemid";
    $result=$conn->query($sql)or die($conn->error);
  }else{
    $sql="UPDATE item SET Status=3 WHERE ItemId=$itemid";
    $result=$conn->query($sql)or die($conn->error);
  }
  $message="成功处理订单。";
}
}

if (isset($_POST['back'])) {
 date_default_timezone_set("Asia/Shanghai");
 $time3=date('Y-m-d H:i:s');

 $sql="UPDATE itemorder SET BackTime='$time3' WHERE ItemId=$itemid";
 $result=$conn->query($sql)or die($conn->error);

 $sql="UPDATE item SET Status=0 WHERE ItemId=$itemid";
 $result=$conn->query($sql)or die($conn->error);

 $message="物品处于可租状态";
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
  <link rel="stylesheet" type="text/css" href="css/order.css" />

  <title>河大帮帮网</title>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <div class="main">
        <form class="cbp-mc-form" method="post" multipart="" enctype="multipart/form-data">
         <div class="cbp-mc-column">
          <div >
            <h2>
              ￥
              <?php echo $price; ?></h2>
              <hr>
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
                        <?php echo $shipment;
                        ?>
                      </h3>
                    </li>
                    <?php
                    if ($shipment=="送货上门") {   ?> <li>
                    <h3>  收货地址： <?php echo $orderaddress; ?></h3>
                  </li>
                  <?php
                }
                ?>
                <li>
                  <h3>
                    支付方式：
                    <?php echo $payment; ?></h3>
                  </li>
                  <li>
                    <h3>
                     订货方：
                     <a href="account.php?HId=<?php echo $userid; ?>
                      ">
                      <?php echo $ordername; ?>
                    </a>
                  </h3>
                </li>

                <?php if ($property=="出租") {?>
                <li>
                  <h3>
                    租期：
                    <?php echo $orderlease; ?>天</h3>
                    <li>
                      <h3>
                        下单时间：
                        <?php echo $birthtime; ?></h3>
                      </li>
                      <li>
                      </li>
                      <?php  } ?>
                      <?php if ($orderstatus==1) {?>
                      <li>
                        <h3>
                          交易时间：
                          <?php echo $dealtime; ?></h3>
                        </li>
                        <li>
                          <?php }  if ($time2!=null) {?>
                          <li>
                            <h3>
                              交易时间：
                              <?php echo $time2; ?></h3>
                            </li>
                            <?php} if ($time3!=null) {?>
                            <li>
                              <h3>
                                归还时间：
                                <?php echo $time3; ?></h3>
                              </li>
                              <li>
                                <?php } ?>
                              </ul>
                            </div>
                          </div>
                          <?php

                          if($status==3){?>
                          <h3><?php echo "物品已售出"; ?></h3>
                          <?php } elseif ($orderstatus==1) {?>
                          <form class="input-group" method="post">
                            <span class="input-group-btn">
                              <button  name="back" class="btn btn-primary"  type="submit">已经归还</button>
                            </span>
                            <h3><?php echo $message; ?></h3>
                          </form>
                          <?php }else{?>
                          <form class="input-group" method="post">
                            <span class="input-group-btn">
                              <button  name="finish" class="btn btn-primary"  type="submit">确认交易</button>
                            </span>
                            <h3><?php echo $message; ?></h3>
                          </form>

                          <?php }?>
                        </div>

                      </div>
                    </form>
                  </div>
                  <footer>
                   <?php  include('./layout/footer.inc.php');?></footer>
                 </body>
                 </html>

