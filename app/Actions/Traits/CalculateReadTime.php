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
        $cleancontent = strip_tags($content);
        $cleancontent = str_replace("\n", '', $cleancontent);
        $cleancontent = array_filter(explode(" ", $cleancontent));

        //Count word from clean content 
        $wordcount = count($cleancontent);

        //Count total chars
        $totalLength = array_sum(array_map('mb_strlen', $cleancontent));

        //If words is long, wpm will change
        if ($wordcount != 0) {
            // $wpm = 250; // statistic in the world, average speed word per min
            $wpm = 100;
            $avgWordLength = $totalLength / $wordcount;
            if ($avgWordLength > 6) {
                // $wpm = 200; // statistic in the world, decrease average wpm  
                $wpm = 50;
            }
            return ceil($wordcount / $wpm);

        } else {
            return 0;
        }
    }
}
