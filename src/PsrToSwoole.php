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
    public static function ConvertRequest(RequestInterface $psr_request, ?\Swoole\Http\Request $swoole_request = NULL) : \Swoole\Http\Request
    {

    }

    /**
     * @param ResponseInterface $psr_response
     * @param \Swoole\Http\Request|null $swoole_response
     * @return \Swoole\Http\Request
     */
    public static function ConvertResponse(ResponseInterface $psr_response, ?\Swoole\Http\Response $swoole_response = NULL) : \Swoole\Http\Response
    {

        if (!$swoole_response) {
            $swoole_response = new \Swoole\Http\Response();
        }

        $headers = $psr_response->getHeaders();
        foreach ($headers as $header_name => $header_value) {
            $swoole_response->header($header_name, $header_value);
        }

        $body = $psr_response->getBody();
        $output = (string) $body;
        $swoole_response->write($output);

        return $swoole_response;
    }
}