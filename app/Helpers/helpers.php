<?php

use Illuminate\Support\Facades\DB;

if (! function_exists('stupid_db_hack')) {
    function stupid_db_hack(string $db_name)
    {
        config(['database.connections.new.database' => $db_name]);
        DB::setDefaultConnection('new');
    }
}


if (! function_exists('end_stupid_db_hack')) {
    function end_stupid_db_hack()
    {
        DB::setDefaultConnection('mysql');
    }
}
