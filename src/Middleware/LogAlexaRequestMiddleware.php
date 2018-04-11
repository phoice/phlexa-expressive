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

use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class InjectAlexaRequestMiddleware
 *
 * @package PhlexaExpressive\Middleware
 */
class LogAlexaRequestMiddleware implements MiddlewareInterface
{
    /** @var bool */
    private $logFlag;

    /**
     * InjectAlexaRequestMiddleware constructor.
     *
     * @param bool $logFlag
     */
    public function __construct(bool $logFlag = false)
    {
        $this->logFlag = $logFlag;
    }

    public function process(Request $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getMethod() == RequestMethodInterface::METHOD_POST
            && $request->getHeaderLine('signaturecertchainurl')
        ) {
            if ($this->logFlag) {
                $microtime = explode('.', (string) microtime(true));

                $random = date('Y-m-d-H-i-s-') . $microtime[1];

                file_put_contents(
                    PROJECT_ROOT . '/data/last-request-' . $random . '.json',
                    $request->getBody()->getContents()
                );

                file_put_contents(
                    PROJECT_ROOT . '/data/last-headers-' . $random . '.json',
                    json_encode($request->getHeaders(), JSON_PRETTY_PRINT)
                );
            }
        }

        return $handler->handle($request);
    }
}
