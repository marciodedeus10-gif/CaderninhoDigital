# 🚀 Teste Rápido - Sistema de Assinaturas

## Passo 1: Setup do Banco de Dados
```bash
# Executar todas as migrations
php artisan migrate

# Popular planos (Autônomo, Pequena Empresa, Empresa)
php artisan db:seed --class=PlanoSeeder

# Popular roles e permissões (Admin, Gerente, Vendedor, etc)
php artisan db:seed --class=RolePermissionSeeder
```

## Passo 2: Entrar no Tinker (Terminal Interativo PHP)
```bash
php artisan tinker
```

## Passo 3: Criar Usuário de Teste
```php
// Criar usuário teste
$user = App\Models\User::create([
    'name' => 'João Admin',
    'email' => 'joao@example.com',
    'password' => Hash::make('senha123')
]);

// Ou usar um usuário existente
$user = App\Models\User::first();

echo "Usuário criado: " . $user->email;
```

## Passo 4: Criar Assinatura
```php
// Ver planos disponíveis
$planos = App\Models\Plano::all();
$planos->each(fn($p) => echo $p->nome . " - R$ " . $p->preco_mensal . "\n");

// Usar o plano "Pequena Empresa"
$plano = App\Models\Plano::where('nome', 'Pequena Empresa')->first();

// Criar assinatura para o usuário
$assinatura = App\Models\Assinatura::create([
    'user_id' => $user->id,
    'plano_id' => $plano->id,
    'status' => 'ativa',
    'data_inicio' => now(),
    'data_fim' => now()->addMonth(),
    'data_renovacao' => now()->addMonth(),
    'periodicidade' => 'mensal',
    'valor' => $plano->preco_mensal
]);

echo "✅ Assinatura criada!";
echo "Status: " . $assinatura->status . "\n";
echo "Plano: " . $assinatura->plano->nome . "\n";
```

## Passo 5: Atribuir Role
```php
// Atribuir role de Administrador
$user->assignRole('Administrador');

echo "✅ Role atribuído: Administrador\n";
echo "Roles do usuário: " . $user->getRoleNames() . "\n";
```

## Passo 6: Verificar Permissões
```php
// Verificar se tem permissão específica
$user->hasPermissionTo('ver_clientes');     // true
$user->hasPermissionTo('ver_estoque');      // true
$user->hasPermissionTo('gerenciar_planos'); // true (admin)

// Listar todas as permissões
$user->getAllPermissions()->pluck('name');

// Verificar role
$user->hasRole('Administrador'); // true
```

## Passo 7: Testar Acesso a Recursos
```php
// Verificar assinatura ativa
$user->temAssinaturaAtiva(); // true

// Verificar acesso a recurso específico
$user->podeAcessarRecurso('estoque');       // true
$user->podeAcessarRecurso('financeiro');    // true
$user->podeAcessarRecurso('vendas');        // true

// Ver limite de clientes
$user->getLimite('max_clientes'); // 1000 (Pequena Empresa)
```

## Passo 8: Criar Usuários Secundários
```php
// Criar usuário para Gerente de Estoque
$gerente_estoque = App\Models\User::create([
    'name' => 'Maria Estoque',
    'email' => 'maria@example.com',
    'password' => Hash::make('senha123'),
    'user_id' => $user->id // Vinculado ao admin
]);

// Atribuir role
$gerente_estoque->assignRole('Gerente Estoque');

// Criar usuário para Gerente Financeiro
$gerente_financeiro = App\Models\User::create([
    'name' => 'Pedro Financeiro',
    'email' => 'pedro@example.com',
    'password' => Hash::make('senha123'),
    'user_id' => $user->id
]);

$gerente_financeiro->assignRole('Gerente Financeiro');

// Criar vendedor
$vendedor = App\Models\User::create([
    'name' => 'Ana Vendas',
    'email' => 'ana@example.com',
    'password' => Hash::make('senha123'),
    'user_id' => $user->id
]);

$vendedor->assignRole('Vendedor');

echo "✅ 3 usuários criados com roles diferentes!\n";
```

## Passo 9: Verificar Diferenças de Permissão
```php
// Gerente de Estoque pode ver estoque?
$gerente_estoque->can('ver_estoque');      // true
$gerente_estoque->can('gerenciar_financeiro'); // false

// Gerente Financeiro pode ver financeiro?
$gerente_financeiro->can('gerenciar_financeiro'); // true
$gerente_financeiro->can('gerenciar_estoque');     // false

// Vendedor pode criar vendas?
$vendedor->can('criar_vendas'); // true
$vendedor->can('gerenciar_estoque'); // false

echo "✅ Permissões diferenciadas funcionando!\n";
```

## Passo 10: Testar Cancelamento e Upgrade
```php
// Ver assinatura atual
$user->assinatura;

// Fazer upgrade para Empresa
$plano_empresa = App\Models\Plano::where('nome', 'Empresa')->first();
$user->assinatura->update(['plano_id' => $plano_empresa->id]);

echo "✅ Upgrade feito para Empresa!\n";

// Cancelar assinatura
$user->assinatura->update(['status' => 'cancelada']);

echo "✅ Assinatura cancelada\n";
echo "Tem assinatura ativa? " . ($user->temAssinaturaAtiva() ? 'SIM' : 'NÃO') . "\n";

// Ativar novamente
$user->assinatura->update(['status' => 'ativa', 'data_fim' => now()->addMonth()]);
echo "✅ Assinatura reativada!\n";
```

## Sair do Tinker
```php
exit
```

---

## 🧪 Teste no Browser

Após executar os passos acima:

1. **Fazer Login**
   ```
   URL: http://localhost/login
   Email: joao@example.com
   Senha: senha123
   ```

2. **Acessar Assinatura**
   ```
   URL: http://localhost/assinaturas
   ```
   Você verá:
   - Status da assinatura atual
   - 3 planos disponíveis
   - Opção de fazer upgrade

3. **Criar Novo Usuário**
   ```
   URL: http://localhost/usuarios/create
   ```
   Preencha:
   - Nome: João Teste
   - Email: joao@teste.com
   - Senha: senha123
   - Role: Gerente Estoque
   - Clique em Criar

4. **Testar Acesso por Role**
   ```
   Login com usuário diferente
   Tente acessar módulo que não tem permissão
   Deve aparecer: "403 - Acesso Negado"
   ```

---

## 📊 Verificar Dados no Banco

### Ver Planos
```bash
php artisan tinker
App\Models\Plano::all()->map(fn($p) => $p->nome)->toArray();
```

### Ver Assinaturas Ativas
```bash
php artisan tinker
App\Models\Assinatura::where('status', 'ativa')->with('user', 'plano')->get();
```

### Ver Usuários e Seus Roles
```bash
php artisan tinker
App\Models\User::with('roles')->get()->each(fn($u) => 
    echo $u->name . " → " . $u->getRoleNames()->implode(', ') . "\n"
);
```

### Ver Permissões de um Usuário
```bash
php artisan tinker
$user = App\Models\User::find(1);
$user->getAllPermissions()->pluck('name')->toArray();
```

---

## ✅ Checklist de Teste

- [ ] Migrations executadas
- [ ] Seeders rodados (Planos e Roles)
- [ ] Usuário criado com sucesso
- [ ] Assinatura criada
- [ ] Role atribuído
- [ ] Pode acessar recurso do plano
- [ ] Não pode acessar recurso fora do plano
- [ ] Usuário secundário criado
- [ ] Roles diferentes funcionando
- [ ] Upgrade de plano funcionando
- [ ] Cancelamento de assinatura funcionando
- [ ] Browser: Login funcionando
- [ ] Browser: Página de assinaturas acessível
- [ ] Browser: Criar usuário funcionando

---

## 🎯 Testes Rápidos por Cenário

### Cenário: Usuário sem Assinatura
```php
$novo_user = App\Models\User::create([
    'name' => 'Sem Assinatura',
    'email' => 'sem@test.com',
    'password' => Hash::make('123')
]);

// Tentar acessar recurso
$novo_user->podeAcessarRecurso('estoque'); // false
// Ou: tentará redirecionar para /assinaturas
```

### Cenário: Plano Expirado
```php
$user->assinatura->update([
    'data_fim' => now()->subDay(),
    'status' => 'expirada'
]);

$user->temAssinaturaAtiva(); // false
// Sistema redireciona para renovar
```

### Cenário: Limite de Usuários Atingido
```php
// Plano Autônomo permite apenas 1
$autonomo = App\Models\Plano::where('nome', 'Autônomo')->first();
$user->assinatura->plano_id = $autonomo->id;
$user->assinatura->save();

// Tentar criar 2º usuário
$user->podeCriarUsuario(); // false
// Sistema não permite
```

---

## 🆘 Se Algo Der Errado

### Resetar Tudo
```bash
php artisan migrate:refresh
php artisan db:seed --class=PlanoSeeder
php artisan db:seed --class=RolePermissionSeeder
```

### Ver Erros
```bash
# Checar logs
tail -f storage/logs/laravel.log
```

### Testar Conexão com BD
```bash
php artisan tinker
DB::connection()->getPdo(); // Deve conectar
```