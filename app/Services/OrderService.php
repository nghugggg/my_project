<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\GioHang;
use App\Models\Size;

class OrderService {
    public function createOrder($userId, $selectedProducts, $selectedAddress,$paymentMethod, $totalOrder ) {
        DB::beginTransaction();
        
        try{
            $order = DonHang::create([
                'id_user' => $userId,
                 'thoi_diem_mua_hang' => now(),
                 'id_dc' => $selectedAddress,
                 'tong_dh' => $totalOrder,
                 'pttt' => $paymentMethod,
                 'trang_thai' => ($paymentMethod === 'COD') ? 0 : 1,
            ]);

            foreach($selectedProducts as $prodId){
                //Tìm sản phẩm trong giỏ hàng bằng sản phẩm đã chọn
                $cart = GioHang::with(['sanpham', 'size'])->find($prodId);
                if(!$cart) continue;

                //Tạo chi tiết đơn hàng
                ChiTietDonHang::create([
                    'id_dh' => $order->id,
                    'id_sp' => $cart->id_sp,
                    'id_size' => $cart->id_size,
                    'so_luong' => $cart->so_luong,
                    'gia' => $cart->sanpham->gia_km > 0 ? $cart->sanpham->gia_km : $cart->sanpham->gia,
                ]);

                $size = Size::find($cart->id_size);
                if ($size) {
                    $size->so_luong -= $cart->so_luong;
                    $size->save();
                }

                $sanpham = $cart->sanpham;
                if ($sanpham) {
                    $sanpham->luot_mua += $cart->so_luong;
                    $sanpham->save();
                }

                $cart->delete();
            }

            DB::commit();
            return $order;

        }catch(\Exception $e){
            DB::rollBack();
            Log::error("Lỗi tạo đơn hàng:".$e->getMessage());
            throw $e;
        }
    }
}