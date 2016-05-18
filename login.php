 <?php
 session_start();
 require_once('includes/connection.inc.php');
 $addNum=0;
 if (isset($_POST['login']))
 {
  $loghenuid=$_POST['loghenuid'];
  $logpassword=$_POST['logpassword'];
  $sql="SELECT * FROM account WHERE HenuId='$loghenuid'";
  $result=$conn->query($sql) or die($conn->error);
  $numRows=$result->num_rows;
  $row=$result->fetch_assoc();
  if ($numRows==0)
  {
   ?>
   <script type="text/javascript">alert("该用户不存在！")</script>
   <?php
 }elseif ($row['Password']==$logpassword)
 {
  $_SESSION['username']=$row['UserName'];
  $_SESSION['henuid']=$row['HenuId'];
  session_regenerate_id();
  ?>
  <script type="text/javascript">alert("登录成功！")</script>
  <?php
    if ($_SESSION['henuid']==1) {
     header("Location:admin.php");
     exit;
   }else{
    header("Location:index.php");
    exit;
  }
}else{
  ?>
  <script type="text/javascript">alert("密码不正确！")</script>
  <?php
}
}
if (isset($_POST['register']))
{
  $henuid=$_POST['henuid'];
  $email=$_POST['email'];
  $username=$_POST['username'];
  $phone=$_POST['phone'];
  $password=$_POST['password'];
  $password_confirm=$_POST['password_confirm'];
  if ($password!=$password_confirm)
  {
    ?>
    <script type="text/javascript">alert("两次密码不一样")</script>
    <?php
  }else
  {
    $sql="SELECT * FROM account WHERE HenuId='$henuid'";
    $result=$conn->query($sql) or die($conn->error);
    $numRows=$result->num_rows;
    if ($numRows==0) {
      $sql="INSERT INTO account(HenuId,Email,UserName,Password,Phone)VALUES('$henuid','$email','$username','$password','$phone')";
      if ($conn->query($sql))
      {
       ?>
       <script type="text/javascript">alert("注册成功，请登录!")</script>
       <?php
       $_SESSION['henuid'] = $henuid;
       $_SESSION['username'] = $username;
       $_SESSION['password'] = $password ;
     }else{
       ?>
       <script type="text/javascript">alert("学号必须为数字！!")</script>
       <?php
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

  <meta name="description" content="河大帮帮网">
  <meta name="author" content="1235252117">
  <link rel="icon" href="images/logo.ico">

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/demo.css" />
  <link rel="stylesheet" type="text/css" href="css/style2.css" />
  <link rel="stylesheet" type="text/css" href="css/animate-custom.css" />


  <title>河大帮帮网</title>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <header>
        <h1></h1>
        <nav class="codrops-demos"></nav>
      </header>
      <section>
        <div id="container_demo" >
          <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
          <a class="hiddenanchor" id="toregister"></a>
          <a class="hiddenanchor" id="tologin"></a>
          <div id="wrapper">
            <div id="login" class="animate form">
              <form method="post" autocomplete="on">
                <h1>登录</h1>
                <p>
                  <label for="username" class="uname" data-icon="u" >河大学号</label>
                  <input id="username" name="loghenuid" required="required" type="text" placeholder="河大学号"/>
                </p>
                <p>
                  <label for="password" class="youpasswd" data-icon="p">密码</label>
                  <input id="password" name="logpassword" required="required" type="password" placeholder="eg. X8df!90EO" />
                </p>
                <p class="keeplogin">
                  <input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" />
                  <label for="loginkeeping">记住用户</label>
                </p>
                <p class="login button">
                  <input name="login" type="submit" value="登录" />
                </p>
                <p class="change_link">
                  还未注册?
                  <a href="#toregister" class="to_register">加入我们</a>
                </p>
              </form>
            </div>

            <div id="register" class="animate form">
              <form method="post" autocomplete="on">
                <h1>注册</h1>
                <p>
                  <label for="henuidsignup" class="henuid" data-icon="u">河大学号</label>
                  <input id="henuidsignup" name="henuid" required="required" type="text" placeholder="学号" />
                </p>
                <p>
                  <label for="usernamesignup" class="uname" data-icon="u">用户名</label>
                  <input id="usernamesignup" name="username" required="required" type="text" placeholder="用户名" />
                </p>
                <p>
                  <label for="emailsignup" class="youmail" data-icon="e" >邮箱</label>
                  <input id="emailsignup" name="email" required="required" type="email" placeholder="邮箱"/>
                </p>
                <p>
                  <label for="phonesignup" class="youphone" data-icon="u" >手机号</label>
                  <input id="phonesignup" name="phone" required="required" type="text" placeholder="手机号"/>
                </p>
                <p>
                  <label for="passwordsignup" class="password" data-icon="p">密码</label>
                  <input id="passwordsignup" name="password" required="required" type="password" placeholder="密码"/>
                </p>
                <p>
                  <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">确认密码</label>
                  <input id="passwordsignup_confirm" name="password_confirm" required="required" type="password" placeholder="确认密码"/>
                </p>
                <p class="signin button">
                  <input name="register" type="submit" value="注册"/>
                </p>
                <p class="change_link">
                  已经注册?
                  <a href="#tologin" class="to_register">登录</a>
                </p>
              </form>
            </div>

          </div>
        </div>
      </section>
    </div>
    <footer>
      <?php  include('./layout/footer.inc.php');?></footer>
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/ie10-viewport-bug-workaround.js"></script>
    </body>
    </html>
