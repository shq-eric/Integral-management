<?php
/**
 * URL检测监控
 * @author Rebill.Ruan <rebill01.ruan@viphsop.com>
 */


/**
 * MySQL健康检查
 * @param $host
 * @param $dbname
 * @param $username
 * @param $password
 * @param int $port
 * @return bool
 */
function checkMySQL($host, $dbname, $username, $password, $port=3306) {
    try {
        $conn = new PDO("mysql:host={$host};port={$port};dbname={$dbname}", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn = null;
        return true;
    } catch(Exception $e) {
        return false;
    }
}

/**
 * Redis健康检查
 * @param $host
 * @param $port
 * @return bool
 */
function checkRedis($host, $port) {
    try {
        $redis = new Redis();
        $redis->connect($host, $port, 3);
        $redis->ping();
        $redis->close();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Memcache健康检查
 * @param $host
 * @param $port
 * @return bool
 */
function checkMemcache($host, $port) {
    try {
        if (extension_loaded('memcached')) {
            $m = new Memcached();
        } else {
            $m = new Memcache();
        }

        $m->addServer($host, $port);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * MongoDB健康检查
 * @param $host
 * @param $port
 * @return bool
 */
function checkMongoDB($host, $port, $replsetname) {
    try {
        $connection = new MongoClient("mongodb://{$host}:{$port}/?replicaSet={$replsetname}");
        $connection->connect();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
//$connection = new MongoClient('mongodb://'. getenv('VIPWEIXIN_API_CACHE_MONGO_A_HOST'). ':' .getenv('VIPWEIXIN_API_CACHE_MONGO_A_PORT').','. getenv('VIPWEIXIN_API_CACHE_MONGO_B_HOST'). ':' .getenv('VIPWEIXIN_API_CACHE_MONGO_B_PORT').'/?replicaSet='. getenv('VIPWEIXIN_API_CACHE_MONGO_REPLSETNAME'));
//$connection->connect();

/**
 * 检查日志目录
 * @param $logPath
 */
function checkLogDir($logPath) {
    if (!file_exists($logPath)) {
        mkdir($logPath, 0777, true);
    }
}

// MySQL
if (!checkMySQL(getenv('VIPWEIXIN_API_DB_MASTER_HOST'), getenv('VIPWEIXIN_API_DB_MASTER_DATABASE'),
    getenv('VIPWEIXIN_API_DB_MASTER_USERNAME'), getenv('VIPWEIXIN_API_DB_MASTER_PASSWORD'))) {
    echo '1001'.'<br/>';
}

if (!checkMySQL(getenv('VIPWEIXIN_API_DB_SLAVE_HOST'), getenv('VIPWEIXIN_API_DB_SLAVE_DATABASE'),
    getenv('VIPWEIXIN_API_DB_SLAVE_USERNAME'), getenv('VIPWEIXIN_API_DB_SLAVE_PASSWORD'))) {
    echo '1002'.'<br/>';
}

if (!checkMySQL(getenv('VIPWEIXIN_ACT_DB_MASTER_HOST'), getenv('VIPWEIXIN_ACT_DB_MASTER_DATABASE'),
    getenv('VIPWEIXIN_ACT_DB_MASTER_USERNAME'), getenv('VIPWEIXIN_ACT_DB_MASTER_PASSWORD'), getenv('VIPWEIXIN_ACT_DB_MASTER_PORT'))) {
    echo '1003'.'<br/>';
}

if (!checkMySQL(getenv('VIPWEIXIN_ACT_DB_SLAVE_HOST'), getenv('VIPWEIXIN_ACT_DB_SLAVE_DATABASE'),
    getenv('VIPWEIXIN_ACT_DB_SLAVE_USERNAME'), getenv('VIPWEIXIN_ACT_DB_SLAVE_PASSWORD'), getenv('VIPWEIXIN_ACT_DB_MASTER_PORT'))) {
    echo '1004'.'<br/>';
}

// Redis
if (!checkRedis(getenv('VIPWEIXIN_API_CACHE_REDIS_A_HOST'), getenv('VIPWEIXIN_API_CACHE_REDIS_A_PORT'))) {
    echo '2001'.'<br/>';
}

if (!checkRedis(getenv('VIPWEIXIN_API_CACHE_REDIS_B_HOST'), getenv('VIPWEIXIN_API_CACHE_REDIS_B_PORT'))) {
    echo '2002'.'<br/>';
}

// Memcache
if (!checkMemcache(getenv('VIPWEIXIN_API_CACHE_MEMCACHE_A_HOST'), getenv('VIPWEIXIN_API_CACHE_MEMCACHE_A_PORT'))) {
    echo '3001'.'<br/>';
}
if (!checkMemcache(getenv('VIPWEIXIN_API_CACHE_MEMCACHE_B_HOST'), getenv('VIPWEIXIN_API_CACHE_MEMCACHE_B_PORT'))) {
    echo '3002'.'<br/>';
}

// MongoDB

//if (!checkMongoDB(getenv('VIPWEIXIN_API_CACHE_MONGO_A_HOST'), getenv('VIPWEIXIN_API_CACHE_MONGO_A_PORT'),getenv('VIPWEIXIN_API_CACHE_MONGO_REPLSETNAME'))) {
//    echo '4001'.'<br/>';
//}
//
//if (!checkMongoDB(getenv('VIPWEIXIN_API_CACHE_MONGO_B_HOST'), getenv('VIPWEIXIN_API_CACHE_MONGO_B_PORT'),getenv('VIPWEIXIN_API_CACHE_MONGO_REPLSETNAME'))) {
//    echo '4002'.'<br/>';
//}


checkLogDir('/apps/logs/php/weixin-act.vip.com/');

echo 'ok';
