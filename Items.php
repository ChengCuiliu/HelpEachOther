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

$addNum=0;
$message="";
$total=0;
$henuid=null;
if (isset($_SESSION['henuid']))
  $henuid=$_SESSION['henuid'];

if (isset($_GET['cateid'])){
  $cateid=$_GET['cateid'];
}else{
  $cateid='';
}
if (isset($_GET['property'])){
  $property=$_GET['property'];
}else{
  $property='';
}

if(isset($_GET["page"]))
  $page = (int)$_GET["page"];
else
  $page = 1;

$setLimit = 8;
$pageLimit = ($page * $setLimit) - $setLimit;

$sql="SELECT COUNT(*) FROM item ";
$sql2 = "SELECT * FROM item LIMIT ".$pageLimit." , ".$setLimit;

if ($cateid!='') {

  $n=0;
  $cateids=array();

  $sqla="SELECT ParentId FROM itemcategory WHERE CateId='$cateid'";
  $resulta=$conn->
  query($sqla);
  $rowa=$resulta->fetch_assoc();

//第一级别分类
  if ($rowa['ParentId']==null) {
    $sqlb="SELECT * FROM itemcategory WHERE ParentId='$cateid'";
    $resultb=$conn->query($sqlb);
    while ($rowb=$resultb->fetch_assoc()) {
      $b=$rowb['CateId'];
      $sqlc="SELECT * FROM itemcategory WHERE ParentId='$b'";
      $resultc=$conn->query($sqlc);
      while ($rowc=$resultc->fetch_assoc()) {
        $n++;
        $cateids[$n]=$rowc['CateId'];
      }
    }
  }else{
    $sqld="SELECT * FROM itemcategory WHERE ParentId='$cateid'";
    if ($conn->query($sqld)) {
     $resultd=$conn->query($sqld);
     if ($resultd->num_rows>0) {
      //第二级别分类
       while ($rowd=$resultd->fetch_assoc()) {
        $n++;
        $cateids[$n]=$rowd['CateId'];
      }
    }else{
     //第三级别分类
     $n++;
     $cateids[$n]=$cateid;
   }
 }
}
$cateids=implode(",", $cateids);
$sql="SELECT COUNT(*) FROM item WHERE CateId IN ($cateids)";
$sql2 = "SELECT * FROM item WHERE CateId IN ($cateids) LIMIT ".$pageLimit." , ".$setLimit;
}
if ($property!='') {
  $sql="SELECT COUNT(*) FROM item WHERE Property='$property'";
  $sql2 = "SELECT * FROM item WHERE Property='$property' LIMIT ".$pageLimit." , ".$setLimit;
}

$result=$conn->query($sql);
if ($conn->query($sql)) {
  $result=$conn->query($sql);
  $numrows=$result->fetch_row();
  $total=$numrows[0];
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

  <title>河大帮帮网
    <?php if(isset($title)) {echo "&#8212;{$title}"; }?></title>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <label>
        <?php echo $message; ?></label>

        <?php
        if ($conn->
          query($sql2)) {
          $result2 = $conn->query($sql2);
        while($row=$result2->fetch_assoc()){
          $addNum++;
          $itemid=$row['ItemId'];
          $hid=$row['HenuId'];
          $itemname=$row['ItemName'];
          $itemdes=$row['ItemDes'];
          $itemproperty=$row['Property'];
          $itemprice=$row['Price'];
          $itemcateid=$row['CateId'];
          $status=$row['Status'];

          $q="SELECT * FROM itemcategory WHERE CateId=$itemcateid";
          $r=$conn->query($q)or die($conn->error);
          $row=$r->fetch_assoc();
          $catename=$row['CateName'];

          $sqlphoto="SELECT * FROM itemphoto WHERE ItemId=$itemid";
          $photoResult=$conn->query($sqlphoto) or die($conn->error);

          $getPhotoCount="SELECT COUNT(*) FROM itemphoto WHERE ItemId=$itemid ";
          $photoCount=$conn->query($getPhotoCount);
          $photoCountRow=$photoCount->fetch_row();
          $photoNum=$photoCountRow[0];

          $photo_array=array();
          $i=0;
          while ($photoRow=$photoResult->fetch_assoc()) {
            $photo_array[$i]=$photoRow;
            $i++;
          }
          $index=array_rand($photo_array);
          $phototype= $photo_array[$index]['PhotoType'];
          $photodata=$photo_array[$index]['PhotoData'];

          ?>
          <div class=" col-md-3">
            <div class="thumbnail featured-product">
              <a href="item.php?itemid=<?php echo $itemid ?>
                ">
                <img src="data:<?php echo $phototype?>
                ;base64,
                <?php echo base64_encode( $photodata ); ?>" alt=""></a>
                <div class="caption">
                  <h3>
                    <?php echo $itemname ?>
                    (
                    <?php echo $catename; ?>)</h3>

                    <h4 class="price">
                      ￥
                      <?php echo $itemprice ?></h4>

                      <?php
                      if ($hid==$henuid) {?>
                      <h3>这是您发布的物品</h3>
                      <?php }elseif ($status==1) {?>
                      <h3>此物品已被下订单</h3>
                      <?php }elseif ($status==2) {?>
                      <h3>此物品正在出租中</h3>
                      <?php }elseif ($status==3) {?>
                      <h3>此物品已售出</h3>
                      <?php  }elseif ($itemproperty!="2") {
                        ?>
                        <form class="input-group" method="post">
                          <span class="input-group-btn">
                            <button name="<?php echo $addNum;?>" class="btn btn-primary" type="submit">
                              <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                              加入购物车
                            </button>
                            <a href="order.php?itemid=<?php echo $itemid; ?>" class="btn btn-primary" role="button">
                              立即购买</a>
                            </span>
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

                        if (isset($_POST[$addNum])) {
                          if (!isset($_SESSION['henuid'])){
                            $message= '请登录后进行操作！';
                          }else{
                            $henuid=$_SESSION['henuid'];

               /* $itemcount=$conn->real_escape_string($_POST['itemcount']);

                if ($itemcount
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
           /* $sqlf="UPDATE cart SET ItemCount=ItemCount+$itemcount  WHERE henuid=$hId && ItemId=$itemid";
            if ($conn->query($sqlf)) {
             $message="再次添加成功!";
           }else
           {
            $message="再次添加失败!";
          }
        }
      }*/
    }
  }
  ?></div>
</div>
</div>

<?php }?></div>

<?php } ?>
<div class="pagination">
  <?php
  echo displayPaginationBelow($setLimit,$page,$total);
  ?></div>

  <footer>
    <?php  include('./layout/footer.inc.php');?></footer>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/ie10-viewport-bug-workaround.js"></script>

  </body>
  </html>
