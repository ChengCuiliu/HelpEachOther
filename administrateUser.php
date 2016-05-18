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
$henuid=null;
if(isset($_GET["page"]))
  $page = (int)$_GET["page"];
else
  $page = 1;

$setLimit = 8;
$pageLimit = ($page * $setLimit) - $setLimit;

$sql="SELECT COUNT(*) FROM account WHERE HenuId!=1";
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

              $sql="SELECT * FROM account WHERE HenuId!=1  ORDER BY HenuId DESC LIMIT ".$pageLimit." , ".$setLimit;
              $result=$conn->query($sql) or die($conn->error);

              ?>
              <form method="post">

                <table class="table">
                  <tr>
                    <th><h4>河大学号</h4></th>
                    <th><h4>用户名</h4></th>
                    <th><h4>邮箱</h4></th>
                    <th><h4>手机号</h4></th>
                    <th><h4>操作</h4></th>
                  </tr>
                  <?php
                  while ($row=$result->fetch_assoc()){
                    $delnum++;
                    $henuid=$row['HenuId'];
                    $username=$row['UserName'];
                    $email=$row['Email'];
                    $phone=$row['Phone'];
                    ?>
                    <tr>
                      <td><h4><?php echo $henuid;?></h4></td>
                      <td><h4><a href="account.php?HId=<?php echo $henuid; ?>"><?php echo $username;?></a></h4></td>
                      <td><h4><?php echo $email;?></h4></td>
                      <td><h4><?php echo $phone;?></h4></td>
                      <td><h4><a onclick="return confirm('确定要删除用户<?php echo $username;?>吗？')" href="administrateUser.php?delitem=<?php echo $henuid;?>">删除</a>
                      </h4></td>
                      <td><h4></h4></td>
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
