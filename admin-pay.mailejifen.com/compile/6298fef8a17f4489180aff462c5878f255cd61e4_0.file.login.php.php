<?php
/* Smarty version 3.1.30-dev/45, created on 2018-05-29 10:06:35
  from "/vagrant/www/admin-pay.mailejifen.com/views/site/login.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/45',
  'unifunc' => 'content_5b0cb5ab27d444_86051471',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6298fef8a17f4489180aff462c5878f255cd61e4' => 
    array (
      0 => '/vagrant/www/admin-pay.mailejifen.com/views/site/login.php',
      1 => 1526876268,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/from.php' => 1,
  ),
),false)) {
function content_5b0cb5ab27d444_86051471 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>

<?php 
new Block_title_8378248085b0cb5ab276428_05792499($_smarty_tpl);
?>


<?php 
new Block_css_16936659895b0cb5ab277181_30510608($_smarty_tpl);
?>

<?php 
new Block_content_20646903655b0cb5ab277f96_41236811($_smarty_tpl);
?>

<?php 
new Block_js_1789826465b0cb5ab27a059_29396704($_smarty_tpl);
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:layouts/from.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'title'} /vagrant/www/admin-pay.mailejifen.com/views/site/login.php */
class Block_title_8378248085b0cb5ab276428_05792499 extends Smarty_Internal_Block
{
public $name = 'title';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>
麦乐支付中心 | 登录帐号<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'title'} */
/* {block 'css'} /vagrant/www/admin-pay.mailejifen.com/views/site/login.php */
class Block_css_16936659895b0cb5ab277181_30510608 extends Smarty_Internal_Block
{
public $name = 'css';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

<link rel="stylesheet" href="http://cdn.mailejifen.com/plugins/iCheck/square/blue.css">
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'css'} */
/* {block 'content'} /vagrant/www/admin-pay.mailejifen.com/views/site/login.php */
class Block_content_20646903655b0cb5ab277f96_41236811 extends Smarty_Internal_Block
{
public $name = 'content';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

<form method="post" class="form-horizontal">
    <div class="form-group has-feedback">
        <input type="text" class="form-control" id="username" placeholder="用户名" name="username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="密码" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="login">
        <input type="submit" value="登&nbsp;录" class="btn btn-info btn-block btn-flat">
    </div>
</form>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'content'} */
/* {block 'js'} /vagrant/www/admin-pay.mailejifen.com/views/site/login.php */
class Block_js_1789826465b0cb5ab27a059_29396704 extends Smarty_Internal_Block
{
public $name = 'js';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>


<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'js'} */
}
