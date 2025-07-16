<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\DonHang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationData;

class AccountController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    function profile_page(){
        $userId = Auth::id();
        $profile = User::where('id', $userId)->first();
        return view('user.profile', compact('profile'));
    }
    function purchase_page(){
        $userId = Auth::id();
        //Truy vấn đến đơn hàng đã mua của người dùng
        $order = DonHang::with(['ChiTietDonHangs.sanPham', 'ChiTietDonHangs.size'])
                        ->join('dia_chi', 'dia_chi.id', '=', 'don_hang.id_dc')
                        ->where('don_hang.id_user', $userId)
                        ->select('don_hang.*', 'dia_chi.id as dia_chi_id', 'dia_chi.dc_chi_tiet', 'dia_chi.phone', 'dia_chi.ho_ten');
        //Tách đơn hàng theo từng trạng thái từ $order
        $pending_order = clone $order->where('trang_thai', 0)->orderBy('don_hang.id', 'desc')->get();
        $shipping_order = clone $order->where('trang_thai', 1)->orderBy('don_hang.id', 'desc')->get(); 
        $delivering_order = clone $order->where('trang_thai', 2)->orderBy('don_hang.id', 'desc')->get();
        $completed_order = clone $order->where('trang_thai', 3)->orderBy('don_hang.id', 'desc')->get();
        $canceled_order = clone $order->where('trang_thai', 4)->orderBy('don_hang.id', 'desc')->get();

        // $purchase = ChiTietDonHang::join('don_hang', 'don_hang.id', '=', 'chi_tiet_don_hang.id_dh')
        //                         ->join('san_pham', 'san_pham.id', '=', 'chi_tiet_don_hang.id_sp')
        //                         ->join('sizes', 'sizes.id', '=', 'chi_tiet_don_hang.id_size')
        //                         ->join('dia_chi', 'dia_chi.id', '=', 'don_hang.id_dc')
        //                         ->select('don_hang.*', 'chi_tiet_don_hang.*', 'chi_tiet_don_hang.id as id_ctdh', 'san_pham.id as id_sp', 'san_pham.ten_sp', 'san_pham.hinh', 'san_pham.color', 'sizes.size_product', 'dia_chi.*')
        //                         ->where('don_hang.id_user', $userId)
        //                         ->get();
        return view('user.purchase', compact('pending_order', 'shipping_order', 'delivering_order', 'completed_order', 'canceled_order'));
    }
    function password_page(){
        return view('user.account-password');
    }
    function change_password(Request $request){
        // $userId = Auth::id();
        $user = User::find(Auth::id());
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8',
        ]);

        if(!Hash::check($request->current_password, $user->password)){
            return back()->with('alert', 'Mật khẩu hiện tại chưa đúng');
        }else{
            $user->password = Hash::make($request->new_password);
            $user->save();
        }
        return back()->with('alert', 'Đổi mật khẩu thành công'); 
    }
}
