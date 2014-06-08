<?php

namespace OP3Nvoice\Bus;

use GuzzleHttp\Event\BeforeEvent;
use GuzzleHttp\Event\RequestEvents;
use GuzzleHttp\Event\SubscriberInterface;

class AuthenticatorSubscriber implements SubscriberInterface
{
    const AUTH_KEY = 'OP3Nvoice';

    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getEvents()
    {
        return ['before' => ['sign', RequestEvents::SIGN_REQUEST]];
    }

    public function sign(BeforeEvent $e)
    {
        if ($e->getRequest()->getConfig()['auth'] === self::AUTH_KEY) {
            $e->getRequest()->setHeader('Authorization', 'Bearer ' . $this->apiKey);
        }
    }
}
