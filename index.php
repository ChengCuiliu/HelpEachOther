<?php
session_start();
if (isset($_SESSION['henuid'])) {
 if ($_SESSION['henuid']==1) {
   include('./layout/administrateHeader.inc.php');
 }else{
  include('./layout/loggedHeader.inc.php');
}
$henuId=$_SESSION['henuid'];
}else{
  include('./layout/header.inc.php');
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
  <link rel="stylesheet" type="text/css" href="css/default.css" />
  <link rel="stylesheet" type="text/css" href="css/component.css" />
  <link rel="stylesheet" type="text/css" href="css/index.css" />

  <title>河大帮帮网
    <?php if(isset($title)) {echo "&#8212;{$title}"; }?></title>
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  <div class="container">
    <ul class="cbp-ig-grid">
      <li>
        <a href="items.php?property=1">
          <span class="cbp-ig-icon cbp-ig-icon-shoe"></span>
          <h3 class="cbp-ig-title">买</h3>
          <span class="cbp-ig-category">便宜</span>
        </a>
      </li>
      <li>
        <a href="items.php?property=2">
          <span class="cbp-ig-icon cbp-ig-icon-ribbon"></span>
          <h3 class="cbp-ig-title">租</h3>
          <span class="cbp-ig-category">经济</span>
        </a>
      </li>
      <li>
        <a href="items.php?property=3">
          <span class="cbp-ig-icon cbp-ig-icon-milk"></span>
          <h3 class="cbp-ig-title">免费</h3>
          <span class="cbp-ig-category">分享</span>
        </a>
      </li>
    </ul>
  </div>
  <footer>
    <?php include('./layout/footer.inc.php');?></footer>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <script src="js/modernizr.custom.js"></script>

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
$henuId=$_SESSION['henuid'];
}else{
  include('./layout/header.inc.php');
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
  <link rel="stylesheet" type="text/css" href="css/default.css" />
  <link rel="stylesheet" type="text/css" href="css/component.css" />
  <link rel="stylesheet" type="text/css" href="css/index.css" />

  <title>河大帮帮网
    <?php if(isset($title)) {echo "&#8212;{$title}"; }?></title>
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  <div class="container">
    <ul class="cbp-ig-grid">
      <li>
        <a href="items.php?property=1">
          <span class="cbp-ig-icon cbp-ig-icon-shoe"></span>
          <h3 class="cbp-ig-title">买</h3>
          <span class="cbp-ig-category">便宜</span>
        </a>
      </li>
      <li>
        <a href="items.php?property=2">
          <span class="cbp-ig-icon cbp-ig-icon-ribbon"></span>
          <h3 class="cbp-ig-title">租</h3>
          <span class="cbp-ig-category">经济</span>
        </a>
      </li>
      <li>
        <a href="items.php?property=3">
          <span class="cbp-ig-icon cbp-ig-icon-milk"></span>
          <h3 class="cbp-ig-title">免费</h3>
          <span class="cbp-ig-category">分享</span>
        </a>
      </li>
    </ul>
  </div>
  <footer>
    <?php include('./layout/footer.inc.php');?></footer>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <script src="js/modernizr.custom.js"></script>

  </body>
  </html>
>>>>>>> e769018c1717fa08580e854e5f18736d73757250
