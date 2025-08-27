<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Mail\ParticipantRegistered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;


class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        // prendi solo i partecipanti di questo evento
        $participants = $event->participants()->get();

        return view('participants.index', compact('event', 'participants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        return view('participants.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ], [
            'name.required' => 'Il nome è obbligatorio.',
            'name.string'   => 'Il nome deve essere una stringa valida.',
            'name.max'      => 'Il nome non può superare i 255 caratteri.',

            'email.required' => 'L\'email è obbligatoria.',
            'email.email'    => 'Inserisci un indirizzo email valido.',
            'email.max'      => 'L\'email non può superare i 255 caratteri.',
        ]);

        try {
            // Crea il partecipante
            $participant = Participant::create([
                'name'  => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Genera codice univoco
            $uniqueCode = Str::uuid();

            // Lo collega all'evento tramite la tabella pivot
            $event->participants()->attach($participant->id, [
                'present' => false,
                'qr_code' => $uniqueCode,
            ]);

            // Genera QR code e salvalo come file
            $qrCode = new QrCode($uniqueCode);
            $qrCode->setSize(150);
            $qrCode->setMargin(2);
            $writer = new PngWriter();
            $result = $writer->write($qrCode);
            
            // Salva il QR in storage/app/qr_[uuid].png
            $qrPath = storage_path('app/qr_' . $uniqueCode . '.png');
            file_put_contents($qrPath, $result->getString());

            // Invia email al partecipante con il QR allegato
            Mail::to($participant->email)->send(new ParticipantRegistered($event, $participant, $qrPath));


            return redirect()
                ->route('events.show', $event->slug)
                ->with('message', 'Partecipante aggiunto con successo e email inviata!')
                ->with('message_type', 'success');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('message', 'C\'è stato un problema nell\'aggiungere il partecipante.')
                ->with('message_type', 'error');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Participant $participant)
    {
        return view('participants.show', compact('event', 'participant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event, Participant $participant)
    {
        return view('participants.edit', compact('event', 'participant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event, Participant $participant)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'present' => 'boolean',
        ], [
            'name.required' => 'Il nome è obbligatorio.',
            'name.string'   => 'Il nome deve essere una stringa valida.',
            'name.max'      => 'Il nome non può superare i 255 caratteri.',

            'email.required' => 'L\'email è obbligatoria.',
            'email.email'    => 'Inserisci un indirizzo email valido.',
            'email.max'      => 'L\'email non può superare i 255 caratteri.',
            
            'present.boolean' => 'Lo stato presenza deve essere valido.',
        ]);

        try {
            $participant->update([
                'name'  => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Aggiorna lo stato presenza nella tabella pivot
            $event->participants()->updateExistingPivot($participant->id, [
                'present' => $validated['present'] ?? false,
            ]);

            return redirect()
                ->route('events.show', $event->slug)
                ->with('message', 'Partecipante aggiornato con successo!')
                ->with('message_type', 'success');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('message', 'C\'è stato un problema nell\'aggiornare il partecipante.')
                ->with('message_type', 'error');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Participant $participant)
    {
        $participant->delete();

        return redirect()
            ->route('events.participants.index', $event->slug)
            ->with('message', 'Partecipante eliminato con successo!')
            ->with('message_type', 'success');
    }
}
