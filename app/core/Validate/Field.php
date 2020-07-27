<?php

declare(strict_types=1);

use Core\Validate;

interface Field 
{

    public function validate(): bool;

}