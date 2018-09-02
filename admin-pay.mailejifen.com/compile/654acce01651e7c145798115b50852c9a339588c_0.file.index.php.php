<?php
/* Smarty version 3.1.30-dev/45, created on 2018-06-04 17:42:58
  from "/vagrant/www/admin-pay.mailejifen.com/views/layouts/index.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/45',
  'unifunc' => 'content_5b1509a27f8f97_58672417',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '654acce01651e7c145798115b50852c9a339588c' => 
    array (
      0 => '/vagrant/www/admin-pay.mailejifen.com/views/layouts/index.php',
      1 => 1528105373,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b1509a27f8f97_58672417 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php 
new Block_title_4665945715b1509a27cd4a1_64699730($_smarty_tpl);
?>
</title>
    <link rel="shortcut icon" href="http://cdn.mailejifen.com/dist/img/ml_16X16.ico"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="http://cdn.mailejifen.com/dist/css/lib.min.css">

    <link rel="stylesheet" href="http://cdn.mailejifen.com/dist/css/skins/_all-skins.min.css">
    <?php 
new Block_css_18855516525b1509a27cf646_73737426($_smarty_tpl);
?>

    <!--[if lt IE 9]>
    <?php echo '<script'; ?>
 src="http://cdn.mailejifen.com/vender/html5shiv.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="http://cdn.mailejifen.com/vender/respond.min.js"><?php echo '</script'; ?>
>
    <![endif]-->
</head>
<body class="hold-transition fixed skin-blue sidebar-mini">

<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">麦乐</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">麦乐支付中心管理后台</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs"><?php echo $_smarty_tpl->tpl_vars['admin']->value['realname'];?>
</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">

                                <p>
                                    <?php echo $_smarty_tpl->tpl_vars['admin']->value['realname'];?>


                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <!--                                <div class="pull-left">-->
                                <!--                                    <a href="/site/profile" class="btn btn-success btn-flat">帐户设置</a>-->
                                <!--                                </div>-->
                                <div class="pull-left">
                                    <a href="/site/password" class="btn btn-warning btn-flat">修改密码</a>
                                </div>
                                <div class="pull-right">
                                    <a href="/site/logout" class="btn btn-danger btn-flat">退出</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li>
                    <a href="#">
                        <i class="fa fa-th-large"></i> <span>平台管理</span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/platform/third-account"><i class="fa fa-circle-o"></i>支付账户列表</a></li>
                        <li><a href="/platform/list"><i class="fa fa-circle-o"></i>内部平台列表</a></li>
                        <li><a href="/application/list"><i class="fa fa-circle-o"></i>外部应用列表</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#">
                        <i class="fa fa-list"></i> <span>订单管理</span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/order/maile-pay-order"><i class="fa fa-circle-o"></i> 麦乐订单</a></li>
                        <li><a href="/order/refund-order"><i class="fa fa-circle-o"></i> 退款订单</a></li>
                        <li><a href="/order/third-pay-order"><i class="fa fa-circle-o"></i> 第三方订单</a></li>
                    </ul>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <!--
        <h1>
            应用数据
            <small>访问数据</small>
        </h1>
        -->


        <!-- Main content -->
        <section class="content">
            <?php 
new Block_content_5536962535b1509a27eb9a5_00895988($_smarty_tpl);
?>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!--modal msg  start-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">
                        操作成功!
                    </h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-ok">
                        确定
                    </button>
                    <button type="button" style="display: none" class="btn btn-danger btn-no"
                            data-dismiss="modal">关闭
                    </button>

                </div>
            </div>
        </div>
    </div>
    <!--modal msg  end-->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2016 <a href="http://www.mailemailejifen.com">麦乐积分</a>.</strong> All rights
        reserved.
    </footer>


</div>
<!-- ./wrapper -->

<!-- lib -->
<?php echo '<script'; ?>
 src="http://cdn.mailejifen.com/dist/lib.min.js"><?php echo '</script'; ?>
>


<!-- Sparkline -->
<?php echo '<script'; ?>
 src="http://cdn.mailejifen.com/plugins/sparkline/jquery.sparkline.min.js"><?php echo '</script'; ?>
>
<!-- jvectormap -->
<?php echo '<script'; ?>
 src="http://cdn.mailejifen.com/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="http://cdn.mailejifen.com/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"><?php echo '</script'; ?>
>
<!-- SlimScroll 1.3.0 -->
<?php echo '<script'; ?>
 src="http://cdn.mailejifen.com/plugins/slimScroll/jquery.slimscroll.min.js"><?php echo '</script'; ?>
>
<!-- ChartJS 1.0.1 -->
<?php echo '<script'; ?>
 src="http://cdn.mailejifen.com/plugins/chartjs/Chart.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
    $(function () {
        var requestUri = '/' + location.href.replace(/^http:\/\/.*?\//, '');
        $('.sidebar-menu li > a').each(function () {
            if (requestUri.indexOf($(this).attr('href')) == 0) {
                $('.sidebar-menu li.active').removeClass('active');
                $(this).parents('li').addClass('active');
            }
        });

        $('.treeview-menu li > a').each(function () {
            if ($(this).attr('href') == '#') {
                $(this).hide();
            }
        });
    });

<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
    function UrlSearch() 
    {
        var value;
        var res = new Array();
        var str=decodeURI(location.href); //取得整个地址栏
        var num=str.indexOf("?") 
        str=str.substr(num+1); //取得所有参数   stringvar.substr(start [, length ]

        var arr=str.split("&"); //各个参数放到数组里
        for(var i=0;i < arr.length;i++){ 
            if(arr.length == 1){
            return false; //只有page
            }
            num=arr[i].indexOf("="); 
            if(num>0){ 
            value=arr[i].substr(num+1);
            res[i] = value;
            }  
        }
        return res;
    }
    function myCheck()
      {
        for(var i=0;i<document.orderform.elements.length-1;i++)
        {
         if(document.orderform.elements[i].value!="")
         {
           return true;
         }
        }
        alert("当前表单不能有空项");
        return false;
      }

    function res_is_void(arr)
    {
      for(var i=0; i<arr.length; i++){
          if(arr[i] != '')
            return false;
      }
      return true;
    }
<?php echo '</script'; ?>
>
<?php 
new Block_js_18331515155b1509a27f19e4_80471521($_smarty_tpl);
?>

</body>
</html>
<?php }
/* {block 'title'} /vagrant/www/admin-pay.mailejifen.com/views/layouts/index.php */
class Block_title_4665945715b1509a27cd4a1_64699730 extends Smarty_Internal_Block
{
public $name = 'title';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>
麦乐积分管理后台<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'title'} */
/* {block 'css'} /vagrant/www/admin-pay.mailejifen.com/views/layouts/index.php */
class Block_css_18855516525b1509a27cf646_73737426 extends Smarty_Internal_Block
{
public $name = 'css';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'css'} */
/* {block 'content'} /vagrant/www/admin-pay.mailejifen.com/views/layouts/index.php */
class Block_content_5536962535b1509a27eb9a5_00895988 extends Smarty_Internal_Block
{
public $name = 'content';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'content'} */
/* {block 'js'} /vagrant/www/admin-pay.mailejifen.com/views/layouts/index.php */
class Block_js_18331515155b1509a27f19e4_80471521 extends Smarty_Internal_Block
{
public $name = 'js';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'js'} */
}
