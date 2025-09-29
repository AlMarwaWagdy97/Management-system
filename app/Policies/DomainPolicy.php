<?php

namespace App\Policies;

use App\Models\Admin; // adjust if your User model differs
use App\Models\Domain;

class DomainPolicy
{
    // TODO: Replace with real permission checks, e.g., $user->can('domains.view')
    public function viewAny($user): bool { return true; }
    public function view($user, Domain $domain): bool { return true; }
    public function create($user): bool { return true; }
    public function update($user, Domain $domain): bool { return true; }
    public function delete($user, Domain $domain): bool { return true; }
    public function restore($user, Domain $domain): bool { return false; }
    public function forceDelete($user, Domain $domain): bool { return false; }
}
