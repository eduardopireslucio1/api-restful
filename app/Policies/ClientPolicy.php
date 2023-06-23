<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Client;

class ClientPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Client $client)
    {
        return $user->id === $client->user_id;
    }

    public function update(User $user, Client $client)
    {
        return $user->id === $client->user_id;
    }

    public function destroy(User $user, Client $client)
    {
        return $user->id === $client->user_id;
    }

}
