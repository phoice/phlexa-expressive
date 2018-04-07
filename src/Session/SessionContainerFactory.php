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

namespace PhlexaExpressive\Session;

use Interop\Container\ContainerInterface;
use Phlexa\Configuration\SkillConfiguration;
use Phlexa\Request\AlexaRequest;
use Phlexa\Session\SessionContainer;
use Zend\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class SessionContainerFactory
 *
 * @package PhlexaExpressive\Session
 */
class SessionContainerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return SessionContainer
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var AlexaRequest $alexaRequest */
        $alexaRequest = $container->get(AlexaRequest::class);

        /** @var SkillConfiguration $skillConfiguration */
        $skillConfiguration = $container->get(SkillConfiguration::class);

        $sessionContainer = new SessionContainer($skillConfiguration->getSessionDefaults());
        $sessionContainer->initAttributes($alexaRequest);

        return $sessionContainer;
    }
}
