<?php
declare(strict_types=1);

namespace App\Application\EventSubscriber;

use App\Infrastructure\Rpc\Exception\RpcExceptionInterface;
use App\Infrastructure\Rpc\Exception\RpcInternalErrorException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class RpcExceptionSubscriber implements EventSubscriberInterface
{
    private EventDispatcherInterface $eventDispatcher;
    private string $env;

    public function __construct(EventDispatcherInterface $eventDispatcher, string $env)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->env = $env;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', -63],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        if (!in_array('application/json', $event->getRequest()->getAcceptableContentTypes())) {
            return;
        }

        if (!$event->getThrowable() instanceof RpcExceptionInterface) {
            $event->setThrowable(new RpcInternalErrorException($event->getThrowable()));
        }

        /** @var RpcExceptionInterface $exception */
        $exception = $event->getThrowable();

        $error = [
            'code' => $exception->getErrorCode(),
            'message' => $exception->getErrorMessage()
        ];

        if (!empty($exception->getErrorData()) && $this->env !== 'prod') {
            $error['data'] = $exception->getErrorData();
        }

        $response = new JsonResponse(['error' => $error]);

        $event->allowCustomResponseCode();
        $event->setResponse($response);
    }
}
