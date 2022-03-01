<?php
declare(strict_types=1);

namespace App\Service;

class ShortLink
{
    public function generate(int $length = 5): string
    {
        return dechex(mt_rand(0, (1 << ($length << 2)) - 1));
    }
}
