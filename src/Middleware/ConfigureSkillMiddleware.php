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

use Phlexa\Configuration\SkillConfiguration;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
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
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
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

        $this->skillConfiguration->setHost(
            $request->getUri()->getScheme() . '://' . $request->getUri()->getHost() . '/'
        );

        return $handler->handle($request);
    }
}
