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

$money=0;
$message="";

if(isset($_GET["page"]))
  $page = (int)$_GET["page"];
else
  $page = 1;

$setLimit = 100;
$pageLimit = ($page * $setLimit) - $setLimit;

$sql="SELECT COUNT(*) FROM cart ";
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
              <div>
                <h2>购物车<?php echo $message;?></h2>

                <table class="table">
                  <tr>
                    <th>
                    </th>
                    <th><h3>全部商品</h3></th>
                    <th><h3>价格</h3></th>
                    <th><h3>属性</h3></th>
                    <th><h3>发货方式</h3></th>
                    <th><h3>支付方式</h3></th>
                    <th><h3>删除</h3></th>
                    <th><h3>结算</h3></th>
                  </tr>
                  <?php

                  if(isset($_POST['dell'])){
                    $ids=$_POST['dell'];
                    $ids=implode(",", $ids);

                    if(isset($_POST['dels'])){
                      $sql="DELETE FROM cart WHERE ItemId IN ($ids) AND HenuId=$henuid";
                      $conn->query($sql) or die($conn->error);
                    }

                  /*  if(isset($_POST['sums'])){
                      $sql3="SELECT * FROM cart WHERE ItemId IN ($ids) AND HenuId=$henuid";
                      $result3= $conn->query($sql3) or die($conn->error);
                      while ( $row3=$result3->fetch_assoc()) {
                        $id=$row3['ItemId'];
                        $sql4="SELECT * FROM item WHERE ItemId =$id";
                        $result4= $conn->query($sql4) or die($conn->error);
                        $row4=$result4->fetch_assoc();
                        $money+=$row4['Price']*$row3['ItemCount'];
                      }
                    }
                    */
                  }

                  if(isset($_GET['del'])){
                    $itemid=$_GET['del'];
                    $sql="DELETE FROM cart WHERE ItemId=$itemid AND HenuId=$henuid";
                    $conn->query($sql) or die($conn->error);
                  }

                  $sql2="SELECT * FROM cart WHERE HenuId=$henuid ORDER BY ItemId LIMIT ".$pageLimit." , ".$setLimit;
                  $result2=$conn->query($sql2) or die($conn->error);

                  while ($row=$result2->fetch_assoc()){
                    $itemid=$row['ItemId'];
                    $HenuId=$row['HenuId'];

                    $sqla="SELECT * FROM item WHERE ItemId=$itemid";
                    $resulta=$conn->query($sqla) or die($conn->error);
                    $itemRow=$resulta->fetch_assoc();
                    $itemName=$itemRow['ItemName'];
                    $itemPrice=$itemRow['Price'];
                    $property=$itemRow['Property'];
                    if ($property==1) {
                     $property= "出售";
                   }elseif ($property==2)
                   {
                    $property= "出租";
                  }else{
                    $property= "免费";
                  }
                  $shipment=$itemRow['Shipment'];
                  if ($shipment==1) {
                    $shipment= "送货上门";
                  }else{
                   $shipment= "买家自取";
                 }
                 $payment=$itemRow['Payment'];
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
                <form method="post"  >
                  <tr>
                    <td>
                      <h3>
                        <input  name="dell[]" type="checkbox" value="<?php echo $itemid; ?>">
                      </h3>
                    </td>
                    <td>
                      <h3>
                        <a href="item.php?itemid=<?php echo $itemid; ?>
                          ">
                          <?php echo $itemName;?>
                        </a>
                      </h3>
                    </td>
                    <td><h3>￥
                      <?php echo $itemPrice;?>
                    </h3></td>
                    <td><h3>
                      <?php echo $property;?>
                    </h3></td>
                    <td><h3>
                      <?php echo $shipment;?>
                    </h3></td>
                    <td><h3>
                      <?php echo $payment;?>
                    </h3></td>
                    <td> <h3>
                      <a onclick="return confirm('确定要删除物品<?php echo $itemName;?>吗？')" href="cart.php?del=<?php echo $itemid;?>">删除
                      </a>
                    </h3> </td>
                    <td> <h3>
                      <a  href="order.php?itemid=<?php echo $itemid;?>">结算
                      </a>
                    </h3> </td>
                  </tr>
                  <?php  }?>
                  <tr>
                    <td><h3><a href="javascript:select()">全选</a>/<a href="javascript:fanselect()">反选</a> </h3></td>
                    <td><h3><a href="javascript:noselect()">全不选</a> </h3></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td> <input name="dels" type="image" title="删除" value="删除" ></td>
                  </tr>
                </form>
              </table>
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

require_once('includes/connection.inc.php');
require_once('includes/function.php');

$money=0;
$message="";

if(isset($_GET["page"]))
  $page = (int)$_GET["page"];
else
  $page = 1;

$setLimit = 100;
$pageLimit = ($page * $setLimit) - $setLimit;

$sql="SELECT COUNT(*) FROM cart ";
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
              <div>
                <h2>购物车<?php echo $message;?></h2>

                <table class="table">
                  <tr>
                    <th>
                    </th>
                    <th><h3>全部商品</h3></th>
                    <th><h3>价格</h3></th>
                    <th><h3>属性</h3></th>
                    <th><h3>发货方式</h3></th>
                    <th><h3>支付方式</h3></th>
                    <th><h3>删除</h3></th>
                    <th><h3>结算</h3></th>
                  </tr>
                  <?php

                  if(isset($_POST['dell'])){
                    $ids=$_POST['dell'];
                    $ids=implode(",", $ids);

                    if(isset($_POST['dels'])){
                      $sql="DELETE FROM cart WHERE ItemId IN ($ids) AND HenuId=$henuid";
                      $conn->query($sql) or die($conn->error);
                    }

                  /*  if(isset($_POST['sums'])){
                      $sql3="SELECT * FROM cart WHERE ItemId IN ($ids) AND HenuId=$henuid";
                      $result3= $conn->query($sql3) or die($conn->error);
                      while ( $row3=$result3->fetch_assoc()) {
                        $id=$row3['ItemId'];
                        $sql4="SELECT * FROM item WHERE ItemId =$id";
                        $result4= $conn->query($sql4) or die($conn->error);
                        $row4=$result4->fetch_assoc();
                        $money+=$row4['Price']*$row3['ItemCount'];
                      }
                    }
                    */
                  }

                  if(isset($_GET['del'])){
                    $itemid=$_GET['del'];
                    $sql="DELETE FROM cart WHERE ItemId=$itemid AND HenuId=$henuid";
                    $conn->query($sql) or die($conn->error);
                  }

                  $sql2="SELECT * FROM cart WHERE HenuId=$henuid ORDER BY ItemId LIMIT ".$pageLimit." , ".$setLimit;
                  $result2=$conn->query($sql2) or die($conn->error);

                  while ($row=$result2->fetch_assoc()){
                    $itemid=$row['ItemId'];
                    $HenuId=$row['HenuId'];

                    $sqla="SELECT * FROM item WHERE ItemId=$itemid";
                    $resulta=$conn->query($sqla) or die($conn->error);
                    $itemRow=$resulta->fetch_assoc();
                    $itemName=$itemRow['ItemName'];
                    $itemPrice=$itemRow['Price'];
                    $property=$itemRow['Property'];
                    if ($property==1) {
                     $property= "出售";
                   }elseif ($property==2)
                   {
                    $property= "出租";
                  }else{
                    $property= "免费";
                  }
                  $shipment=$itemRow['Shipment'];
                  if ($shipment==1) {
                    $shipment= "送货上门";
                  }else{
                   $shipment= "买家自取";
                 }
                 $payment=$itemRow['Payment'];
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
                <form method="post"  >
                  <tr>
                    <td>
                      <h3>
                        <input  name="dell[]" type="checkbox" value="<?php echo $itemid; ?>">
                      </h3>
                    </td>
                    <td>
                      <h3>
                        <a href="item.php?itemid=<?php echo $itemid; ?>
                          ">
                          <?php echo $itemName;?>
                        </a>
                      </h3>
                    </td>
                    <td><h3>￥
                      <?php echo $itemPrice;?>
                    </h3></td>
                    <td><h3>
                      <?php echo $property;?>
                    </h3></td>
                    <td><h3>
                      <?php echo $shipment;?>
                    </h3></td>
                    <td><h3>
                      <?php echo $payment;?>
                    </h3></td>
                    <td> <h3>
                      <a onclick="return confirm('确定要删除物品<?php echo $itemName;?>吗？')" href="cart.php?del=<?php echo $itemid;?>">删除
                      </a>
                    </h3> </td>
                    <td> <h3>
                      <a  href="order.php?itemid=<?php echo $itemid;?>">结算
                      </a>
                    </h3> </td>
                  </tr>
                  <?php  }?>
                  <tr>
                    <td><h3><a href="javascript:select()">全选</a>/<a href="javascript:fanselect()">反选</a> </h3></td>
                    <td><h3><a href="javascript:noselect()">全不选</a> </h3></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td> <input name="dels" type="image" title="删除" value="删除" ></td>
                  </tr>
                </form>
              </table>
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
>>>>>>> e769018c1717fa08580e854e5f18736d73757250
