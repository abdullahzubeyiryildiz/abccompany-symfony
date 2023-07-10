<?php

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__) . '/abc-company/vendor/autoload.php';

// Dotenv ile .env dosyasını yükle
(new Dotenv(false))->usePutenv(true)->load(dirname(__DIR__) . '/abc-company/.env');

// Geliştirme ortamında hata ayıklama etkinleştirme
if ($_SERVER['APP_DEBUG']) {
    umask(0000);
    Debug::enable();
}

// Kernel'i oluştur
$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);

// İstek oluştur
$request = Request::createFromGlobals();

// Yanıtı al
$response = $kernel->handle($request);

// Yanıtı gönder
$response->send();

// Kernel'i sonlandır
$kernel->terminate($request, $response);