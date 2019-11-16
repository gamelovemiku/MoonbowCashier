<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; // ชื่อตาราง
    protected $primaryKey = "product_barcode";

    protected $fillable = ['product_barcode', 'product_name', 'product_price', 'product_sold'];
}
