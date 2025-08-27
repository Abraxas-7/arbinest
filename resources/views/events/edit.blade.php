@extends('layouts.app')

@section('title', 'Modifica Evento')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">
                    <h1 class="h3 mb-0">Modifica Evento</h1>
                    <p class="text-muted mb-0">Modifica i dettagli di "{{ $event->title }}"</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('events.update', $event->slug) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Titolo -->
                        <div class="mb-3">
                            <label for="title" class="form-label">
                                Titolo Evento <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}"
                                class="form-control @error('title') is-invalid @enderror" placeholder="Es: Workshop Laravel"
                                required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Descrizione -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrizione</label>
                            <textarea id="description" name="description" rows="4"
                                class="form-control @error('description') is-invalid @enderror" placeholder="Descrivi il tuo evento...">{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Località -->
                        <div class="mb-3">
                            <label for="location" class="form-label">Località</label>
                            <input type="text" id="location" name="location"
                                value="{{ old('location', $event->location) }}"
                                class="form-control @error('location') is-invalid @enderror"
                                placeholder="Es: Milano, Via Roma 123">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Data e Ora -->
                        <div class="mb-3">
                            <label for="date" class="form-label">
                                Data e Ora <span class="text-danger">*</span>
                            </label>
                            <input type="datetime-local" id="date" name="date"
                                value="{{ old('date', $event->date ? \Carbon\Carbon::parse($event->date)->format('Y-m-d\TH:i') : '') }}"
                                class="form-control @error('date') is-invalid @enderror" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('events.show', $event->slug) }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Annulla
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-pencil-square me-2"></i>Aggiorna Evento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
