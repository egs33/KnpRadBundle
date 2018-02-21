<?php

namespace Knp\RadBundle\EventListener;

use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class CsrfListener
{
    private $csrfProvider;
    private $intention;

    public function __construct(CsrfTokenManagerInterface $csrfProvider, $intention = 'link')
    {
        $this->csrfProvider = $csrfProvider;
        $this->intention    = $intention;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (false === $request->attributes->get('_check_csrf', false)) {
            return;
        }
        if (!$request->request->has('_link_token')) {
            throw new \InvalidArgumentException(
                'The CSRF token verification is activated but you did not send a token. Please submit a request with a valid csrf token.'
            );
        }

        $token = $request->request->get('_link_token');

        if (!$this->csrfProvider->isTokenValid(new CsrfToken($this->intention, $token))) {
            throw new \InvalidArgumentException(
                'The CSRF token is invalid. Please submit a request with a valid csrf token.'
            );
        }
    }
}
