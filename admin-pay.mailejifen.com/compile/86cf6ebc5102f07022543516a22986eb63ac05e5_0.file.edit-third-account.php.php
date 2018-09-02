<?php
/* Smarty version 3.1.30-dev/45, created on 2018-05-30 01:52:09
  from "/vagrant/www/admin-pay.mailejifen.com/views/platform/edit-third-account.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/45',
  'unifunc' => 'content_5b0d934953b544_19075306',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '86cf6ebc5102f07022543516a22986eb63ac05e5' => 
    array (
      0 => '/vagrant/www/admin-pay.mailejifen.com/views/platform/edit-third-account.php',
      1 => 1526618129,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/index.php' => 1,
  ),
),false)) {
function content_5b0d934953b544_19075306 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>

<?php 
new Block_title_9271345755b0d93493a8053_00438800($_smarty_tpl);
?>

<?php 
new Block_js_19862602615b0d93493aa291_56914800($_smarty_tpl);
?>


<?php 
new Block_breadcrumb_19254266835b0d93494c74b9_65554271($_smarty_tpl);
?>


<?php 
new Block_content_19089712265b0d934953a2c9_78758906($_smarty_tpl);
$_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:layouts/index.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'title'} /vagrant/www/admin-pay.mailejifen.com/views/platform/edit-third-account.php */
class Block_title_9271345755b0d93493a8053_00438800 extends Smarty_Internal_Block
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
/* {block 'js'} /vagrant/www/admin-pay.mailejifen.com/views/platform/edit-third-account.php */
class Block_js_19862602615b0d93493aa291_56914800 extends Smarty_Internal_Block
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

	$('form').on('submit', function() {
	   var json = $('.json').val();
	   if(json == '') {
		   $('.json').val('{}');
		   return true;
	   }

	   try {
		   JSON.parse(json);
	   }
	   catch(e) {
		   alert('json数据格式不正确，请检查后再提交');
		   return false;
	   }
	});
});
<?php echo '</script'; ?>
>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'js'} */
/* {block 'breadcrumb'} /vagrant/www/admin-pay.mailejifen.com/views/platform/edit-third-account.php */
class Block_breadcrumb_19254266835b0d93494c74b9_65554271 extends Smarty_Internal_Block
{
public $name = 'breadcrumb';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

    <?php if ($_smarty_tpl->tpl_vars['appContext']->value) {?><li><a href="/uc/application/dashboard?id=<?php echo $_smarty_tpl->tpl_vars['appContext']->value->id;?>
"><i class="fa fa-dashboard"></i> <?php echo $_smarty_tpl->tpl_vars['appContext']->value->app_name;?>
</a></li><?php }?>
    <li class="active">账号编辑</li>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'breadcrumb'} */
/* {block 'content'} /vagrant/www/admin-pay.mailejifen.com/views/platform/edit-third-account.php */
class Block_content_19089712265b0d934953a2c9_78758906 extends Smarty_Internal_Block
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
                 账号（在第三方平台上的账号，如支付宝账号） <input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['model']->value['account'];?>
" name="account" />
            </td>
        </tr>
        <tr>
            <td>
                类型（alipay:支付宝; weixin:微信; iapppay:爱贝） <input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['model']->value['account_type'];?>
" name="account_type" <?php if ($_smarty_tpl->tpl_vars['model']->value) {?>disabled<?php }?>/>
            </td>
        </tr>
        <tr>
            <td>
                说明<br/><textarea class="form-control" name="description"><?php echo $_smarty_tpl->tpl_vars['model']->value['description'];?>
</textarea>
            </td>
        </tr>
        <tr>
            <td>
                配置数据（json）<br/><textarea class="form-control json" style="word-break: break-all; font-weight: bold;" name="data" rows="20" data-title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['model']->value['data']);?>
"></textarea>
            </td>
        </tr>
    </table>
    <br>
    <input type="submit" class="btn-primary btn" value="提交" />&nbsp;&nbsp;&nbsp;<a href="/platform/third-account" type="submit" class="btn-default btn">返回</a>
</form>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'content'} */
}
