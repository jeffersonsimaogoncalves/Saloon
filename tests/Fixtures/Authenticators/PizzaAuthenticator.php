<?php declare(strict_types=1);

namespace Saloon\Tests\Fixtures\Authenticators;

use Saloon\Contracts\Authenticator;
use Saloon\Http\PendingSaloonRequest;

class PizzaAuthenticator implements Authenticator
{
    /**
     * @param string $pizza
     * @param string $drink
     */
    public function __construct(
        public string $pizza,
        public string $drink,
    ) {
        //
    }

    /**
     * Set the pending request.
     *
     * @param PendingSaloonRequest $pendingRequest
     * @return void
     */
    public function set(PendingSaloonRequest $pendingRequest): void
    {
        $pendingRequest->headers()->add('X-Pizza', $this->pizza);
        $pendingRequest->headers()->add('X-Drink', $this->drink);

        $pendingRequest->config()->add('debug', true);
    }
}
