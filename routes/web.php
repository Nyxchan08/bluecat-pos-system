    <?php
    use App\Http\Controllers\GenderController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\SupplierController;
    use App\Http\Controllers\CategoryController;
    use App\http\Controllers\StoreController;
    use App\http\Controllers\TransactionController;
    use App\http\Controllers\DashboardController;
    use App\http\Controllers\SearchController;
    use App\Http\Middleware\PreventBackHistory;
    use App\Http\Controllers\MessageController;
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider and all of them will
    | be assigned to the "web" middleware group. Make something great!
    |
    */

    Route::controller(UserController::class)->group(function(){
        Route::get('/', 'login')->name('login');
        Route::post('/process/login', 'processLogin');
        Route::get('/process/logout', 'processLogout')->name('processLogout');
    });
    

// Routes accessible only when authenticated and preventing back history
Route::middleware(['auth', 'preventBackHistory'])->group(function () {
    Route::controller(GenderController::class)->group(function(){
        Route::get('/genders', 'index');
        Route::get('/gender/create', 'create');
        Route::get('/gender/show/{id}', 'show');
        Route::get('/gender/edit/{id}', 'edit');
        Route::get('/gender/delete/{id}', 'delete');
        
        Route::post('/gender/store', 'store');
        Route::put('/gender/update/{gender}', 'update');
        Route::delete('/gender/destroy/{gender}', 'destroy');
        });
        
        //User Controller
        Route::controller(UserController::class)->group(function(){
        Route::get('/user/list', 'index');
        Route::get('/user/create', 'create');
        Route::get('/user/show/{id}', 'show')->name('user.show');
        Route::get('/user/edit/{id}', 'edit');
        Route::get('/user/delete/{id}', 'delete');
        
        Route::post('/user/store', 'store');
        Route::put('/user/update/{user}', 'update');
        Route::delete('/user/destroy/{user}', 'destroy');
        });

        Route::controller(ProductController::class)->group(function(){
            Route::get('/product/list', 'index');
            Route::get('/product/create', 'create');
            Route::get('/product/show/{id}', 'show')->name('product.show');
            Route::get('/product/edit/{id}', 'edit');
            Route::get('/product/delete/{id}', 'delete');
            
            Route::post('/product/store', 'store');
            Route::put('/product/update/{product}', 'update');
            Route::delete('/product/destroy/{product}', 'destroy');
        });   
        
        Route::controller(SupplierController::class)->group(function(){
            Route::get('/supplier/list', 'index');
            Route::get('/supplier/create', 'create');
            Route::get('/supplier/show/{id}', 'show');
            Route::get('/supplier/edit/{id}', 'edit');
            Route::get('/supplier/delete/{id}', 'delete');
            
            Route::post('/supplier/store', 'store');
            Route::put('/supplier/update/{supplier}', 'update');
            Route::delete('/supplier/destroy/{supplier}', 'destroy');
        });

        Route::controller(CategoryController::class)->group(function(){
            Route::get('/category/list', 'index');
            Route::get('/category/create', 'create');
            Route::get('/category/show/{id}', 'show')->name('category.show');
            Route::get('/category/edit/{id}', 'edit');
            Route::get('/category/delete/{id}', 'delete');
            
            Route::post('/category/store', 'store');
            Route::put('/category/update/{category}', 'update');
            Route::delete('/category/destroy/{category}', 'destroy');
        });

            // Store Routes
            Route::controller(StoreController::class)->group(function(){
                Route::get('/store/list', 'index')->name('store.index');
            });

            // Transaction Controller
            Route::controller(TransactionController::class)->group(function() {
                Route::get('/transactions/list', 'index')->name('transactions.index');
                Route::post('/transactions/store', 'store')->name('transactions.store');
                Route::get('/transactions/download/{id}','download')->name('transactions.download');
                Route::get('/transactions/preview/{id}', 'preview')->name('transactions.preview');
                Route::delete('/transactions/{id}', 'destroy')->name('transactions.destroy');

            });
            // routes/web.php
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


            Route::get('/search', [SearchController::class, 'search'])->name('search');

            Route::middleware(['auth'])->group(function () {
                Route::get('inbox', [MessageController::class, 'inbox'])->name('messages.inbox');
                Route::get('compose', [MessageController::class, 'compose'])->name('messages.compose');
                Route::post('send', [MessageController::class, 'send'])->name('messages.send');
                Route::get('notifications', [MessageController::class, 'notifications'])->name('messages.notifications');
            });
            
});