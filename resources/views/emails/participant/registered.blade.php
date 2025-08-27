<x-mail::message>
    # Ciao {{ $participant->name }}

    Sei registrato all'evento **{{ $event->title }}**!

    Il tuo QR code per l'ingresso è allegato a questa email come file "qr_code.png".

    <x-mail::button :url="''">
        Visualizza Evento
    </x-mail::button>

    Grazie,<br>
    {{ config('app.name') }}
</x-mail::message>
