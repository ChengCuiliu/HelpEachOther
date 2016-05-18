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

 if(isset($_GET['itemid']))
 {
  $itemid = intval($_GET['itemid']);
}
else
{
  $itemid = 68;
}

$message="";
$useraddress="";
$lease=0;
$status=0;

$itemsql="SELECT * FROM item WHERE ItemId= $itemid ";
$itemResult=$conn->query($itemsql) or die($conn->error);
  #$numRows=$result->num_rows;
$itemRow=$itemResult->fetch_assoc();

$itemcateid=$itemRow['CateId'];
$price=$itemRow['Price'];
$payid=$itemRow['PayId'];
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

if (isset($_POST['rent'])) {
  $sql="SELECT Status FROM item WHERE ItemId=$itemid";
  if ($conn->query($sql))  {
    $result=$conn->query($sql);
    $row=$result->fetch_assoc();
    $status=$row['Status'];
    if ($status==1) {
      $message="此物品已被下订单，如有需要，请联系发布方。";
    }elseif ($status==2) {
      $message="此物品正在出租中，如有需要，请联系发布方。";
    }
    elseif($status==3) {
      $message="此物品已售出，如有需要，请联系发布方。";
    }
    else{
      if (isset($_POST['useraddress'])&&$_POST['useraddress']!="") {
        $useraddress=$conn->real_escape_string($_POST['useraddress']);
      }
      if (isset($_POST['lease'])&&$_POST['lease']!="") {
        $lease=$conn->real_escape_string($_POST['lease']);
      }
      date_default_timezone_set("Asia/Shanghai");
      $time=date('Y-m-d H:i:s');
      $sql="INSERT INTO itemorder(ItemId,UserId,Lease,UserAddress,Status,BirthTime)VALUES('$itemid','$henuid','$lease','$useraddress','$status','$time')";
      if ($conn->query($sql))  {
        $sql="UPDATE item SET Status=1 WHERE ItemId=$itemid";
        if ($conn->query($sql))  {
          $message="成功下单，请在规定时间支付，等待发布方发货";
        }else{
         $message="更新物品状态失败";
       }
     }else{
      $message="下单失败";
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
                        <?php echo $shipment;?>
                      </h3>
                    </li>
                    <?php
                    if ($shipment=="送货上门") {
                      ?>
                      <li>
                        <h3>
                          <input name="useraddress" placeholder="请输入收货地址"  required>
                        </h3>
                      </li>
                      <?php
                    }else{
                      ?>
                      <li>
                        <h3>请到 <?php echo $address; ?> 取货</h3>
                      </li>
                      <?php
                    }
                    ?>

                    <li>
                      <h3>
                        支付方式：
                        <?php echo $payment; ?></h3>
                      </li>
                      <?php if ($payment=="提前支付") {?>
                      <li>
                        <h3>
                          卖家支付宝：
                          <?php echo $payid; ?></h3>
                        </li>
                        <li>
                         <?php } ?>

                         <h3>
                          发布者：
                          <a href="account.php?HId=<?php echo $hid; ?>
                            ">
                            <?php echo $username; ?>
                          </a>
                        </h3>
                      </li>
                      <?php if ($property=="出租") {?>
                      <li>
                        <h3>
                          输入您打算租的天数：
                          <input name="lease" type="number" required />
                        </h3>
                      </li><?php  } ?>
                    </ul>
                  </div>
                </div>
                <?php
                if  (isset($henuid)&&$hid!==$henuid) {?>
                <form class="input-group" method="post">
                  <span class="input-group-btn">
                    <button  name="rent" class="btn btn-primary"  type="submit">提交订单</button>
                  </span>
                  <h3><?php echo $message; ?></h3>
                </form>
                <?php
              }
              ?>
            </div>

          </div>
        </form>
      </div>
      <footer>
       <?php  include('./layout/footer.inc.php');?></footer>
     </body>
     </html>

