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

namespace PhlexaExpressiveTest\Middleware;

use Fig\Http\Message\RequestMethodInterface;
use PhlexaExpressive\Middleware\LogAlexaRequestMiddleware;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class LogAlexaRequestMiddlewareTest
 *
 * @package PhlexaExpressiveTest\Middleware
 */
class LogAlexaRequestMiddlewareTest extends TestCase
{
    /**
     *
     */
    public function testWithGetRequest(): void
    {
        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);

        /** @var MethodProphecy $getMethod */
        $getMethod = $request->getMethod();
        $getMethod->shouldBeCalled()->willReturn(
            RequestMethodInterface::METHOD_GET
        );

        /** @var ResponseInterface|ObjectProphecy $response */
        $response = $this->prophesize(ResponseInterface::class)->reveal();

        /** @var RequestHandlerInterface|ObjectProphecy $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);
        $handler->handle($request->reveal())->willReturn($response);

        $middleware = new LogAlexaRequestMiddleware();

        $result = $middleware->process($request->reveal(), $handler->reveal());

        $this->assertSame($response, $result);
    }

    /**
     *
     */
    public function testWithPostRequest(): void
    {
        $data = [
            'version' => '1.0',
            'session' => [
                'new'         => true,
                'sessionId'   => 'sessionId',
                'application' => [
                    'applicationId' => 'applicationId',
                ],
                'user'        => [
                    'userId' => 'userId',
                ],
            ],
            'request' => [
                'type'      => 'LaunchRequest',
                'requestId' => 'requestId',
                'timestamp' => '2017-01-27T20:29:59Z',
                'locale'    => 'de-DE',
            ],
        ];

        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);

        /** @var MethodProphecy $getMethod */
        $getMethod = $request->getMethod();
        $getMethod->shouldBeCalled()->willReturn(
            RequestMethodInterface::METHOD_POST
        );

        /** @var MethodProphecy|StreamInterface $getHeaderMethod1 */
        $getHeaderMethod1 = $request->getHeaderLine('signaturecertchainurl');
        $getHeaderMethod1->shouldBeCalled()->willReturn(['foo']);

        /** @var ResponseInterface|ObjectProphecy $response */
        $response = $this->prophesize(ResponseInterface::class)->reveal();

        /** @var RequestHandlerInterface|ObjectProphecy $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);
        $handler->handle($request->reveal())->willReturn($response);

        $middleware = new LogAlexaRequestMiddleware();

        $result = $middleware->process($request->reveal(), $handler->reveal());

        $this->assertEquals($response, $result);
    }
}
