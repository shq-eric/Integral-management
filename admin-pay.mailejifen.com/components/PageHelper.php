<?php
/**
 * Created by PhpStorm.
 * User: Neo
 * Date: 16/3/2
 * Time: 下午5:25
 */
namespace app\components;

use Yii;

class PageHelper
{

    private $full;

    private $url;

    private $html = '';

    private $op;

    private $totalPage;

    private $page;

    private $count;

    private $maxPage = 9;

    public $pageField = 'page';

    public function __construct($full = true)
    {
        $this->full = $full;
    }

    public function html($url, $count, $pageSize, $params = [], $page = null)
    {

        if ($count <= 0) {
            return '';
        }

        if (!$url) {
            $url = $_SERVER['REQUEST_URI'];
        }

        $op = strpos($url, '?') === false ? '?' : '&';
        $url .= $op . http_build_query($params);
        $url = preg_replace('/' . $this->pageField . '=\w+(&|\?)?/', '', $url);
        $url = preg_replace('/(&|\?)$/', '', $url);

        $this->op = strpos($url, '?') === false ? '?' : '&';
        $this->url = $url;

        $this->totalPage = ceil($count / $pageSize);
        $this->maxPage = $this->totalPage > $this->maxPage ? $this->maxPage : $this->totalPage;
        if (!$page) {
            $page = isset($_REQUEST[$this->pageField]) ? $_REQUEST[$this->pageField] : 1;
        }
        $this->page = $page;
        $this->count = $count;

        if ($this->full) {
            $this->html .= $this->info();
        }
        $this->html .= '<ul class="pagination pagination-sm no-margin pull-right">';
        $this->html .= $this->firstPage();
        $this->html .= $this->prevPage();
        $preHindPage = 4;
        $preHindPage = $page == 1 ? $this->maxPage : $preHindPage;
        $preHindPage = $page == $this->totalPage ? $this->maxPage : $preHindPage;

        $prev = $page - $preHindPage;
        $prev = $prev < 1 ? 1 : $prev;

        $next = $page + $preHindPage;
        $next = $next > $this->totalPage ? $this->totalPage : $next;

        //$next = $prev == 1 ? 10 : $next;
        //$prev = $next == $this->totalPage ? $next - 10 : $prev;

        for ($i = $prev; $i <= $next; $i++) {
            $this->html .= $this->getPage($i);
        }

//        $start = ( $this->totalPage > $this->maxPage ) ?  ( ($page > $this->maxPage) ? ( $page - ($this->totalPage - $this->maxPage) ) : $page > $this->maxPage/2 ? $page -( $this->maxPage - ( $this->totalPage - $page))  : 1 ) :1;
//        for ($i = 0; $i <= $this->maxPage; $i ++) {
//            $this->html .= $this->getPage($start);
//            if($start < $this->totalPage) {
//                ++$start;
//            }
//            else {
//                break;
//            }
//        }
        $this->html .= $this->nextPage();
        $this->html .= $this->lastPage();
        $this->html .= '</ul>';

        return $this->html;
    }

    private function firstPage()
    {
        if ($this->page > 1) {
            return '<li><a href="' . $this->url . $this->op . $this->pageField . '=1"><<</a></li>';
        }
        return '';
    }

    private function lastPage()
    {
        if ($this->totalPage > $this->page) {
            return '<li><a href="' . $this->url . $this->op . $this->pageField . '=' . $this->totalPage . '">>></a></li>';
        }
        return '';
    }

    private function prevPage()
    {
        if ($this->page > 1) {
            return '<li><a href="' . $this->url . $this->op . $this->pageField . '=' . ($this->page - 1) . '"><</a></li>';
        }
        return '';
    }

    private function nextPage()
    {
        if ($this->totalPage > $this->page) {
            return '<li><a href="' . $this->url . $this->op . $this->pageField . '=' . ($this->page + 1) . '">></a></li>';
        }
        return '';
    }

    private function getPage($page)
    {
        if ($page == $this->page) {
            return '<li class="active"><a href="javascript: void(0);"><b>' . $page . '</b></a></li>';
        }
        return '<li><a href="' . $this->url . $this->op . $this->pageField . '=' . $page . '">' . $page . '</a></li>';
    }

    private function info()
    {
        return '<div class="pull-left" style="color: #666; padding-top: 5px;">总共 ' . $this->count . ' 条记录，当前页：' . $this->page . ' / ' . $this->totalPage . '</div>';
    }
}