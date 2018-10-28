<?php declare(strict_types=1);

namespace BabDev\Transifex;

use Psr\Http\Message\ResponseInterface;

/**
 * Transifex API Formats class.
 *
 * @link http://docs.transifex.com/api/formats/
 */
class Formats extends TransifexObject
{
    /**
     * Get the supported file formats.
     *
     * @return ResponseInterface
     */
    public function getFormats(): ResponseInterface
    {
        return $this->client->request('GET', $this->createUri('/api/2/formats'), ['auth' => $this->getAuthData()]);
    }
}
