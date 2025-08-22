<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

    use AuthorizesRequests;
    
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
            'description' => 'required|string',
            'location_name' => 'required|string|max:255',
            'location_address' => 'required|string|max:500',
            'location_city' => 'required|string|max:100',
            'location_province' => 'required|string|max:100',
            'location_zip_code' => 'required|string|max:10',
            'location_country' => 'required|string|max:100',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'max_participants' => 'required|integer|min:1',
        ], [
            'title.required' => 'Il titolo è obbligatorio.',
            'title.max' => 'Il titolo non può superare i 255 caratteri.',

            'description.required' => 'La descrizione è obbligatoria.',

            'location_name.reqired' => 'Il nome del luogo è obbligatorio',
            'location_name.max' => 'Il nome del luogo non può superare i 255 caratteri.',
            
            'location_address.required' => 'L\'indirizzo è obbligatorio',
            'location_address.max' => 'L\'indirizzo non può superare i 500 caratteri.',
            
            'location_city.required' => 'La città è obbligatoria',
            'location_city.max' => 'La città non può superare i 100 caratteri.',

            'location_province.required' => 'La provincia è obbligatoria',
            'location_province.max' => 'La provincia non può superare i 100 caratteri.',

            'location_zip_code.required' => 'Il CAP è obbligatorio',
            'location_zip_code.max' => 'Il CAP non può superare i 10 caratteri.',

            'location_country.required' => 'Il paese è obbligatorio',
            'location_country.max' => 'Il paese non può superare i 100 caratteri.',
        
            'start.required' => 'La data di inizio è obbligatoria.',
            'start.date' => 'La data di inizio deve essere valida.',
        
            'end.required' => 'La data di fine è obbligatoria.',
            'end.date' => 'La data di fine deve essere valida.',
            'end.after' => 'La data di fine deve essere successiva a quella di inizio.',

            'max_participants.required' => 'Il numero massimo di partecipanti è obbligatorio.',
            'max_participants.integer' => 'Il numero massimo di partecipanti deve essere un numero intero.',
            'max_participants.min' => 'Il numero minimo di partecipanti è 1.',
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
                'location_name' => $validated['location_name'],
                'location_address' => $validated['location_address'],
                'location_city' => $validated['location_city'],
                'location_province' => $validated['location_province'],
                'location_zip_code' => $validated['location_zip_code'],
                'location_country' => $validated['location_country'] ?? 'Italia',
                'start' => $validated['start'],
                'end' => $validated['end'],
                'max_participants' => $validated['max_participants'],
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
        return view('events.update', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location_name' => 'required|string|max:255',
            'location_address' => 'required|string|max:500',
            'location_city' => 'required|string|max:100',
            'location_province' => 'required|string|max:100',
            'location_zip_code' => 'required|string|max:10',
            'location_country' => 'required|string|max:100',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'max_participants' => 'required|integer|min:1',
        ], [
            'title.required' => 'Il titolo è obbligatorio.',
            'title.max' => 'Il titolo non può superare i 255 caratteri.',

            'description.required' => 'La descrizione è obbligatoria.',

            'location_name.reqired' => 'Il nome del luogo è obbligatorio',
            'location_name.max' => 'Il nome del luogo non può superare i 255 caratteri.',
            
            'location_address.required' => 'L\'indirizzo è obbligatorio',
            'location_address.max' => 'L\'indirizzo non può superare i 500 caratteri.',
            
            'location_city.required' => 'La città è obbligatoria',
            'location_city.max' => 'La città non può superare i 100 caratteri.',

            'location_province.required' => 'La provincia è obbligatoria',
            'location_province.max' => 'La provincia non può superare i 100 caratteri.',

            'location_zip_code.required' => 'Il CAP è obbligatorio',
            'location_zip_code.max' => 'Il CAP non può superare i 10 caratteri.',

            'location_country.required' => 'Il paese è obbligatorio',
            'location_country.max' => 'Il paese non può superare i 100 caratteri.',
        
            'start.required' => 'La data di inizio è obbligatoria.',
            'start.date' => 'La data di inizio deve essere valida.',
        
            'end.required' => 'La data di fine è obbligatoria.',
            'end.date' => 'La data di fine deve essere valida.',
            'end.after' => 'La data di fine deve essere successiva a quella di inizio.',

            'max_participants.required' => 'Il numero massimo di partecipanti è obbligatorio.',
            'max_participants.integer' => 'Il numero massimo di partecipanti deve essere un numero intero.',
            'max_participants.min' => 'Il numero minimo di partecipanti è 1.',
        ]);

        // Controllo se il titolo è cambiato e se sì, aggiorno lo slug, verifico se esiste già un evento con lo stesso slug
        if ($validated['title'] !== $event->title) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;
            while (Event::where('slug', $slug)->where('id', '!=', $event->id)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }
            $event->slug = $slug;
        }

        try {
            $event->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'location_name' => $validated['location_name'],
                'location_address' => $validated['location_address'],
                'location_city' => $validated['location_city'],
                'location_province' => $validated['location_province'],
                'location_zip_code' => $validated['location_zip_code'],
                'location_country' => $validated['location_country'] ?? 'Italia',
                'start' => $validated['start'],
                'end' => $validated['end'],
                'max_participants' => $validated['max_participants'],
                'slug' => $slug,
            ]);
        
            return redirect()->route('events.show', $event->slug)->with('message', 'Evento aggiornato con successo!')->with('message_type', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'C\'è stato un problema nell\'aggiornare l\'evento.');
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
