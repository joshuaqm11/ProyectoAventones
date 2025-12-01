<?php

namespace App\Console\Commands;

use App\Mail\ReservaPendienteMail;
use App\Models\Reserva;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotificarReservasPendientes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * reservas:notificar 30   → X = 30 minutos
     */
    protected $signature = 'reservas:notificar {minutos=30}';

    /**
     * The console command description.
     */
    protected $description = 'Notifica a los choferes sobre reservas pendientes con más de X minutos de creadas';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $minutos = (int) $this->argument('minutos');

        $this->info("Buscando reservas pendientes con más de {$minutos} minutos...");

        $limite = now()->subMinutes($minutos);

        // Ajusta nombres de columnas/estado según tu BD
        $reservas = Reserva::where('estado', 'pendiente')
            ->where('created_at', '<=', $limite)
            ->with(['ride.chofer'])    // necesitamos el chofer del ride
            ->get();

        if ($reservas->isEmpty()) {
            $this->info('No hay reservas pendientes que cumplan la condición.');
            return Command::SUCCESS;
        }

        $this->info("Se encontraron {$reservas->count()} reservas. Enviando correos...");

        foreach ($reservas as $reserva) {
            $chofer = $reserva->ride->chofer ?? null;

            if (!$chofer || empty($chofer->correo)) {
                $this->warn("Reserva ID {$reserva->id} no tiene chofer con correo definido.");
                continue;
            }

            Mail::to($chofer->correo)->send(new ReservaPendienteMail($reserva));

            $this->info("Correo enviado al chofer {$chofer->correo} por reserva ID {$reserva->id}.");
        }

        $this->info('Proceso finalizado.');

        return Command::SUCCESS;
    }
}
