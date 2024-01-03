<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status'
    ];
    public function scopeAllowed($query){
        return $query->where('status','!=','deleted');
    }
    public function components(){
        return $this->hasMany(MenuComponent::class);
    }

}
