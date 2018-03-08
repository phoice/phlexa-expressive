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

namespace PhlexaExpressive\Request\Certificate;

use Interop\Container\ContainerInterface;
use Phlexa\Request\AlexaRequest;
use Phlexa\Request\Certificate\CertificateLoader;
use Phlexa\Request\Certificate\CertificateValidator;
use Phlexa\Request\Certificate\CertificateValidatorFactory as PhlexaCertificateValidatorFactory;
use Zend\Diactoros\ServerRequestFactory;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class CertificateValidatorFactory
 *
 * @package PhlexaExpressive\Request\Certificate
 */
class CertificateValidatorFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return CertificateValidator
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serverRequest = ServerRequestFactory::fromGlobals();

        $certificateValidatorFactory = new PhlexaCertificateValidatorFactory();

        $alexaRequest      = $container->get(AlexaRequest::class);
        $certificateLoader = $container->get(CertificateLoader::class);

        $config = $container->get('config');

        $flag = true;

        if (isset($config['travello_alexa'])) {
            if (isset($config['travello_alexa']['validate_signature'])) {
                $flag = $config['travello_alexa']['validate_signature'];
            }
        }

        /** @var CertificateValidator $certificateValidator */
        $certificateValidator = $certificateValidatorFactory->create(
            $serverRequest->getHeader('signaturecertchainurl')[0],
            $serverRequest->getHeader('signature')[0],
            $alexaRequest,
            $certificateLoader,
            $flag
        );

        return $certificateValidator;
    }
}
