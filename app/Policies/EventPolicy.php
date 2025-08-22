<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    // Se vuoi dare permessi globali agli admin
    public function before(User $user, $ability)
    {
        if ($user->is_admin) { // devi avere un campo is_admin nella tabella users
            return true;
        }
    }

    // Chi può vedere un evento
    public function view(User $user, Event $event)
    {
        return $user->id === $event->user_id;
    }

    // Chi può modificare un evento
    public function update(User $user, Event $event)
    {
        return $user->id === $event->user_id;
    }

    // Chi può cancellare un evento
    public function delete(User $user, Event $event)
    {
        return $user->id === $event->user_id;
    }
}
