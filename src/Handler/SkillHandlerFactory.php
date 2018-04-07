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

namespace PhlexaExpressive\Handler;

use Interop\Container\ContainerInterface;
use Phlexa\Application\AlexaApplication;
use Phlexa\Configuration\SkillConfiguration;
use Zend\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class SkillHandlerFactory
 *
 * @package PhlexaExpressive\Handler
 */
class SkillHandlerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null|null    $options
     *
     * @return SkillHandler
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): SkillHandler
    {
        /** @var SkillConfiguration $skillConfiguration */
        $skillConfiguration = $container->get(SkillConfiguration::class);

        /** @var AlexaApplication $alexaApplication */
        $alexaApplication = $container->get($skillConfiguration->getApplicationClass());

        return new SkillHandler($alexaApplication);
    }
}
