<?php
/* Smarty version 3.1.30-dev/45, created on 2018-06-04 18:33:46
  from "/vagrant/www/admin-pay.mailejifen.com/views/platform/edit.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/45',
  'unifunc' => 'content_5b15158a4182c0_15315284',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '87490d901002fa671cb77c6022931b79102ff2e9' => 
    array (
      0 => '/vagrant/www/admin-pay.mailejifen.com/views/platform/edit.php',
      1 => 1528094857,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/index.php' => 1,
  ),
),false)) {
function content_5b15158a4182c0_15315284 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>

<?php 
new Block_title_16566240305b15158a3df996_16493063($_smarty_tpl);
?>

<?php 
new Block_js_8365854455b15158a3e2718_59064313($_smarty_tpl);
?>


<?php 
new Block_breadcrumb_859384535b15158a411552_55752879($_smarty_tpl);
?>


<?php 
new Block_content_4191470635b15158a4170d3_04757684($_smarty_tpl);
$_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:layouts/index.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'title'} /vagrant/www/admin-pay.mailejifen.com/views/platform/edit.php */
class Block_title_16566240305b15158a3df996_16493063 extends Smarty_Internal_Block
{
public $name = 'title';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>
麦乐积分 | 商户后台<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'title'} */
/* {block 'js'} /vagrant/www/admin-pay.mailejifen.com/views/platform/edit.php */
class Block_js_8365854455b15158a3e2718_59064313 extends Smarty_Internal_Block
{
public $name = 'js';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

<?php echo '<script'; ?>
 src="/public/js/jquery.upload.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/public/js/jquery.myupload.js"><?php echo '</script'; ?>
>
<link rel="stylesheet" href="/public/css/upload.css">
<?php echo '<script'; ?>
>
$(function() {
	var data = $('textarea[name=data]').data('title');
	if(!data) {
		data = {};
	}
	$('textarea[name=data]').val(JSON.stringify(data, null, 8));
});
<?php echo '</script'; ?>
>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'js'} */
/* {block 'breadcrumb'} /vagrant/www/admin-pay.mailejifen.com/views/platform/edit.php */
class Block_breadcrumb_859384535b15158a411552_55752879 extends Smarty_Internal_Block
{
public $name = 'breadcrumb';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

    <?php if ($_smarty_tpl->tpl_vars['appContext']->value) {?><li><a href="/uc/application/dashboard?id=<?php echo $_smarty_tpl->tpl_vars['appContext']->value->id;?>
"><i class="fa fa-dashboard"></i> <?php echo $_smarty_tpl->tpl_vars['appContext']->value->app_name;?>
</a></li><?php }?>
    <li class="active">平台编辑</li>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'breadcrumb'} */
/* {block 'content'} /vagrant/www/admin-pay.mailejifen.com/views/platform/edit.php */
class Block_content_4191470635b15158a4170d3_04757684 extends Smarty_Internal_Block
{
public $name = 'content';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

<form method="post">
    <table width="100%" border="0">
        <table width="100%" border="0">
        <tr>
            <td>
                平台标识 <input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['model']->value['platform'];?>
" name="platform" <?php if ($_smarty_tpl->tpl_vars['model']->value) {?>disabled<?php }?> />
            </td>
        </tr>
        <tr>
            <td>
                平台名称<input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['model']->value['name'];?>
" name="name" />
            </td>
        </tr>
    </table>
    <br>
    <input type="submit" class="btn-primary btn" value="提交" />&nbsp;&nbsp;&nbsp;<a href="/platform/list" type="submit" class="btn-default btn">返回</a>
</form>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'content'} */
}
