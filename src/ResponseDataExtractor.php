<?php

namespace Dykyi;

use Psr\Http\Message\ResponseInterface;
use Dykyi\Exception\ClientException;

/**
 * Class ResponseDataExtractor
 */
class ResponseDataExtractor implements ResponseDataInterface
{
    /**
     * @param ResponseInterface $response
     *
     * @throws \RuntimeException
     *
     * @return \stdClass
     */
    public function extract(ResponseInterface $response)
    {
        $responseBody = (string)$response->getBody()->getContents();
        $rawDecoded   = json_decode($responseBody);
        if ($rawDecoded === null) {
            $oneLineResponseBody = str_replace("\n", '\n', $responseBody);
            throw new ClientException(sprintf("Can't decode response: %s", $oneLineResponseBody));
        }

        return $rawDecoded;
    }
}