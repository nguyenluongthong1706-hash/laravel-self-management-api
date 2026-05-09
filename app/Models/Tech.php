<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;
use App\Models\Product;
#[Table('techs')]
#[Fillable(['name', 'icon'])]
class Tech extends Model
{
    use HasUuids;

    public function users():BelongsToMany{
        return $this->belongsToMany(User::class,'user_techs','tech_id','user_id')->using(UserTech::class);
    }

    public function products():BelongsToMany{
        return $this->belongsToMany(Product::class,'product_techs','tech_id','product_id')->using(ProductTech::class);
    }
}
