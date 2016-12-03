<?php

    function firstDayOf($period, DateTime $date = null)
    {
        $period = strtolower($period);
        $validPeriods = array('week');
    
        if ( ! in_array($period, $validPeriods))
            throw new InvalidArgumentException('Period must be one of: ' . implode(', ', $validPeriods));
    
        $newDate = ($date === null) ? new DateTime() : clone $date;
    
        switch ($period) {
            case 'week':
                $newDate->modify(($newDate->format('w') === '0') ? 'monday last week' : 'monday this week');
                break;
        }
    
        return $newDate->format('d.m.Y');
    }


    function lastDayOf($period, DateTime $date = null)
    {
        $period = strtolower($period);
        $validPeriods = array('week');
    
        if ( ! in_array($period, $validPeriods))
            throw new InvalidArgumentException('Period must be one of: ' . implode(', ', $validPeriods));
    
        $newDate = ($date === null) ? new DateTime() : clone $date;
    
        switch ($period)
        {
            case 'week':
                $newDate->modify(($newDate->format('w') === '0') ? 'now' : 'sunday this week');
                break;
        }
    
        return $newDate->format('d.m.Y');
    }