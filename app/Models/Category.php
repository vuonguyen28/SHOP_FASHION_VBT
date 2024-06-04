<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table ="DanhMuc";
    protected $primaryKey = 'MaDanhMuc'; 
    protected $fillable = ['TenDanhMuc'];
    public $timestamps = false; 

    public function sanphams()
    {
        return $this->hasMany(Product::class, 'MaDanhMuc');
    }
}
