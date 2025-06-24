<?php

namespace App\Http\Controllers;

use Faker\Core\Number;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
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
use App\Models\DiaChi;
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
            return back()->with('alert', 'Chưa chọn size');
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
        function hiengiohang(Request $request){
            $userId = auth::id();
            $cart = GioHang::with(['sanpham', 'size'])
            ->where('user_id', $userId)
            ->get();
            
            //HIện sản phẩm trong giỏ hàng bằng session
            session(['cart'=> $cart]);
            
            return view('user.hiengiohang');
        }
    public function update_quantity(Request $request, $id): JsonResponse { // Thay đổi kiểu trả về
    $cart = GioHang::findOrFail($id);
    $new_qty = $request->input('quantity');

    // Validate new_qty (ví dụ: phải là số nguyên dương)
    if (!is_numeric($new_qty) || $new_qty < 1) {
        return response()->json(['success' => false, 'message' => 'Số lượng không hợp lệ.'], 400); // 400 Bad Request
    }

    $sizeInfo = Size::where('id', $cart->id_size)->first();

    if (!$sizeInfo) {
        return response()->json(['success' => false, 'message' => 'Thông tin size không tìm thấy.'], 404); // 404 Not Found
    }

    // Kiểm tra số lượng mới có lớn hơn số lượng tồn hay không
    if ($new_qty > $sizeInfo->so_luong) {
        return response()->json([
            'success' => false,
            'message' => 'Vượt quá số lượng hàng có sẵn. Chỉ còn ' . $sizeInfo->so_luong . ' sản phẩm.'
        ], 422); // 422 Unprocessable Entity
    } else {
        $cart->so_luong = $new_qty;
        $cart->save();
        // Trả về thông báo thành công và có thể là dữ liệu giỏ hàng đã cập nhật nếu cần
        return response()->json([
            'success' => true,
            'message' => 'Cập nhật số lượng thành công.',
            'new_quantity' => $cart->so_luong // Trả về số lượng mới để JS có thể xác nhận
        ]);
    }
}
    function xoasptronggio($id){
        Auth::check();
        $userId = Auth::id();
        $cart = GioHang::where('user_id', $userId)
                        ->where('id', $id)
                        ->first();
        //Kiểm tra nếu có tồn tại $cart thì xóa
        if($cart){
            $cart->delete();
            return redirect()->route('cart.gio_hang');
        }else{//Nếu không thì trả về thông báo (trường hợp xóa bằng link)
            return redirect()->route('cart.gio_hang')->with('alert', 'Sản phẩm không tồn tại');
        }
    }       
    function xoatatca(){
        auth::check();
        $userId = auth::id();
        $deletedRows = GioHang::where('user_id', $userId)->delete();//Method delete() sẽ trả về số dòng đã được xóa vào biến

        if($deletedRows > 0){
            return redirect()->route('cart.gio_hang');
        }else{
            return redirect()->route('cart.gio_hang')->with('alert', 'Giỏ hàng của bạn trống');
        }
    }
    
    function checkout_page(Request $request){
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn chưa đăng nhập');
        }
        $userId = Auth::id();
        // $selectedItemString = $request->input('selected_products', '');

        if($request->isMethod('post')){
            $selectedItems = $request->input('selected_products', []);
            session(['selected_products' => $selectedItems]);
        }else{
            $selectedItems = session('selected_products', []);
        }

        //Kiểm tra đã có sản phẩm nào được chọn chưa
        if(empty($selectedItems)){
            return redirect()->back()->with('alert', 'Vui lòng chọn sản phẩm để thanh toán');
        }
        //Lấy các sản phẩm trùng với id người dùng và những sản phẩm là id của những checkbox đã chọn
        $cart = GioHang::with(['sanpham', 'size'])
                        ->where('user_id', $userId)
                        ->whereIn('id', $selectedItems)//whereIn nếu biến đó có giá trị là một mảng
                        ->get();
        //Truy vấn để lấy dữ liệu địa chỉ của người dùng
        $addressUser = DiaChi::where('id_user', $userId)->get();
        //Địa chỉ mặc định
        $defaultAddress = DiaChi::where('id_user', $userId)
                                ->where('is_default_address', 1)
                                ->first();
        //Nếu không có địa chỉ nào là địa chỉ mặc định thì chọn địa chỉ đầu tiên là mặc định
        if(!$defaultAddress && $addressUser->isNotEmpty()){
            $defaultAddress = $addressUser->first();
        }
        //Tính tổng tiền
        $totalAmount = $cart->sum(function($item){
            if($item->sanpham->gia_km > 0){
                return $item->sanpham->gia_km * $item->so_luong;
            }else{
                return $item->sanpham->gia * $item->so_luong;
            }
        });

        return view('user.checkout_page', compact('cart', 'totalAmount', 'addressUser', 'defaultAddress'));
    }
    function change_address(Request $request)   {
        $userId = Auth::id(); 
        $selectedId = $request->address_id;

        // Đặt tất cả địa chỉ của user về mặc định = 0
        DiaChi::where('user_id', $userId)->update(['is_default_address' => 0]);

        // Đặt địa chỉ được chọn thành mặc định
        DiaChi::where('user_id', $userId)->where('id', $selectedId)->update(['is_default_address' => 1]);

        return response()->json(['success' => true]);
    }
}