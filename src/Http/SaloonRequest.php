<?php declare(strict_types=1);

namespace Saloon\Http;

use Saloon\Traits\Bootable;
use Saloon\Contracts\Sender;
use GuzzleHttp\Promise\PromiseInterface;
use Saloon\Contracts\MockClient;
use Saloon\Traits\HasMockClient;
use Saloon\Contracts\SaloonResponse;
use Saloon\Traits\HasCustomResponses;
use Saloon\Traits\Request\BuildsUrls;
use Saloon\Traits\Request\HasConnector;
use Saloon\Traits\Auth\AuthenticatesRequests;
use Saloon\Traits\Request\CastDtoFromResponse;
use Saloon\Exceptions\PendingSaloonRequestException;
use Saloon\Exceptions\SaloonInvalidConnectorException;
use Saloon\Traits\RequestProperties\HasRequestProperties;
use Saloon\Exceptions\SaloonInvalidResponseClassException;

abstract class SaloonRequest
{
    use AuthenticatesRequests;
    use HasRequestProperties;
    use CastDtoFromResponse;
    use HasCustomResponses;
    use HasMockClient;
    use HasConnector;
    use BuildsUrls;
    use Bootable;

    /**
     * Define the connector.
     *
     * @var string
     */
    protected string $connector = '';

    /**
     * Define the method.
     *
     * @var string
     */
    protected string $method = '';

    /**
     * Define the endpoint for the request.
     *
     * @return string
     */
    abstract protected function defineEndpoint(): string;

    /**
     * Create a pending request
     *
     * @param MockClient|null $mockClient
     * @return PendingSaloonRequest
     * @throws PendingSaloonRequestException
     * @throws SaloonInvalidConnectorException
     * @throws SaloonInvalidResponseClassException
     * @throws \ReflectionException
     */
    public function createPendingRequest(MockClient $mockClient = null): PendingSaloonRequest
    {
        return new PendingSaloonRequest($this, $mockClient);
    }

    /**
     * Access the HTTP sender
     *
     * @return Sender
     * @throws SaloonInvalidConnectorException
     */
    public function sender(): Sender
    {
        return $this->connector()->sender();
    }

    /**
     * Send a request
     *
     * @param MockClient|null $mockClient
     * @param bool $asynchronous
     * @return SaloonResponse|PromiseInterface
     * @throws SaloonInvalidConnectorException
     * @throws \ReflectionException
     * @throws \Sammyjo20\Saloon\Exceptions\SaloonException
     */
    public function send(MockClient $mockClient = null, bool $asynchronous = false): SaloonResponse|PromiseInterface
    {
        return $this->connector()->send($this, $mockClient, $asynchronous);
    }

    /**
     * Send a request asynchronously
     *
     * @param MockClient|null $mockClient
     * @return PromiseInterface
     * @throws SaloonInvalidConnectorException
     * @throws \ReflectionException
     * @throws \Sammyjo20\Saloon\Exceptions\SaloonException
     */
    public function sendAsync(MockClient $mockClient = null): PromiseInterface
    {
        return $this->send($mockClient, true);
    }

    /**
     * Instantiate a new class with the arguments.
     *
     * @param ...$arguments
     * @return static
     */
    public static function make(...$arguments): static
    {
        return new static(...$arguments);
    }

    /**
     * Get the method of the request.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}
