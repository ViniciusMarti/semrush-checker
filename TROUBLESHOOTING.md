# Opções para resolver o erro 403 Forbidden

Este erro geralmente ocorre por permissões de arquivos ou falta de uma configuração de índice no servidor Apache/Nginx.

## 1. Verifique as Permissões
Certifique-se de que os arquivos e pastas têm as permissões corretas (normalmente 755 para pastas e 644 para arquivos).
No terminal do servidor:
```bash
chmod 755 .
chmod 644 *
```

## 2. Arquivo .htaccess (Para Apache)
Se o servidor for Apache, crie um arquivo `.htaccess` na raiz para garantir que o `index.php` seja lido corretamente:
```apache
DirectoryIndex index.php
Options -Indexes +FollowSymLinks
```

## 3. Configuração do Domínio
Verifique se a 'Document Root' no seu painel (cPanel/Plesk) está apontando exatamente para a pasta onde os arquivos foram enviados.
