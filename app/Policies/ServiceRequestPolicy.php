<?php

namespace App\Policies;

use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ServiceRequestPolicy
{
    /**
     * Any signed-in user may list requests.
     * (Students see only their own; admins see all — enforced in the controller.)
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * The owner or an administrator may view a request.
     * Another student receives 404 to avoid disclosing the record's existence.
     */
    public function view(User $user, ServiceRequest $serviceRequest): Response
    {
        return ($user->id === $serviceRequest->user_id || $user->is_admin)
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * Only students may create requests (admins don't submit requests).
     */
    public function create(User $user): bool
    {
        return ! $user->is_admin;
    }

    /**
     * Only an administrator may update the status.
     */
    public function updateStatus(User $user, ServiceRequest $serviceRequest): bool
    {
        return (bool) $user->is_admin;
    }
}