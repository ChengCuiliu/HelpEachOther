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
  include('/layout/header.inc.php');
}
require_once('includes/connection.inc.php');

$message="";
$cateid=1;

if (isset($_POST['additem'])) {

 $itemname=$conn-> real_escape_string($_POST['itemname']);
 $cateid=$_COOKIE['cateid'];
 $property=2;
 $itemdes=$conn->real_escape_string($_POST['itemdes']);
 $shipment=$conn->real_escape_string($_POST['shipment']);
 $address=$conn->real_escape_string($_POST['address']);
 $payment=$conn->real_escape_string($_POST['payment']);
 $payid=$conn->real_escape_string($_POST['payid']);
 $itemprice=$conn->real_escape_string($_POST['itemprice']);
 $despoit=$conn->real_escape_string($_POST['despoit']);

 $sql="INSERT INTO item(HenuId,ItemName,CateId,Property,Price,ItemDes,Shipment,Address,Payment,PayId)VALUES('$henuid','$itemname','$cateid','$property','$itemprice','$itemdes','$shipment','$address','$payment','$payid')";
 if ($conn->query($sql))  {
  $sqlt="SELECT * FROM item WHERE ItemId = (SELECT MAX(ItemId) FROM item)";

  $result=$conn->query($sqlt) or die ($conn->error);
  $row=$result->fetch_assoc();
  $itemid=$row['ItemId'];

  $s="INSERT INTO rent(ItemId,Despoit,Status) VALUES('$itemid','$despoit',1)";
  if (!$conn->query($s) ) {
    $message="添加失败！";
  }

  function reArrayFiles(&$file_post) {
    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i
      <$file_count; $i++) {
      foreach ($file_keys as $key) {
        $file_ary[$i][$key] = $file_post[$key][$i];
      }
    }

    return $file_ary;
  }

  $file_ary = reArrayFiles($_FILES['photos']);
  $success_count=0;
  foreach ($file_ary as $file) {
    $image = $conn->
    real_escape_string(file_get_contents($file['tmp_name']));
    $type = $file['type'];
    $sqlstr = "INSERT INTO  itemphoto(ItemId,PhotoType,PhotoData) values('$itemid','".$type."','".$image."')";
    if($conn->query($sqlstr)){
      $success_count++;
    }
  }
  $message="提交物品成功！";
}
else{
  $message=$shipment;
 // $message="添加物品失败！";
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
  <link rel="stylesheet" type="text/css" href="css/component.css" />
  <link rel="stylesheet" type="text/css" href="css/default.css" />
  <link rel="stylesheet" type="text/css" href="css/common.css" />

  <title>河大帮帮网</title>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="js/jquery-1.3.2.js"></script>
    <script type="text/javascript" src="js/jquery.livequery.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
  //$('#loader').hide();
  $('.parent').livequery('change', function() {

    $(this).nextAll('.parent').remove();
    $(this).nextAll('label').remove();

    $('#show_sub_categories').append('<img src="images/loader.gif" style="float:left; margin-top:7px;" id="loader" alt="" />');

    $.post("includes/get_chid_categories.php", {
      parent_id: $(this).val(),
    }, function(response){
      setTimeout("finishAjax('show_sub_categories', '"+escape(response)+"')", 400);
    });
    var cateid=$('.cate').find("select:last option:selected").val();
    document.cookie = "cateid "+"="+cateid;
    return false;
  } );
} );
      function finishAjax(id, response){
        $('#loader').remove();
        $('#'+id).append(unescape(response));
      }

      window.onload=function(){
        $('#address').hide();
        $('#payid').hide();
      }
      function valueselect(sel) {
        var value = sel.options[sel.selectedIndex].value;
        if (value==2) {
          $('#address').show();
        }else{
         $('#address').hide();
       }
     }
     function valueselect2(s) {
      var value2 = s.options[s.selectedIndex].value;
      if (value2==2) {
        $('#payid').show();
      }else{
       $('#payid').hide();
     }
   }
 </script>
</head>
<body>
  <div class="container">
    <div class="main">
      <form class="cbp-mc-form" method="post" multipart="" enctype="multipart/form-data">

       <div class="cbp-mc-column">

        <label for="itemname">物品名称</label>
        <input type="text" id="itemname" name="itemname"  required>

        <label for="itemprice">物品租金</label>
        <input type="text" id="itemprice" name="itemprice" required placeholder="如：￥10/天">

        <label for="despoit">物品押金</label>
        <input type="number" id="despoit" name="despoit" required>

        <label for="itemcategory">物品分类</label>
        <div id="show_sub_categories" class="cate">
          <select name="search_category" class="parent">
            <option value="" selected="selected">第一级分类</option>
            <?php
            $sql = "SELECT * FROM itemcategory WHERE CateId< 9";
            $result=$conn->
            query($sql);
            while ($rows = $result->fetch_assoc())
              {?>
            <option value="<?php echo $rows['CateId'];?>
              ">
              <?php echo $rows['CateName'];?></option>
              <?php
            }?></select>
          </div>

          <label for="itemdes">物品描述</label>
          <textarea id="itemdes" name="itemdes" required></textarea>

        </div>
        <div class="cbp-mc-column">

          <label>发货方式</label>
          <select id="shipment" name="shipment" class="shipment" required onchange="valueselect(this);">
            <option value="0" selected="selected">选择发货方式</option>
            <option value="1">送货上门</option>
            <option value="2">买家自取</option>
          </select>

          <div id="address">
            <label>请输入买家自行取货地址</label>
            <input  name="address">
          </div>

          <label>付款方式</label>
          <select id="payment" name="payment" class="payment" required onchange="valueselect2(this);">
            <option value="0" selected="selected">选择支付方式</option>
            <option value="3">一天一付</option>
            <option value="4">租完总付</option>
          </select>

          <div id="payid">
            <label>请输入您的支付宝账号</label>
            <input  name="payid">
          </div>

          <label class="control-label" for="image">上传物品图片:</label>
          <input type="file" multiple="multiple" name="photos[ ]" required>

          <label class="control-label" for="message">
            提交结果:
            <?php echo $message;?></label>


            <div class="cbp-mc-submit-wrap ">
              <input name="additem" class="cbp-mc-submit" type="submit" value="提交" />
            </div>

          </div>
        </form>
      </div>
    </div>
    <footer>
     <?php  include('./layout/footer.inc.php');?></footer>
   </body>
   </html>
