<?php declare(strict_types=1);

namespace BabDev\Transifex\Exception;

/**
 * Exception defining an invalid file type.
 */
final class InvalidFileTypeException extends \InvalidArgumentException implements TransifexException
{
}
