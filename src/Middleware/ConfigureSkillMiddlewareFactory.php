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
use Phlexa\Configuration\SkillConfiguration;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ConfigureSkillMiddlewareFactory
 *
 * @package PhlexaExpressive\Middleware
 */
class ConfigureSkillMiddlewareFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return ConfigureSkillMiddleware
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var array $config */
        $config = $container->get('config');

        /** @var SkillConfiguration $skillConfiguration */
        $skillConfiguration = $container->get(SkillConfiguration::class);

        return new ConfigureSkillMiddleware($config, $skillConfiguration);
    }
}
