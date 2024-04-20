{{-- TODO: pass a url var here as so we don't have to compose it here --}}
{{-- TODO: pass the random passord here --}}
{{-- NOTE: we just focus on building the template now --}}
<x-mail::message>
# Hello {{ $tenant->name ?? 'Deez Nuts' }}, Welcome to OrgLink
Thanks for your subscription. We're excited to have you on board!
<br>
<br>
# Your Account Details
- **Domain:**
[{{ $tenant->id ?? 'deeznuts' }}.localhost:8000](http://{{ $tenant->id ?? 'deeznuts' }}.localhost:8000)
- **Organization Name:** {{ $tenant->organization_name ?? 'Deez Nuts' }}
- **Name:** {{ $tenant->name ?? 'Deez Nuts' }}
- **Email:** {{ $tenant->email ?? 'Deez Nuts' }}
- **Password:** {{ $password ?? 'Deez Nuts' }}
- **Plan:** {{ $tenant->plan ? ucfirst($tenant->plan) : 'Deez Nuts' }}
<x-mail::button :url="'http://itsmenewbie03.is-a.dev'">
Get Started
</x-mail::button>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
