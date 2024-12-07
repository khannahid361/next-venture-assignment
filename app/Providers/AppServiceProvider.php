<?php

namespace App\Providers;

use App\Repositories\Permission\UserPermissionRepository;
use App\Repositories\Permission\UserPermissionRepositoryInterface;
use App\Repositories\Role\UserRoleRepository;
use App\Repositories\Role\UserRoleRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserRoleRepositoryInterface::class, UserRoleRepository::class);
        $this->app->bind(UserPermissionRepositoryInterface::class, UserPermissionRepository::class);
    }

    public function boot(): void
    {
        
    }
}
