<?php

/**
 * Operation 计算器基类
 * 
 */
class Operation {
    private $x;
    private $y;
    function getResult($x, $y){
        return 0;
    }
}

/**
 * AddOperation 加法类
 */
class AddOperation extends Operation {
    function getResult($x, $y){
        return $x + $y; 
    }
}

/**
 * PlugOperation 乘法类
 */
class PlugOperation extends Operation {
    function getResult($x, $y){
        return $x * $y; 
    }
}

/**
 * SubOperation 减法类
 * 
 */
class SubOperation extends Operation {
    function getResult($x, $y){
        return $x - $y;
    }
}

/**
 * DivOperation 除法类
 */
class DivOperation extends Operation {
    function getResult($x, $y){
        if($y == 0){
            return 0;
        }
        return $x / $y;
    }
}

/**
 * OperationFactory 算法工厂类
 * 
 */
class OperationFactory {

    /**
     * createOperation 静态方法，用于生成指定的操作对象，即工厂
     * 
     * @param mixed $op 
     * @static
     * @access public
     * @return void
     */
    static function createOperation($op){
        $operation = null;
        switch($op){
            case '+': $operation = new AddOperation(); break;
            case '-': $operation = new SubOperation(); break;
            case '*': $operation = new PlugOperation(); break;
            case '/': $operation = new DivOperation(); break;
        
        }
        return $operation;
    }
}

/**
 * client 控制台客户端
 */
class Client {
    function run(){
        $subOperation = OperationFactory::createOperation('-');
        var_dump($subOperation->getResult(5, 2));
        $addOperation = OperationFactory::createOperation('+');
        var_dump($addOperation->getResult(5, 2));

    }
}

$client = new Client();
$client->run();
?>
