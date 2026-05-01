# 📖 Guia de Acesso - Sistema de Assinaturas e Planos

## 🚀 Primeiros Passos

### 1. **Executar as Migrations**
```bash
php artisan migrate
```
Isto criará as tabelas: `planos`, `assinaturas`, `roles`, `permissions`, etc.

### 2. **Popular os Dados Iniciais (Seeders)**
```bash
# Criar os 3 planos padrão
php artisan db:seed --class=PlanoSeeder

# Criar os 5 roles e permissões
php artisan db:seed --class=RolePermissionSeeder
```

### 3. **Testar o Login**
- Acesse: `http://seu-dominio/login`
- Use as credenciais do seu usuário teste ou crie um novo

---

## 🎯 Fluxo de Uso

### **Cenário 1: Usuário Novo sem Assinatura**

```
1. Usuário faz login
   └─> Sistema detecta que não tem assinatura
   └─> Redireciona para /assinaturas

2. Página de Assinatura mostra:
   ├─ Aviso: "Assinatura Necessária"
   ├─ 3 planos disponíveis
   └─ Botão "Assinar" para cada plano

3. Usuário clica em "Assinar Pequena Empresa"
   └─> Cria assinatura com status 'ativa'
   └─> Redireciona para dashboard
   └─> Sistema agora permite acesso aos módulos
```

---

## 📍 URLs de Acesso

### **Para Gerenciar Assinaturas**
```
GET  /assinaturas           → Ver assinatura atual
POST /assinaturas          → Criar nova assinatura
POST /assinaturas/upgrade  → Fazer upgrade para outro plano
POST /assinaturas/cancelar → Cancelar assinatura
```

### **Para Gerenciar Usuários (somente Admin)**
```
GET    /usuarios           → Listar usuários da empresa
GET    /usuarios/create    → Formulário para novo usuário
POST   /usuarios           → Criar usuário
GET    /usuarios/{id}/edit → Editar usuário
PUT    /usuarios/{id}      → Atualizar usuário
DELETE /usuarios/{id}      → Deletar usuário
```

---

## 💡 Exemplos de Uso

### **Exemplo 1: Criar Assinatura via Artisan Tinker**

```bash
php artisan tinker
```

```php
# Encontrar um plano
$plano = App\Models\Plano::where('nome', 'Pequena Empresa')->first();

# Encontrar um usuário
$user = App\Models\User::find(1);

# Criar assinatura
App\Models\Assinatura::create([
    'user_id' => $user->id,
    'plano_id' => $plano->id,
    'status' => 'ativa',
    'data_inicio' => now(),
    'data_fim' => now()->addMonth(),
    'data_renovacao' => now()->addMonth(),
    'periodicidade' => 'mensal',
    'valor' => $plano->preco_mensal
]);

# Atribuir role ao usuário
$user->assignRole('Administrador');

# Verificar se tem assinatura ativa
$user->temAssinaturaAtiva(); // true

# Sair
exit
```

### **Exemplo 2: Criar Assinatura via Controller**

No seu controller:

```php
use App\Models\Assinatura;
use App\Models\Plano;
use Illuminate\Support\Facades\Auth;

public function criar()
{
    $plano = Plano::find(2); // Pequena Empresa
    $user = Auth::user();

    Assinatura::create([
        'user_id' => $user->id,
        'plano_id' => $plano->id,
        'status' => 'ativa',
        'data_inicio' => now(),
        'data_fim' => now()->addMonth(),
        'data_renovacao' => now()->addMonth(),
        'periodicidade' => 'mensal',
        'valor' => $plano->preco_mensal
    ]);

    $user->assignRole('Gerente Estoque');

    return redirect('/dashboard')->with('success', 'Assinatura criada!');
}
```

### **Exemplo 3: Criar Usuário com Role**

Na página `/usuarios/create`:

```html
<form action="/usuarios" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Nome completo" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Senha" required>
    <input type="password" name="password_confirmation" placeholder="Confirmar senha" required>
    
    <select name="role" required>
        <option value="">Selecione o Papel</option>
        <option value="Administrador">Administrador</option>
        <option value="Gerente Estoque">Gerente Estoque</option>
        <option value="Gerente Financeiro">Gerente Financeiro</option>
        <option value="Vendedor">Vendedor</option>
        <option value="Usuário Comum">Usuário Comum</option>
    </select>
    
    <button type="submit">Criar Usuário</button>
</form>
```

---

## 🔒 Verificações Automáticas

### **Na Página de Dashboard**
```php
$user = Auth::user();

// Verificar assinatura
if (!$user->temAssinaturaAtiva()) {
    // Redirecionar para assinaturas
    return redirect('/assinaturas')->with('warning', 'Assinatura expirada');
}

// Verificar acesso a recurso
if (!$user->podeAcessarRecurso('estoque')) {
    abort(403, 'Seu plano não permite acessar estoque');
}

// Verificar limite
$maxClientes = $user->getLimite('max_clientes');
$clientesAtuais = Cliente::where('user_id', $user->id)->count();

if ($clientesAtuais >= $maxClientes && $maxClientes > 0) {
    // Mostrar aviso de limite atingido
}
```

### **Nos Middlewares de Rota**
```php
// Rotas protegidas por plano
Route::get('/estoque', Controller::class)->middleware('plano:estoque');

// Rotas protegidas por permissão
Route::get('/usuarios', UsuarioController::class)->middleware('permission:ver_usuarios');

// Ambas
Route::post('/compras', CompraController::class)
    ->middleware(['plano:compras', 'permission:criar_compras']);
```

---

## 📊 Estados de Assinatura

```
┌─────────────────────────────────────────┐
│        CICLO DE ASSINATURA              │
├─────────────────────────────────────────┤
│                                         │
│  ativa → (tempo passa) → expirada       │
│    ↓                                    │
│  cancelada (a qualquer momento)         │
│    ↓                                    │
│  suspensa (por falta de pagamento)      │
│                                         │
└─────────────────────────────────────────┘
```

### **Verificar Status**
```php
$assinatura = $user->assinatura;

if ($assinatura->estaAtiva()) {
    // Acesso liberado
}

$diasParaExpirar = $assinatura->diasParaExpirar();
if ($diasParaExpirar <= 7) {
    // Mostrar aviso de vencimento próximo
}
```

---

## ⚙️ Permissões Disponíveis

### **Roles e Suas Permissões**

#### **Administrador**
- ✅ Tudo (acesso completo ao sistema)

#### **Gerente Estoque**
- ✅ Ver/Criar/Editar Produtos
- ✅ Ver/Criar/Editar Compras
- ✅ Gerenciar Estoque
- ✅ Ver Movimentações
- ✅ Acessar Dashboard

#### **Gerente Financeiro**
- ✅ Ver/Gerenciar Financeiro
- ✅ Ver/Criar/Editar Lançamentos
- ✅ Ver Vendas e Compras
- ✅ Ver Relatórios Básicos
- ✅ Acessar Dashboard

#### **Vendedor**
- ✅ Ver/Criar/Editar Clientes
- ✅ Ver Produtos e Serviços
- ✅ Ver/Criar/Editar Vendas
- ✅ Acessar Dashboard

#### **Usuário Comum**
- ✅ Apenas Visualizar (Clientes, Produtos, Vendas, Dashboard)

---

## 🔄 Workflow Completo

### **Para Autônomo com Plano Autônomo**
```
1. Faz login
2. Vai para /assinaturas
3. Escolhe "Assinar - Autônomo (R$ 49/mês)"
4. Cria assinatura
5. Agora pode usar: Clientes, Produtos, Serviços, Vendas
6. ❌ NÃO pode usar: Estoque, Financeiro avançado
```

### **Para Pequena Empresa com Plano Pequena Empresa**
```
1. Admin faz login
2. Vai para /assinaturas
3. Escolhe "Assinar - Pequena Empresa (R$ 149/mês)"
4. Cria assinatura
5. Vai para /usuarios/create
6. Cria 4 usuários com roles diferentes:
   ├─ João (Gerente Estoque)
   ├─ Maria (Gerente Financeiro)
   ├─ Pedro (Vendedor)
   └─ Ana (Usuário Comum)
7. Cada um usa apenas sua área:
   ├─ João: Vê Estoque, Compras, Produtos
   ├─ Maria: Vê Financeiro, Relatórios
   ├─ Pedro: Vê Vendas, Clientes
   └─ Ana: Vê apenas informações básicas
```

---

## 🆘 Troubleshooting

### **Erro: "Assinatura expirada"**
```bash
# Verificar assinatura do usuário
php artisan tinker
$user = App\Models\User::find(1);
$user->assinatura;

# Se está expirada, renovar
$user->assinatura->update([
    'status' => 'ativa',
    'data_fim' => now()->addMonth()
]);
```

### **Erro: "Recurso não disponível"**
```bash
# Verificar plano e recursos
php artisan tinker
$user->plano;
$user->podeAcessarRecurso('estoque');

# Ver todos os recursos do plano
$user->plano->recursos;
```

### **Usuário não consegue acessar módulo**
```php
// Verificar role
$user->getRoleNames(); // Ver roles do usuário

// Verificar permissões
$user->getAllPermissions(); // Ver todas as permissões

// Dar permissão manualmente
$user->givePermissionTo('ver_estoque');
```

---

## 📱 URLs Rápidas

| Função | URL | Método |
|--------|-----|--------|
| Ver assinatura | `/assinaturas` | GET |
| Fazer upgrade | `/assinaturas/upgrade` | POST |
| Cancelar | `/assinaturas/cancelar` | POST |
| Listar usuários | `/usuarios` | GET |
| Novo usuário | `/usuarios/create` | GET |
| Salvar usuário | `/usuarios` | POST |
| Editar usuário | `/usuarios/{id}/edit` | GET |
| Atualizar usuário | `/usuarios/{id}` | PUT |
| Deletar usuário | `/usuarios/{id}` | DELETE |
| Dashboard | `/dashboard` | GET |

---

## 🎓 Próximas Etapas

1. **Teste o Sistema**
   - Execute as migrations e seeders
   - Faça login e vá para /assinaturas
   - Crie uma assinatura
   - Crie usuários com roles diferentes

2. **Integre com Views**
   - Crie formulários para as ações
   - Adicione validações
   - Implemente feedback visual

3. **Implemente Pagamento**
   - Integre Stripe ou Mercado Pago
   - Configure webhooks para renovação
   - Crie sistema de faturas

4. **Configure Scheduler**
   - Adicione comando de verificação de expiradas
   - Configure cron job do servidor
