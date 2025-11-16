<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Financial\Domain\Persistence\OrderPersistence;
use App\Financial\Infrastructure\Db\Persistence\OrderPersistenceDb;

use App\Financial\Domain\Persistence\PaymentPersistence;
use App\Financial\Infrastructure\Db\Persistence\PaymentPersistenceDb;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderPersistence::class, OrderPersistenceDb::class);
        $this->app->bind(PaymentPersistence::class, PaymentPersistenceDb::class);
    }

    public function boot(): void
    {
        //
    }
}
