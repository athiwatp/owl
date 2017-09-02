<?php

function timezones() {
    $timezones = [];

    foreach (timezone_identifiers_list() as $identifier) {
        $datetime = new \DateTime('now', new DateTimeZone($identifier));
        $timezones[] = [
            'sort' => str_replace(':', '', $datetime->format('P')),
            'identifier' => $identifier,
            'label' => '(UTC '.$datetime->format('P').') '.str_replace('_', ' ', implode(', ', explode('/', $identifier))),
        ];
    }

    usort($timezones, function($a, $b) {
        return $a['sort'] - $b['sort'] ?: strcmp($a['identifier'], $b['identifier']);
    });

    return $timezones;
}