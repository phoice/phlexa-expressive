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

namespace PhlexaExpressive\Intent;

use Interop\Container\ContainerInterface;
use Phlexa\Configuration\SkillConfiguration;
use Phlexa\Configuration\SkillConfigurationInterface;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class IntentManagerFactory
 *
 * @package PhlexaExpressive\Intent
 */
class IntentManagerFactory implements FactoryInterface
{
    /**
     * @var string
     */
    protected $configKey = null;

    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return IntentManager
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var SkillConfigurationInterface $skillConfiguration */
        $skillConfiguration = $container->get(SkillConfiguration::class);

        $intentConfig = $skillConfiguration->getIntents();

        $manager = new IntentManager($container);

        if (!empty($intentConfig)) {
            (new Config($intentConfig))->configureServiceManager($manager);
        }

        return $manager;
    }
}
