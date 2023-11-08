<?php

use App\Response;
use App\Router\Router;
use App\WeatherApi;
use Carbon\Carbon;
use Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

require_once __DIR__ . '/../vendor/autoload.php';

$loader = new FilesystemLoader(__DIR__ . '/../app/Views');
$twig = new Environment($loader);

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$twig->addExtension(new DebugExtension());

$weatherApi = new WeatherApi();
$weather = $weatherApi->fetchCity();
$weather->setDayTime(Carbon::now()->timezone($weather->getTimezone()/3600));

$twig->addGlobal('weather', $weather);

$routeInfo = Router::dispatch();

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo $twig->render('404.twig');
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        [$className, $method] = $routeInfo[1];
        $vars = $routeInfo[2];

        $response = (new $className())->{$method}($vars);

        /** @var Response $response */
        echo $twig->render($response->getViewName() . '.twig', $response->getData());

        break;
}
