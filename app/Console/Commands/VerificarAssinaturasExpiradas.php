<?php

namespace App\Console\Commands;

use App\Models\Assinatura;
use Illuminate\Console\Command;

class VerificarAssinaturasExpiradas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assinaturas:verificar-expiradas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica e atualiza o status das assinaturas expiradas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Verificando assinaturas expiradas...');

        $assinaturasExpiradas = Assinatura::where('status', 'ativa')
            ->where('data_fim', '<', now())
            ->get();

        foreach ($assinaturasExpiradas as $assinatura) {
            $assinatura->update(['status' => 'expirada']);
            $this->info("Assinatura #{$assinatura->id} do usuário {$assinatura->user->email} foi marcada como expirada.");
        }

        $this->info("Total de assinaturas atualizadas: {$assinaturasExpiradas->count()}");

        return Command::SUCCESS;
    }
}