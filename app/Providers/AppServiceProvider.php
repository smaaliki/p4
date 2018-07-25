<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        \Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        view()->composer('shared.navbar', function($view){
            //get all parent categories with their subcategories
            $categories = \App\Category::where('parent_id', 0)->with('subcategories')->get();
            //attach the categories to the view.
            $view->with(compact('categories'));
        });

    }
}
