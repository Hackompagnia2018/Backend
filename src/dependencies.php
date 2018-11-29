<?php
// DIC configuration
$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};


// PDO database library
$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
        $settings['user'], $settings['pass']);
    // $pdo->setAttribute(PDO::PARAM_STR)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $pdo;
};

$container['token'] = function () {
    // Otteniamo il token proveniente dal frontend
    return new Classes\Validator();
};

$container['token_info'] = function () use($container) {
    // otteniamo le informazioni contenute nel token
    return $container['token']->getTokenInfo();
};


$container['token_mail'] = function () use($container) {
    $cont = (array)$container['token_info'];
    return $cont['https://hack2018api.com/allemail'];
};

$container['token_id'] = function () use ($container) {
    // otteniamo l'id e il provider dell'utente dal token
    return $container['token_info']->sub;
};

/*function ownCrypt($value) {
    return crypt($value, 'Hack2018dwuvdoiuwrvi2ren2ip4poj490p3j593jrk3');
}*/
