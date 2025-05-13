<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Mapear los modelos a sus policies (si tuvieras).
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Registra las políticas y define gates.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate para administrador
        Gate::define('admin', fn($user) => $user->role === 'admin');
    }
}
