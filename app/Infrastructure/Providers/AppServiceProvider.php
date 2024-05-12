<?php

declare(strict_types=1);

namespace App\Infrastructure\Providers;

use App\Domain\Contracts\MerchantI;
use App\Domain\Contracts\PaymentI;
use App\Domain\Contracts\PaymentMethodI;
use App\Infrastructure\Persistence\Repositories\MerchantRepository;
use App\Infrastructure\Persistence\Repositories\PaymentRepository;
use App\Infrastructure\Persistence\Repositories\PaymentMethodRepository;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerRepositories();
    }

    public function boot(): void
    {
        Factory::guessFactoryNamesUsing(function (string $modelName) {
            return 'Database\\Factories\\' . class_basename($modelName) . 'Factory';
        });
        Factory::guessModelNamesUsing(function($string){
            return 'App\\Infrastructure\\Persistence\\Models\\'  . str_replace('Factory', '', class_basename($string));
        });
    }

    private function registerRepositories(): void
    {
        $this->app->bind(MerchantI::class, MerchantRepository::class);
        $this->app->bind(PaymentI::class, PaymentRepository::class);
        $this->app->bind(PaymentMethodI::class, PaymentMethodRepository::class);
    }
}
