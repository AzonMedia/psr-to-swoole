<?php
declare(strict_types=1);


namespace Azonmedia\PsrToSwoole;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class PsrToSwoole
 * @package PsrToSwoole
 */
class PsrToSwoole
{

    /**
     * @param RequestInterface $psr_request
     * @param \Swoole\Http\Request|null $swoole_request
     * @return \Swoole\Http\Request
     */
    public static function ConvertRequest(RequestInterface $PsrRequest, ?\Swoole\Http\Request $SwooleResponse = NULL) : \Swoole\Http\Request
    {

    }

    /**
     * @param ResponseInterface $PsrRequest
     * @param \Swoole\Http\Request|null $SwooleResponse
     * @return \Swoole\Http\Request
     */
    public static function ConvertResponse(ResponseInterface $PsrRequest, ?\Swoole\Http\Response $SwooleResponse = NULL) : \Swoole\Http\Response
    {

        if (!$SwooleResponse) {
            $SwooleResponse = new \Swoole\Http\Response();
        }

        $SwooleResponse->status($PsrRequest->getStatusCode());

        $headers = $PsrRequest->getHeaders();
        foreach ($headers as $header_name => $header_value) {
            $SwooleResponse->header($header_name, $header_value);
        }

        $Body = $PsrRequest->getBody();
        $output = (string) $Body;
        if (!$output) {
            $output = $PsrRequest->getReasonPhrase();
        }
        $SwooleResponse->write($output);

        return $SwooleResponse;
    }
}