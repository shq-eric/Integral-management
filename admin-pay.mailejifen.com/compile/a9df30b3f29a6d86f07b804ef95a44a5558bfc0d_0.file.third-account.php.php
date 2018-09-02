<?php
/* Smarty version 3.1.30-dev/45, created on 2018-05-30 09:12:29
  from "/vagrant/www/admin-pay.mailejifen.com/views/platform/third-account.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/45',
  'unifunc' => 'content_5b0dfa7d6f8a99_08278009',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a9df30b3f29a6d86f07b804ef95a44a5558bfc0d' => 
    array (
      0 => '/vagrant/www/admin-pay.mailejifen.com/views/platform/third-account.php',
      1 => 1527642718,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/index.php' => 1,
  ),
),false)) {
function content_5b0dfa7d6f8a99_08278009 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>
 <?php 
new Block_title_1027719805b0dfa7d67de61_65134046($_smarty_tpl);
?>
 <?php 
new Block_js_6929292815b0dfa7d6834f6_43921826($_smarty_tpl);
?>


<?php 
new Block_breadcrumb_19768597915b0dfa7d69c3f4_14711301($_smarty_tpl);
?>


<?php 
new Block_content_7357669745b0dfa7d6f4339_02295829($_smarty_tpl);
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:layouts/index.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'title'} /vagrant/www/admin-pay.mailejifen.com/views/platform/third-account.php */
class Block_title_1027719805b0dfa7d67de61_65134046 extends Smarty_Internal_Block
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
/* {block 'js'} /vagrant/www/admin-pay.mailejifen.com/views/platform/third-account.php */
class Block_js_6929292815b0dfa7d6834f6_43921826 extends Smarty_Internal_Block
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
    $(function(){
        $('.item-data').click(function(){
            var data = $(this).data('title');
            var html = '';
            for(var k in data) {
            	html += "<div style='background: #ccc; margin-bottom: 10px;'><p style='background: #aaa; font-weight: bold;'>" + k + "</p><p style='word-break: break-all;'>" + data[k] + "</p></div>"
            }
            
            $('#data-modal .body').html(html);
            $('#data-modal').modal();
        });
    });
<?php echo '</script'; ?>
>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'js'} */
/* {block 'breadcrumb'} /vagrant/www/admin-pay.mailejifen.com/views/platform/third-account.php */
class Block_breadcrumb_19768597915b0dfa7d69c3f4_14711301 extends Smarty_Internal_Block
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
/* {block 'content'} /vagrant/www/admin-pay.mailejifen.com/views/platform/third-account.php */
class Block_content_7357669745b0dfa7d6f4339_02295829 extends Smarty_Internal_Block
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
            <a href="/platform/add" class="btn btn-info" role="button">添加账户</a>
        </div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">账户列表</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th style="width: 20%;">账号</th>
                        <th style="width: 10%;">类型</th>
                        <th>说明</th>
                        <th>绑定平台</th>
                        <th style="width: 10%;">配置数据</th>
                        <th style="width: 10%;">操作</th>
                    </tr>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'item');
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$__foreach_item_0_saved = $_smarty_tpl->tpl_vars['item'];
?>
                    <tr>
                        <td><b><?php echo $_smarty_tpl->tpl_vars['item']->value['account'];?>
</b></td>
                        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['account_type'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['description'];?>
</td>
                        <td>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value['boundPlatforms'], 'platform');
foreach ($_from as $_smarty_tpl->tpl_vars['platform']->value) {
$_smarty_tpl->tpl_vars['platform']->_loop = true;
$__foreach_platform_1_saved = $_smarty_tpl->tpl_vars['platform'];
?>
                                <label class="label bg-gray" title="平台标识：<?php echo $_smarty_tpl->tpl_vars['platform']->value['platform'];?>
"><?php echo $_smarty_tpl->tpl_vars['platform']->value['name'];?>
</label>
                            <?php
$_smarty_tpl->tpl_vars['platform'] = $__foreach_platform_1_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
                        </td>
                        <td><span class="item-data" style="cursor: pointer;" data-title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['data']);?>
">点击查看</span></td>
                        <td><a href="/platform/edit-third-account?id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
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

<div class="example-modal">
    <div class="modal" id="data-modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">配置数据</h4>
          </div>
          <div class="modal-body">
            <p class="body"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div><!-- /.example-modal -->

<div class="example-modal">
    <div class="modal" id="bind-modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">平台绑定</h4>
          </div>
          <div class="modal-body">
            <p class="body"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div><!-- /.example-modal -->
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'content'} */
}
