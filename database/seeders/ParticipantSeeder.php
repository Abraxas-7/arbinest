<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Participant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Prendi tutti gli eventi dell'utente ID 2
        $events = Event::where('user_id', 2)->get();

        if ($events->isEmpty()) {
            return; // Non ci sono eventi da popolare
        }

        // Nomi e email di esempio per i partecipanti
        $participantsData = [
            ['name' => 'Mario Rossi', 'email' => 'mario.rossi@example.com'],
            ['name' => 'Giulia Bianchi', 'email' => 'giulia.bianchi@example.com'],
            ['name' => 'Luca Verdi', 'email' => 'luca.verdi@example.com'],
            ['name' => 'Anna Neri', 'email' => 'anna.neri@example.com'],
            ['name' => 'Marco Gialli', 'email' => 'marco.gialli@example.com'],
            ['name' => 'Sofia Rossi', 'email' => 'sofia.rossi@example.com'],
            ['name' => 'Davide Bianchi', 'email' => 'davide.bianchi@example.com'],
            ['name' => 'Elena Verdi', 'email' => 'elena.verdi@example.com'],
            ['name' => 'Roberto Neri', 'email' => 'roberto.neri@example.com'],
            ['name' => 'Laura Gialli', 'email' => 'laura.gialli@example.com'],
        ];

        foreach ($events as $event) {
            // Per ogni evento, aggiungi un numero casuale di partecipanti (da 2 a 6)
            $numParticipants = rand(2, 6);
            $selectedParticipants = array_rand($participantsData, $numParticipants);
            
            if (!is_array($selectedParticipants)) {
                $selectedParticipants = [$selectedParticipants];
            }

            foreach ($selectedParticipants as $index) {
                $participantData = $participantsData[$index];
                
                // Crea o trova il partecipante
                $participant = Participant::firstOrCreate(
                    ['email' => $participantData['email']],
                    [
                        'name' => $participantData['name'],
                        'email' => $participantData['email'],
                    ]
                );

                // Collega il partecipante all'evento se non è già collegato
                if (!$event->participants()->where('participant_id', $participant->id)->exists()) {
                    $event->participants()->attach($participant->id, [
                        'present' => rand(0, 1), // Stato casuale (0 = Registrato, 1 = Presente)
                        'qr_code' => Str::uuid(), // Codice QR univoco
                    ]);
                }
            }
        }
    }
}
