<?php

class Censure
{
    public static function is_bad(?string $text): bool
    {
        return !\ObsceneCensorRus::isAllowed((string) $text);
    }

    public static function replace(?string $text): string
    {
        return \ObsceneCensorRus::getFiltered((string) $text);
    }
}
