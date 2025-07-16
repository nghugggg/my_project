<?php

namespace App\Http\Controllers;

use Faker\Core\Number;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Arr;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Log;
use App\Models\Loai;
use App\Models\SanPham;
use App\Models\Size;
use App\Models\GioHang;
use App\Http\Controllers\ModelNotFoundException;
Paginator::useBootstrap();
use Illuminate\Support\Str;

use function Laravel\Prompts\table;

class SiteController extends Controller
{
    function index(){
        //Lấy danh sách loại sản phẩm
        $ds_loai = Loai::all();
        //Lấy dssp để dùng cho các kiểu danh sách sản phẩm khác nhau như: mua nhiều, mới, khuyến mãi
        $dssp = DB::table('san_pham')
        ->select('san_pham.id', 'ten_sp', 'gia', 'gia_km', 'hinh', 'luot_mua')
        ->join('danh_muc', 'danh_muc.id', '=', 'san_pham.id_dm');
        //sản phẩm mới
            $sp_moi = (clone $dssp)
            ->where('san_pham.an_hien', '=', 0)//0 là hiện, 1 là ẩn
            ->orderBy('san_pham.id', 'desc')
            ->limit(4)
            ->get();
            
        //sản phẩm khuyến mãi
        $sp_km = (clone $dssp)
        ->where('san_pham.gia_km','>',0)
        ->where('san_pham.an_hien', '=', 0)
        ->whereNotIn('san_pham.trang_thai', [1, 2])
        ->inRandomOrder()
        ->limit(4)
        ->get(); 
        //sản phẩm bán chạy
        // $sp_banchay = DB::table('san_pham')->select('san_pham.id', 'ten_sp', 'gia', 'gia_km', 'hinh','san_pham.trang_thai', 'danh_muc.ten_dm', 'mo_ta_ngan' ,'luot_mua')
        // ->join('danh_muc', 'san_pham.id_dm', '=', 'danh_muc.id')
        // ->where('san_pham.trang_thai', '!=', 2)
        // ->where('san_pham.luot_mua', '!=', 0)
        // ->where('san_pham.an_hien', '=', 0)
        // ->orderBy('luot_mua', 'desc')
        // ->limit(4)
        // ->get();
        // Sản phẩm theo loại
        $query_theoloai = DB::table('san_pham')
        ->select('san_pham.id', 'ten_sp', 'gia', 'gia_km', 'hinh','san_pham.trang_thai', 'danh_muc.ten_dm', 'mo_ta_ngan' ,'luot_mua')
        ->join('danh_muc', 'san_pham.id_dm', '=', 'danh_muc.id')
        ->join('loai', 'danh_muc.id_loai', '=', 'loai.id')
        ->whereNotIn('san_pham.trang_thai', [2])
        ->where('san_pham.an_hien', '!=', 1)
        ->inRandomOrder() // Random sản phẩm
        ->limit(4); // Lấy ra 4 sản phẩm

        $sanpham = [];
        foreach ($ds_loai as $loai) {
            $sanpham[$loai->slug] = (clone $query_theoloai)->where('loai.slug', $loai->slug)->get();
        }

        return view('user.home', compact('sp_moi', 'sp_km', 'sanpham'));
    }
    function chitietsp($id){
        try{
            $sp = SanPham::findOrFail($id);
            $splienquan_arr = SanPham::where('id_dm', $sp->id_dm)
            ->where('id', '!=', $id)
            ->orderBy('ngay', 'desc')
            ->limit(4)
            ->inRandomOrder()
            ->get();

            $size = Size::where('id_product', $id)
            ->select('size_product', 'so_luong')
            ->get();

            return view('user.detail', compact(['sp', 'splienquan_arr', 'size']));
        }
        catch(ModelNotFoundException $e){
            return redirect('/thongbao')->with("thongbao", "Không tìm thấy sản phẩm");
        }
    }
    function sptheodm($idDanhMuc){
        if(is_numeric($idDanhMuc)==false)
        return redirect("/thongbao")
        ->with("thongbao", "Khong co san pham trong danh muc: ".$idDanhMuc);
        $tendanhmuc = DB::table('danhmuc')->where('id', $idDanhMuc)->value('ten');
        $dssp = DB::table('sanpham')->where('idDanhMuc', $idDanhMuc)->get();
        return view('spdanhmuc', ['idDanhMuc'=> $idDanhMuc, 'tendanhmuc'=>$tendanhmuc, 'dssp'=> $dssp]);
    }
    function logout(){

        Auth::guard('web')->logout();

        return redirect('/')->with('alert','Bạn đã thoát tài khoản');
    }
}
