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

use Phlexa\Request\Certificate\CertificateValidator;
use Phlexa\Request\Exception\BadRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class ValidateCertificateMiddleware
 *
 * @package PhlexaExpressive\Middleware
 */
class ValidateCertificateMiddleware implements MiddlewareInterface
{
    /** @var CertificateValidator */
    private $certificateValidator;

    /**
     * ValidateCertificateMiddleware constructor.
     *
     * @param CertificateValidator $certificateValidator
     */
    public function __construct(CertificateValidator $certificateValidator = null)
    {
        $this->certificateValidator = $certificateValidator;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->certificateValidator) {
            try {
                $this->certificateValidator->validate();
            } catch (BadRequest $e) {
                $data = ['error' => $e->getMessage()];

                return new JsonResponse($data, 400);
            }
        }

        return $handler->handle($request);
    }
}
