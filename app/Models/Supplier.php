<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table='NhaCungCap';
    protected $primaryKey ="MaNhaCungCap";
    protected $fillable = ['TenNhaCungCap','DiaChi','SoDienThoai'];
    public $timestamps =false;  

    public function sanphams()
    {
        return $this->hasMany(Product::class, 'MaNhaCungCap');
    }
}
