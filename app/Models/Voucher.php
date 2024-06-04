<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $table = "Voucher";
    protected $primaryKey = "MA_VOUCHER";
    protected $keyType = 'string'; // Explicitly specify the key type
    protected $fillable = ['MA_VOUCHER', 'Ten_VOUCHER', 'PhanTramGiam', 'DonToiThieu', 'GiamToiDa', 'SoLuongVOUCHER', 'Ngaybatdau', 'Ngayketthuc'];
    public $timestamps = false;


    // Định nghĩa mối quan hệ không qua bảng nối với Customer
    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'voucher_khachhang', 'MA_VOUCHER', 'MaKH');
    }

    // Scope để lấy danh sách các voucher mà khách hàng chưa lưu
    public function scopeNotSavedByCustomer($query, $customerId)
    {
        return $query->whereDoesntHave('customers', function ($query) use ($customerId) {
            $query->where('voucher_khachhang.MaKH', $customerId)
             ;
        });
    }
}
