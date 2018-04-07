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

use Interop\Container\ContainerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class LogAlexaRequestMiddlewareFactory
 *
 * @package PhlexaExpressive\Middleware
 */
class LogAlexaRequestMiddlewareFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null|null    $options
     *
     * @return LogAlexaRequestMiddleware
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');

        $flag = false;

        if (isset($config['phlexa'])) {
            if (isset($config['phlexa']['log_requests'])) {
                $flag = $config['phlexa']['log_requests'];
            }
        }

        return new LogAlexaRequestMiddleware($flag);
    }
}
