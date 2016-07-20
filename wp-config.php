<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'wp_nemt');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '');

/** nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '7Nlz-~%mw_%:Ius@*A%cXIhCaaIQej?lxJ:}awKTwxP/?- tu[[b4qYl5j/lzXb.');
define('SECURE_AUTH_KEY',  'I|Cm-Ykf|kC~yI1y+||K@cCExZ|.O1`-5k}M,u]Sb|9n-#<-6].LRS7@bR~8YW|k');
define('LOGGED_IN_KEY',    '[Wd5o--%bgXL~&4-9:g}J7JDq|E ?b*`x}75s~{jLJKSxw/<QfhAW7&JJ+MzfJ^s');
define('NONCE_KEY',        '^66l|Axl)oi<Ob$F%}`.]zIqC<}+8? g(Mr@F3W[H-`=+).Ig*;pbM8%dG1lA:&&');
define('AUTH_SALT',        '=*vwU<k6E(reN WDQ+@)YP_~Pz$A#=Qqg;A1<i-=^7N;=93cm*lXc8H {qts{dyT');
define('SECURE_AUTH_SALT', 'B(gVA+G@/o?Eu>EtZ7P}u+CkZycN!Re9t-K1UUcCO`YGx,DMW mNOSTM(nmWo*{9');
define('LOGGED_IN_SALT',   'bX(o[V:2>-^I|aL!{G#r]G3<=zrC=iC6LQtVTtC&}.j(ZYH=Y5-<[c1 +P&A}7+I');
define('NONCE_SALT',       'TKOw){+:mMQX54z*|@UQ8^+sme0S3cix:nWymkMPD8-Ds)E|-(ofO=83!5Sshv/-');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';


/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
