# 1. IMAGEM BASE: Usamos uma imagem PHP com Apache (servidor web)
# e as extensões necessárias para MySQL (pdo_mysql)
FROM php:8.2-apache

# 2. DEFINIÇÃO DO DIRETÓRIO DE TRABALHO
# O diretório /var/www/html é o padrão do Apache para servir arquivos.
WORKDIR /var/www/html

# 3. INSTALAÇÃO DE DEPENDÊNCIAS DO PHP
# Instala extensões PHP e ferramentas necessárias.
# A flag --no-install-recommends otimiza o tamanho da imagem.
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    git \
    zip \
    unzip \
    && \
    # Habilita a extensão pdo_mysql para comunicação com o banco de dados
    docker-php-ext-install pdo_mysql

# 4. INSTALAÇÃO DO COMPOSER
# Baixa e instala o Composer globalmente, que é necessário para o 'vendor/autoload.php'.
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# 5. CONFIGURAÇÃO DO APACHE
# (Opcional, mas recomendado para remover o index.html padrão e garantir que o Apache
# use o index.php como arquivo principal)
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN a2enmod rewrite
# Copiar um arquivo de configuração do site (Virtual Host)
# COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# 6. COPIAR OS ARQUIVOS DA APLICAÇÃO
# Copia todo o conteúdo da sua pasta (o contexto) para o diretório de trabalho.
COPY . .

# 7. INSTALAÇÃO DAS DEPENDÊNCIAS DO PROJETO
# Executa o Composer para instalar as bibliotecas do projeto (framework, etc.)
# O Composer precisa rodar dentro do container para criar a pasta 'vendor'.
RUN composer install --no-dev --optimize-autoloader

# 8. PERMISSÕES DE ARQUIVO
# Define as permissões corretas para que o servidor web (Apache) possa ler os arquivos.
RUN chown -R www-data:www-data /var/www/html

# 9. INSTRUÇÃO DE START
# O comando padrão do PHP-Apache (CMD [ "apache2-foreground" ])
# já inicia o servidor e o PHP, então não precisamos de um CMD explícito.