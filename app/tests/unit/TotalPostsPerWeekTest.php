<?php

declare(strict_types = 1);

namespace Tests\unit;

use PHPUnit\Framework\TestCase;
use Statistics\Calculator\TotalPostsPerWeek;
use Statistics\Enum\StatsEnum;

/**
 * Class TotalPostsPerWeekTest
 *
 * @package Tests\unit
 */
class TotalPostsPerWeekTest extends TestCase
{
    /**
     * @test
     */
    public function testMaxPostLength(): void
    {
        $params = Utilities::createParameters(StatsEnum::TOTAL_POSTS_PER_WEEK);

        $child = new TotalPostsPerWeek();
        $child->setParameters($params);

        $strJsonFileContents = file_get_contents('tests/data/social-posts-response.json');
        $responseData = json_decode($strJsonFileContents, true);

        $posts = array_map('Tests\unit\Utilities::hydrate', $responseData['data']['posts']);
        foreach ($posts as &$value) {
            $child->accumulateData($value);
        }
        $result = $child->calculate();

        $first = $result->getChildren()[0];

        $this->assertCount(1, $result->getChildren());
        $this->assertEquals(floatval('3'), $first->getValue());
        $this->assertEquals('Week 32, 2018', $first->getSplitPeriod());
    }

}
