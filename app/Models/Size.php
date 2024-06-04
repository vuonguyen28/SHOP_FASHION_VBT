<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $table='KichThuoc';
    protected $primaryKey ="MaKichThuoc";
    protected $fillable = ['TenKichThuoc'];
    public $timestamps =false;  
}
