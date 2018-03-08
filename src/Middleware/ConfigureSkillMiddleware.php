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

namespace PhlexaExpressive\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Phlexa\Configuration\SkillConfiguration;
use Zend\Expressive\Router\RouteResult;

/**
 * Class ConfigureSkillMiddleware
 *
 * @package PhlexaExpressive\Middleware
 */
class ConfigureSkillMiddleware implements MiddlewareInterface
{
    /** @var array */
    private $config;

    /** @var SkillConfiguration */
    private $skillConfiguration;

    /**
     * ConfigureSkillMiddleware constructor.
     *
     * @param array              $config
     * @param SkillConfiguration $skillConfiguration
     */
    public function __construct(array $config, SkillConfiguration $skillConfiguration)
    {
        $this->config             = $config;
        $this->skillConfiguration = $skillConfiguration;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        /** @var RouteResult $result */
        $result = $request->getAttribute(RouteResult::class);

        $matchedParams = $result->getMatchedParams();

        if (isset($matchedParams['skillName'])) {
            $skillName = $matchedParams['skillName'];

            $this->skillConfiguration->setName($skillName);

            if (isset($this->config['skills'])) {
                $this->skillConfiguration->setConfig($this->config['skills'][$skillName]);
            }
        }

        return $delegate->process($request);
    }
}
