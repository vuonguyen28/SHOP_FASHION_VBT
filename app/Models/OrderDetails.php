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
}
