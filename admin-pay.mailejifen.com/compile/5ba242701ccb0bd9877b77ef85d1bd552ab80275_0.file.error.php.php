<?php
/* Smarty version 3.1.30-dev/45, created on 2018-05-30 11:37:42
  from "/vagrant/www/admin-pay.mailejifen.com/views/public/error.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/45',
  'unifunc' => 'content_5b0e1c8689ff25_62240160',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5ba242701ccb0bd9877b77ef85d1bd552ab80275' => 
    array (
      0 => '/vagrant/www/admin-pay.mailejifen.com/views/public/error.php',
      1 => 1526618129,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b0e1c8689ff25_62240160 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
new Block_content_10165129535b0e1c86893e00_01891489($_smarty_tpl);
?>

<?php if ($_smarty_tpl->tpl_vars['url']->value) {
echo '<script'; ?>
>setTimeout(function () {
        location.assign('<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
');
    }, 1000);<?php echo '</script'; ?>
>
<?php }
}
/* {block 'content'} /vagrant/www/admin-pay.mailejifen.com/views/public/error.php */
class Block_content_10165129535b0e1c86893e00_01891489 extends Smarty_Internal_Block
{
public $name = 'content';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

<div>错误：<?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</div>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'content'} */
}
