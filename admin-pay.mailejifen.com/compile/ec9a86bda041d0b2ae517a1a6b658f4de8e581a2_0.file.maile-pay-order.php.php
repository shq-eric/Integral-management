<?php
/* Smarty version 3.1.30-dev/45, created on 2018-06-04 20:51:24
  from "/vagrant/www/admin-pay.mailejifen.com/views/order/maile-pay-order.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/45',
  'unifunc' => 'content_5b1535cca44eb2_87984828',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ec9a86bda041d0b2ae517a1a6b658f4de8e581a2' => 
    array (
      0 => '/vagrant/www/admin-pay.mailejifen.com/views/order/maile-pay-order.php',
      1 => 1528116682,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/index.php' => 1,
  ),
),false)) {
function content_5b1535cca44eb2_87984828 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>
 
<?php 
new Block_title_15790097665b1535cc995fc3_82272730($_smarty_tpl);
?>


<?php 
new Block_breadcrumb_12245468535b1535cc9ad186_41842210($_smarty_tpl);
?>


<?php 
new Block_content_1708756285b1535cca2fc44_75993813($_smarty_tpl);
?>


<?php 
new Block_js_17205813685b1535cca403c6_81569023($_smarty_tpl);
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:layouts/index.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'title'} /vagrant/www/admin-pay.mailejifen.com/views/order/maile-pay-order.php */
class Block_title_15790097665b1535cc995fc3_82272730 extends Smarty_Internal_Block
{
public $name = 'title';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

麦乐积分 | 管理后台
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'title'} */
/* {block 'breadcrumb'} /vagrant/www/admin-pay.mailejifen.com/views/order/maile-pay-order.php */
class Block_breadcrumb_12245468535b1535cc9ad186_41842210 extends Smarty_Internal_Block
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
/* {block 'content'} /vagrant/www/admin-pay.mailejifen.com/views/order/maile-pay-order.php */
class Block_content_1708756285b1535cca2fc44_75993813 extends Smarty_Internal_Block
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
        <form name="orderform"action="/order/maile-pay-order" method="get" class="form-inline">
          <div class="form-group">
                  <input type="text" class="form-control" id="maile_pay_sn" name="maile_pay_sn" placeholder="麦乐支付订单号" style="width: 200px; height: 35px;" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="text" class="form-control" id="order_sn" name="order_sn" placeholder="商品订单号" style="width: 200px; height: 35px;" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <select class="form-control" id="platform" name="platform" style="width: 150px; height: 35px;">
                    <option value ='' checked>请选择购买平台</option>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['platform']->value, 'plt');
foreach ($_from as $_smarty_tpl->tpl_vars['plt']->value) {
$_smarty_tpl->tpl_vars['plt']->_loop = true;
$__foreach_plt_0_saved = $_smarty_tpl->tpl_vars['plt'];
?>
                    <option value = <?php echo $_smarty_tpl->tpl_vars['plt']->value['platform'];?>
><?php echo $_smarty_tpl->tpl_vars['platform_array']->value[$_smarty_tpl->tpl_vars['plt']->value['platform']];?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['plt'] = $__foreach_plt_0_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
                  </select>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <select class="form-control" id="pay_type" name="pay_type" style="width: 150px; height: 35px;">
                    <option value ='' checked>请选择充值方式</option>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pay_type']->value, 'type');
foreach ($_from as $_smarty_tpl->tpl_vars['type']->value) {
$_smarty_tpl->tpl_vars['type']->_loop = true;
$__foreach_type_1_saved = $_smarty_tpl->tpl_vars['type'];
?>
                    <?php if ($_smarty_tpl->tpl_vars['type']->value['pay_type'] != '') {?>
                    <option value = <?php echo $_smarty_tpl->tpl_vars['type']->value['pay_type'];?>
><?php echo $_smarty_tpl->tpl_vars['type']->value['pay_type'];?>
</option>
                    <?php }?>
                    <?php
$_smarty_tpl->tpl_vars['type'] = $__foreach_type_1_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
                  </select>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <select class="form-control" id="pay_client_type" name="pay_client_type" style="width: 200px; height: 35px;">
                    <option value ='' checked>请选择支付客户端类型</option>
                    <option value ='h5' checked>h5</option>
                    <option value ='web' checked>web</option>
                    <option value ='app' checked>app</option>
                  </select>
              
              <p></p>
                  <select class="form-control" id="status" name="status" style="width: 150px; height: 35px;">
                    <option value ='' checked>请选择充值状态</option>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['status']->value, 'value', false, 'key');
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$__foreach_value_2_saved = $_smarty_tpl->tpl_vars['value'];
?>
                    <option value = <?php echo $_smarty_tpl->tpl_vars['value']->value;?>
><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_2_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
                  </select>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="input-group date"> 
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>  
                <input type="text" class="form-control pull-right" value="" id="start_time" name="start_time" placeholder="开始时间"/>
            </div> 
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="input-group date"> 
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
                <input type="text" class="form-control pull-right" value="" id="end_time" name="end_time" placeholder="结束时间"/>
            </div>
          </div> 
            <p></p>    
            <div align="right">
                <input type="submit" class="btn btn-info" value="筛选">
            <a href="/order/maile-export-csv" id=export_csv onclick="  return ModidyHerf()" class="btn btn-info" role="button">导出订单</a>
            </div>
        </form>
        <p></p>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">麦乐订单</h3>
                <p></p>
                <?php echo $_smarty_tpl->tpl_vars['html']->value;?>

            </div>
            
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th style="width: 15%;">麦乐支付订单号</th>
                        <th style="width: 15%;">商品订单号</th>
                        <th >购买平台</th>
                        <th >充值方式</th>
                        <th >充值金额</th>
                        <th >支付客户端类型</th>
                        <th >充值状态</th>
                        <th style="width: 5%;">币种</th>
                        <th> 创建时间</th>
                    </tr>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['order']->value, 'item');
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$__foreach_item_3_saved = $_smarty_tpl->tpl_vars['item'];
?>
                    <tr>
                        <td><b><?php echo $_smarty_tpl->tpl_vars['item']->value['maile_pay_sn'];?>
</b></td>
                        <td><b><?php echo $_smarty_tpl->tpl_vars['item']->value['order_sn'];?>
</b></td>
                        <td><?php echo $_smarty_tpl->tpl_vars['platform_array']->value[$_smarty_tpl->tpl_vars['item']->value['platform']];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['pay_type'];?>
</td>
                        <td><?php echo number_format($_smarty_tpl->tpl_vars['item']->value['pay_amount']/100,2);?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['pay_client_type'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['status_array']->value[$_smarty_tpl->tpl_vars['item']->value['status']];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['fee_type'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['create_time'];?>
</td>   
                    </tr>
                    <?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_3_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
                </table>
                <div class="box-footer clearfix">
                  <?php echo $_smarty_tpl->tpl_vars['html']->value;?>

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
/* {block 'js'} /vagrant/www/admin-pay.mailejifen.com/views/order/maile-pay-order.php */
class Block_js_17205813685b1535cca403c6_81569023 extends Smarty_Internal_Block
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
<link href="/public/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
<?php echo '<script'; ?>
 src="/public/js/moment.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/public/js/bootstrap-datetimepicker.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
    $('#start_time,#end_time').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    
    window.onload = function() 
    {
      var res = UrlSearch();
      if(res[0] != '')
      {$('#maile_pay_sn').val(res[0])}
      if(res[1] != '')
      {$('#order_sn').val(res[1])}
      if(res[2] != '')
      {$('#platform').val(res[2])}
      if(res[3] != '')
      {$('#pay_type').val(res[3])}
      if(res[4] != '')
      {$('#pay_client_type').val(res[4])}
      if(res[5] != '')
      {$('#status').val(res[5])}
      if(res[6] != '')
      {$('#start_time').val(res[6])}
      if(res[7] != '')
      {$('#end_time').val(res[7])}

    }

    function ModidyHerf(){
        var res = UrlSearch();
        var flag = res_is_void(res);
        if(flag || !res)
        {
          alert("请筛选条件后再导出!");
          return false;
        }
        var a = document.getElementById("export_csv");
        a.href += ("?maile_pay_sn=" + res[0] + "&order_sn=" + res[1] + "&platform=" + res[2] + "&pay_type=" +res[3]+ "&pay_client_type=" +res[4] + "&status=" + res[5] + "&start_time=" +res[6] + "&end_time=" +res[7] );
        return true;
    }
<?php echo '</script'; ?>
>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'js'} */
}
