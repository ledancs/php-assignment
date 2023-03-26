<?php

declare(strict_types = 1);

namespace Tests\unit;

use PHPUnit\Framework\TestCase;
use Statistics\Calculator\AveragePostsPerUserPerMonth;
use Statistics\Enum\StatsEnum;

/**
 * Class AveragePostsPerUserPerMonthTest
 *
 * @package Tests\unit
 */
class AveragePostsPerUserPerMonthTest extends TestCase
{

    /**
     * @test
     */
    public function testAveragePostsPerUserPerMonth(): void
    {
        $params = Utilities::createParameters(
            StatsEnum::AVERAGE_POSTS_NUMBER_PER_USER_PER_MONTH
        );

        $child = new AveragePostsPerUserPerMonth();
        $child->setParameters($params);

        $strJsonFileContents = file_get_contents('tests/data/social-posts-response.json');
        $responseData = json_decode($strJsonFileContents, true);
        $posts = array_map('Tests\unit\Utilities::hydrate', $responseData['data']['posts']);
        foreach ($posts as &$value) {
            $child->accumulateData($value);
        }
        $result = $child->calculate();

        $this->assertEquals(floatval('1'), $result->getValue());
    }
}
