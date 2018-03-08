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

use Interop\Container\ContainerInterface;
use Phlexa\Request\AlexaRequest;
use Phlexa\Request\Certificate\CertificateValidator;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ValidateCertificateMiddlewareFactory
 *
 * @package PhlexaExpressive\Middleware
 */
class ValidateCertificateMiddlewareFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return ValidateCertificateMiddleware
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        if ($container->get(AlexaRequest::class)) {
            $certificateValidator = $container->get(CertificateValidator::class);
        } else {
            $certificateValidator = null;
        }

        return new ValidateCertificateMiddleware($certificateValidator);
    }
}
