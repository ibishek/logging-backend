<?php

namespace App\Contracts;

interface MacroContract
{
    /**
     * Bootstrap macros for the application.
     */
    public static function macros(): void;
}
