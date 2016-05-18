  <?php
  if (isset($_POST['logout'])) {
   $_SESSION=array();
   if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(),' ',time()-86400,'/');
  }
  session_destroy();
  header('Location:http://localhost/HelpEachOther/index.php');
  exit;
  }
  ?>
  <style>
    /* navigation style */
    #nav{
      height: 50px;
      font: 17px Geneva, Arial, Helvetica, sans-serif;
      background: #3AB3A9;
      min-width:500px;
    }

    #nav li{
      list-style: none;
      display: block;
      float: left;
      height: 50px;
      position: relative;
      /*   border-right: 1px solid #52BDB5;*/
    }

    #nav li a{
      padding: 0px 10px 0px 30px;
      margin: 0px 0;
      line-height: 50px;
      text-decoration: none;
      /*   border-right: 1px solid #389E96;*/
      height: 40px;
      color: #FFF;
      text-shadow: 1px 1px 1px #66696B;
    }

    #nav ul{
      background: #f2f5f6;
      padding: 0px;
      border-bottom: 1px solid #DDDDDD;
      /*   border-right: 1px solid #DDDDDD;*/
      /*   border-left:1px solid #DDDDDD;*/
      border-radius: 0px 0px 3px 3px;
      box-shadow: 2px 2px 3px #ECECEC;
      -webkit-box-shadow: 2px 2px 3px #ECECEC;
      -moz-box-shadow:2px 2px 3px #ECECEC;
      width:170px;
    }
    #nav .site-name,#nav .site-name:hover{
      padding-left: 10px;
      padding-right: 10px;
      color: #FFF;
      text-shadow: 1px 1px 1px #66696B;
      font: bolder 21px Georgia, "Times New Roman", Times, serif;
      width: 150px;
      /*   border-right: 1px solid #52BDB5;*/
    }
    #nav .site-name a{
      width: 150px;
      overflow:hidden;
    }

    #nav li:hover{
      background: #3BA39B;
    }
    #nav li a{
      display: block;
    }
    #nav ul li {
      border-right:none;
      border-bottom:1px solid #DDDDDD;
      width:170px;
      height:40px;
    }
    #nav ul li a {
      border-right: none;
      /*color:#6791AD;*/
      color:black;
      text-shadow: 1px 1px 1px #FFF;
      border-bottom:1px solid #FFFFFF;
    }

    #nav ul li:hover{background:#DFEEF0;}
    #nav ul li:last-child { border-bottom: none;}
    #nav ul li:last-child a{ border-bottom: none;}
    /* Sub menus */
    #nav ul{
      display: none;
      visibility:hidden;
      position: absolute;
      top: 50px;
    }

    /* Third-level menus */
    #nav ul ul{
      top: 0px;
      left:170px;
      display: none;
      visibility:hidden;
      border: 1px solid #DDDDDD;
    }
    /* Fourth-level menus */
    #nav ul ul ul{
      top: 0px;
      left:170px;
      display: none;
      visibility:hidden;
      border: 1px solid #DDDDDD;
    }

    #nav ul li{
      display: block;
      visibility:visible;
    }
    #nav li:hover > ul{
      display: block;
      visibility:visible;
    }
  </style>
  <!--[if IE 7]>
  <style>
  #nav{
    margin-left:0px
  }
  #nav ul{
    left:-40px;
  }
  #nav ul ul{
    left:130px;
  }
  #nav ul ul ul{
    left:130px;
  }
  </style>
  <![endif]-->
  <script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
  <script>
    $(document).ready(function(){
      $("#nav li").hover(
        function(){
          $(this).children('ul').hide();
          $(this).children('ul').slideDown('fast');
        },
        function () {
          $('ul', this).slideUp('fast');
        });
    });
  </script>
  <?php  $currentPage=basename($_SERVER['SCRIPT_FILENAME']);
  ?>
  <ul id="nav" class="navbar navbar-default navbar-fixed-top">

    <li class="site-name">
      <a href="index.php">河大帮帮网</a>
    </li>

    <li class="yahoo">
      <a href="items.php">所有物品</a>
      <ul>
        <li>
          <a href="items.php?cateid=1">学习资料 &raquo;</a>
          <ul>
            <li>
              <a href="items.php?cateid=9">课本&raquo;</a>
              <ul>
                <li>
                  <a href="items.php?cateid=33">专业课</a>
                </li>
                <li>
                  <a href="items.php?cateid=34">公共课</a>
                </li>
                <li>
                  <a href="items.php?cateid=35">选修课</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="items.php?cateid=10">考试必备&raquo;</a>
              <ul>
                <li>
                  <a href="items.php?cateid=36">四六级考试</a>
                </li>
                <li>
                  <a href="items.php?cateid=37">雅思考试</a>
                </li>
                <li>
                  <a href="items.php?cateid=38">考证必备</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="items.php?cateid=11">课外书&raquo;</a>
              <ul>
                <li>
                  <a href="items.php?cateid=39">小说</a>
                </li>
                <li>
                  <a href="items.php?cateid=40">文艺</a>
                </li>
                <li>
                  <a href="items.php?cateid=41">人文社科</a>
                </li>
                <li>
                  <a href="items.php?cateid=42">科技</a>
                </li>
                <li>
                  <a href="items.php?cateid=43">生活</a>
                </li>
                <li>
                  <a href="items.php?cateid=44">教育</a>
                </li>
                <li>
                  <a href="items.php?cateid=50">励志</a>
                </li>
                <li>
                  <a href="items.php?cateid=46">经管</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <a href="items.php?cateid=2">生活用品 &raquo;</a>
          <ul>
            <li>
              <a href="items.php?cateid=12">宿舍小家具&raquo;</a>
              <ul>
                <li>
                  <a href="items.php?cateid=47">鞋柜</a>
                </li>
                <li>
                  <a href="items.php?cateid=48">置物架</a>
                </li>
                <li>
                  <a href="items.php?cateid=49">书架</a>
                </li>
                <li>
                  <a href="items.php?cateid=50">沙发</a>
                </li>
                <li>
                  <a href="items.php?cateid=51">椅子</a>
                </li>
                <li>
                  <a href="items.php?cateid=52">其他家具</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="items.php?cateid=13">日用日化&raquo;</a>
              <ul>
                <li>
                  <a href="items.php?cateid=53">毛巾</a>
                </li>
                <li>
                  <a href="items.php?cateid=54">洗衣液</a>
                </li>
                <li>
                  <a href="items.php?cateid=50">伞</a>
                </li>
                <li>
                  <a href="items.php?cateid=56">雨衣</a>
                </li>
                <li>
                  <a href="items.php?cateid=57">垃圾桶</a>
                </li>
                <li>
                  <a href="items.php?cateid=58">其他用品</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="items.php?cateid=14">工具箱</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="items.php?cateid=3">数码产品 &raquo;</a>
          <ul>
            <li>
              <a href="items.php?cateid=15">手机&raquo;</a>
              <ul>
                <li>
                  <a href="items.php?cateid=59">手机</a>
                </li>
                <li>
                  <a href="items.php?cateid=60">手机配件</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="items.php?cateid=16">相机&raquo;</a>
              <ul>
                <li>
                  <a href="items.php?cateid=61">相机</a>
                </li>
                <li>
                  <a href="items.php?cateid=62">相机配件</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="items.php?cateid=17">电脑&raquo;</a>
              <ul>
                <li>
                  <a href="items.php?cateid=63">电脑</a>
                </li>
                <li>
                  <a href="items.php?cateid=64">电脑配件</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="items.php?cateid=18">其他数码产品</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="items.php?cateid=4">鞋服配饰 &raquo;</a>
          <ul>
            <li>
              <a href="items.php?cateid=19">女装&raquo;</a>
              <ul>
                <li>
                  <a href="items.php?cateid=65">上衣</a>
                </li>
                <li>
                  <a href="items.php?cateid=66">裙子</a>
                </li>
                <li>
                  <a href="items.php?cateid=67">裤装</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="items.php?cateid=20">男装&raquo;</a>
              <ul>
                <li>
                  <a href="items.php?cateid=68">上衣</a>
                </li>
                <li>
                  <a href="items.php?cateid=69">裤子</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="items.php?cateid=21">鞋包&raquo;</a>
              <ul>
                <li>
                  <a href="items.php?cateid=70">女包</a>
                </li>
                <li>
                  <a href="items.php?cateid=71">男包</a>
                </li>
                <li>
                  <a href="items.php?cateid=72">女鞋</a>
                </li>
                <li>
                  <a href="items.php?cateid=73">男鞋</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="items.php?cateid=22">配饰</a>
              <ul>
                <li>
                  <a href="items.php?cateid=74">腰带</a>
                </li>
                <li>
                  <a href="items.php?cateid=75">皮带</a>
                </li>
                <li>
                  <a href="items.php?cateid=76">帽子</a>
                </li>
                <li>
                  <a href="items.php?cateid=77">围巾</a>
                </li>
                <li>
                  <a href="items.php?cateid=78">手套</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <a href="items.php?cateid=5">娱乐 &raquo;</a>
          <ul>
            <li>
              <a href="items.php?cateid=23">休闲娱乐&raquo;</a>
              <ul>
                <li>
                  <a href="items.php?cateid=79">电影票</a>
                </li>
                <li>
                  <a href="items.php?cateid=80">演出赛事</a>
                </li>
                <li>
                  <a href="items.php?cateid=81">折扣券</a>
                </li>
                <li>
                  <a href="items.php?cateid=82">购物卡</a>
                </li>
                <li>
                  <a href="items.php?cateid=83">餐饮美食</a>
                </li>
                <li>
                  <a href="items.php?cateid=84">生活服务</a>
                </li>
                <li>
                  <a href="items.php?cateid=85">其他卡券服务</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="items.php?cateid=24">文体用品&raquo;</a>
              <ul>
                <li>
                  <a href="items.php?cateid=86">乐器</a>
                </li>
                <li>
                  <a href="items.php?cateid=87">运动器材</a>
                </li>
                <li>
                  <a href="items.php?cateid=88">文具</a>
                </li>
                <li>
                  <a href="items.php?cateid=89">其他文体工具</a>
                </li>
              </ul>
            </li>

          </ul>
        </li>
        <li>
          <a href="items.php?cateid=6">大一必备 &raquo;</a>
          <ul>
            <li>
              <a href="items.php?cateid=25">生活必备</a>
            </li>
            <li>
              <a href="items.php?cateid=26">学习必备</a>
            </li>
            <li>
              <a href="items.php?cateid=27">玩耍必备</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="items.php?cateid=7">毕业大甩卖 &raquo;</a>
          <ul>
            <li>
              <a href="items.php?cateid=28">生活</a>
            </li>
            <li>
              <a href="items.php?cateid=29">学习</a>
            </li>
            <li>
              <a href="items.php?cateid=30">娱乐</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="items.php?cateid=8">其他资源 &raquo;</a>
          <ul>
            <li>
              <a href="items.php?cateid=31">电子资源</a>
            </li>
            <li>
              <a href="items.php?cateid=32">非电子资源</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>

    <li >
     <a href="forum.php"  >论坛</a>
   </li>

   <li>
    <a href="myaccount.php">
      <?php echo $_SESSION['username'];?></a>

      <ul>
        <li>
          <a href="cart.php">购物车</a>
        </li>
        <li><a>发布物品    &raquo;</a>
          <ul>
            <li><a href="editItem.php?property=1">我要出售</a></li>
            <li> <a href="editItem.php?property=2">我要出租</a></li>
            <li><a href="editItem.php?property=3">我要免费分享</a></li>
          </ul>
        </li>

          <li>
          <a href="editPost.php">发布帖子</a>
        </li>

        <li>
          <a href="myaccount.php">我的账户</a>
        </li>

        <li>
          <form method="post">
            <button name="logout" type="submit" class="btn btn-link">退出</button>
          </form>
        </li>
      </ul>
    </li>

  </ul>
