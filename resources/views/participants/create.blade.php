@extends('layouts.app')

@section('title', 'Aggiungi Partecipante')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">
                    <h1 class="h3 mb-0">Aggiungi Partecipante</h1>
                    <p class="text-muted mb-0">Aggiungi un partecipante all'evento "{{ $event->title }}"</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('events.participants.store', $event->slug) }}" method="POST">
                        @csrf

                        <!-- Nome -->
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Nome Partecipante <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Es: Mario Rossi"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="mario.rossi@example.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('events.show', $event->slug) }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Annulla
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Aggiungi Partecipante
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
