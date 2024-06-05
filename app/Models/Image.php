<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table ='HinhAnh';
    protected $primaryKey='MaHinhAnh';
    protected $fillable =['MaSP', 'hinhanh'];
    public $timestamps=false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'MaSP','MaSP');
    }

    
    
}
