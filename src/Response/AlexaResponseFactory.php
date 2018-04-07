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

namespace PhlexaExpressive\Response;

use Interop\Container\ContainerInterface;
use Phlexa\Request\AlexaRequest;
use Phlexa\Response\AlexaResponse;
use Phlexa\Session\SessionContainer;
use Zend\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class AlexaResponseFactory
 *
 * @package PhlexaExpressive\Response
 */
class AlexaResponseFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return AlexaResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var AlexaRequest $alexaRequest */
        $sessionContainer = $container->get(SessionContainer::class);

        $alexaResponse = new AlexaResponse();
        $alexaResponse->setSessionContainer($sessionContainer);

        return $alexaResponse;
    }
}
