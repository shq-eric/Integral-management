<?php
/* Smarty version 3.1.30-dev/45, created on 2018-06-04 20:52:11
  from "/vagrant/www/admin-pay.mailejifen.com/views/order/refund-order.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/45',
  'unifunc' => 'content_5b1535fbd11e82_24629144',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'be8dd6b71f742191d211ac46204fe3615a466878' => 
    array (
      0 => '/vagrant/www/admin-pay.mailejifen.com/views/order/refund-order.php',
      1 => 1528116707,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/index.php' => 1,
  ),
),false)) {
function content_5b1535fbd11e82_24629144 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>
 
<?php 
new Block_title_20460079015b1535fbcc33e6_43020672($_smarty_tpl);
?>
 

<?php 
new Block_breadcrumb_13321181735b1535fbcd9453_74525715($_smarty_tpl);
?>


<?php 
new Block_content_13024829465b1535fbd09ef1_04420395($_smarty_tpl);
?>


<?php 
new Block_js_20379401565b1535fbd10666_68252992($_smarty_tpl);
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:layouts/index.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'title'} /vagrant/www/admin-pay.mailejifen.com/views/order/refund-order.php */
class Block_title_20460079015b1535fbcc33e6_43020672 extends Smarty_Internal_Block
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
/* {block 'breadcrumb'} /vagrant/www/admin-pay.mailejifen.com/views/order/refund-order.php */
class Block_breadcrumb_13321181735b1535fbcd9453_74525715 extends Smarty_Internal_Block
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
/* {block 'content'} /vagrant/www/admin-pay.mailejifen.com/views/order/refund-order.php */
class Block_content_13024829465b1535fbd09ef1_04420395 extends Smarty_Internal_Block
{
public $name = 'content';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

<link href="/public/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
<style>
label.label {
	margin-right: 10px;
}
</style>
<div class="row">
    <div class="col-xs-12">
          <form name="orderform" action="/order/refund-order" method="get" class="form-inline">
            <div class="form-group">
                    <input type="text"  class="form-control" id="maile_pay_sn" name="maile_pay_sn" placeholder="麦乐支付订单号" style="width: 200px; height: 35px " />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" class="form-control" id="maile_refund_sn" name="maile_refund_sn" placeholder="退款订单号" style="width: 200px; height: 35px;" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <select class="form-control" id="refund_reason" name="refund_reason" style="width: 150px; height: 35px;">
                    <option value ='' checked>请选择退款原因</option>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['refund_reason']->value, 'reason');
foreach ($_from as $_smarty_tpl->tpl_vars['reason']->value) {
$_smarty_tpl->tpl_vars['reason']->_loop = true;
$__foreach_reason_0_saved = $_smarty_tpl->tpl_vars['reason'];
?>
                    <option value = <?php echo $_smarty_tpl->tpl_vars['reason']->value['refund_reason'];?>
><?php echo $_smarty_tpl->tpl_vars['reason']->value['refund_reason'];?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['reason'] = $__foreach_reason_0_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
                  </select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <select class="form-control" id="status" name="status" style="width: 150px; height: 35px;">
                    <option value ='' checked>请选择退款状态</option>
                    <option value =9 checked>退款成功</option>
                    <option value =10 checked>退款失败</option>
                  </select>
            </div>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="input-group date"> 
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>  
                <input type="text" class="form-control pull-right" value="" id="start_time" name="start_time" placeholder="开始时间"/>
            </div>
            <p></p>
            <div class="input-group date"> 
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
                <input type="text" class="form-control pull-right" value="" id="end_time" name="end_time" placeholder="结束时间"/>
            </div>
            
            <div align="right">
                <input type="submit" class="btn btn-info" value="筛选">
            <a href="/order/refund-export-csv" id = export_csv onclick="return ModidyHerf()" class="btn btn-info" role="button">导出订单</a>
            </div>
        </form>
        <p></p>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">退款订单</h3>
                <p></p>
                <?php echo $_smarty_tpl->tpl_vars['html']->value;?>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
            
                <table class="table table-hover">
                    <tr>
                        <th style="width: 15%;">麦乐支付订单号</th>
                        <th style="width: 20%;">退款订单号</th>
                        <th style="width: 10%;">退款原因</th>
                        <th style="width: 10%;">退款金额</th>
                        <th style="width: 15%;">退款状态</th>
                        <th> 创建时间</th>
                    </tr>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['order']->value, 'item');
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$__foreach_item_1_saved = $_smarty_tpl->tpl_vars['item'];
?>
                    <tr>
                        <td><b><?php echo $_smarty_tpl->tpl_vars['item']->value['maile_pay_sn'];?>
</b></td>
                        <td><b><?php echo $_smarty_tpl->tpl_vars['item']->value['maile_refund_sn'];?>
</b></td>
                        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['refund_reason'];?>
</td>
                        <td><?php echo number_format($_smarty_tpl->tpl_vars['item']->value['refund_amount']/100,2);?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['refund_status_array']->value[$_smarty_tpl->tpl_vars['item']->value['status']];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['create_time'];?>
</td>   
                    </tr>
                    <?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_1_saved;
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
/* {block 'js'} /vagrant/www/admin-pay.mailejifen.com/views/order/refund-order.php */
class Block_js_20379401565b1535fbd10666_68252992 extends Smarty_Internal_Block
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
      {$('#maile_refund_sn').val(res[1])}
      if(res[2] != '')
      {$('#refund_reason').val(res[2])}
      if(res[3] != '')
      {$('#status').val(res[3])}
      if(res[4] != '')
      {$('#start_time').val(res[4])}
      if(res[5] != '')
      {$('#end_time').val(res[5])}

    }

    function ModidyHerf(){
        var res = UrlSearch();
        var flag = res_is_void(res);
        if(flag || !res)
        {
          alert("请搜索后再导出!");
          return false;
        }
        var a = document.getElementById("export_csv");
        a.href += ("?maile_pay_sn=" + res[0] + "&maile_refund_sn=" + res[1] + "&refund_reason=" + res[2] + "&status=" +res[3]+ "&start_time=" +res[4] + "&end_time=" + res[5]);
    }
    
<?php echo '</script'; ?>
>


<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'js'} */
}
