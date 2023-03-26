<?php

declare(strict_types = 1);

namespace Tests\unit;

use PHPUnit\Framework\TestCase;
use Statistics\Calculator\AveragePostLength;
use Statistics\Enum\StatsEnum;

/**
 * Class AveragePostLengthTest
 *
 * @package Tests\unit
 */
class AveragePostLengthTest extends TestCase
{
    /**
     * @test
     */
    public function testMaxPostLength(): void
    {
        $params = Utilities::createParameters(StatsEnum::AVERAGE_POST_LENGTH);

        $child = new AveragePostLength();
        $child->setParameters($params);

        $strJsonFileContents = file_get_contents('tests/data/social-posts-response.json');
        $responseData = json_decode($strJsonFileContents, true);

        $posts = array_map('Tests\unit\Utilities::hydrate', $responseData['data']['posts']);
        foreach ($posts as &$value) {
            $child->accumulateData($value);
        }
        $result = $child->calculate();
        
        $this->assertEquals(floatval('489'), $result->getValue());
    }

}
