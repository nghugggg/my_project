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
use App\Models\GioHang;
use App\Models\Size;
use App\Http\Controllers\ModelNotFoundException;
Paginator::useBootstrap();
use Illuminate\Support\Str;

use function Laravel\Prompts\table;

class BuyController extends Controller
{
    //     function themvaogio(Request $request, $id_sp = 0, $soluong=1){
    //     if ($request->session()->exists('cart')==false) {//chưa có cart trong session           
    //         $request->session()->put('cart', ['id_sp'=> $id_sp,  'soluong'=> $soluong]);          
    //     } else {// đã có cart, kiểm tra id_sp có trong cart không
    //         $cart =  $request->session()->get('cart'); 
    //         $index = array_search($id_sp, array_column($cart, 'id_sp'));
    //         if ($index!=''){ //id_sp có trong giỏ hàng thì tăhg số lượng
    //             $cart[$index]['soluong']+=$soluong;
    //             $request->session()->put('cart', $cart);
    //         }
    //         else { //sp chưa có trong array cart thì thêm vào 
    //             $cart[]= ['id_sp'=> $id_sp, 'soluong'=> $soluong];
    //             $request->session()->put('cart', $cart);
    //         }    
    //     }        
    //     //$request->session()->forget('cart');
    //     return redirect('hiengiohang');
    // }
    function themvaogio(Request $request, $id){
        //Lấy dữ liệu từ request
        $sanpham = SanPham::findOrFail($id);
        $soluong = $request->input('soluong', 1);
        $size = $request->input('size');
        $sizeInfo = Size::where('id_product', $id)
                    ->where('size_product', $size)
                    ->first();
        
        if(!$sizeInfo){
            return back()->with('elert', 'Chưa chọn size');
        }
        //Lấy id người dùng
        $userId = Auth::id();
        //Tìm cart của user
        $cart = GioHang::where('user_id', $userId)
        ->where('id_sp', $id)
        ->where('id_size', $sizeInfo->id)
        ->first();        
        //Xử lý số lượng cho sản phẩm
        if($cart){//nếu có tồn tại $cart thì + thêm
            $cart->so_luong += $soluong;
        }else{//tạo record mới
            $cart = new GioHang();
            $cart->user_id = $userId;
            $cart->id_sp = $sanpham->id;
            $cart->id_size = $sizeInfo->id;
            $cart->so_luong = $soluong;
        }
        //Lưu $cart
        $cart->save();
        
        return redirect()->route('cart.gio_hang');
    }
    // function hiengiohang(Request $request){
    //     $cart = [];
    //     if(!empty($request->session()->get('cart'))){
    //         $cart =  $request->session()->get('cart');
    //     }else{
    //         $cart = [];
    //     }

    //     $tongTien = 0;   
    //     $tongSl=0;

    //     for ( $i=0; $i<count($cart) ; $i++) {
    //       $sp = $cart[$i];
    //       $ten_sp = DB::table('sanpham')->where('id', $sp['id_sp'] )->value('ten_sp');
    //       $gia_km = DB::table('sanpham')->where('id', $sp['id_sp'] )->value('gia_km');
    //       $hinh = DB::table('sanpham')->where('id', $sp['id_sp'] )->value('hinh');        
    //       $thanhTien = (int)$gia_km*(int)$sp['soluong'];
    //       $tongSl+=(int)$sp['soluong'];
    //         $tongTien +=  $thanhTien;
          
    //       $sp['ten_sp'] = $ten_sp;
    //       $sp['gia'] = $gia_km;
    //       $sp['hinh'] = $hinh;
    //       $sp['thanhtien'] = $thanhTien;
    //         $cart[$i] = $sp;
    //     }
    //     $request->session()->put('cart', $cart);
    //     return view('user.hiengiohang', compact(['cart', 'tongSl','tongTien']));
    // }
        function hiengiohang(Request $request){
            $userId = auth::id();
            $cart = GioHang::with(['sanpham', 'size'])
            ->where('user_id', $userId)
            ->get();
            
            //HIện sản phẩm trong giỏ hàng bằng session
            session(['cart'=> $cart]);
            
            return view('user.hiengiohang');
        }
    function xoasptronggio(Request $request, $id = 0){
        $cart =  $request->session()->get('cart'); 
        $index = array_search($id, array_column($cart, 'id_sp'));
        if ($index!=''){ 
            array_splice($cart, $index, 1);
            $request->session()->put('cart', $cart);
        }
        return redirect('/hiengiohang');
    }          
    function xoatatca(){
        Session::forget('cart');
        return back();
    }
}