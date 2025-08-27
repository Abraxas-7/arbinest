<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ServeVpn extends Command
{
    protected $signature = 'serve:vpn {--port=8000}';
    protected $description = 'Avvia il server Laravel accessibile in LAN/VPN su una porta definita';

    public function handle()
    {
        $port = $this->option('port');

        $this->info("====================================");
        $this->info("🚀 Server di sviluppo avviato!");
        $this->info("👉 URL: http://localhost:{$port}");
        $this->info("====================================");

        // Usa percorso assoluto di artisan
        $artisanPath = base_path('artisan');

        $process = new Process([PHP_BINARY, $artisanPath, 'serve', "--host=0.0.0.0", "--port={$port}"]);

        // Disabilita timeout, TTY solo su Linux/macOS
        $process->setTimeout(null);
        $process->setIdleTimeout(null);

        if (DIRECTORY_SEPARATOR !== '\\') {
            $process->setTty(true);
        }

        // Avvia il server e mostra l'output
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
    }
}
