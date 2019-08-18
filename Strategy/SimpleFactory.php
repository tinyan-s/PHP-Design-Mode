<?php
abstract class CashSuper {
    /**
     * getResult 计算最后结果
     * 
     * @param mixed $count 数量
     * @param mixed $price 单价
     * @access public
     * @return int
     */
    abstract function getResult($count, $price);
}


/**
 * NomalCash 普通收费类
 * 
 */
class NomalCash extends CashSuper{
    function getResult($count, $price) {
        return $count * $price; 
    }
}

/**
 * DiscountCash 
 * 商场会进行搞活动，比如今天打8折，后天打7折, 等等。 
 */
class DiscountCash extends CashSuper {

    // 折扣值
    private $discount=0;

    function __construct($discount){
        $this->discount = $discount; 
    }

    /**
     * getResult 
     * 
     * @param mixed $count  数量
     * @param mixed $price  单价
     * @access public
     * @return void
     */
    function getResult($count, $price){
         return $count * $price * $this->discount; 
    }

}


/**
 * FullPresendCash 
 * 商场的活动加大， 需要有满300返利100的促销， 满400返利160促销，等等。 
 */
class FullPresendCash extends CashSuper {
    // 满多少
    private $full = 0;
    // 送多少
    private $presend = 0;

    function __construct($full, $presend){
        $this->full = $full;
        $this->presend = $presend; 
    }

    function getResult($count, $price){
        $total = $count * $price;
        if($total >= $this->full){
            $total -= $this->presend; 
        }
        return $total;
    
    }
}

class FactoryCash {

    static function createCash($type){
        $object = null;
        // 后续新增不同的算法，则需要在这里一直加下去
        switch($type){
            case '打折5折': $object = new DiscountCash(0.5); break;
            case '打折6折': $object = new DiscountCash(0.6); break;
            case '打折7折': $object = new DiscountCash(0.7); break;
            case '打折8折': $object = new DiscountCash(0.8); break;
            case '满100减20': $object = new FullPresendCash(100, 20); break;
            case '满200减50': $object = new FullPresendCash(200, 50); break;
            case '满300减80': $object = new FullPresendCash(300, 80); break;
            case '正常': $object = new NomalCash(); break;
        }
        return $object;
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
        $nomalCash = FactoryCash::createCash('正常');
        $total += $nomalCash->getResult(2, 50);
        $discountCash80 = FactoryCash::createCash('打折8折');
        $total += $discountCash80->getResult(3, 50);
        $discountCash70 = FactoryCash::createCash('打折7折');
        $total += $discountCash70->getResult(5, 50);
        $fullPresendCashA = FactoryCash::createCash('满200减50');
        $total += $fullPresendCashA->getResult(4, 50);
    
        echo '总花费：' . $total;
        
    }


}

Client::run();

?>
