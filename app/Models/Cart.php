<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = "GioHang";
    protected $primaryKey='MaGioHang';
    protected $fillable =['MaKhachHang', 'MaChiTietSanPham', 'SoLuong'];
    public $timestamps=false;

    public function Customer()
    {
        return $this->belongsTo(Customer::class, 'MaKhachHang');
    }
    public function ProductDetails()
    {
        return $this->belongsTo(ProductDetails::class, 'MaChiTietSanPham');
    }
}
