<?php

declare(strict_types = 1);

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

class AveragePostsPerUserPerMonth extends AbstractCalculator
{

    protected const UNITS = 'posts';

    /**
     * @var int
     */
    private $postCount = 0;

    /**
     * @var array
     */
    private $users = [];
    /**
     * @var array
     */
    private $months = [];

    /**
     * @param SocialPostTo $postTo
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        $month = $postTo->getDate()->format('M, Y');
        $user = $postTo->getAuthorId();
        $this->postCount++;
        if (!in_array($month, $this->months)){
            $this->months[] = $month;
        }
        if(!in_array($user, $this->users)){
            $this->users[] = $user;
        }
    }

    /**
     * @return StatisticsTo
     */
    protected function doCalculate(): StatisticsTo
    {
        $value = $this->postCount > 0
            ? $this->postCount / count($this->users) / count($this->months)
            : 0;

        return (new StatisticsTo())->setValue(round($value,2));
    }
}
