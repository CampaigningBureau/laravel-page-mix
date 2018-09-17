<?php

if (!function_exists('pageMix')) {
    /**
     * @return string
     */
    function pageMix(): string
    {
        return app('page-mix')->getScript();
    }
}
