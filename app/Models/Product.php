<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'SanPham';
    protected $primaryKey = 'MaSP';
    protected $fillable = ['TenSP', 'Gia', 'PhanTramGiamGia', 'MoTa', 'MaDanhMuc', 'MaNhaCungCap', 'TrinhTrang'];
    public $timestamps = false;

    public function Category()
    {
        return $this->belongsTo(Category::class, 'MaDanhMuc');
    }
    public function Supplier()
    {
        return $this->belongsTo(Supplier::class, 'MaNhaCungCap');
    }
    public function images()
    {
        return $this->hasMany(Image::class, 'MaSP', 'MaSP');
    }

    public function ProductDetails()
    {
        return $this->hasMany(ProductDetails::class, 'MaSP', 'MaSP');
    }

    public function firstImage()
    {
        return $this->hasOne(Image::class, 'MaSP')->orderBy('MaHinhAnh');
    }
}
