<?php
/**
 * Build voice applications for Amazon Alexa with phlexa, PHP and Zend\Expressive
 *
 * @author     Ralf Eggert <ralf@travello.audio>
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/phoice/phlexa-expressive
 * @link       https://www.phoice.tech/
 * @link       https://www.travello.audio/
 */

namespace PhlexaExpressive\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Phlexa\Request\AlexaRequest;

/**
 * Class CheckApplicationMiddleware
 *
 * @package PhlexaExpressive\Middleware
 */
class CheckApplicationMiddleware implements MiddlewareInterface
{
    /** @var string */
    private $applicationId;

    /** @var AlexaRequest */
    private $alexaRequest;

    /**
     * CheckApplicationMiddleware constructor.
     *
     * @param string       $applicationId
     * @param AlexaRequest $alexaRequest
     */
    public function __construct($applicationId = null, AlexaRequest $alexaRequest = null)
    {
        $this->applicationId = $applicationId;
        $this->alexaRequest  = $alexaRequest;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if ($this->alexaRequest) {
            $this->alexaRequest->checkApplication($this->applicationId);
        }

        return $delegate->process($request);
    }
}
