<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar permissões
        $permissions = [
            // Clientes
            'ver_clientes',
            'criar_clientes',
            'editar_clientes',
            'deletar_clientes',

            // Produtos
            'ver_produtos',
            'criar_produtos',
            'editar_produtos',
            'deletar_produtos',

            // Serviços
            'ver_servicos',
            'criar_servicos',
            'editar_servicos',
            'deletar_servicos',

            // Vendas
            'ver_vendas',
            'criar_vendas',
            'editar_vendas',
            'deletar_vendas',

            // Compras
            'ver_compras',
            'criar_compras',
            'editar_compras',
            'deletar_compras',

            // Estoque
            'ver_estoque',
            'gerenciar_estoque',
            'ver_movimentacoes',

            // Financeiro
            'ver_financeiro',
            'gerenciar_financeiro',
            'ver_lancamentos',
            'criar_lancamentos',
            'editar_lancamentos',

            // Usuários
            'ver_usuarios',
            'criar_usuarios',
            'editar_usuarios',
            'deletar_usuarios',
            'gerenciar_roles',

            // Relatórios
            'ver_relatorios_basicos',
            'ver_relatorios_avancados',

            // Sistema
            'acessar_dashboard',
            'configurar_sistema',
            'gerenciar_planos'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Criar roles e atribuir permissões
        $roles = [
            'Administrador' => [
                'ver_clientes', 'criar_clientes', 'editar_clientes', 'deletar_clientes',
                'ver_produtos', 'criar_produtos', 'editar_produtos', 'deletar_produtos',
                'ver_servicos', 'criar_servicos', 'editar_servicos', 'deletar_servicos',
                'ver_vendas', 'criar_vendas', 'editar_vendas', 'deletar_vendas',
                'ver_compras', 'criar_compras', 'editar_compras', 'deletar_compras',
                'ver_estoque', 'gerenciar_estoque', 'ver_movimentacoes',
                'ver_financeiro', 'gerenciar_financeiro', 'ver_lancamentos', 'criar_lancamentos', 'editar_lancamentos',
                'ver_usuarios', 'criar_usuarios', 'editar_usuarios', 'deletar_usuarios', 'gerenciar_roles',
                'ver_relatorios_basicos', 'ver_relatorios_avancados',
                'acessar_dashboard', 'configurar_sistema', 'gerenciar_planos'
            ],
            'Gerente Estoque' => [
                'ver_produtos', 'criar_produtos', 'editar_produtos',
                'ver_compras', 'criar_compras', 'editar_compras',
                'ver_estoque', 'gerenciar_estoque', 'ver_movimentacoes',
                'acessar_dashboard'
            ],
            'Gerente Financeiro' => [
                'ver_financeiro', 'gerenciar_financeiro', 'ver_lancamentos', 'criar_lancamentos', 'editar_lancamentos',
                'ver_vendas', 'ver_compras',
                'ver_relatorios_basicos',
                'acessar_dashboard'
            ],
            'Vendedor' => [
                'ver_clientes', 'criar_clientes', 'editar_clientes',
                'ver_produtos', 'ver_servicos',
                'ver_vendas', 'criar_vendas', 'editar_vendas',
                'acessar_dashboard'
            ],
            'Usuário Comum' => [
                'ver_clientes',
                'ver_produtos', 'ver_servicos',
                'ver_vendas',
                'acessar_dashboard'
            ]
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
    }
}