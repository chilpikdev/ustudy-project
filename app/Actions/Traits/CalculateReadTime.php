<?php

namespace App\Actions\Traits;

trait CalculateReadTime
{
    /**
     * Summary of calculateTime
     * @param string $content
     * @return int
     */
    public function calculateTime(string $content): int
    {
        //Clean content from new lines and html tags
        $cleanContent = strip_tags($content);
        $cleanContent = str_replace("\n", '', $cleanContent);
        $cleanContent = array_filter(explode(" ", $cleanContent));

        //Count word from clean content 
        $wordCount = count($cleanContent);

        //Count total chars
        $totalLength = array_sum(array_map('mb_strlen', $cleanContent));

        //If words is long, wpm will change
        if ($wordCount != 0) {
            // $wpm = 250; // statistic in the world, average speed word per min
            $wpm = 100;
            $avgWordLength = $totalLength / $wordCount;
            if ($avgWordLength > 6) {
                // $wpm = 200; // statistic in the world, decrease average wpm  
                $wpm = 50;
            }
            return ceil($wordCount / $wpm);

        } else {
            return 0;
        }
    }
}
