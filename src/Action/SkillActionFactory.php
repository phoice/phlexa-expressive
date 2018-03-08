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

namespace PhlexaExpressive\Action;

use Interop\Container\ContainerInterface;
use Phlexa\Application\AlexaApplication;
use Phlexa\Configuration\SkillConfiguration;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class SkillActionFactory
 *
 * @package PhlexaExpressive\Action
 */
class SkillActionFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null|null    $options
     *
     * @return SkillAction
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): SkillAction
    {
        /** @var SkillConfiguration $skillConfiguration */
        $skillConfiguration = $container->get(SkillConfiguration::class);

        /** @var AlexaApplication $alexaApplication */
        $alexaApplication = $container->get($skillConfiguration->getApplicationClass());

        return new SkillAction($alexaApplication);
    }
}
