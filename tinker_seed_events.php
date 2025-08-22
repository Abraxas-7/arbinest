<?php

use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

// --- 1. Creazione utenti ---
$admin = new User([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('password'),
]);
$admin->is_admin = 1; // impostato manualmente
$admin->save();

$mario = new User([
    'name' => 'Mario',
    'email' => 'mario@example.com',
    'password' => Hash::make('password'),
]);
$mario->is_admin = 0; // impostato manualmente
$mario->save();

echo "Utenti creati: Admin (is_admin=1), Mario (is_admin=0)\n";

// --- 2. Creazione eventi ---
$data = [
    'title' => 'Evento Tinker',
    'description' => 'Descrizione evento',
    'location_name' => 'Luogo X',
    'location_address' => 'Via Y 123',
    'location_city' => 'Città Z',
    'location_province' => 'Provincia P',
    'location_zip_code' => '12345',
    'location_country' => 'Italia',
    'start' => now()->addDay(),
    'end' => now()->addDays(2),
    'max_participants' => 10,
];

// Validazione
$validator = Validator::make($data, [
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
]);

if ($validator->fails()) {
    echo "Errore validazione: \n";
    print_r($validator->errors()->all());
} else {
    $baseSlug = Str::slug($data['title']);
    $slug = $baseSlug;
    $counter = 1;
    while (Event::where('slug', $slug)->exists()) {
        $slug = $baseSlug . '-' . $counter++;
    }
    $data['slug'] = $slug;
    $data['user_id'] = $mario->id; // ← qui usiamo $mario direttamente
    $eventMario = Event::create($data);
    echo "Evento creato con successo per Mario: {$eventMario->title}\n";
}

// --- Tentativo di creare evento con errore ---
$data_invalid = $data;
$data_invalid['title'] = ''; // titolo mancante
$validator = Validator::make($data_invalid, [
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
]);

if ($validator->fails()) {
    echo "Errore creazione evento (come previsto): \n";
    print_r($validator->errors()->all());
}

// --- Tentativo di aggiornamento evento Mario ---
$eventMario->title = 'Evento Tinker Modificato';
$eventMario->save();
echo "Evento aggiornato con successo: {$eventMario->title}\n";

// --- Tentativo di aggiornare evento Admin ---
$eventAdmin = Event::create([
    'user_id' => $admin->id,
    'title' => 'Evento Admin',
    'description' => 'Descrizione Admin',
    'location_name' => 'Admin Place',
    'location_address' => 'Via Admin 1',
    'location_city' => 'Admin City',
    'location_province' => 'Admin Province',
    'location_zip_code' => '00000',
    'location_country' => 'Italia',
    'start' => now()->addDays(3),
    'end' => now()->addDays(4),
    'max_participants' => 5,
    'slug' => 'evento-admin',
]);

if ($mario->id !== $eventAdmin->user_id && !$mario->is_admin) {
    echo "Mario NON può modificare evento Admin (come previsto)\n";
}

// --- Tentativo di cancellazione evento Mario ---
$eventMario->delete();
echo "Evento Mario eliminato con successo\n";

// --- Tentativo di cancellazione evento Admin ---
if ($mario->id !== $eventAdmin->user_id && !$mario->is_admin) {
    echo "Mario NON può eliminare evento Admin (come previsto)\n";
}

echo "=== END CRUD TEST ===\n";
