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

use Exception;
use Phlexa\Application\AlexaApplicationInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Phlexa\Request\Exception\BadRequest;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class SkillAction
 *
 * @package PhlexaExpressive\Action
 */
class SkillAction implements ServerMiddlewareInterface
{
    /** @var AlexaApplicationInterface */
    private $alexaApplication;

    /**
     * SkillAction constructor.
     *
     * @param AlexaApplicationInterface $alexaApplication
     */
    public function __construct(AlexaApplicationInterface $alexaApplication)
    {
        $this->alexaApplication = $alexaApplication;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return mixed
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        try {
            $data = $this->alexaApplication->execute();

            return new JsonResponse($data, 200);
        } catch (BadRequest $e) {
            $data = ['error' => $e->getMessage()];

            return new JsonResponse($data, 400);
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];

            return new JsonResponse($data, 400);
        }
    }
}
