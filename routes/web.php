<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Models\Product;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AiChatController;

/*
|--------------------------------------------------------------------------
| 1. ПУБЛИЧНЫЕ МАРШРУТЫ
|--------------------------------------------------------------------------
*/

// 👇 ГЛАВНОЕ ИСПРАВЛЕНИЕ ТУТ:
// Теперь мы используем твой PageController, где прописана логика с галочкой "NEW"
Route::get('/', [PageController::class, 'home'])->name('home');

// Страница "О нас"
Route::get('/about', [PageController::class, 'about'])->name('about'); 
// (Я поменял Route::view на контроллер, если ты добавлял метод about, 
// но если метода нет — верни Route::view('/about', 'pages.about')->name('about');)


// Магазин и Товары
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

// КОРЗИНА
Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index')->name('cart.index');
    Route::post('/cart/add/{id}', 'add')->name('cart.add');
    Route::patch('/cart/update', 'update')->name('cart.update');
    Route::delete('/cart/remove', 'remove')->name('cart.remove');
    Route::post('/checkout', 'checkout')->name('checkout');
});

/*
|--------------------------------------------------------------------------
| 2. ЗАЩИЩЕННЫЕ МАРШРУТЫ
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Личный кабинет
    Route::get('/dashboard', function () {
        $user = Illuminate\Support\Facades\Auth::user();
        $orders = $user->orders()->latest()->get();
        return view('dashboard', compact('orders'));
    })->name('dashboard');

    // Профиль
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Заказы
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');

    // Избранное
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorite/{id}', [FavoriteController::class, 'toggle'])->name('favorite.toggle');
});

// Статические страницы
Route::get('/delivery', [PageController::class, 'delivery'])->name('page.delivery');
Route::get('/returns', [PageController::class, 'returns'])->name('page.returns');
Route::get('/size-guide', [PageController::class, 'sizeGuide'])->name('page.size-guide');
Route::get('/contacts', [PageController::class, 'contacts'])->name('page.contacts');
Route::post('/chat', [AiChatController::class, 'ask']);

// Маршрут для печати накладной (доступен только авторизованным)
Route::get('/admin/orders/{id}/print', function ($id) {
    // Находим заказ вместе с товарами
    $order = \App\Models\Order::with('items.product')->findOrFail($id);
    
    return view('pdf.invoice', compact('order'));
})->name('orders.print')->middleware('auth');

require __DIR__.'/auth.php';