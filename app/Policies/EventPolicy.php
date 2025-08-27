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
        if ($user->is_admin) {
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

    // Chi può vedere la lista degli eventi
    public function viewAny(User $user)
    {
        return true; // Tutti gli utenti autenticati possono vedere la lista
    }

    // Chi può creare eventi
    public function create(User $user)
    {
        return true; // Tutti gli utenti autenticati possono creare eventi
    }
}
