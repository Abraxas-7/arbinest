@extends('layouts.app')

@section('title', $event->title)

@section('content')
    <!-- Header Evento -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h1 class="h2 mb-2">{{ $event->title }}</h1>
                    @if ($event->description)
                        <p class="lead text-muted">{{ $event->description }}</p>
                    @endif
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('events.edit', $event->slug) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square me-2"></i>Modifica
                    </a>
                    <form action="{{ route('events.destroy', $event->slug) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Sei sicuro di voler eliminare questo evento?')">
                            <i class="bi bi-trash me-2"></i>Elimina
                        </button>
                    </form>
                </div>
            </div>

            <!-- Dettagli Evento -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                        @if ($event->location)
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-geo-alt text-primary fs-4 me-3"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Località</h6>
                                        <p class="text-muted mb-0">{{ $event->location }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($event->date)
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-calendar text-success fs-4 me-3"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Data e Ora</h6>
                                        <p class="text-muted mb-0">
                                            {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sezione Partecipanti -->
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h4 mb-0">Partecipanti ({{ $event->participants()->count() }})</h2>
                <a href="{{ route('events.participants.create', $event->slug) }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Aggiungi Partecipante
                </a>
            </div>
        </div>

        @if (session('message'))
            <div class="card-body pt-0">
                <div class="alert alert-{{ session('message_type') === 'success' ? 'success' : 'danger' }} alert-dismissible fade show"
                    role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        <div class="card-body">
            @if ($event->participants()->count() > 0)
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
                            @foreach ($event->participants as $participant)
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
        </div>
    </div>

    <!-- Torna alla lista -->
    <div class="text-center mt-4">
        <a href="{{ route('events.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left me-2"></i>Torna ai Miei Eventi
        </a>
    </div>
@endsection
