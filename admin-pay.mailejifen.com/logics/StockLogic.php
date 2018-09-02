<?php 
namespace app\logics;

use app\logics\BaseLogic;
use app\models\StockModel;
class StockLogic extends BaseLogic
{
    public function getStockMap($ids)
    {
        $stocks =  StockModel::getStocksArr($ids);
        $stocks = array_column($stocks, 'stock', 'id');
        return $stocks;
    }
}
?>