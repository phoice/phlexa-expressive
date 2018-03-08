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
use Phlexa\Request\Certificate\CertificateLoader;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class CertificateLoaderFactory
 *
 * @package Phlexa\Request\Certificate
 */
class CertificateLoaderFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null|null    $options
     *
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');

        $cacheFlag = false;
        $cacheDir  = null;

        if (isset($config['travello_alexa'])) {
            if (isset($config['travello_alexa']['cache_flag'])) {
                $cacheFlag = $config['travello_alexa']['cache_flag'];
            }
            if (isset($config['travello_alexa']['cache_dir'])) {
                $cacheDir = $config['travello_alexa']['cache_dir'];
            }
        }

        return new CertificateLoader($cacheFlag, $cacheDir);
    }
}
