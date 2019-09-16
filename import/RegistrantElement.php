<?php

$xml = simplexml_load_file('RangeMessage.xml');
foreach ($xml->RegistrationGroups->Group as $key => $group) {
    echo '            case \'' . $group->Prefix . '\':' . "\n";
    foreach ($group->Rules->Rule as $rule) {
        $rangeMin = strstr($rule->Range, '-', true);
        $rangeMax = substr(strstr($rule->Range, '-'), 1);
        echo '                $this->range(\'' . $rangeMin . '\', \'' . $rangeMax . '\', ' . $rule->Length . ', 2);' . "\n";
    }
    echo '                break;' . "\n";
}
