<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "DonHang";
    protected $primaryKey = 'MaDonHang';
    protected $fillable = [
        'MaKhachHang', 
        'NgayDat', 
        'NgayDuKienGiaoHang', 
        'TongGia', 
        'TongTienSauKhiGiamGia', 
        'PhiVanChuyen', 
        'TrangThaiThanhToan', 
        'HinhThucThanhToan', 
        'TrangThaiDonHang', 
        'DiaChiGiaoHang', 
        'MaVoucher',
        'RecipientPhone'
    ];    
    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'MaKhachHang');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'MaDonHang');
    }
}
