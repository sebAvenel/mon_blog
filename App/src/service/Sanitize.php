<?php

namespace App\src\service;

class Sanitize
{
    /**
     * Sanitize string belonging to super globals variables
     *
     * @param string $type
     * @param string $input
     * @return string
     */
    public static function onString(string $type, string $input): ?string
    {
        return filter_input(constant('INPUT_' . strtoupper($type)), $input, FILTER_SANITIZE_STRING);
    }

    /**
     * Sanitize email belonging to super globals variables
     *
     * @param string $type
     * @param string $input
     * @return string
     */
    public static function onEmail(string $type, string $input): ?string
    {
        return filter_input(constant('INPUT_' . strtoupper($type)), $input, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Sanitize integer belonging to super globals variables
     *
     * @param string $type
     * @param string $input
     * @return string
     */
    public static function onInteger(string $type, string $input): ?string
    {
        return filter_input(constant('INPUT_' . strtoupper($type)), $input, FILTER_SANITIZE_NUMBER_INT);
    }
}
