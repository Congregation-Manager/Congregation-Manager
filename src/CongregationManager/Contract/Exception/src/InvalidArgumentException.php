<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Exception;

use InvalidArgumentException as CoreInvalidArgumentException;

class InvalidArgumentException extends CoreInvalidArgumentException implements ExceptionInterface
{
}
