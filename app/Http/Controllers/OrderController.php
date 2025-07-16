<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Services\OrderService;
class OrderController extends Controller
{
    public function order(Request $request, OrderService $orderService)
    {
        $request->validate([
            'selected-products' => 'required|array|min:1',
            'address_id' => 'required|integer',
            'payment-method' => 'required|string',
            'total-payment' => 'required|numeric',
        ]);

        $userId = Auth::id();
        $selectedProducts = $request->input('selected-products');
        $selectedAddress = $request->input('address_id');
        $paymentMethod = $request->input('payment-method');
        $totalOrder = $request->input('total-payment');

        //Kiểm tra khi các session không có giá trị
        if(!$selectedAddress){
            return Redirect::back()->with('alert', 'Vui lòng kiểm tra lại địa chỉ');
        }elseif(!$paymentMethod){
            return Redirect::back()->with('alert', 'Vui lòng kiểm tra lại phương thức thanh toán');
        }elseif(!$totalOrder){
            return Redirect::back()->with('alert', 'Đã có lỗi xảy ra trong quá trình xử lý');
        }elseif(empty($selectedProducts)){
            return Redirect::back()->with('alert', 'Vui lòng kiểm tra lại sản phẩm đã chọn');
        }

        if ($paymentMethod === 'VNPAY') {
            return back()->with('alert', 'Thanh toán VNPAY hiện đang bảo trì');
        }

        try {
            $orderService->createOrder($userId, $selectedProducts, $selectedAddress, $paymentMethod, $totalOrder);
            return redirect('/')->with('alert', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            Log::error("Lỗi controller OrderController: " . $e->getMessage());
            return back()->with('alert', 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.');
        }
    }
}
