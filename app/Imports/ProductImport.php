<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Product::create([
                'TenSP' => $row['tensp'], //'Cột trong db => $row['cột trong excel']'
                'Gia' => $row['gia'],
                'PhanTramGiamGia' => $row['phantramgiamgia'],
                'MoTa' => $row['mota'],
                'MaDanhMuc' => $row['madanhmuc'],
                'MaNhaCungCap' => $row['manhacungcap'],
                'TrinhTrang' => $row['tinhtrang'] 
            ]);
        }
    }
}
