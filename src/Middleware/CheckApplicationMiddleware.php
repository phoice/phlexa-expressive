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

declare(strict_types=1);

namespace PhlexaExpressive\Middleware;

use Phlexa\Request\AlexaRequest;
use Phlexa\Request\Exception\BadRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

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
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     * @throws BadRequest
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->alexaRequest) {
            $this->alexaRequest->checkApplication($this->applicationId);
        }

        return $handler->handle($request);
    }
}
