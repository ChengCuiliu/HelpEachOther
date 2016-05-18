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


$message="";
$delnum=0;
$total=0;
if(isset($_GET["page"]))
  $page = (int)$_GET["page"];
else
  $page = 1;

$setLimit = 5;
$pageLimit = ($page * $setLimit) - $setLimit;

$sql="SELECT COUNT(*) FROM item WHERE HenuId=$henuid";
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
              <h3>所有物品<?php echo $message;?></h3>
              <?php
              if(isset($_GET['delitem'])){
                $itemid=$_GET['delitem'];
                $sqlf="DELETE FROM itemphoto WHERE ItemId=$itemid";
                $conn->query($sqlf) or die($conn->error);
                $sqlg="DELETE FROM itemcomment WHERE ItemId=$itemid";
                $conn->query($sqlg) or die($conn->error);
                $sqli="DELETE FROM cart WHERE ItemId=$itemid";
                $conn->query($sqli) or die($conn->error);
                $sqld="DELETE FROM item WHERE ItemId=$itemid";
                $result=$conn->query($sqld) or die($conn->error);
              }

              $sql="SELECT * FROM item WHERE HenuId=$henuid ORDER BY ItemId DESC LIMIT ".$pageLimit." , ".$setLimit;
              $result=$conn->query($sql) or die($conn->error);

              ?>
              <form method="post">

                <table class="table">
                  <tr>
                    <th><h3>名称</h3></th>
                    <th><h3>价格</h3></th>
                    <th><h3>押金</h3></th>
                    <th><h3>属性</h3></th>
                    <th><h3>发货方式</h3></th>
                    <th><h3>支付方式</h3></th>
                    <th><h3>状态</h3></th>
                    <th><h3>操作</h3></th>
                    <th><h3></h3></th>
                  </tr>
                  <?php
                  while ($row=$result->fetch_assoc()){
                    $delnum++;
                    $itemid=$row['ItemId'];
                    $itemids[$delnum]=$itemid;
                    $itemName=$row['ItemName'];
                    $price=$row['Price'];
                    $despoit=$row['Despoit'];
                    $property=$row['Property'];
                    $status=$row['Status'];


                    if ($status==0) {
                      $status="暂无订单";
                    }elseif ($status==2) {
                      $status="物品出租中";
                    }elseif ($status==3){
                      $status="物品已售出";
                    }else{
                      $status="订单待处理";
                    }

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
                  <td><h3><a href="item.php?itemid=<?php echo $itemid; ?>"><?php echo $itemName;?></a></h3></td>
                  <td><h3><?php echo $itemPrice;   if ($property=="出租") {
                   echo "/天";
                 } ?></h3></td>
                 <td><h3><?php echo $despoit;?></h3></td>
                 <td><h3><?php echo $property;?></h3></td>
                 <td><h3><?php echo $shipment;?></h3></td>
                 <td><h3><?php echo $payment;?></h3></td>
                 <td><h3><?php echo $status;?></h3></td>
                 <td><h3>
                  <?php if ($status=="暂无订单") {?>
                  <a onclick="return confirm('确定要删除物品<?php echo $itemName;?>吗？')" href="myaccount.php?delitem=<?php echo $itemid;?>">删除
                  </a>
                  <?php }elseif ($status=="订单待处理") {
                    ?>
                    <a  class="btn btn-primary" href="dealOrder.php?itemid=<?php echo $itemid; ?>" role="button">处理</a>
                    <?php }elseif ($status=="物品出租中") {?>
                    <a  class="btn btn-default" href="dealorder.php?itemid=<?php echo $itemid; ?>" role="button">归还</a>
                    <?php }else {    ?>
                    已售
                    <?php }?>
                  </h3></td>
                  <td><h3></h3></td>
                </tr>
                <?php
              }
              ?>
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
