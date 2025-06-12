<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DanhMuc;
use Illuminate\Database\Eloquent\Model;

class Loai extends Model
{
    use HasFactory;

    protected $table = 'loai';
    protected $primaryKey = 'id';
    protected $fillable = ['ten_loai', 'slug'];

    public function danhmucs() {
        return $this->hasMany(DanhMuc::class, 'id_loai');
    }
}