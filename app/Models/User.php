<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// use Laravel\Sanctum\HasApiTokens; 
use App\Models\Location;
use App\Models\Product;
use App\Models\Education;
use App\Models\WorkExperience;
use App\Models\Tool;
use App\Models\Tech;

#[Fillable(['name', 'email', 'password','field','slogan','about_me','facebook_link','linkedin_link','github_link'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<UserFactory> */
    use HasUuids, Notifiable;

    public function location(): HasOne{
        return $this->hasOne(Location::class, 'user_id', 'id');
    }

    public function products(): HasMany{
        return $this->hasMany(Product::class, 'user_id', 'id');
    }

    public function educations(): HasMany{
        return $this->hasMany(Education::class, 'user_id', 'id');
    }

    public function workExperiences(): HasMany{
        return $this->hasMany(WorkExperience::class, 'user_id', 'id');
    }

    public function tools(): BelongsToMany{
        return $this->belongsToMany(Tool::class,'user_tools', 'user_id', 'tool_id')->using(UserTool::class);
    }

    public function techs(): BelongsToMany{
        return $this->belongsToMany(Tech::class,'user_techs', 'user_id', 'tech_id')->using(UserTech::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // public function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }
}
