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
use Phlexa\Request\Certificate\CertificateValidator;

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

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if ($this->certificateValidator) {
            $this->certificateValidator->validate();
        }

        return $delegate->process($request);
    }
}
