@extends('layouts.app')

@section('title', 'Partecipanti - ' . $event->title)

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h1 class="h2 mb-2">Partecipanti</h1>
                    <p class="text-muted mb-0">Evento: {{ $event->title }}</p>
                </div>
                <a href="{{ route('events.participants.create', $event->slug) }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Aggiungi Partecipante
                </a>
            </div>

            <!-- Torna all'evento -->
            <a href="{{ route('events.show', $event->slug) }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-2"></i>Torna all'Evento
            </a>
        </div>
    </div>

    @if (session('message'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-{{ session('message_type') === 'success' ? 'success' : 'danger' }} alert-dismissible fade show"
                    role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    @endif

    @if ($participants->count() > 0)
        <div class="card shadow-sm">
            <div class="card-header">
                <h2 class="h5 mb-0">{{ $participants->count() }} partecipanti totali</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Stato</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($participants as $participant)
                                <tr>
                                    <td class="fw-medium">{{ $participant->name }}</td>
                                    <td class="text-muted">{{ $participant->email }}</td>
                                    <td>
                                        @php
                                            $pivot = $event
                                                ->participants()
                                                ->where('participant_id', $participant->id)
                                                ->first()->pivot;
                                        @endphp
                                        <span class="badge {{ $pivot->present ? 'bg-success' : 'bg-warning' }}">
                                            {{ $pivot->present ? 'Presente' : 'Registrato' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('events.participants.edit', [$event->slug, $participant->id]) }}"
                                                class="btn btn-outline-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form
                                                action="{{ route('events.participants.destroy', [$event->slug, $participant->id]) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Sei sicuro di voler eliminare questo partecipante?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <div class="text-muted mb-4">
                <i class="bi bi-people display-1"></i>
            </div>
            <h3 class="h5">Nessun partecipante ancora</h3>
            <p class="text-muted mb-4">Aggiungi il primo partecipante al tuo evento!</p>
            <a href="{{ route('events.participants.create', $event->slug) }}" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle me-2"></i>Aggiungi Primo Partecipante
            </a>
        </div>
    @endif
@endsection
