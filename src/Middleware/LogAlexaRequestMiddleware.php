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

use Fig\Http\Message\RequestMethodInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class InjectAlexaRequestMiddleware
 *
 * @package PhlexaExpressive\Middleware
 */
class LogAlexaRequestMiddleware implements MiddlewareInterface
{
    /** @var bool */
    private $logFlag = false;

    /**
     * InjectAlexaRequestMiddleware constructor.
     *
     * @param bool $logFlag
     */
    public function __construct(bool $logFlag = false)
    {
        $this->logFlag = $logFlag;
    }

    /**
     * @param Request           $request
     * @param DelegateInterface $delegate
     *
     * @return ResponseInterface
     */
    public function process(Request $request, DelegateInterface $delegate)
    {
        if ($request->getMethod() == RequestMethodInterface::METHOD_POST
            && $request->getHeaderLine('signaturecertchainurl')
        ) {
            if ($this->logFlag) {
                $microtime = explode('.', microtime(true));

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

        return $delegate->process($request);
    }
}
