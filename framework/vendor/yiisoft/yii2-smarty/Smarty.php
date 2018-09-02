<?php
/**
 * Created by PhpStorm.
 * User: Neo
 * Date: 16/2/20
 * Time: 下午2:04
 */

namespace yii\smarty;

use Yii;
use yii\base\Component;

class Smarty extends Component
{

    public $config;

    public $debug = false;

    public $caching = false;

    public $cache_lifetime = null;


    function __call($name,$arguments){
        return call_user_func_array(array($this->_init(),$name),$arguments);
    }

    private function _init() {
        static $_smarty;
        if(!is_object($_smarty)) {
            include_once 'Smarty.class.php';
            $_smarty = new \Smarty();
            if(isset($this->config['template_dir'])) {
                $_smarty->template_dir = $this->config['template_dir'];
            }
            if(isset($this->config['compile_dir'])) {
                $_smarty->compile_dir = $this->config['compile_dir'];
            }
            if(isset($this->config['config_dir'])) {
                $_smarty->config_dir = $this->config['config_dir'];
            }
            if(isset($this->config['cache_dir'])) {
                $_smarty->cache_dir = $this->config['cache_dir'];
            }
            if(isset($this->config['left_delimiter'])) {
                $_smarty->left_delimiter = $this->config['left_delimiter'];
            }
            if(isset($this->config['right_delimiter'])) {
                $_smarty->right_delimiter = $this->config['right_delimiter'];
            }
            $_smarty->debugging = $this->debug;
            $_smarty->caching = $this->caching;
            if(empty($this->cache_lifetime)) {
                $_smarty->right_delimiter = $this->config['right_delimiter'];
            }

            return $_smarty;
        }
        return $_smarty;

    }
}