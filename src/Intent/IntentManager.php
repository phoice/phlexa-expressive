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

namespace PhlexaExpressive\Intent;

use Phlexa\Intent\AudioPlayer\PlaybackFinishedIntent;
use Phlexa\Intent\AudioPlayer\PlaybackNearlyFinishedIntent;
use Phlexa\Intent\AudioPlayer\PlaybackStartedIntent;
use Phlexa\Intent\AudioPlayer\PlaybackStoppedIntent;
use Phlexa\Intent\CancelIntent;
use Phlexa\Intent\HelpIntent;
use Phlexa\Intent\IntentInterface;
use Phlexa\Intent\LaunchIntent;
use Phlexa\Intent\StopIntent;
use Phlexa\Intent\System\ExceptionEncountered;
use Phlexa\Request\RequestType\LaunchRequestType;
use Phlexa\Request\RequestType\SessionEndedRequestType;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception\InvalidServiceException;

/**
 * Class IntentManager
 *
 * @package PhlexaExpressive\Intent
 */
class IntentManager extends AbstractPluginManager
{
    /**
     * @var array
     */
    protected $aliases
        = [
            LaunchRequestType::NAME            => LaunchIntent::class,
            SessionEndedRequestType::NAME      => StopIntent::class,
            HelpIntent::NAME                   => HelpIntent::class,
            StopIntent::NAME                   => StopIntent::class,
            CancelIntent::NAME                 => CancelIntent::class,
            PlaybackFinishedIntent::NAME       => PlaybackFinishedIntent::class,
            PlaybackNearlyFinishedIntent::NAME => PlaybackNearlyFinishedIntent::class,
            PlaybackStartedIntent::NAME        => PlaybackStartedIntent::class,
            PlaybackStoppedIntent::NAME        => PlaybackStoppedIntent::class,
            ExceptionEncountered::NAME         => ExceptionEncountered::class,
        ];

    protected $factories
        = [
            LaunchIntent::class                 => AbstractIntentFactory::class,
            HelpIntent::class                   => AbstractIntentFactory::class,
            StopIntent::class                   => AbstractIntentFactory::class,
            CancelIntent::class                 => AbstractIntentFactory::class,
            PlaybackFinishedIntent::class       => AbstractIntentFactory::class,
            PlaybackNearlyFinishedIntent::class => AbstractIntentFactory::class,
            PlaybackStartedIntent::class        => AbstractIntentFactory::class,
            PlaybackStoppedIntent::class        => AbstractIntentFactory::class,
            ExceptionEncountered::class         => AbstractIntentFactory::class,
        ];

    /**
     * Validate the plugin is of the expected type (v3).
     *
     * Validates against callables and HelperInterface implementations.
     *
     * @param mixed $instance
     *
     * @throws InvalidServiceException
     */
    public function validate($instance)
    {
        if (!is_callable($instance) && !$instance instanceof IntentInterface) {
            throw new InvalidServiceException(
                sprintf(
                    '%s can only create instances of %s and/or callables; %s is invalid',
                    get_class($this),
                    IntentInterface::class,
                    (is_object($instance) ? get_class($instance) : gettype($instance))
                )
            );
        }
    }
}
