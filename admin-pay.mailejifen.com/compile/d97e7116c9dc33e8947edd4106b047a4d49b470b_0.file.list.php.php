<?php
/* Smarty version 3.1.30-dev/45, created on 2018-05-29 10:10:10
  from "/vagrant/www/admin-pay.mailejifen.com/views/platform/list.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/45',
  'unifunc' => 'content_5b0cb682dffb58_97932478',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd97e7116c9dc33e8947edd4106b047a4d49b470b' => 
    array (
      0 => '/vagrant/www/admin-pay.mailejifen.com/views/platform/list.php',
      1 => 1526886586,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/index.php' => 1,
  ),
),false)) {
function content_5b0cb682dffb58_97932478 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>
 <?php 
new Block_title_4518600325b0cb682c517e3_71025751($_smarty_tpl);
?>
 <?php 
new Block_js_17308257635b0cb682c53362_15192139($_smarty_tpl);
?>


<?php 
new Block_breadcrumb_8205332135b0cb682d38415_95086586($_smarty_tpl);
?>


<?php 
new Block_content_20147185435b0cb682dfda25_62407116($_smarty_tpl);
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:layouts/index.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'title'} /vagrant/www/admin-pay.mailejifen.com/views/platform/list.php */
class Block_title_4518600325b0cb682c517e3_71025751 extends Smarty_Internal_Block
{
public $name = 'title';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>
麦乐积分 |
管理后台<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'title'} */
/* {block 'js'} /vagrant/www/admin-pay.mailejifen.com/views/platform/list.php */
class Block_js_17308257635b0cb682c53362_15192139 extends Smarty_Internal_Block
{
public $name = 'js';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

<?php echo '<script'; ?>
 src="/public/js/bootstrapValidator.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/public/js/jquery.myvalidator.js"><?php echo '</script'; ?>
>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'js'} */
/* {block 'breadcrumb'} /vagrant/www/admin-pay.mailejifen.com/views/platform/list.php */
class Block_breadcrumb_8205332135b0cb682d38415_95086586 extends Smarty_Internal_Block
{
public $name = 'breadcrumb';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

<li class="active"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</li>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'breadcrumb'} */
/* {block 'content'} /vagrant/www/admin-pay.mailejifen.com/views/platform/list.php */
class Block_content_20147185435b0cb682dfda25_62407116 extends Smarty_Internal_Block
{
public $name = 'content';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

<style>
label.label {
	margin-right: 10px;
}
</style>
<div class="row">
    <div class="col-xs-12">
        <div style="margin-bottom:10px;">
            <a href="/platform/add" class="btn btn-info" role="button">添加平台</a>
        </div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">用户列表</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th style="width: 10%;">平台标识</th>
                        <th style="width: 10%;">平台名称</th>
                        <th>绑定账号</th>
                        <th style="width: 10%;">操作</th>
                    </tr>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'item');
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$__foreach_item_0_saved = $_smarty_tpl->tpl_vars['item'];
?>
                    <tr>
                        <td><b><?php echo $_smarty_tpl->tpl_vars['item']->value['platform'];?>
</b></td>
                        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
                        <td>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value['boundAccounts'], 'account');
foreach ($_from as $_smarty_tpl->tpl_vars['account']->value) {
$_smarty_tpl->tpl_vars['account']->_loop = true;
$__foreach_account_1_saved = $_smarty_tpl->tpl_vars['account'];
?>
                            <div style="margin-bottom: 10px;"><label class="label bg-gray"><?php echo $_smarty_tpl->tpl_vars['accountTypeMap']->value[$_smarty_tpl->tpl_vars['account']->value['account_type']];?>
</label><?php echo $_smarty_tpl->tpl_vars['account']->value['account'];?>
 <span style="font-size: 12px; color: #666;"><?php echo $_smarty_tpl->tpl_vars['account']->value['description'];?>
</span></div>
                            <?php
$_smarty_tpl->tpl_vars['account'] = $__foreach_account_1_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
                            <label class="label bg-gray"><a href="/platform/platform-account-bind?id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><i class="fa fa-edit" style="cursor: pointer;">编辑</i></a></label>
                        </td>
                        <td><a href="/platform/edit?id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">编辑</a></td>
                    </tr>
                    <?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_0_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
                </table>
                <div class="box-footer clearfix">
                </div>
            </div><!-- /.box -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'content'} */
}
