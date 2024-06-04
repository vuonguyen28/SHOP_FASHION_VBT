<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    use HasFactory;
    protected $table = 'khachhang';
    protected $primaryKey = 'MaKH'; 
    protected $fillable = ['TenKH', 'SoDienThoai', 'Email', 'DiaChi', 'Password_hs5','GioiTinh','TrangThai','avatar','Role'];
    public $timestamps = false; 
    
}
