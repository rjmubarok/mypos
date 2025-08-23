<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'brand_id',
        'supplier_id',
        'name',
        'slug',
        'sku',
        'barcode',
        'description',
        'image',
        'purchase_price',
        'selling_price',
        'stock',
        'alert_quantity',
        'status',
    ];

    // 🔗 Category Relation
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // 🔗 Brand Relation
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    // 🔗 Supplier Relation
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
