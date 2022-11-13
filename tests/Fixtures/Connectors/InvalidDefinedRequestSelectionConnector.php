<?php declare(strict_types=1);

namespace Saloon\Tests\Fixtures\Connectors;

use Sammyjo20\MissingClass;
use Saloon\Http\SaloonConnector;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Tests\Fixtures\Requests\UserRequest;
use Saloon\Tests\Fixtures\Requests\ErrorRequest;

/**
 * @method getMyUser($userId, $groupId): UserRequest
 * @method errorRequest(...$args): UserRequest
 */
class InvalidDefinedRequestSelectionConnector extends SaloonConnector
{
    use AcceptsJson;

    /**
     * Manually specify requests that the connector will register as methods
     *
     * @var array|string[]
     */
    protected array $requests = [
        'missing_request' => MissingClass::class, // Invalid Class
        'test_connector' => TestConnector::class, // Invalid Connector
    ];

    /**
     * Define the base url of the api.
     *
     * @return string
     */
    public function defineBaseUrl(): string
    {
        return apiUrl();
    }

    /**
     * Define the base headers that will be applied in every request.
     *
     * @return string[]
     */
    public function defaultHeaders(): array
    {
        return [];
    }

    public function __construct(public ?string $apiKey = null)
    {
        //
    }
}
