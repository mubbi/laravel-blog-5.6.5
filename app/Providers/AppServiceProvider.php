<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Category;
use App\Setting;
use App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Share sidebar Categories with all views
        if (Schema::hasTable('categories')) {
            $categories = Category::select('name', 'slug', 'id')->get();
            View::share('sidebar_categories', $categories);
        }

        // Share Settings all views
        if (Schema::hasTable('settings')) {
            // You can keep this in your filters.php file
            App::singleton('global_settings', function () {
                return Setting::select('setting_name', 'setting_value')->get();
            });
            // If you use this line of code then it'll be available in any view
            // as $global_settings but you may also use app('global_settings') as well
            // View::share('global_settings', app('global_settings'));
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
