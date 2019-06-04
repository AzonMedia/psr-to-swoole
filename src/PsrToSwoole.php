<?php
declare(strict_types=1);


namespace Azonmedia\PsrToSwoole;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;

/**
 * Class PsrToSwoole
 * @package PsrToSwoole
 */
class PsrToSwoole
{

    /**
     * @param RequestInterface $PsrRequest
     * @param SwooleRequest|null $SwooleRequest
     * @return SwooleRequest
     */
    public static function ConvertRequest(RequestInterface $PsrRequest, ?SwooleRequest $SwooleRequest = NULL) : SwooleRequest
    {

        return $SwooleRequest;
    }

    /**
     * Converts a PSR-7 Response to a Swoole Server Response
     *
     * @param ResponseInterface $PsrResponse
     * @param SwooleResponse|null $SwooleResponse
     * @return SwooleResponse
     */
    public static function ConvertResponse(ResponseInterface $PsrResponse, ?SwooleResponse $SwooleResponse = NULL) : SwooleResponse
    {

        if (!$SwooleResponse) {
            $SwooleResponse = new SwooleResponse();
        }

        $SwooleResponse->status($PsrResponse->getStatusCode());

        $headers = $PsrResponse->getHeaders();
        foreach ($headers as $header_name => $header_arr) {
            if (!is_array($header_arr)) {
                $header_arr = [$header_arr];
            }

            foreach ($header_arr as $header_value) {
                $SwooleResponse->header($header_name, $header_value);
            }
        }

        $Body = $PsrResponse->getBody();
        $output = (string) $Body;
        if (!$output) {
            $output = $PsrResponse->getReasonPhrase();
        }
        $SwooleResponse->write($output);

        return $SwooleResponse;
    }
}