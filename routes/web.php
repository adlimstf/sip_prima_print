<?php

use App\Http\Controllers\admin\BennerHomeController;
use App\Http\Controllers\admin\HomeController as AdminHomeController;
use App\Http\Controllers\user\PrintController;
use App\Http\Controllers\admin\PaymentMetodeController;
use App\Http\Controllers\admin\DesainController;
use App\Http\Controllers\admin\PembayaranController;
use App\Http\Controllers\admin\PengirimanController;
use App\Http\Controllers\admin\PesananController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\SubKatagoriController;
use App\Http\Controllers\admin\UserController as AdminUserController;
use App\Http\Controllers\AlamatController;
use App\Http\Controllers\guest\FaqController;
use App\Http\Controllers\guest\HomeController as GuestHomeController;
use App\Http\Controllers\guest\katagoriController as GuestkatagoriController;
use App\Http\Controllers\guest\ProdukController as GuestProdukController;
use App\Http\Controllers\user\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\user\CartController;
use App\Http\Controllers\user\CheckOutController;
use App\Http\Controllers\user\PaymentController;
use App\Http\Controllers\user\ProduckFavController;
use App\Http\Controllers\user\TransaksiController;
use App\Http\Controllers\user\DesainCotroller as UserDesainCotroller;
use App\Http\Controllers\user\ReturnController;
use App\Http\Controllers\admin\ReturnController as AdminReturnController;
use App\Http\Controllers\user\CostumeTransaktionController;
use App\Http\Controllers\admin\CostumeTransaktionController as adminCostumeTransaktionController;
use App\Http\Controllers\user\ProfileController as userProfileController;
use App\Http\Controllers\admin\exportController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\helper\getOngkirController;


require __DIR__ . '/auth.php';

//route tanpa middleware
Route::get('/', [GuestHomeController::class, 'index'])->name('guest.dashboard');
Route::get('/product', [GuestProdukController::class, 'index'])->name('guest.product');
Route::get('/katagori', [GuestkatagoriController::class, 'index'])->name('guest.katagori');
Route::get('/product/{id}/show', [GuestProdukController::class, 'show'])->name('guest.product.show');

// about
Route::get('/about', [GuestHomeController::class, 'about'])->name('guest.about');

//faq
Route::get('/faq', [FaqController::class, 'index'])->name('guest.faq');



Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/print', function () {
        return view('user.print_doc');
    });

    Route::prefix('/super')->middleware('superadmin')->group(function () {
        Route::get('/', [AdminHomeController::class, 'index'])->name('super.dashboard');
    });

    // Route::get('/cek', function () {
    //     $transaksi = \App\Models\Transaksi::where('transaksi_code', 'TR-004')->first();
    //     $user = Auth::user();

    //     return view('mail.mail_notif', compact('transaksi', 'user'));
    // });

    Route::prefix('/admin')->middleware('admin')->group(function () {
        Route::get('/', [AdminHomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/print-chart', [AdminHomeController::class, 'printChart'])->name('admin.print.chart');

        //product
        Route::get('/product', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('/product/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/product', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('/product/{id}/show', [ProductController::class, 'show'])->name('admin.product.show');
        Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::put('/product/{id}', [ProductController::class, 'update'])->name('admin.product.update');
        Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
        Route::get('/product/img/{id}/delete', [ProductController::class, 'deleteImage'])->name('admin.product.delete-image');
        Route::post('/product/import', [ProductController::class, 'import'])->name('admin.product.import');

        Route::get('sub-kategori', [SubKatagoriController::class, 'index'])->name('admin.sub-kategori.index');
        Route::post('sub-kategori', [SubKatagoriController::class, 'store'])->name('admin.sub-kategori.store');
        Route::put('sub-kategori/{id}', [SubKatagoriController::class, 'update'])->name('admin.sub-kategori.update');
        Route::delete('sub-kategori/{id}', [SubKatagoriController::class, 'destroy'])->name('admin.sub-kategori.destroy');

        //pesanan
        Route::get('/pesanan', [PesananController::class, 'index'])->name('admin.pesanan.index');
        Route::put('/pesanan/{id}/update', [PesananController::class, 'update'])->name('admin.pesanan.update');

        // pesanan costume
        Route::get('/costume-pesanan', [adminCostumeTransaktionController::class, 'index'])->name('admin.costume.index');
        Route::put('/costume-pesanan/{id}/update', [adminCostumeTransaktionController::class, 'update'])->name('admin.costume.update');

        //return
        Route::post('/return/{id}/update', [AdminReturnController::class, 'update'])->name('admin.return.update');

        //pembayaran
        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('admin.pembayaran.index');
        Route::get('/pembayaran/{id}/Confirm', [PembayaranController::class, 'show'])->name('admin.pembayaran.show');
        Route::post('/pembayaran/{id}/Confirm', [PembayaranController::class, 'paymentConfirm'])->name('admin.pembayaran.confirm');

        //desain
        Route::get('/desain', [DesainController::class, 'index'])->name('admin.desain.index');
        Route::get('/desain/{id}', [DesainController::class, 'show'])->name('admin.desain.show');
        Route::post('/desain/{id}', [DesainController::class, 'add'])->name('admin.desain.add');

        //pengiriman
        Route::get('/pengiriman', [PengirimanController::class, 'index'])->name('admin.pengiriman.index');
        Route::get('/pengiriman/{id}', [PengirimanController::class, 'show'])->name('admin.pengiriman.show');
        Route::put('/pengiriman/{id}', [PengirimanController::class, 'edit'])->name('admin.pengiriman.edit');

        //return
        Route::get('return', [AdminReturnController::class, 'index'])->name('admin.return.index');

        //user
        Route::get('/user', [AdminUserController::class, 'index'])->name('admin.user.index');
        Route::post('/user', [AdminUserController::class, 'store'])->name('admin.user.store');
        Route::put('/user/{id}', [AdminUserController::class, 'update'])->name('admin.user.update');
        Route::put('/user/{id}/update-pass', [AdminUserController::class, 'updatePass'])->name('admin.user.update-pass');
        Route::delete('/user/{id}', [AdminUserController::class, 'destroy'])->name('admin.user.destroy');

        //payment metode
        Route::get('/payment-metode', [PaymentMetodeController::class, 'index'])->name('admin.payment-metode.index');
        Route::post('/payment-metode', [PaymentMetodeController::class, 'store'])->name('admin.payment-metode.store');
        Route::put('/payment-metode/{id}', [PaymentMetodeController::class, 'update'])->name('admin.payment-metode.update');
        Route::put('/payment-metode/{id}/update-qr-code', [PaymentMetodeController::class, 'updateQrCode'])->name('admin.payment-metode.update-qr-code');
        Route::delete('/payment-metode/{id}', [PaymentMetodeController::class, 'destroy'])->name('admin.payment-metode.destroy');

        //export
        Route::get('/export', [exportController::class, 'index'])->name('admin.export.index');
        Route::post('/export', [exportController::class, 'export'])->name('admin.export.export');

        //benner home
        Route::get('/benner', [BennerHomeController::class, 'index'])->name('admin.benner.index');
        Route::put('/benner/{id}', [BennerHomeController::class, 'update'])->name('admin.benner.update');
        Route::delete('/benner/{id}', [BennerHomeController::class, 'destroy'])->name('admin.benner.destroy');
    });

    Route::prefix('/user')->middleware('user')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('user.dashboard');

        //address user
        Route::get('/alamat', [AlamatController::class, 'index'])->name('user.alamat.index');
        Route::get('/alamat/create', [AlamatController::class, 'create'])->name('user.alamat.create');
        Route::post('/alamat', [AlamatController::class, 'store'])->name('user.alamat.store');
        Route::get('/alamat/{id}/edit', [AlamatController::class, 'edit'])->name('user.alamat.edit');
        Route::put('/alamat/{id}', [AlamatController::class, 'update'])->name('user.alamat.update');
        Route::delete('/alamat/{id}/delete', [AlamatController::class, 'destroy'])->name('user.alamat.destroy');
        Route::get('/alamat/{id}/default', [AlamatController::class, 'setDefault'])->name('user.alamat.default');

        //love product
        Route::get('/love', [ProduckFavController::class, 'index'])->name('user.love.index');
        Route::get('/love/add', [ProduckFavController::class, 'addLove'])->name('user.love.add');
        Route::get('/love/remove', [ProduckFavController::class, 'removeLove'])->name('user.love.remove');

        //cart product
        Route::get('/cart', [CartController::class, 'index'])->name('user.cart.index');
        Route::get('/cart/{id}/delete', [CartController::class, 'destroy'])->name('user.cart.delete');
        Route::post('/cart', [CartController::class, 'store'])->name('user.cart.store');
        Route::post('/cart/update', [CartController::class, 'update'])->name('user.cart.update');

        //checkout
        Route::get('/checkout/{transaksi_code}', [CheckOutController::class, 'index'])->name('user.checkout.index');
        Route::post('/checkout/{transaksi_code}/checkout', [CheckOutController::class, 'checkout'])->name('user.checkout.make');
        Route::post('/checkout', [CheckOutController::class, 'store'])->name('user.checkout.store');
        Route::get('/checkout/{id}/product_detail', [CheckOutController::class, 'product_detail'])->name('user.checkout.product_detail');
        Route::post('/checkout/{id}/update_produck_transaksi', [CheckOutController::class, 'update_produck_transaksi'])->name('user.checkout.update_produck_transaksi');
        Route::post('/checkout/update-quantity', [CheckOutController::class, 'updateQuantity'])->name('user.checkout.update-quantity');


        //transaction payment
        Route::get('/payment/{transaksi_code}', [PaymentController::class, 'index'])->name('user.payment.index');
        Route::post('/payment/{transaksi_code}', [PaymentController::class, 'store'])->name('user.payment.store');

        //transaktion Desain
        Route::get('/desain/{transaksi_code}', [UserDesainCotroller::class, 'index'])->name('user.desain.index');
        Route::post('/desain/{id}/confirm', [UserDesainCotroller::class, 'confirm'])->name('user.desain.confirm');

        //history transaction
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('user.transaksi.index');
        Route::get('/transaksi/{id}/show', [TransaksiController::class, 'show'])->name('user.transaksi.show');
        Route::get('/transaksi/{id}/done', [TransaksiController::class, 'done'])->name('user.transaksi.done');

        //return
        Route::get('/return/{id}/create', [ReturnController::class, 'create'])->name('user.return.create');
        Route::post('/return/{id}/store', [ReturnController::class, 'store'])->name('user.return.store');

        //pesanan constume
        Route::get('/costume-pesanan', [CostumeTransaktionController::class, 'index'])->name('user.costume.index');
        Route::post('/costume-pesanan', [CostumeTransaktionController::class, 'store'])->name('user.costume.store');
        Route::get('/costume-pesanan/{id}/show', [CostumeTransaktionController::class, 'show'])->name('user.costume.show');

        //profile
        Route::get('/profile', [userProfileController::class, 'index'])->name('user.profile.index');
        Route::put('/profile', [userProfileController::class, 'update'])->name('user.profile.update');

        //print
        Route::get('/print/{transaksi_code}/inv', [PrintController::class, 'print_invoice'])->name('user.print.inv');
        Route::get('/print/{transaksi_code}/pesan', [PrintController::class, 'print_pesan'])->name('user.print.pesan');
        Route::get('/print/{transaksi_code}/ba', [PrintController::class, 'print_ba'])->name('user.print.ba');
    });
});

Route::prefix('/helper')->group(function () {
    Route::get('/ongkir', [getOngkirController::class, 'index'])->name('helper.ongkir');
});
