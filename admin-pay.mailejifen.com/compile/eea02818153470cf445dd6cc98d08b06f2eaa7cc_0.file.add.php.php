<?php
/* Smarty version 3.1.30-dev/45, created on 2018-06-04 15:04:35
  from "/vagrant/www/admin-pay.mailejifen.com/views/application/add.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/45',
  'unifunc' => 'content_5b14e4830a6b55_91497868',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eea02818153470cf445dd6cc98d08b06f2eaa7cc' => 
    array (
      0 => '/vagrant/www/admin-pay.mailejifen.com/views/application/add.php',
      1 => 1528094699,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/index.php' => 1,
  ),
),false)) {
function content_5b14e4830a6b55_91497868 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>

<?php 
new Block_title_9038489535b14e48307a7c1_06982213($_smarty_tpl);
?>


<?php 
new Block_js_5782163275b14e48307c374_46623580($_smarty_tpl);
?>


<?php 
new Block_breadcrumb_15672381305b14e483096d41_31353066($_smarty_tpl);
?>


<?php 
new Block_content_8593451455b14e4830a5fa3_52463043($_smarty_tpl);
$_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:layouts/index.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'title'} /vagrant/www/admin-pay.mailejifen.com/views/application/add.php */
class Block_title_9038489535b14e48307a7c1_06982213 extends Smarty_Internal_Block
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
/* {block 'js'} /vagrant/www/admin-pay.mailejifen.com/views/application/add.php */
class Block_js_5782163275b14e48307c374_46623580 extends Smarty_Internal_Block
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
 src="/public/js/moment.min.js"><?php echo '</script'; ?>
>
<link rel="stylesheet" href="/public/css/upload.css">

<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'js'} */
/* {block 'breadcrumb'} /vagrant/www/admin-pay.mailejifen.com/views/application/add.php */
class Block_breadcrumb_15672381305b14e483096d41_31353066 extends Smarty_Internal_Block
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
/* {block 'content'} /vagrant/www/admin-pay.mailejifen.com/views/application/add.php */
class Block_content_8593451455b14e4830a5fa3_52463043 extends Smarty_Internal_Block
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
                 平台标识* <input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['model']->value['platform'];?>
" name="platform" <?php if ($_smarty_tpl->tpl_vars['model']->value) {?>disabled<?php }?> />
            </td>
        </tr>
            <td>
                 应用名称*<input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['model']->value['name'];?>
" name="name" />
            </td>
        </tr>
        <tr>
            <td>
                <p></p>
                应用状态*
                <div>
                    <label checkbox-inline>
                        启用<input type="radio" class="minimal" checked name="status" value="0"  />
                    </label>
                    &nbsp;&nbsp;&nbsp;
                    <label checkbox-inline>
                        禁用<input type="radio" class="minimal" name="status" value="1"/>
                    </label>
                </div> 
            </td>
        </tr>
    </table>
    <br>
    <input type="submit" class="btn-primary btn" id="btnSubmit" value="提交"  />&nbsp;&nbsp;&nbsp;<a href="/application/list" type="submit" class="btn-default btn">返回</a>
</form>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'content'} */
}
