<?php
$databaseUrl = getenv('DATABASE_URL') ?: '';
$localConfig = __DIR__ . '/database.local.php';
if ($databaseUrl === '' && is_file($localConfig)) {
    $databaseUrl = (string) require $localConfig;
}
if ($databaseUrl === '') {
    throw new RuntimeException('Set DATABASE_URL or create config/database.local.php.');
}
$parts = parse_url($databaseUrl);
if ($parts === false || ($parts['scheme'] ?? '') !== 'postgresql' || !isset($parts['host'], $parts['user'], $parts['pass'])) {
    throw new RuntimeException('DATABASE_URL must be a valid postgresql:// connection URL.');
}

define('DB_HOST',        $parts['host']);
define('DB_PORT',        (string) ($parts['port'] ?? 5432));
define('DB_NAME',        ltrim($parts['path'] ?? '/postgres', '/'));
define('DB_USER',        rawurldecode($parts['user']));
define('DB_PASS',        rawurldecode($parts['pass']));
define('DB_SSLMODE',     getenv('DB_SSLMODE') ?: 'require');
define('DB_SSLROOTCERT', getenv('DB_SSLROOTCERT') ?: '');

define('BASE_URL', rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/'));

function getDBConnection(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s;sslmode=%s', DB_HOST, DB_PORT, DB_NAME, DB_SSLMODE);
        if (DB_SSLROOTCERT !== '') {
            $dsn .= ';sslrootcert=' . DB_SSLROOTCERT;
        }
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => DB_PORT === '6543',
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log('G&G Audit DB Error: ' . $e->getMessage());
            die('<div style="font-family:sans-serif;padding:2rem;color:#991b1b">
                    <h2>Database connection failed.</h2>
                    <p>Please check your Supabase DATABASE_URL configuration.</p>
                 </div>');
        }
    }
    return $pdo;
}
