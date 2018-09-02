<?php
/* Smarty version 3.1.30-dev/45, created on 2018-05-31 16:37:29
  from "/vagrant/www/admin-pay.mailejifen.com/views/application/edit.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/45',
  'unifunc' => 'content_5b0fb4493addb5_86613554',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b8a6e648009456af6fb88593011e177172679d12' => 
    array (
      0 => '/vagrant/www/admin-pay.mailejifen.com/views/application/edit.php',
      1 => 1527676932,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/index.php' => 1,
  ),
),false)) {
function content_5b0fb4493addb5_86613554 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>

<?php 
new Block_title_8215639135b0fb449386ef4_05787176($_smarty_tpl);
?>


<?php 
new Block_breadcrumb_2625847415b0fb4493a1c66_91030010($_smarty_tpl);
?>


<?php 
new Block_content_18034170695b0fb4493a7683_04746996($_smarty_tpl);
?>



<?php 
new Block_js_6463808055b0fb4493ac9f9_73826724($_smarty_tpl);
$_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:layouts/index.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'title'} /vagrant/www/admin-pay.mailejifen.com/views/application/edit.php */
class Block_title_8215639135b0fb449386ef4_05787176 extends Smarty_Internal_Block
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
/* {block 'breadcrumb'} /vagrant/www/admin-pay.mailejifen.com/views/application/edit.php */
class Block_breadcrumb_2625847415b0fb4493a1c66_91030010 extends Smarty_Internal_Block
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
/* {block 'content'} /vagrant/www/admin-pay.mailejifen.com/views/application/edit.php */
class Block_content_18034170695b0fb4493a7683_04746996 extends Smarty_Internal_Block
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
                 应用名称*<input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['model']->value['name'];?>
" name="name" />
            </td>
        </tr>
        <tr>
            <td>
                key<input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['model']->value['key'];?>
" name="key" disabled/>
            </td>
        </tr>
        <tr>
            <td>
                secret<input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['model']->value['secret'];?>
" name="secret" disabled/>
            </td>
        </tr>
        <tr>
            <td>
                <p></p>
                应用状态*
                <div>
                    <label checkbox-inline>
                        启用<input type="radio" name="status" value="0"/>
                    </label>
                    &nbsp;&nbsp;&nbsp;
                    <label checkbox-inline>
                        禁用<input type="radio" name="status" value="1"/>
                    </label>
                </div>
            </td>
        </tr>
    </table>
    <br>
    <input type="submit" class="btn-primary btn" id="btnSubmit" value="提交" />&nbsp;&nbsp;&nbsp;<a href="/application/list" type="submit" class="btn-default btn">返回</a>
</form>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'content'} */
/* {block 'js'} /vagrant/www/admin-pay.mailejifen.com/views/application/edit.php */
class Block_js_6463808055b0fb4493ac9f9_73826724 extends Smarty_Internal_Block
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
<?php echo '<script'; ?>
 type="text/javascript"> 
$(function() {
    $("#btnSubmit").click(function(){
            var val_name=$("#name").val();
            if(val_name==''){
                alert("名称不能为空!");
                return false; 
            }
    });
});
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">  
    $(function() {
        var sta = <?php echo $_smarty_tpl->tpl_vars['model']->value['status'];?>

        $(":input[name='status']").eq(sta).attr("checked",true);  
        
    });
<?php echo '</script'; ?>
>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'js'} */
}
