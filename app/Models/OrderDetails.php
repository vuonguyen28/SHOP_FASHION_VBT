<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $table = "chitietdonhang";
    protected $primaryKey = 'MaChiTiet';
    protected $fillable = ['MaDonHang', 'MaChiTietSanPham', 'SoLuong', 'Gia'];
    public $timestamps = false;

    public function productDetails()
    {
        return $this->belongsTo(ProductDetails::class, 'MaChiTietSanPham');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'MaChiTietDH');
    }

    /**
     * Tính tổng số lượng đơn hàng
     */
    public static function getTotalOrdersCount()
    {
        return Order::count();
    }

    /**
     * Tính tổng số lượng sản phẩm
     */
    public static function getTotalQuantity()
    {
        return OrderDetails::sum('SoLuong');
    }

    /**
     * Tính tổng doanh thu
     */
    public static function getTotalRevenue()
    {
        return Order::sum('TongGia');
    }

    public function images()
    {
        return $this->hasManyThrough(
            Image::class,
            Product::class,
            'MaSP', // Foreign key on ProductDetails table
            'MaSP', // Foreign key on Images table
            'MaChiTietSanPham', // Local key on OrderDetails table
            'MaSP' // Local key on ProductDetails table
        );
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'MaDonHang', 'MaDonHang');
    }
}
