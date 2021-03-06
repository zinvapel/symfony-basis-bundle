<?php
declare(strict_types=1);

namespace Zinvapel\Basis\BasisBundle\Regular\Http\Flow\Context\Factory\DataExtractor;

use Symfony\Component\HttpFoundation\Request;

final class EmptyData implements DataExtractorInterface
{
    public function extract(Request $request): array
    {
        return [];
    }
}