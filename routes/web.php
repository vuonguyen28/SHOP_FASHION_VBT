<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CategoryController;
use App\http\Controllers\Admin\ColorController;
use App\http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductDetailsController;
use App\http\Controllers\Admin\SizeController;
use App\http\Controllers\Admin\SupplierController;
use App\http\Controllers\Admin\ImageController;
use App\http\Controllers\Admin\StatisticController;
use App\http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Account\ProductsController;
use App\Http\Controllers\Account\LoginController;
use App\Http\Controllers\Account\CartsController;
use App\Http\Controllers\Account\OrderController;
use App\Http\Controllers\Account\VouchersController;
use App\Http\Controllers\Account\ProfileController;
use App\Http\Controllers\Account\BillController;
use App\Http\Controllers\Account\FeedbackController;

use App\Http\Controllers\Admin\TestController;
//demo
Route::get('/test', [TestController::class, 'index']);
Route::post('/upload', [TestController::class, 'upload']);





use Illuminate\Support\Facades\Mail;

Route::get('/test-email', function () {
    Mail::raw('This is a test email sent using Google SMTP.', function ($message) {
        $message->to('cr.havaka@gmail.com')
                ->subject('Test Email from Laravel');
    });

    return 'Email sent!';
});

Route::post('/send-email', [LoginController::class, 'ForgotPassword'])->name('login.ForgotPassword');

Route::prefix('admin')->group(function () {

    // Customer
    // Hiển thị danh sách khách hàng
    Route::get('/', [CustomerController::class, 'showCustomers'])->name('customers.show');

    // Thêm khách hàng - GET và POST
    Route::get('/customers/add', [CustomerController::class, 'addCustomerForm'])->name('customers.add');
    Route::post('/customers/add', [CustomerController::class, 'addCustomer'])->name('customers.store');

    // Xóa khách hàng
    Route::delete('/customers/delete/{id}', [CustomerController::class, 'deleteCustomer'])->name('customers.delete');

    // Chỉnh sửa thông tin khách hàng - GET
    Route::get('/customers/edit/{id}', [CustomerController::class, 'editCustomerForm'])->name('customers.edit');
    // Cập nhật thông tin khách hàng - PUT
    Route::put('/customers/update/{id}', [CustomerController::class, 'updateCustomer'])->name('customers.update');



    // category

    // Hiển thị danh muc
    Route::get('/category/index', [CategoryController::class, 'index'])->name('category.index');
    // Them Danh Muc
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/create', [CategoryController::class, 'store'])->name('category.store');
    // Xóa Danh Muc
    Route::delete('/category/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    // Chỉnh sửa thông tin danh muc - GET
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    // Cập nhật thông tin danh muc - PUT
    Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    // Xem chi tiết danh mục
    Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');


    // color

    // Hiển thị Color
    Route::get('/Color/index', [ColorController::class, 'index'])->name('Color.index');
    //Them color
    Route::get('/Color/create', [ColorController::class, 'create'])->name('Color.create');
    Route::post('/Color/create', [ColorController::class, 'store'])->name('Color.store');
    // Xóa color
    Route::delete('/Color/destroy/{id}', [ColorController::class, 'destroy'])->name('Color.destroy');
    // Chỉnh sửa thông tin color - GET
    Route::get('/Color/edit/{id}', [ColorController::class, 'edit'])->name('Color.edit');
    // Cập nhật thông tin color - PUT
    Route::put('/Color/update/{id}', [ColorController::class, 'update'])->name('Color.update');
    // Xem chi tiết color
    Route::get('/Color/{id}', [ColorController::class, 'show'])->name('Color.show');



    // size

    // Hiển thị size
    Route::get('/size/index', [SizeController::class, 'index'])->name('size.index');
    //Them size
    Route::get('/size/create', [SizeController::class, 'create'])->name('size.create');
    Route::post('/size/create', [SizeController::class, 'store'])->name('size.store');
    // Xóa size
    Route::delete('/size/destroy/{id}', [SizeController::class, 'destroy'])->name('size.destroy');
    // Chỉnh sửa thông tin size - GET
    Route::get('/size/edit/{id}', [SizeController::class, 'edit'])->name('size.edit');
    // Cập nhật thông tin size - PUT
    Route::put('/size/update/{id}', [SizeController::class, 'update'])->name('size.update');
    // Xem chi tiết size
    Route::get('/size/{id}', [SizeController::class, 'show'])->name('size.show');


    // supplier

    // Hiển thị size
    Route::get('/supplier/index', [SupplierController::class, 'index'])->name('supplier.index');
    //Them size
    Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::post('/supplier/create', [SupplierController::class, 'store'])->name('supplier.store');
    // Xóa size
    Route::delete('/supplier/destroy/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    // Chỉnh sửa thông tin size - GET
    Route::get('/supplier/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
    // Cập nhật thông tin size - PUT
    Route::put('/supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    // Xem chi tiết supplier
    Route::get('/supplier/{id}', [SupplierController::class, 'show'])->name('supplier.show');



    //Product
    Route::post('/product/delete_all', [ProductController::class, 'destroy_all'])->name('product.destroy_all');

    Route::get('/product/index', [ProductController::class, 'index'])->name('product.index');
    //Them Product
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/create', [ProductController::class, 'store'])->name('product.store');
    // Xóa Product
    Route::delete('/product/destroy/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    // Chỉnh sửa thông tin Product - GET
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    // Cập nhật thông tin Product - PUT
    Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');

    // xem chi tiết 
    Route::get('/product/show/{id}', [ProductController::class, 'show'])->name('product.show');

    //search
    Route::get('/product/search', [ProductController::class, 'index'])->name('product.search');

    //import product form excel
    Route::get('/product/import', [ProductController::class, 'import'])->name('product.import');
    Route::post('/product/import', [ProductController::class, 'importFromExcel'])->name('product.importFromExcel');



    //ProductDetails
    //show index product details
    Route::get('/productdetails/index', [ProductDetailsController::class, 'index'])->name('productdetails.index');
    
    //Them ProductDetails
    Route::get('/productdetails/create', [ProductDetailsController::class, 'create'])->name('productdetails.create');
    Route::post('/productdetails/create', [ProductDetailsController::class, 'store'])->name('productdetails.store');
    // Xóa Product
    Route::delete('/productdetails/destroy/{id}', [ProductDetailsController::class, 'destroy'])->name('productdetails.destroy');
    // Chỉnh sửa thông tin Product - GET
    Route::get('/productdetails/edit/{id}', [ProductDetailsController::class, 'edit'])->name('productdetails.edit');
    // Cập nhật thông tin Product - PUT
    Route::put('/productdetails/update/{id}', [ProductDetailsController::class, 'update'])->name('productdetails.update');
    Route::get('/productdetails/create/{MaSP}', [ProductDetailsController::class, 'create'])->name('productdetails.create');

    // Image
    // Cập nhật thông tin Product - PUT
    Route::get('/image/create/{MaSP}', [ImageController::class, 'create'])->name('image.create');
    Route::post('/image/show/{MaSP}', [ImageController::class, 'store'])->name('image.store');
    //Route::get('/image/index', [ImageController::class, 'index'])->name('image.index');
    Route::get('/image/show/{MaSP}', [ImageController::class, 'index'])->name('image.show');

    // Xóa image
    //Route::delete('/image/{id}', [ImageController::class, 'destroy'])->name('image.destroy');
    Route::post('/image/delete', [ImageController::class, 'destroy'])->name('image.destroy');


    //voucher admin
    // Hiển thị voucher
    Route::get('/voucher/index', [VoucherController::class, 'index'])->name('voucher.index');
    //Them voucher
    Route::get('/voucher/create', [VoucherController::class, 'create'])->name('voucher.create');
    Route::post('/voucher/create', [VoucherController::class, 'store'])->name('voucher.store');
    // Xóa voucher
    Route::delete('/voucher/destroy/{id}', [VoucherController::class, 'destroy'])->name('voucher.destroy');
    // Chỉnh sửa thông tin voucher - GET
    Route::get('/voucher/edit/{id}', [VoucherController::class, 'edit'])->name('voucher.edit');
    // Cập nhật thông tin voucher - PUT
    Route::put('/voucher/update/{id}', [VoucherController::class, 'update'])->name('voucher.update');
    // xem chi tiết 
    Route::get('/voucher/show/{id}', [VoucherController::class, 'show'])->name('voucher.show');
    //search
    Route::get('/voucher/search', [VoucherController::class, 'search'])->name('voucher.search');


    // Thống kê
    Route::get('/statistic/index', [StatisticController::class, 'index'])->name('statistic.index');
    Route::post('days_order', [StatisticController::class, 'days_order'])->name('statistic.days_order');
    Route::post('dashboard_filter', [StatisticController::class, 'dashboard_filter'])->name('statistic.dashboard_filter');
    Route::post('filter_by_date', [StatisticController::class, 'filter_by_date'])->name('statistic.filter_by_date');
    

    //Đơn hàng
    Route::get('/order/index', [OrderAdminController::class, 'index'])->name('order.index');   
    Route::post('/order/edit', [OrderAdminController::class, 'edit'])->name('order.edit');
    Route::post('/order/update', [OrderAdminController::class, 'update'])->name('order.update');

    Route::post('/order/index',[OrderAdminController::class, 'index'])->name('order.index');
    Route::post('/order/index_detailOrder',[OrderAdminController::class, 'index'])->name('order.index_DetailOrder');
    
});



// show top sale 8 product 
Route::get('/', [ProductsController::class, 'showTop8Sale'])->name('product.top-8-sale');

// show all product
Route::get('/products/products', [ProductsController::class, 'ShowProduct'])->name('product.showProduct');

//show dropdow product
//Route::get('/layout/dorpdown_category', [CategorysController::class, 'ShowCategory'])->name('layout.dorpdown_category');

//show theo category
Route::get('/products/DisplayProductsByType/{MaDanhMuc}', [ProductsController::class, 'DisplayProductsByType'])->name('product.DisplayProductsByType');
// show category trong trang product
// Route::get('/products/products', [CategorysController::class, 'ShowCategory'])->name('product.category');
// xem chi tiết sản phẩm account
Route::get('/product/SeeProductDetails/{id}', [ProductsController::class, 'SeeProductDetails'])->name('product.SeeProductDetails');

//login show
Route::get('/login/ShowLoginForm', [LoginController::class, 'ShowLoginForm'])->name('login.ShowLoginForm');

Route::post('/login/ShowLoginForm', [LoginController::class, 'login'])->name('login.login');
//register
Route::post('/login/register', [LoginController::class, 'Register'])->name('login.Register');

//logOut khi click vào btn đăng xuất
Route::get('/login/logout', [LoginController::class, 'LogOut'])->name('login.LogOut');

//add to cart
Route::post('/cart/cart', [CartsController::class, 'AddProductToCart'])->name('cart.AddProductToCart');
// show cart 
Route::get('/cart/cart', [CartsController::class, 'showCart'])->name('cart.showCart'); //

//delete all to cart
Route::post('/cart/clearAllProduct', [CartsController::class, 'ClearAllCart'])->name('cart.clearAllCart');

//dealte item to cart session
Route::post('/cart/removeItem', [CartsController::class, 'RemoveProductFromCart'])->name('cart.removeItemProductFromCart');

//delete item to cart USER ID
Route::delete('cart/delete/{id}',[CartsController::class,'DeleteCart'])->name('cart.deleteCart');

//add don hang vao database
Route::post('/create-order', [OrderController::class, 'createOrder'])->name('order.create');
//add don hang vao database Walk-in customers
Route::post('/create-order-Walk-in', [OrderController::class, 'createOrder_WalkInCustomers'])->name('order.createOrder_WalkInCustomers');
//add don hang vao database của thanh toán bằng paymomo
Route::post('/create-order-momo', [OrderController::class, 'createOrder'])->name('order.create-momo');



Route::get('/products', function () {
    return view('account.products.products'); //folder.view
});

Route::get('/details', function () {
    return view('account.products.details_product'); //folder.view
});

// routes/web.php
Route::get('/sizes', 'ProductController@getSizesByColor')->name('sizes');

Route::get('/cart', function () {
    return view('account.cart.cart');
});

//applyvoucher
Route::post('/applyVoucher', [VouchersController::class, 'applyVoucher'])->name('applyVoucher');

//show voucher
Route::get('/showVoucher', [VouchersController::class, 'showVoucher'])->name('voucher.showVoucher');

// show my  voucher in layout
Route::get('/myVouchers', [VouchersController::class, 'MyVoucherLayout'])->name('voucher.MyVoucherLayout');

// save voucher to table customer_vouhcer
Route::post('/vouchers/saveVoucher', [VouchersController::class, 'AddVoucherToCustomer'])->name('voucher.saveVoucher');


// show my voucher
Route::get('/myVoucher', [VouchersController::class, 'MyVoucher'])->name('voucher.myVoucher');


// Define a route that supports POST requests for the MoMo payment
Route::get('/momo', [OrderController::class, 'showMomoPaymentForm'])->name('show_momo_payment_form');
Route::post('/momo', [OrderController::class, 'momo_payment'])->name('momo_payment');

// thanh toán momo
Route::get('/momo/payment/form', [OrderController::class, 'showMomoPaymentForm'])->name('momo.payment.form');
Route::post('/momo/payment', [OrderController::class, 'momo_payment'])->name('momo.payment');
Route::get('/momo/callback', [OrderController::class, 'momoCallback'])->name('momo.callback');
// thanh toán momo cho khác hàng vãn lai

Route::post('/momo/payment_WalkInCustomers', [OrderController::class, 'momo_payment_WalkInCustomers'])->name('momo.paymentWalkInCustomers');
Route::get('/momo/callback_WalkInCustomers', [OrderController::class, 'momoCallback_WalkInCustomers'])->name('momo.callbackWalkInCustomers');


// CART UPDATE PHONE ORDER
Route::post('/update_address', [OrderController::class, 'update_InfoOrder'])->name('update_InfoOrder');

Route::post('/update-info-order', [OrderController::class, 'update_InfoOrder'])->name('update.info.order');


// CART UPDATE PHONE ORDER -WalkInCus

Route::post('/update-info-order-WalkInCus', [OrderController::class, 'update_InfoOrder_WalkInCustomers'])->name('update_InfoOrder_WalkInCustomers');

// ADD QUALITY ITEM TO CART
Route::post('/update/AddQualityCart',[CartsController::class, 'AddItemCartProduct'])->name('cart.addItemCartProduct');

Route::post('/update/reduceQualityCart',[CartsController::class, 'reduceItemCartProduct'])->name('cart.reduceItemCartProduct');


// DELETE VOUCHER TO ORDER
route::get('/deleteVoucherToOrder',[VouchersController::class, 'deleteVoucherApplyToOrder'])->name('deleteVoucherApplyToOrder');

//CHECK ORDER CUSTOMER WalkInCustomers
route::get('/check_order_WalkInCustomers',[OrderController::class, 'CheckOrderForm_WalkInCustomers'])->name('show.CheckOrderForm_WalkInCustomers');
route::post('/check_order_WalkInCustomers',[OrderController::class, 'SearchBill_WalkInCustomers'])->name('show.searchBill_WalkInCustomers');


//XEM CHI TIẾT ĐƠN HÀNG CỦA KHÁCH HÀNG VÃN LAI
route::post('/detail_order_walkInCus',[OrderController::class, 'FindOrderDetail_WalkInCustomers'])->name('show.detailOrder');



// search product
route::post('/searchProduct',[ProductsController::class, 'SearchProduct'])->name('SearchProduct');

//up date Order.UpdateAdressAndPhone


route::post('/UpdateAdressAndPhone',[BillController::class, 'UpdateAdressAndPhone'])->name('Order.UpdateAdressAndPhone');
//CancelOrder

route::post('/CancelOrder',[BillController::class, 'CancelOrder'])->name('Order.CancelOrder');


//show bill theo customer
Route::get('/bill/CheckYourOrder', [BillController::class, 'CheckYourOrder'])->name('bill.CheckYourOrder');

Route::get('/bill/ShowOrderedBill', [BillController::class, 'ShowOrderedBill'])->name('bill.ShowOrderedBill');
Route::get('/bill/ShowDeliveredBill', [BillController::class, 'ShowDeliveredBill'])->name('bill.ShowDeliveredBill');

Route::get('/bill/ShowCancelledBill', [BillController::class, 'ShowCancelledBill'])->name('bill.ShowCancelledBill');
Route::post('/bill/ShowCancelledBill', [BillController::class, 'ShowCancelledBill_Detail_Bill'])->name('bill.ShowCancelledBill_Detail_Bill');

Route::post('/bill/ShowOrderedBill', [BillController::class, 'ShowOrdered_Detail_Bill'])->name('bill.ShowOrdered_Detail_Bill');


Route::post('/bill/CheckYourOrder', [BillController::class, 'CheckYourOrder_Detail_Bill'])->name('bill.CheckYourOrder_Detail_Bill');
Route::post('/bill/ShowDeliveredBill', [BillController::class, 'ShowDeliveredBill_Detail_Bill'])->name('bill.ShowDeliveredBill_Detail_Bill');



// FEEDBACK TO ORDER DETAIL 
Route::post('/feedback/FeedbackToOrder', [FeedbackController::class, 'FeedbackToOrderDetail'])->name('feedback.FeedbackToOrderDetail');




//USER PROFILE
Route::get('/user/ShowProfile', [ProfileController::class, 'ShowProfile'])->name('user.ShowProfile');

Route::post('/user/ShowProfile', [ProfileController::class, 'editName'])->name('profile.editName');

Route::post('/user/ShowProfile_phone', [ProfileController::class, 'editPhone'])->name('profile.editPhone');

Route::post('/user/ShowProfile_Email', [ProfileController::class, 'editEmail'])->name('profile.editEmail');

Route::post('/user/ShowProfile_Address', [ProfileController::class, 'editAddress'])->name('profile.editAddress');

Route::post('/user/ShowProfile_Password', [ProfileController::class, 'editPassword'])->name('profile.editPassword');

Route::post('/user/ShowProfile_gender', [ProfileController::class, 'editgender'])->name('profile.editgender');


Route::post('/user/ShowProfile_image', [ProfileController::class, 'editimage'])->name('profile.editimage');



Route::post('/cart/cartAdd',[CartsController::class, 'decreaseProductQuantity'])->name('cart.decreaseProductQuantity');
Route::post('/cart/increase',[CartsController::class, 'increaseProductQuantity'])->name('cart.increaseProductQuantity');



