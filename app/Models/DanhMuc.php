<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    use HasFactory;

    protected $table = 'danh_muc';
    protected $primaryKey = 'id';
    protected $fillable = ['ten_dm', 'slug', 'trang_thai'];

    public function loai()
    {
        return $this->belongsTo(Loai::class, 'id_loai');
    }
}