<?php declare(strict_types=1);

namespace BabDev\Transifex\Exception;

/**
 * Exception defining missing API credentials.
 */
final class MissingCredentialsException extends \RuntimeException implements TransifexException
{
}
