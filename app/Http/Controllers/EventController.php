<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    
    public function __construct()
    {
        $this->authorizeResource(Event::class, 'event');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::where('user_id', Auth::id())->get();
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'date' => 'required|date',
        ], [
            'title.required' => 'Il titolo è obbligatorio.',
            'title.max' => 'Il titolo non può superare i 255 caratteri.',
            'description.string' => 'La descrizione deve essere una stringa valida.',
            'location.string' => 'La località deve essere una stringa valida.',
            'location.max' => 'La località non può superare i 255 caratteri.',
            'date.required' => 'La data è obbligatoria.',
            'date.date' => 'La data deve essere valida.',
        ]);

        // Slug
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Event::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        try {
            $event = Event::create([
                'user_id' => Auth::id(),
                'title' => $validated['title'],
                'description' => $validated['description'],
                'location' => $validated['location'],
                'date' => $validated['date'],
                'slug' => $slug,
            ]);
    
            return redirect()->route('events.show', $event->slug)->with('message', 'Evento creato con successo!')->with('message_type', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'C\'è stato un problema nel creare l\'evento.')->with('message_type', 'error');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'date' => 'required|date',
        ], [
            'title.required' => 'Il titolo è obbligatorio.',
            'title.max' => 'Il titolo non può superare i 255 caratteri.',
            'description.string' => 'La descrizione deve essere una stringa valida.',
            'location.string' => 'La località deve essere una stringa valida.',
            'location.max' => 'La località non può superare i 255 caratteri.',
            'date.required' => 'La data è obbligatoria.',
            'date.date' => 'La data deve essere valida.',
        ]);

        // Controllo se il titolo è cambiato e se sì, aggiorno lo slug
        if ($validated['title'] !== $event->title) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;
            while (Event::where('slug', $slug)->where('id', '!=', $event->id)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }
        } else {
            $slug = $event->slug;
        }

        try {
            $event->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'location' => $validated['location'],
                'date' => $validated['date'],
                'slug' => $slug,
            ]);
        
            return redirect()->route('events.show', $event->slug)->with('message', 'Evento aggiornato con successo!')->with('message_type', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'C\'è stato un problema nell\'aggiornare l\'evento.')->with('message_type', 'error');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('message', 'Evento eliminato con successo!')->with('message_type', 'success');
    }
}
