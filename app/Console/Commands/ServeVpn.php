<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ServeVpn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:vpn {--port=8000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Avvia il server Laravel accessibile in LAN/VPN';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $port = $this->option('port');

        $this->line(PHP_EOL . "====================================");
        $this->line(PHP_EOL . "🚀 Server di sviluppo avviato!");
        $this->line("👉 URL: http://localhost:{$port}" . PHP_EOL);
        $this->line("====================================" . PHP_EOL);

        $process = new Process([
            PHP_BINARY,
            'artisan',
            'serve',
            "--host=0.0.0.0",
            "--port={$port}",
        ]);
        
        $process->setTimeout(null); // ❌ no limite di 60s
        $process->setIdleTimeout(null); // ❌ no idle timeout
        
        if (DIRECTORY_SEPARATOR !== '\\') {
            $process->setTty(true);
        }
        
        // esegue e mostra l’output man mano
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
    }
}
