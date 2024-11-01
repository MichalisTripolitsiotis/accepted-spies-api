<?php

namespace App\Infrastructure\Bus;

use App\Domain\Common\Contracts\BusInterface;
use Exception;
use Illuminate\Support\Facades\App;
use ReflectionClass;

class MessageBus implements BusInterface
{
    public function dispatch(object $message): mixed
    {
        $handlerClass = $this->resolveHandler($message);

        if (! class_exists($handlerClass)) {
            throw new Exception('No handler found for class '.get_class($message));
        }

        $handler = App::make($handlerClass);

        return $handler->handle($message);
    }

    private function resolveHandler(object $message): string
    {
        $reflection = new ReflectionClass($message);

        $namespace = $reflection->getNamespaceName();

        $baseName = str_replace(['Command', 'Query'], '', $reflection->getShortName());

        return "{$namespace}\\{$baseName}Handler";
    }
}
