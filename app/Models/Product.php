<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function setCategory($category){
        if(! is_null($this->category_id)){
            throw new \Exception('You can not change the product category');
        }

        $this->category()->associate($category)->save();
    }
}
