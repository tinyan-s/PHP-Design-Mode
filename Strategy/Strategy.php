<?php
// stragegy 定义所有支持的算法的公共接口
abstract class CashStrategySuper {
    abstract function getCash($count, $price);
}

/**
 * NomalCashStrategy 无任何优惠, 具体实现的算法Nomal类
 * 
 * @uses CashStrategySuper
 */
class NomalCashStrategy extends CashStrategySuper {

    public function getCash($count, $price){
        return $count * $price;
    }
}

/**
 * DiscountCashStrategy 具体实现的算法折扣类
 * 
 * @uses CashStrategySuper
 */
class DiscountCashStrategy extends CashStrategySuper {
    private $discount;

    public function __construct($discount){
        $this->discount = $discount;
    }

    public function getCash($count, $price){
        return $count * $price * $this->discount; 
    }
}

class FullPresendCashStrategy extends CashStrategySuper {
    // 满多少
    private $full = 0;
    // 送多少
    private $presend = 0;

    public function __construct($full, $presend) {
        $this->full = $full;
        $this->presend = $presend;
    }


    public function getCash($count, $price){
        $total = $count * $price;    
        if($total >= $this->full){
            $total -= $this->presend; 
        }
        return $total;
    }

}

/**
 * Strategy 策略算法上下文 维护一个对Strategy具体算法对象的应用
 * 
 */
class Context {
    private $instance;

    /**
     * setInstance 
     * 
     * @param mixed $instance 实际执行的算法实例
     * @access public
     * @return void
     */
    public function __construct($instance){
        $this->instance = $instance; 
    }
    
    public function getResult($count, $price){
        return $this->instance->getCash($count, $price);
    }
}

class Client {
    // 某某在天猫里面，不同的店铺，购买了以下商品，每个店铺优惠力度不一样。
    // 购买了2箱牛奶，每箱50元，无优惠   100  
    // 购买了3箱青苹果，每箱50元，打8折， 120 
    // 购买了5箱红苹果，每箱50元，打7折， 175 
    // 购买了4箱李子，每箱50元，满200减50，150 
    // 共花费多少钱？
    // 545元
    static function run(){
        $total = 0;
        // 普通收费
        $nomalCashStrategy = new Context(new NomalCashStrategy());
        $total += $nomalCashStrategy->getResult(2, 50);

        // 8折算法收费
        $discountCash80Strategy = new Context(new DiscountCashStrategy(0.8));
        $total += $discountCash80Strategy->getResult(3, 50);

        // 7折算法收费
        $discountCash70Strategy = new Context(new DiscountCashStrategy(0.7));
        $total += $discountCash70Strategy->getResult(5, 50);

        // 满赠算法 满200 减50
        $fullPresendCashStrategy = new Context(new FullPresendCashStrategy(200, 50));
        $total += $fullPresendCashStrategy->getResult(4, 50);
    
        echo '总花费：' . $total;
        
    }
}

Client::run();


?>
