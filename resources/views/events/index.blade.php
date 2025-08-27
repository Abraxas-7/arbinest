@extends('layouts.app')

@section('title', 'I Miei Eventi')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2">I Miei Eventi</h1>
                <a href="{{ route('events.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Nuovo Evento
                </a>
            </div>

            @if (session('message'))
                <div class="alert alert-{{ session('message_type') === 'success' ? 'success' : 'danger' }} alert-dismissible fade show"
                    role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($events->count() > 0)
                <div class="row">
                    @foreach ($events as $event)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $event->title }}</h5>

                                    @if ($event->description)
                                        <p class="card-text text-muted">{{ Str::limit($event->description, 100) }}</p>
                                    @endif

                                    <div class="mb-3">
                                        @if ($event->location)
                                            <div class="d-flex align-items-center text-muted mb-2">
                                                <i class="bi bi-geo-alt me-2"></i>
                                                <small>{{ $event->location }}</small>
                                            </div>
                                        @endif

                                        @if ($event->date)
                                            <div class="d-flex align-items-center text-muted mb-2">
                                                <i class="bi bi-calendar me-2"></i>
                                                <small>{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y H:i') }}</small>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-secondary">
                                            {{ $event->participants()->count() }} partecipanti
                                        </span>

                                        <div class="btn-group" role="group">
                                            <a href="{{ route('events.show', $event->slug) }}"
                                                class="btn btn-outline-primary btn-sm">
                                                Visualizza
                                            </a>
                                            <a href="{{ route('events.edit', $event->slug) }}"
                                                class="btn btn-outline-warning btn-sm">
                                                Modifica
                                            </a>
                                            <form action="{{ route('events.destroy', $event->slug) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Sei sicuro di voler eliminare questo evento?')">
                                                    Elimina
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="text-muted mb-4">
                        <i class="bi bi-calendar-x display-1"></i>
                    </div>
                    <h3 class="h4">Nessun evento ancora</h3>
                    <p class="text-muted mb-4">Crea il tuo primo evento per iniziare!</p>
                    <a href="{{ route('events.create') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Crea Primo Evento
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
