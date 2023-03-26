<?php

namespace Tests\unit;

use DateTime;
use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\ParamsTo;
use Statistics\Enum\StatsEnum;

class Utilities {
    public static function hydrateDate(?string $date): ?DateTime
    {
        $date = DateTime::createFromFormat(
            DateTime::ATOM,
            $date
        );

        return false === $date ? null : $date;
    }

    public static function hydrate(array $postData): SocialPostTo
    {
        $dto = (new SocialPostTo())
            ->setId($postData['id'] ?? null)
            ->setAuthorName($postData['from_name'] ?? null)
            ->setAuthorId($postData['from_id'] ?? null)
            ->setText($postData['message'] ?? null)
            ->setType($postData['type'] ?? null)
            ->setDate(Utilities::hydrateDate($postData['created_time'] ?? null));

        return $dto;
    }

    public static function createParameters(string $statName): ParamsTo {
        $startDate = DateTime::createFromFormat('Y-m-d', '2018-08-10');
        $endDate   = DateTime::createFromFormat('Y-m-d', '2018-08-11');

        $params = (new ParamsTo())
            ->setStatName($statName)
            ->setStartDate($startDate)
            ->setEndDate($endDate);

        return $params;
    }
}
