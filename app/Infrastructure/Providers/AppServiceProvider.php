<?php

declare(strict_types=1);

namespace Infrastructure\Providers;

use Domain\Interfases\MerchantI;
use Domain\Interfases\PaymentI;
use Domain\Interfases\PaymentMethodI;
use Infrastructure\Persistence\Repositories\MerchantRepository;
use Infrastructure\Persistence\Repositories\PaymentRepository;
use Infrastructure\Persistence\Repositories\PaymentMethodRepository;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerRepositories();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Factory::guessFactoryNamesUsing(function (string $modelName) {
            return 'Database\\Factories\\' . class_basename($modelName) . 'Factory';
        });
        Factory::guessModelNamesUsing(function($string){
            return 'Infrastructure\\Persistence\\Models\\'  . str_replace('Factory', '', class_basename($string));
        });
    }

    private function registerRepositories(): void
    {
        $this->app->bind(MerchantI::class, MerchantRepository::class);
        $this->app->bind(PaymentI::class, PaymentRepository::class);
        $this->app->bind(PaymentMethodI::class, PaymentMethodRepository::class);
    }
}
