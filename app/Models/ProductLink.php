<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;

#[Table('product_urls')]
#[Fillable(['title', 'url','product_id'])]
class ProductLink extends Model
{
    use HasUuids;

    public function product():BelongsTo{
        return $this->belongsTo(Product::class, 'product_id','id');
    }
}
