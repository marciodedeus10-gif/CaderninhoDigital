# 🚀 COMO EXECUTAR SETUP (3 FORMAS)

Escolha a forma mais fácil para você:

---

## ✅ FORMA 1: Script Automático BAT (MAIS FÁCIL - Windows)

### Passo 1: Abrir Explorador de Arquivos
```
Windows + E
Navegue até: C:\Users\Oycram10\Desktop\agenda\CaderninhoDigital
```

### Passo 2: Duplo-clique em `setup.bat`
- Abrirá um terminal preto
- Executará os 3 comandos automaticamente
- Espere ver: "SUCESSO! Sistema configurado com sucesso!"

### Passo 3: Pressione qualquer tecla
- Terminal fecha automaticamente

✅ **Pronto!** Sistema está 100% configurado.

---

## ✅ FORMA 2: PowerShell Script

### Passo 1: Abrir PowerShell
```
Windows + X
Clique em "Windows PowerShell (Administrador)"
```

### Passo 2: Navegue até a pasta
```powershell
cd C:\Users\Oycram10\Desktop\agenda\CaderninhoDigital
```

### Passo 3: Execute o script
```powershell
powershell -ExecutionPolicy Bypass -File .\setup.ps1
```

Você verá:
```
[1/3] Criando tabelas no banco de dados
Executando: php artisan migrate
✅ Sucesso!

[2/3] Populando planos
Executando: php artisan db:seed --class=PlanoSeeder
✅ Sucesso!

[3/3] Criando roles e permissões
Executando: php artisan db:seed --class=RolePermissionSeeder
✅ Sucesso!

✅ SETUP CONCLUÍDO!
```

✅ **Pronto!** Sistema está 100% configurado.

---

## ✅ FORMA 3: Executar Comandos Manualmente (Controle Total)

### Passo 1: Abrir PowerShell
```
Windows + X → Windows PowerShell (Administrador)
```

### Passo 2: Navegue até a pasta
```powershell
cd C:\Users\Oycram10\Desktop\agenda\CaderninhoDigital
```

### Passo 3: Execute cada comando

**Comando 1:**
```powershell
php artisan migrate
```

Espere ver:
```
✓ Done
```

**Comando 2:**
```powershell
php artisan db:seed --class=PlanoSeeder
```

Espere ver:
```
✓ Done
```

**Comando 3:**
```powershell
php artisan db:seed --class=RolePermissionSeeder
```

Espere ver:
```
✓ Done
```

✅ **Pronto!** Sistema está 100% configurado.

---

## 🎯 Depois do Setup

### Testar no Terminal (Tinker)

```powershell
php artisan tinker
```

Digite:
```php
App\Models\Plano::count()
```

Deve aparecer:
```
=> 3
```

Se aparecer `3`, funcionou! ✅

---

## 🌐 Testar no Navegador

### Passo 1: Inicie o servidor
```powershell
php artisan serve
```

Você verá:
```
Starting Laravel development server: http://127.0.0.1:8000
```

### Passo 2: Abra o navegador
```
http://127.0.0.1:8000/assinaturas
```

Você verá uma página com os 3 planos disponíveis ✅

---

## ❌ Se Algo der Errado

### Erro 1: "PHP not found"
```powershell
# Verifique se PHP está instalado
php -v
```

Se não aparecer nada, instale PHP ou configure a variável de ambiente.

### Erro 2: "Composer not found"
```powershell
# Instale dependências
composer install
```

### Erro 3: "Database does not exist"
```powershell
# Crie o banco manualmente ou:
php artisan db:create
```

### Erro 4: "Class PlanoSeeder not found"
```powershell
# Execute composer dump-autoload
composer dump-autoload
```

### Erro 5: "No application encryption key"
```powershell
php artisan key:generate
```

---

## 📱 Resume dos 3 Comandos

| Comando | O que faz | Tempo |
|---------|-----------|-------|
| `php artisan migrate` | Cria as tabelas no banco | ~5-10s |
| `php artisan db:seed --class=PlanoSeeder` | Cria 3 planos de preço | ~2s |
| `php artisan db:seed --class=RolePermissionSeeder` | Cria 5 roles e 40+ permissões | ~3s |

**Total: ~15 segundos** ⚡

---

## 📋 Tabela de Decisão

Qual forma escolher?

| Situação | Recomendação |
|----------|--------------|
| Primeira vez, quer simplificar | **Forma 1 (BAT)** - Mais fácil |
| Gosta de ver cada passo | **Forma 3 (Manual)** - Mais controle |
| Quer visual bonito | **Forma 2 (PowerShell)** - Mais chique |
| Acabou de instalar tudo | **Qualquer uma funciona** |
| Quer automatizar | **Forma 1 ou 2** - Scripts |

---

## ✅ Checklist Final

Depois que terminar, marque:

- [ ] Um dos 3 scripts executado com sucesso
- [ ] Mensagens dizendo "✓ Done" apareceram
- [ ] `php artisan tinker` abre terminal interativo
- [ ] `App\Models\Plano::count()` retorna 3
- [ ] Servidor inicia com `php artisan serve`
- [ ] Navegador abre http://127.0.0.1:8000/assinaturas sem erro

Se tudo marcado = Sistema 100% funcionando! 🎉

---

## 🎓 Próximas Etapas

1. **Criar usuário teste** (no Tinker)
2. **Atribuir role ao usuário** (Administrador, Vendedor, etc)
3. **Fazer login** no sistema
4. **Gerenciar assinaturas** via browser
5. **Criar múltiplos usuários** com roles diferentes

Quer um guia para isso também?
