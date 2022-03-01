<?php

declare(strict_types=1);

namespace App\Dto\Model;

use Doctrine\ODM\MongoDB\Aggregation\Aggregation;

class GroupedLinks
{
    private array $data;

    public function __construct(Aggregation $groupedLinksData)
    {
        $this->data = [];
        foreach ($groupedLinksData as $link) {
            foreach ($link as $item) {
                if (!empty($item['$id'])) {
                    $preparedData = $item['$id']->jsonSerialize();
                    $userId = $preparedData['$oid'];

                    $links = !empty($link['link']) ? $link['link'] : [];
                    $this->data[] = [
                      'userId' => $userId,
                      'links' => $links
                    ];
                }
            }
        }
    }

    public function getLinksData(): array
    {
        return $this->data;
    }
}
