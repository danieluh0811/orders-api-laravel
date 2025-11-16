<?php

namespace App\Financial\Util\Helpers;

class OrderApiInit
{
    protected static ?array $cache = null;

    public static function get(): array
    {
        if (self::$cache !== null) {
            return self::$cache;
        }

        $path = base_path('app/order-api-init.json');

        if (!file_exists($path)) {
            throw new \Exception("Config file order-api-init.json not found at: $path");
        }

        self::$cache = json_decode(file_get_contents($path), true);

        return self::$cache;
    }

    public static function setMode(string $mode): void
    {
        $config = self::get();

        if (!isset($config['paymentUrls'][$mode])) {
            throw new \Exception("Invalid payment mode: $mode");
        }

        $config['paymentMode'] = $mode;

        self::$cache = $config;
    }

    public static function reset(): void
    {
        self::$cache = null;
    }
}
