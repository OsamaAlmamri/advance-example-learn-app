<?php

namespace App;

class Cart {

    protected $items = [];

    public function insert($item){

        $this->items[] = $item;

    }

    public function count(){
        return count($this->items);
    }

    public function getItems(){
        return $this->items;
    }

    public function total(){
        $amount = 0;

        foreach($this->items as $item){
            $amount += $item['price'] * $item['qty'];
        }

        return $amount;
    }

}
