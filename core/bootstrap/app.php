<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);


$app->bind(
	\App\Domain\Contract\System\Facade::class,
	\App\System\Config\Facade::class
);

$app->bind(
    \App\Http\Request\Upsource\ConverterInterface::class,
    \App\Http\Request\Upsource\Converter::class
);

$app->bind(
	\App\Domain\Contract\Action\ContextFactory::class,
	\App\Domain\Implementation\Action\ContextFactory::class
);

$app->bind(
	\App\Domain\Contract\Repository\Upsource\Review::class,
	\App\Repository\Upsource\Review::class
);

$app->bind(
	\App\Domain\Contract\Repository\Telegram\ReviewNotificationMessage::class,
	\App\Repository\Telegram\ReviewNotificationMessage::class
);

$app->bind(
	\App\Domain\Contract\Notifications\Context\Review::class,
	\App\Notifications\Context\Review::class
);

$app->bind(
	\App\Domain\Contract\Api\Upsource\Client::class,
	\App\Api\Upsource\Client::class
);

$app->bind(
	\App\Domain\Contract\Api\Upsource\Request\Factory::class,
	\App\Api\Upsource\Request\Factory::class
);

$app->bind(
	\App\Domain\Contract\Api\Upsource\Response\Factory::class,
	\App\Api\Upsource\Response\Factory::class
);

$app->bind(
	\App\Domain\Contract\Action\Telegram\ContextFactory::class,
	\App\Domain\Implementation\Action\Telegram\ContextFactory::class
);

$app->bind(
	App\Domain\Contract\Api\Upsource\Facade::class,
	App\Api\Upsource\Facade::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
