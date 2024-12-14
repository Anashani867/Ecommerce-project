<?php

class Coupon extends Model
{
    public function __construct()
    {
        parent::__construct('coupons');
    }

    public function getCouponByCode($code)
    {
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE code = :code");
        $statement->execute(['code' => $code]);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function decrementUsageLimit($coupon_id)
    {
        $statement = $this->pdo->prepare("UPDATE $this->table SET usage_limit = usage_limit - 1 WHERE id = :id");
        $statement->execute(['id' => $coupon_id]);
    }

    public function incrementUsageLimit($coupon_id)
    {
        $statement = $this->pdo->prepare("UPDATE $this->table SET usage_limit = usage_limit + 1 WHERE id = :id");
        $statement->execute(['id' => $coupon_id]);
    }

    public function CouponCount()
    {
        $statement = $this->pdo->prepare('SELECT COUNT(*) AS count FROM coupons');
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ)->count;

    }
}

