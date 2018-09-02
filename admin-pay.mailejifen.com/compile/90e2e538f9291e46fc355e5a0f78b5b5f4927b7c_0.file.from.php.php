<?php
/* Smarty version 3.1.30-dev/45, created on 2018-05-29 10:06:35
  from "/vagrant/www/admin-pay.mailejifen.com/views/layouts/from.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/45',
  'unifunc' => 'content_5b0cb5ab476f77_44313167',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '90e2e538f9291e46fc355e5a0f78b5b5f4927b7c' => 
    array (
      0 => '/vagrant/www/admin-pay.mailejifen.com/views/layouts/from.php',
      1 => 1526618129,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b0cb5ab476f77_44313167 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php 
new Block_title_4836327755b0cb5ab46fd51_54467213($_smarty_tpl);
?>
</title>
  <link rel="shortcut icon" href="http://cdn.mailejifen.com/dist/img/ml_16X16.ico" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="http://cdn.mailejifen.com/dist/css/lib.min.css">

   <?php 
new Block_css_19828728195b0cb5ab471787_72061218($_smarty_tpl);
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
<body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="http://mailejifen.com/pages/">麦乐支付中心管理后台</a>
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body">
        <?php 
new Block_content_77778135b0cb5ab4756f4_42254095($_smarty_tpl);
?>

      </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <?php 
new Block_js_18535556955b0cb5ab476784_71891062($_smarty_tpl);
?>

</body>
</html><?php }
/* {block 'title'} /vagrant/www/admin-pay.mailejifen.com/views/layouts/from.php */
class Block_title_4836327755b0cb5ab46fd51_54467213 extends Smarty_Internal_Block
{
public $name = 'title';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>
麦乐积分<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'title'} */
/* {block 'css'} /vagrant/www/admin-pay.mailejifen.com/views/layouts/from.php */
class Block_css_19828728195b0cb5ab471787_72061218 extends Smarty_Internal_Block
{
public $name = 'css';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'css'} */
/* {block 'content'} /vagrant/www/admin-pay.mailejifen.com/views/layouts/from.php */
class Block_content_77778135b0cb5ab4756f4_42254095 extends Smarty_Internal_Block
{
public $name = 'content';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'content'} */
/* {block 'js'} /vagrant/www/admin-pay.mailejifen.com/views/layouts/from.php */
class Block_js_18535556955b0cb5ab476784_71891062 extends Smarty_Internal_Block
{
public $name = 'js';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'js'} */
}
