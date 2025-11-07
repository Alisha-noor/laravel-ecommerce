 <?php

    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;

    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\AdminController;
    use App\Http\Middleware\AuthAdmin;
    use App\Http\Controllers\ShopController;
    use App\Http\Controllers\CartController;
    use App\Http\Controllers\WishlistController;
    use App\Http\Controllers\ReviewController;

    /*
|--------------------------------------------------------------------------
| Public / Site
|--------------------------------------------------------------------------
*/
    // Profile routes
    Route::get('/profile/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('usereditprofile');
    Route::post('/profile/update', [App\Http\Controllers\UserController::class, 'update'])->name('profile.update');
    // web.php
    Route::post('/profile/avatar', [UserController::class, 'updateAvatar'])->name('user.update.avatar');

    Route::get('/profile', [UserController::class, 'profile'])->name('userprofile');
    Route::get('/address/{id}/edit', [App\Http\Controllers\CheckoutController::class, 'edit'])->name('addressedit');
    Route::post('/address/{id}/update', [App\Http\Controllers\CheckoutController::class, 'update'])->name('address.update');
    Route::delete('/address/{id}/delete', [App\Http\Controllers\CheckoutController::class, 'destroy'])->name('address.delete');
    // Profile avatar remove route
    Route::post('/profile/remove-avatar', [UserController::class, 'removeAvatar'])->name('profile.removeAvatar');

    // routes/web.php
    use App\Http\Controllers\ContactController;
    // In routes/web.php
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::post('/product/{id}/review', [ReviewController::class, 'store'])->name('review.store');

    Route::post('/cart/coupon/apply', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
    Route::delete('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    // Shop
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product.details');

    // Static pages
    Route::view('/about', 'about')->name('about.index');
    Route::view('/contact', 'contact')->name('contact.index');

    // Auth
    Auth::routes();

    /*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/
    // Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    // Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

    // Route::put('/cart/{rowId}/decrease', [CartController::class, 'decrease'])
    //     ->whereAlphaNumeric('rowId')
    //     ->name('cart.reduce.qty');

    // Route::put('/cart/{rowId}/increase', [CartController::class, 'increase'])
    //     ->whereAlphaNumeric('rowId')
    //     ->name('cart.increase.qty');

    // Route::delete('/cart/{rowId}', [CartController::class, 'remove'])
    //     ->whereAlphaNumeric('rowId')
    //     ->name('cart.remove');

    // 🛒 Cart main page
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    // ➕ Add product to cart
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

    // ➖ Decrease quantity
    Route::put('/cart/{item}/decrease', [CartController::class, 'decreaseQty'])->name('cart.reduce.qty');

    // ➕ Increase quantity
    Route::put('/cart/{item}/increase', [CartController::class, 'increaseQty'])->name('cart.increase.qty');

    // ❌ Remove item from cart
    Route::delete('/cart/{item}/remove', [CartController::class, 'remove'])->name('cart.remove');


    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    Route::post('/cart/coupon/apply', [CartController::class, 'apply_coupon_code'])->name('cart.coupon.apply');
    Route::delete('/cart/coupon', [CartController::class, 'remove_coupon'])->name('cart.coupon.remove');

    // Route::delete('/cart/{rowId}', [CartController::class, 'remove'])->name('cart.remove');
    // Route::delete('/cart/{rowId}', [CartController::class, 'remove'])
    //     ->where('rowId', '^[a-f0-9]{32}$')
    //     ->name('cart.remove');

    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/place-order', [CartController::class, 'place_order'])->name('cart.place_order');
    Route::get('/order-confirmation', [CartController::class, 'confirmation'])->name('cart.confirmation');

    /*
|--------------------------------------------------------------------------
| Wishlist
|--------------------------------------------------------------------------
*/
    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

    Route::post('/wishlist/add', [WishlistController::class, 'add_to_wishlist'])->name('wishlist.add');

    Route::delete('/wishlist/remove/{rowId}', [WishlistController::class, 'remove_item_from_wishlist'])
        ->whereAlphaNumeric('rowId')
        ->name('wishlist.remove');

    Route::delete('/wishlist/clear', [WishlistController::class, 'empty_wishlist'])->name('wishlist.clear');

    Route::post('/wishlist/move-to-cart/{rowId}', [WishlistController::class, 'move_to_cart'])
        ->whereAlphaNumeric('rowId')
        ->name('wishlist.move.to.cart');

    Route::get('/user/{id}', [App\Http\Controllers\UserController::class, 'show'])
        ->name('show');


    /*
|--------------------------------------------------------------------------
| User Account
|--------------------------------------------------------------------------
*/
    Route::get('/account-orders', [UserController::class, 'account_orders'])->name('user.account.orders');
    Route::get('/account-order-details/{order_id}', [UserController::class, 'account_order_details'])
        ->whereNumber('order_id')
        ->name('user.account.order.details');
    Route::get('/account/addresses', [UserController::class, 'addresses'])->name('user.account.addresses');

    /*
|--------------------------------------------------------------------------
| Admin (protected)
|--------------------------------------------------------------------------
*/
    Route::middleware([AuthAdmin::class])
        ->prefix('admin')
        ->as('admin.')
        ->group(function () {

            // Dashboard
            Route::get('/', [AdminController::class, 'index'])->name('index');

            // Brands
            Route::get('/brands', [AdminController::class, 'brands'])->name('brands');
            Route::get('/brand/add', [AdminController::class, 'add_brand'])->name('brand.add');
            Route::post('/brand/store', [AdminController::class, 'add_brand_store'])->name('brand.store');
            Route::get('/brand/{brand}/edit', [AdminController::class, 'edit_brand'])->name('brand.edit');
            Route::put('/brand/{brand}', [AdminController::class, 'update_brand'])->name('brand.update');
            Route::delete('/brand/{brand}', [AdminController::class, 'delete_brand'])->name('brand.delete');
            Route::get('/brand/{brand_slug}/products', [AdminController::class, 'brand_products'])->name('brand.products');

            // Categories
            Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
            Route::get('/category/add', [AdminController::class, 'category_add'])->name('category.add');
            Route::post('/category/store', [AdminController::class, 'add_category_store'])->name('category.store');
            Route::get('/category/edit/{id}', [AdminController::class, 'edit_category'])
                ->whereNumber('id')->name('category.edit');
            Route::put('/category/update', [AdminController::class, 'update_category'])->name('category.update');
            Route::delete('/category/delete/{id}', [AdminController::class, 'delete_category'])
                ->whereNumber('id')->name('category.delete');
            Route::get('/category/{category_slug}/products', [AdminController::class, 'category_products'])->name('category.products');

            // Products
            Route::get('/products', [AdminController::class, 'products'])->name('products');
            Route::get('/product/add', [AdminController::class, 'add_product'])->name('product.add');
            Route::post('/product/store', [AdminController::class, 'product_store'])->name('product.store');
            Route::get('/product/{id}/edit', [AdminController::class, 'edit_product'])
                ->whereNumber('id')->name('product.edit');
            Route::put('/product/update', [AdminController::class, 'update_product'])->name('product.update');
            Route::delete('/product/{id}/delete', [AdminController::class, 'delete_product'])
                ->whereNumber('id')->name('product.delete');

            // Orders
            Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
            Route::get('/orders/create', [AdminController::class, 'orderCreate'])->name('orders.create');
            Route::post('/orders', [AdminController::class, 'orderStore'])->name('orders.store');
            Route::get('/orders/{order}', [AdminController::class, 'orderItems'])
                ->whereNumber('order')
                ->name('orders.show');

            // Coupons
            Route::get('/coupons', [AdminController::class, 'coupons'])->name('coupons');
            Route::get('/coupon/add', [AdminController::class, 'add_coupon'])->name('coupon.add');
            Route::post('/coupon/store', [AdminController::class, 'add_coupon_store'])->name('coupon.store');
            Route::get('/coupon/{id}/edit', [AdminController::class, 'edit_coupon'])
                ->whereNumber('id')->name('coupon.edit');
            Route::put('/coupon/update', [AdminController::class, 'update_coupon'])->name('coupon.update');
            Route::delete('/coupon/{id}/delete', [AdminController::class, 'delete_coupon'])
                ->whereNumber('id')->name('coupon.delete');
            // Reviews
            Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');
            Route::put('/review/{id}/approve', [AdminController::class, 'approve_review'])->name('review.approve');
            Route::delete('/review/{id}/delete', [AdminController::class, 'delete_review'])->name('review.delete');
        });
