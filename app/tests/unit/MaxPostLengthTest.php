<?php

declare(strict_types = 1);

namespace Tests\unit;

use PHPUnit\Framework\TestCase;
use Statistics\Calculator\MaxPostLength;
use Statistics\Enum\StatsEnum;

/**
 * Class MaxPostLengthTest
 *
 * @package Tests\unit
 */
class MaxPostLengthTest extends TestCase
{
    /**
     * @test
     */
    public function testMaxPostLength(): void
    {
        $params = Utilities::createParameters(StatsEnum::MAX_POST_LENGTH);

        $child = new MaxPostLength();
        $child->setParameters($params);

        $strJsonFileContents = file_get_contents('tests/data/social-posts-response.json');
        $responseData = json_decode($strJsonFileContents, true);

        $posts = array_map('Tests\unit\Utilities::hydrate', $responseData['data']['posts']);
        foreach ($posts as &$value) {
            $child->accumulateData($value);
        }
        $result = $child->calculate();

        $this->assertEquals(floatval('638'), $result->getValue());
    }

}
