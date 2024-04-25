<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Models\Tenant;

if (! function_exists('stupid_db_hack')) {
    function stupid_db_hack(string $db_name)
    {
        config(['database.connections.new.database' => $db_name]);
        DB::setDefaultConnection('new');
    }
}

// TODO: migrate all stupid hacks to the smarter one
if (! function_exists('smart_db_hack')) {
    function smart_db_hack()
    {
        $domain = Request::getHost();
        $db_name = explode('.', $domain)[0];
        $tenant = Tenant::find($db_name);
        config(['database.connections.new.database' => $tenant->tenancy_db_name]);
        DB::setDefaultConnection('new');
    }
}

if (! function_exists('end_stupid_db_hack')) {
    function end_stupid_db_hack()
    {
        DB::setDefaultConnection('mysql');
    }
}
