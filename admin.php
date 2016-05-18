<?php
session_start();
if (isset($_SESSION['henuid'])) {
  if ($_SESSION['henuid']==1) {
   include('./layout/administrateHeader.inc.php');
 }else{
  include('./layout/loggedHeader.inc.php');
}
$henuid=$_SESSION['henuid'];
$hid=$_SESSION['henuid'];
}else{
  include('./layout/header.inc.php');
}
require_once('includes/connection.inc.php');

if(isset($_GET['hId']))
{
  $hid = intval($_GET['hId']);
}

$message="";
$delnum=0;
$postnum=0;
$itemids=array();
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
    <h3><a href="administrateItem.php">管理物品</a></h3>
    <h3><a href="administratePost.php">管理帖子</a></h3>
    <h3><a href="administrateUser.php">管理用户</a></h3>
  </div>
  <footer>
    <?php  include('./layout/footer.inc.php');?>
  </footer>

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>
