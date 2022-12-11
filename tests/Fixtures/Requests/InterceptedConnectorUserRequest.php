<?php

declare(strict_types=1);

namespace Saloon\Tests\Fixtures\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Tests\Fixtures\Connectors\InterceptedConnector;

class InterceptedConnectorUserRequest extends Request
{
    /**
     * Define the method that the request will use.
     *
     * @var string|null
     */
    protected Method $method = Method::GET;

    /**
     * The connector.
     *
     * @var string|null
     */
    protected string $connector = InterceptedConnector::class;

    /**
     * Define the endpoint for the request.
     *
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return '/user';
    }

    public function boot(Request $request): void
    {
        $this->addRequestInterceptor(function (Request $request) {
            $request->addHeader('X-Connector-Name', 'Interceptor');

            return $request;
        });
    }
}
