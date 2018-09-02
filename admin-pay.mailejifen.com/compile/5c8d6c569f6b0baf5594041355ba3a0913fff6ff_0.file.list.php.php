<?php
/* Smarty version 3.1.30-dev/45, created on 2018-05-30 09:34:03
  from "/vagrant/www/admin-pay.mailejifen.com/views/application/list.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/45',
  'unifunc' => 'content_5b0dff8b666b54_26052098',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5c8d6c569f6b0baf5594041355ba3a0913fff6ff' => 
    array (
      0 => '/vagrant/www/admin-pay.mailejifen.com/views/application/list.php',
      1 => 1527643604,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/index.php' => 1,
  ),
),false)) {
function content_5b0dff8b666b54_26052098 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>
 
<?php 
new Block_title_3063792675b0dff8b615675_29220412($_smarty_tpl);
?>
 

<?php 
new Block_breadcrumb_13041445955b0dff8b630095_87509899($_smarty_tpl);
?>


<?php 
new Block_content_15311061085b0dff8b6608f1_48549802($_smarty_tpl);
?>


<?php 
new Block_js_20592861905b0dff8b6660d4_34155989($_smarty_tpl);
$_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:layouts/index.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'title'} /vagrant/www/admin-pay.mailejifen.com/views/application/list.php */
class Block_title_3063792675b0dff8b615675_29220412 extends Smarty_Internal_Block
{
public $name = 'title';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>
麦乐积分 |管理后台  <?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'title'} */
/* {block 'breadcrumb'} /vagrant/www/admin-pay.mailejifen.com/views/application/list.php */
class Block_breadcrumb_13041445955b0dff8b630095_87509899 extends Smarty_Internal_Block
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
/* {block 'content'} /vagrant/www/admin-pay.mailejifen.com/views/application/list.php */
class Block_content_15311061085b0dff8b6608f1_48549802 extends Smarty_Internal_Block
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
            <a href="/application/add" class="btn btn-info" role="button">添加应用</a>
        </div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">应用列表</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th style="width: 10%;">应用名称</th>
                        <th >key</th>
                        <th >secret</th>
                        <th style="width: 10%;">应用状态</th>
                        <th style="width: 10%;">操作</th>
                    </tr>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'item');
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$__foreach_item_0_saved = $_smarty_tpl->tpl_vars['item'];
?>
                    <tr>
                        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['key'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['secret'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['status'];?>
</td>
                        <td><a href="/application/edit?id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
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
/* {block 'js'} /vagrant/www/admin-pay.mailejifen.com/views/application/list.php */
class Block_js_20592861905b0dff8b6660d4_34155989 extends Smarty_Internal_Block
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
}
