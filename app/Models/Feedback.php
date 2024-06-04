<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table ="feedback";
    protected $primaryKey = 'Mafeedback '; 
    protected $fillable = ['MaKH','MaChiTietDH','NoiDung','ThoiGianfeedback','DanhGia'];
    public $timestamps = false; 

    public function Customer()
    {
        return $this->belongsTo(Customer::class, 'MaKH');
    }
    public function OrderDetails()
    {
        return $this->belongsTo(OrderDetails::class, 'MaChiTietDH');
    }
}
