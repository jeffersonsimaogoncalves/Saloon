<?php declare(strict_types=1);

namespace Saloon\Helpers;

use Saloon\Http\SaloonRequest;
use Saloon\Http\SaloonConnector;
use Saloon\Exceptions\SaloonInvalidRequestException;

class RequestHelper
{
    /**
     * Call a request from a connector.
     *
     * @param SaloonConnector $connector
     * @param string $request
     * @param array $arguments
     * @return SaloonRequest
     * @throws SaloonInvalidRequestException
     * @throws \ReflectionException
     */
    public static function callFromConnector(SaloonConnector $connector, string $request, array $arguments = []): SaloonRequest
    {
        $isValidRequest = ReflectionHelper::isSubclassOf($request, SaloonRequest::class);

        if (! $isValidRequest) {
            throw new SaloonInvalidRequestException($request);
        }

        return (new $request(...$arguments))->setConnector($connector);
    }
}
