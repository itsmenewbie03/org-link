<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase;
    use HasDomains;
    protected $fillable = ['id','organization_name','name','email','plan'];

    // NOTE: you need to read the docs carefully
    public static function getCustomColumns(): array
    {
        return [
            'id',
            'organization_name',
            'name',
            'email',
            'plan',
        ];
    }
}
