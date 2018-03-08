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

namespace PhlexaExpressive;

use Phlexa\Application\AlexaApplication;
use Phlexa\Configuration\SkillConfiguration;
use Phlexa\Request\AlexaRequest;
use Phlexa\Request\Certificate\CertificateLoader;
use Phlexa\Request\Certificate\CertificateValidator;
use Phlexa\Response\AlexaResponse;
use Phlexa\Session\SessionContainer;
use Phlexa\TextHelper\TextHelper;
use PhlexaExpressive\Action\HtmlPageAction;
use PhlexaExpressive\Action\HtmlPageActionFactory;
use PhlexaExpressive\Action\SkillAction;
use PhlexaExpressive\Action\SkillActionFactory;
use PhlexaExpressive\Application\AlexaApplicationFactory;
use PhlexaExpressive\Intent\IntentManager;
use PhlexaExpressive\Intent\IntentManagerFactory;
use PhlexaExpressive\Middleware\CheckApplicationMiddleware;
use PhlexaExpressive\Middleware\CheckApplicationMiddlewareFactory;
use PhlexaExpressive\Middleware\ConfigureSkillMiddleware;
use PhlexaExpressive\Middleware\ConfigureSkillMiddlewareFactory;
use PhlexaExpressive\Middleware\LogAlexaRequestMiddleware;
use PhlexaExpressive\Middleware\LogAlexaRequestMiddlewareFactory;
use PhlexaExpressive\Middleware\SetLocaleMiddleware;
use PhlexaExpressive\Middleware\SetLocaleMiddlewareFactory;
use PhlexaExpressive\Middleware\ValidateCertificateMiddleware;
use PhlexaExpressive\Middleware\ValidateCertificateMiddlewareFactory;
use PhlexaExpressive\Request\AlexaRequestFactory;
use PhlexaExpressive\Request\Certificate\CertificateLoaderFactory;
use PhlexaExpressive\Request\Certificate\CertificateValidatorFactory;
use PhlexaExpressive\Response\AlexaResponseFactory;
use PhlexaExpressive\Session\SessionContainerFactory;
use PhlexaExpressive\TextHelper\TextHelperFactory;
use Zend\ServiceManager\Factory\InvokableFactory;

/**
 * Class ConfigProvider
 *
 * @package Phlexa
 */
class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                'factories' => [
                    HtmlPageAction::class => HtmlPageActionFactory::class,
                    SkillAction::class    => SkillActionFactory::class,

                    AlexaApplication::class => AlexaApplicationFactory::class,
                    AlexaRequest::class     => AlexaRequestFactory::class,
                    AlexaResponse::class    => AlexaResponseFactory::class,

                    SessionContainer::class   => SessionContainerFactory::class,
                    SkillConfiguration::class => InvokableFactory::class,
                    TextHelper::class         => TextHelperFactory::class,
                    IntentManager::class      => IntentManagerFactory::class,

                    CertificateLoader::class    => CertificateLoaderFactory::class,
                    CertificateValidator::class => CertificateValidatorFactory::class,

                    CheckApplicationMiddleware::class    => CheckApplicationMiddlewareFactory::class,
                    ConfigureSkillMiddleware::class      => ConfigureSkillMiddlewareFactory::class,
                    LogAlexaRequestMiddleware::class     => LogAlexaRequestMiddlewareFactory::class,
                    SetLocaleMiddleware::class           => SetLocaleMiddlewareFactory::class,
                    ValidateCertificateMiddleware::class => ValidateCertificateMiddlewareFactory::class,
                ],
            ],
        ];
    }
}
