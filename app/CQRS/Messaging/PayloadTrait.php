<?php


namespace App\CQRS\Messaging;

trait PayloadTrait
{
    /**
     * @var array
     */
    protected $payload;

    public function __construct(array $payload = [])
    {
        $this->setPayload($payload);
    }

    public function payload(): array
    {
        return $this->payload;
    }

    protected function setPayload(array $payload)
    {
        $this->payload = $payload;
    }
}
