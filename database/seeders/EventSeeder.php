<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Eventi di test per l'utente ID 2
        $events = [
            [
                'title' => 'Workshop Laravel Avanzato',
                'description' => 'Un workshop intensivo su Laravel per sviluppatori esperti. Copriremo pattern avanzati, testing, e ottimizzazioni.',
                'location' => 'Milano, Via Roma 123 - Sala Conferenze',
                'date' => now()->addDays(7)->setTime(14, 0),
            ],
            [
                'title' => 'Meetup PHP Community',
                'description' => 'Incontro della comunità PHP italiana. Networking, presentazioni e discussioni su temi attuali.',
                'location' => 'Roma, Piazza Navona - Centro Congressi',
                'date' => now()->addDays(14)->setTime(18, 30),
            ],
            [
                'title' => 'Conferenza Web Development',
                'description' => 'Evento annuale dedicato al web development moderno. Frontend, backend, DevOps e molto altro.',
                'location' => 'Firenze, Palazzo dei Congressi',
                'date' => now()->addDays(21)->setTime(9, 0),
            ],
            [
                'title' => 'Hackathon 24 Ore',
                'description' => 'Maratona di programmazione di 24 ore. Sfide, premi e tanto divertimento per sviluppatori di ogni livello.',
                'location' => 'Bologna, Università - Laboratorio Informatica',
                'date' => now()->addDays(30)->setTime(10, 0),
            ],
            [
                'title' => 'Corso Base JavaScript',
                'description' => 'Corso introduttivo a JavaScript per principianti. Dalle basi fino alla creazione di applicazioni web interattive.',
                'location' => 'Torino, Tech Hub - Sala Training',
                'date' => now()->addDays(3)->setTime(15, 0),
            ],
        ];

        foreach ($events as $eventData) {
            Event::create([
                'user_id' => 2, // ID dell'utente di test
                'title' => $eventData['title'],
                'description' => $eventData['description'],
                'location' => $eventData['location'],
                'date' => $eventData['date'],
                'slug' => Str::slug($eventData['title']),
            ]);
        }
    }
}
