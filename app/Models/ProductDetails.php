<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetails extends Model
{
    use HasFactory;

    protected $table = 'ChiTietSanPham';
    protected $primaryKey = 'MaChiTiet';
    protected $fillable = ['MaSP', 'MaKichThuoc', 'MaMau', 'SoLuongTon'];
    public $timestamps = false;

    public function Product()
    {
        return $this->belongsTo(Product::class, 'MaSP','MaSP');
    }

    public function Size()
    {
        return $this->belongsTo(Size::class, 'MaKichThuoc');
    }

    public function Color()
    {
        return $this->belongsTo(Color::class, 'MaMau');
    }

    public function OrderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'MaChiTietSanPham');
    }


}
