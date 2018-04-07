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
use Phlexa\TextHelper\TextHelperInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class SetLocaleMiddleware
 *
 * @package PhlexaExpressive\Middleware
 */
class SetLocaleMiddleware implements MiddlewareInterface
{
    /** @var TextHelperInterface */
    private $textHelper;

    /** @var  AlexaRequest */
    private $alexaRequest;

    /**
     * SetLocaleMiddleware constructor.
     *
     * @param TextHelperInterface $textHelper
     * @param AlexaRequest        $alexaRequest
     */
    public function __construct(TextHelperInterface $textHelper = null, AlexaRequest $alexaRequest = null)
    {
        $this->textHelper   = $textHelper;
        $this->alexaRequest = $alexaRequest;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->alexaRequest) {
            $locale = $this->alexaRequest->getRequest()->getLocale();

            $this->textHelper->setLocale($locale);
        }

        return $handler->handle($request);
    }
}
