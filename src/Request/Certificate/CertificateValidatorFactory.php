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

namespace PhlexaExpressive\Request\Certificate;

use Interop\Container\ContainerInterface;
use Phlexa\Request\AlexaRequest;
use Phlexa\Request\Certificate\CertificateLoader;
use Phlexa\Request\Certificate\CertificateValidator;
use Phlexa\Request\Certificate\CertificateValidatorFactory as PhlexaCertificateValidatorFactory;
use Zend\Diactoros\ServerRequestFactory;
use Zend\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

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
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serverRequest = ServerRequestFactory::fromGlobals();

        $certificateValidatorFactory = new PhlexaCertificateValidatorFactory();

        $alexaRequest      = $container->get(AlexaRequest::class);
        $certificateLoader = $container->get(CertificateLoader::class);

        $config = $container->get('config');

        $flag = true;

        if (isset($config['phlexa'])) {
            if (isset($config['phlexa']['validate_signature'])) {
                $flag = $config['phlexa']['validate_signature'];
            }
        }

        /** @var CertificateValidator $certificateValidator */
        $certificateValidator = $certificateValidatorFactory->create(
            $serverRequest->getHeader('signaturecertchainurl')[0] ?? '',
            $serverRequest->getHeader('signature')[0] ?? '',
            $alexaRequest,
            $certificateLoader,
            $flag
        );

        return $certificateValidator;
    }
}
