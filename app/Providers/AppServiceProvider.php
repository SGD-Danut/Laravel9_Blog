<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Variantă simplă de obținere a categoriilor:
        // $menuCategories = Category::all()->sortBy('title')->where('published', 1);
        
        //Variantă mai complexă(selectivă) de obținere a categoriilor:
        if (Schema::hasTable('categories')) {
            $menuCategories = Category::select('title', 'slug')->orderBy('title')->where('published', 1)->get();
            View::share('menuCategories', $menuCategories);
        }

        Paginator::useBootstrapFive();
    }
}
