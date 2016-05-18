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

$setLimit = 8;
$pageLimit = ($page * $setLimit) - $setLimit;

$sql="SELECT COUNT(*) FROM itemorder WHERE UserId=$henuid";
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
              <h3>我的订单<?php echo $message;?></h3>
              <?php
              if(isset($_GET['cancel'])){
                $orderid=$_GET['cancel'];

                $s="SELECT * FROM itemorder WHERE OrderId=$orderid";
                $r=$conn->query($s) or die($conn->error);
                $w=$r->fetch_assoc();
                $itemid=$w['ItemId'];

                $sqlf="DELETE FROM itemorder WHERE OrderId=$orderid";
                $conn->query($sqlf) or die($conn->error);

                $sqld="UPDATE item SET Status=0 WHERE ItemId=$itemid";
                $result=$conn->query($sqld) or die($conn->error);
              }

              $sql="SELECT * FROM itemorder WHERE UserId=$henuid ORDER BY ItemId DESC LIMIT ".$pageLimit." , ".$setLimit;
              $result=$conn->query($sql) or die($conn->error);

              ?>
              <form method="post">

                <table class="table">
                  <tr>
                    <th><h3>名称</h3></th>
                    <th><h3>属性</h3></th>
                    <th><h3>押金</h3></th>
                    <th><h3>租期</h3></th>
                    <th><h3>价格</h3></th>
                    <th><h3>发货方式</h3></th>
                    <th><h3>买家地址</h3></th>
                    <th><h3>收货地址</h3></th>
                    <th><h3>支付方式</h3></th>
                    <th><h3>买家支付宝</h3></th>
                    <th><h3>订单状态</h3></th>
                    <th><h3>下单时间</h3></th>
                    <th><h3>处理订单时间</h3></th>
                    <th><h3>归还时间</h3></th>
                    <th><h3>操作</h3></th>
                  </tr>
                  <?php
                  while ($row=$result->fetch_assoc()){
                    $delnum++;
                    $orderid=$row['OrderId'];
                    $itemid=$row['ItemId'];
                    $sqln="SELECT * FROM item WHERE ItemId=$itemid";
                    $resultn=$conn->query($sqln) or die($conn->error);
                    $rown=$resultn->fetch_assoc();
                    $itemname=$rown['ItemName'];

                    $property=$rown['Property'];
                    if ($property==1) {
                      $property="出售";
                    }elseif ($property==2) {
                      $property="出租";
                    }else{
                      $property="免费分享";
                    }

                    $despoit=$rown['Despoit'];
                    $price=$rown['Price'];
                    $shipment=$rown['Shipment'];
                    if ($shipment==1) {
                      $shipment="送货上门";
                    }else{
                      $shipment="买家自取";
                    }
                    $address2=$rown['Address'];
                    $payment=$rown['Payment'];
                    if ($payment==1) {
                     $payment="货到付款";
                   }elseif ($payment==2){
                    $payment="提前支付";
                  }elseif($payment==3){
                    $payment="一天一付";
                  }elseif ($payment==4) {
                    $payment="租完总付";
                  }
                  $payid=$rown['PayId'];

                  $itemids[$delnum]=$itemid;

                  $lease=$row['Lease'];
                  $address=$row['UserAddress'];
                  $status=$row['Status'];
                  $birthtime=$row['BirthTime'];
                  $dealtime=$row['DealTime'];
                  $backtime=$row['BackTime'];

                  if ($status==1) {
                    $status="交易已完成";
                  }elseif ($status==0) {
                    $status="订单待处理";
                  }

                  ?>
                  <tr>
                    <td><h3><a href="item.php?itemid=<?php echo $itemid; ?>"><?php echo $itemname;?></a></h3></td>
                    <td><h3><?php echo $property;?> </h3></td>
                    <td><h3><?php echo $despoit;?></h3></td>
                    <?php if ($lease!=0){?>
                    <td><h3><?php echo $lease; ?></h3></td>
                    <?php }else{?>
                    <td><h3></h3></td>
                    <?php } ?>
                    <td><h3><?php echo $price;?></h3></td>
                    <td><h3><?php echo $shipment;?></h3></td>
                    <td><h3><?php echo $address2;?></h3></td>
                    <td><h3><?php echo $address;?></h3></td>
                    <td><h3><?php echo $payment;?></h3></td>
                    <td><h3><?php echo $payid;?></h3></td>
                    <td><h3><?php echo $status;?></h3></td>
                    <td><h3><?php echo $birthtime;?></h3></td>
                    <td><h3><?php echo $dealtime;?></h3></td>
                    <td><h3><?php echo $backtime;?></h3></td>
                    <?php if ($status=="订单待处理") { ?>
                    <td><a onclick="return confirm('确定要取消该订单吗？')" href="myOrder.php?cancel=<?php echo $orderid;?>">取消
                    </a></td>
                    <?php } ?>
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
