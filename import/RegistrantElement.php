<?php

$xml = simplexml_load_file('RangeMessage.xml');
foreach ($xml->RegistrationGroups->Group as $key => $group)
{
    echo '            case \'' . $group->Prefix . '\':' . "\n";
    foreach ($group->Rules->Rule as $rule)
    {
        $rangeMin = strstr($rule->Range, '-', true);
        $rMin = str_pad((int)$rangeMin,7," ",STR_PAD_LEFT);
        $rangeMax = substr(strstr($rule->Range, '-'), 1);
        $rMax = str_pad((int)$rangeMax,7," ",STR_PAD_LEFT);
        echo '                $this->range(' . $rMin . ', ' . $rMax . ', ' . $rule->Length . ', 2);' . "\n";
    }
    echo '                break;' . "\n";
}
