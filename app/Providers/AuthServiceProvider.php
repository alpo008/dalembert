<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\AirmaxClient' => 'App\Policies\AirmaxClientPolicy',
        'App\Models\Media' => 'App\Policies\MediaPolicy',
        'App\Models\Attachment' => 'App\Policies\AttachmentPolicy',
        'App\Models\Work' => 'App\Policies\WorkPolicy',
        'App\Models\Customer' => 'App\Policies\CustomerPolicy',
        'App\Models\Calculation' => 'App\Policies\CalculationPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
