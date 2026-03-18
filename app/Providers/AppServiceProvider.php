<?php

namespace App\Providers;

use App\Repositories\CategoryCompany\CategoryCompanyRepositoryInterface;
use App\Repositories\CategoryCompany\CategoryCompanyRepository;

use App\Repositories\Specialty\SpecialtyRepositoryInterface;
use App\Repositories\Specialty\SpecialtyRepository;

use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Category\CategoryRepository;

use App\Repositories\Region\RegionRepositoryInterface;
use App\Repositories\Region\RegionRepository;

use App\Repositories\Company\CompanyRepositoryInterface;
use App\Repositories\Company\CompanyRepository;

use \App\Models\User;
use \App\Observers\User\UserObserver;

use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {
//
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(RegionRepositoryInterface::class, RegionRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(SpecialtyRepositoryInterface::class, SpecialtyRepository::class);
        $this->app->bind(CategoryCompanyRepositoryInterface::class, CategoryCompanyRepository::class);
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\Region::observe(\App\Observers\Region\RegionObserver::class);
        \App\Models\Category::observe(\App\Observers\Category\CategoryObserver::class);
        User::observe(UserObserver::class);
        Model::unguard();
    }
}
