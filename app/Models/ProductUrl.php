<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;

#[Fillable(['title', 'link','product_id'])]
class ProductUrl extends Model
{
    use HasUuids;

    public function product():BelongsTo{
        return $this->belongsTo(Product::class, 'product_id','id');
    }
}
