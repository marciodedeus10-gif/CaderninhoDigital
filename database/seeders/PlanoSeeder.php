<?php

namespace Database\Seeders;

use App\Models\Plano;
use Illuminate\Database\Seeder;

class PlanoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $planos = [
            [
                'nome' => 'Bronze',
                'descricao' => 'Perfeito para profissionais autônomos que estão começando.',
                'preco_mensal' => 49.90,
                'preco_anual' => 499.00,
                'max_usuarios' => 1,
                'recursos' => [
                    'clientes',
                    'produtos',
                    'servicos',
                    'vendas',
                    'dashboard_basico'
                ],
                'limites' => [
                    'max_clientes' => 100,
                    'max_produtos' => 200,
                    'max_vendas_mes' => 500
                ],
                'vantagens' => [
                    'Gestão básica de clientes e vendas',
                    'Dashboard simplificado',
                    'Até 100 clientes',
                    'Suporte por email',
                    'Ideal para profissionais autônomos'
                ],
                'desvantagens' => [
                    'Apenas 1 usuário',
                    'Sem gestão de estoque',
                    'Sem relatórios avançados',
                    'Sem API',
                    'Limite de 500 vendas/mês'
                ]
            ],
            [
                'nome' => 'Prata',
                'descricao' => 'Completo para pequenas empresas com até 5 usuários.',
                'preco_mensal' => 149.90,
                'preco_anual' => 1499.00,
                'max_usuarios' => 5,
                'recursos' => [
                    'clientes',
                    'produtos',
                    'servicos',
                    'vendas',
                    'compras',
                    'estoque',
                    'financeiro',
                    'dashboard_completo',
                    'relatorios_basicos',
                    'multi_usuario'
                ],
                'limites' => [
                    'max_clientes' => 1000,
                    'max_produtos' => 1000,
                    'max_vendas_mes' => 5000,
                    'max_compras_mes' => 2000
                ],
                'vantagens' => [
                    'Até 5 usuários simultâneos',
                    'Gestão completa de estoque',
                    'Controle financeiro integrado',
                    'Relatórios básicos',
                    'Dashboard avançado',
                    'Suporte prioritário por email'
                ],
                'desvantagens' => [
                    'Sem API para integrações',
                    'Sem auditoria completa',
                    'Relatórios não personalizáveis',
                    'Limite de 5000 vendas/mês'
                ]
            ],
            [
                'nome' => 'Ouro',
                'descricao' => 'Completo e ilimitado para empresas de qualquer tamanho.',
                'preco_mensal' => 399.90,
                'preco_anual' => 3999.00,
                'max_usuarios' => 0, // ilimitado
                'recursos' => [
                    'clientes',
                    'produtos',
                    'servicos',
                    'vendas',
                    'compras',
                    'estoque',
                    'financeiro',
                    'dashboard_completo',
                    'relatorios_avancados',
                    'multi_usuario',
                    'api',
                    'suporte_prioritario',
                    'auditoria_completa'
                ],
                'limites' => [
                    'max_clientes' => 0, // ilimitado
                    'max_produtos' => 0,
                    'max_vendas_mes' => 0,
                    'max_compras_mes' => 0
                ],
                'vantagens' => [
                    'Usuários ilimitados',
                    'Todos os módulos disponíveis',
                    'Relatórios avançados e personalizáveis',
                    'API completa para integrações',
                    'Auditoria completa de todas as ações',
                    'Suporte telefônico 24/7',
                    'Backups diários automáticos',
                    'Sem limites de operações',
                    'Consultoria incluída'
                ],
                'desvantagens' => []
            ]
        ];

        foreach ($planos as $plano) {
            Plano::create($plano);
        }
    }
}