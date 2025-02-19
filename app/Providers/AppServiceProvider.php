<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if($this->app->environment('production')) {  
            URL::forceScheme('https');  
            $this->app['request']->server->set('HTTPS','on'); 
        }

        View::composer('*', function ($view) {
            $user = Auth::user();
    
            if ($user) {
                $matches = User::whereIn('id', function ($query) use ($user) {
                    $query->select('avaliator_id')
                        ->from('avaliations')
                        ->where('avaliated_id', $user->id)
                        ->where('like', 1)
                        ->whereIn('avaliator_id', function ($subquery) use ($user) {
                            $subquery->select('avaliated_id')
                                ->from('avaliations')
                                ->where('avaliator_id', $user->id)
                                ->where('like', 1);
                        });
                })->get();
            } else {
                $matches = collect(); 
            }
    
            $view->with('matches', $matches);
        });
         
    }
}
