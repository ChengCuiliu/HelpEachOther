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
$poststatus=0;

require_once('includes/connection.inc.php');
if (isset($_GET['hId'])) {
 $henuid=$_GET['hId'];
}

if (isset($_POST['addpost'])) {
  $title=$conn->    real_escape_string($_POST['posttitle']);
  $category=$conn->    real_escape_string($_POST['postcategory']);
  if ($category=="我需要帮助") {
    $category=0;
  }else{
    $category=1;
  }
  $price=$conn->real_escape_string($_POST['price']);
  $content=$conn->real_escape_string($_POST['postcontent']);
  date_default_timezone_set("Asia/Shanghai");
  $posttime=date('Y-m-d H:i:s');

  $sql="INSERT INTO post(PostTitle,PostCategory,Price,PostContent,HenuId,PostTime,PostStatus)VALUES('$title','$category','$price','$content','$henuid','$posttime','$poststatus')";

  if ($conn->query($sql))  {
    $message="发帖成功!";
  }else{
    $message=$content;
   // $message= "发帖失败，请查看输入信息!";
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
  <link rel="stylesheet" type="text/css" href="css/editpost.css" />

  <title>河大帮帮网
    <?php if(isset($title)) {echo "&#8212;{$title}"; }?></title>
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  <div class="container-fluid main">
    <div class="container">
      <div class="main">
        <form class="cbp-mc-form" method="post" multipart="" enctype="multipart/form-data">
          <div class="cbp-mc-column">
            <label for="posttitle">标题</label>
            <input type="text" id="posttitle" name="posttitle"  required>

            <label for="postcategory">类型</label>
            <select id="postcategory" name="postcategory" required>
              <option>我需要帮助</option>
              <option>我能提供帮助</option>
            </select>

            <label for="price">价格</label>
            <input type="number" id="price" name="price" required>

            <label for="postcontent">帖子内容</label>
            <textarea id="postcontent" name="postcontent" required></textarea>
          </div>
          <div class="cbp-mc-submit-wrap ">
            <label><?php echo $message;?></label>
            <input name="addpost" class="cbp-mc-submit" type="submit" value="提交" />
          </div>
        </form>
      </div>
    </div>
  </div>
  <footer>
    <?php  include('./layout/footer.inc.php');?></footer>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/ie10-viewport-bug-workaround.js"></script>

  </body>
  </html>
