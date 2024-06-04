<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompositePrimaryKey;

class VoucherToCustomer extends Model
{
    use HasFactory;

    protected $table = "voucher_khachhang";
    protected $keyType = 'string';
    protected $fillable = ['MaKH', 'MA_VOUCHER', 'note'];
    public $timestamps = false;

    public function Voucher()
    {
        return $this->belongsTo(Voucher::class, 'MA_VOUCHER');
    }
}
