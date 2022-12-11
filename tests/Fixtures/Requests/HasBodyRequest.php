<?php

declare(strict_types=1);

namespace Saloon\Tests\Fixtures\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\HasBody;
use Saloon\Tests\Fixtures\Connectors\TestConnector;

class HasBodyRequest extends Request
{
    use HasBody;

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
    protected string $connector = TestConnector::class;

    /**
     * Define the endpoint for the request.
     *
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return '/user';
    }

    /**
     * Define the mixed body
     *
     * @return mixed
     */
    public function defineBody(): mixed
    {
        return 'xml';
    }
}
