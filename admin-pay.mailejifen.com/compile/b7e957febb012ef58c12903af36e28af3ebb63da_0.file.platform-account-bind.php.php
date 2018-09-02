<?php
/* Smarty version 3.1.30-dev/45, created on 2018-05-30 01:54:10
  from "/vagrant/www/admin-pay.mailejifen.com/views/platform/platform-account-bind.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/45',
  'unifunc' => 'content_5b0d93c2e8ae06_23474311',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b7e957febb012ef58c12903af36e28af3ebb63da' => 
    array (
      0 => '/vagrant/www/admin-pay.mailejifen.com/views/platform/platform-account-bind.php',
      1 => 1526618129,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/index.php' => 1,
  ),
),false)) {
function content_5b0d93c2e8ae06_23474311 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>
 <?php 
new Block_title_12307623015b0d93c2db7501_17504885($_smarty_tpl);
?>
 <?php 
new Block_js_10896748045b0d93c2de4c07_89965582($_smarty_tpl);
?>


<?php 
new Block_breadcrumb_14644737035b0d93c2de6f49_63868789($_smarty_tpl);
?>


<?php 
new Block_content_1207300855b0d93c2e886e7_75395707($_smarty_tpl);
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:layouts/index.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'title'} /vagrant/www/admin-pay.mailejifen.com/views/platform/platform-account-bind.php */
class Block_title_12307623015b0d93c2db7501_17504885 extends Smarty_Internal_Block
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
/* {block 'js'} /vagrant/www/admin-pay.mailejifen.com/views/platform/platform-account-bind.php */
class Block_js_10896748045b0d93c2de4c07_89965582 extends Smarty_Internal_Block
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
<?php echo '<script'; ?>
>
var boundAccounts = <?php echo json_encode($_smarty_tpl->tpl_vars['boundAccounts']->value);?>
;
var platformId = <?php echo $_smarty_tpl->tpl_vars['model']->value['id'];?>
;

$(function(){
    $('.bind').on('click', function() {
        var $tr = $(this).closest('tr');
        var account_type = $tr.find('.type').html();
        var accountId = $tr.data('id');
        
        for(var i in boundAccounts) {
            if(boundAccounts[i]['account_type'] == account_type) {
                if(confirm('该支付类型已存在绑定账号，确认替换掉该账号？')) {
                    return true;
                }
                else {
                    return false;
                }
            }
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
/* {block 'breadcrumb'} /vagrant/www/admin-pay.mailejifen.com/views/platform/platform-account-bind.php */
class Block_breadcrumb_14644737035b0d93c2de6f49_63868789 extends Smarty_Internal_Block
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
/* {block 'content'} /vagrant/www/admin-pay.mailejifen.com/views/platform/platform-account-bind.php */
class Block_content_1207300855b0d93c2e886e7_75395707 extends Smarty_Internal_Block
{
public $name = 'content';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

<style>
label.label {
	margin-right: 10px;
}
.bind, .unbind {
	cursor: pointer;
}
</style>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">账户列表 - 绑定到 [<b><?php echo $_smarty_tpl->tpl_vars['model']->value->name;?>
</b>]</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th style="width: 30%;">账号</th>
                        <th style="width: 10%;">类型</th>
                        <th>是否绑定</th>
                        <th style="width: 10%;">操作</th>
                    </tr>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'item');
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$__foreach_item_0_saved = $_smarty_tpl->tpl_vars['item'];
?>
                    <tr data-id="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">
                        <td><b><?php echo $_smarty_tpl->tpl_vars['item']->value['account'];?>
</b> <span style="font-size: 12px; color: #666;"><?php echo $_smarty_tpl->tpl_vars['item']->value['description'];?>
</span></td>
                        <td class="type"><?php echo $_smarty_tpl->tpl_vars['item']->value['account_type'];?>
</td>
                        <td><?php if ($_smarty_tpl->tpl_vars['item']->value['bound']) {?><label class="label bg-green">是</label><?php } else { ?><label class="label bg-red">否</label><?php }?></td>
                        <td><?php if ($_smarty_tpl->tpl_vars['item']->value['bound']) {?>
                            <a href="/platform/do-unbind?platformId=<?php echo $_smarty_tpl->tpl_vars['model']->value['id'];?>
&accountId=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><label class="label bg-red unbind"><i class="fa fa-unlink"> 解除绑定</i></label></a>
                            <?php } else { ?>
                            <a href="/platform/do-bind?platformId=<?php echo $_smarty_tpl->tpl_vars['model']->value['id'];?>
&accountId=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><label class="label bg-green bind"><i class="fa fa-link"> 绑定</i></label></a>
                            <?php }?>
                        </td>
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
        <div style="margin-bottom:10px;">
            <a href="/platform/list" class="btn btn-info" role="button">返回</a>
        </div>
        
    </div>
    <!-- /.box -->
</div>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'content'} */
}
