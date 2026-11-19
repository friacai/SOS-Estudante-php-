<?php
/**
 * SOS-Estudante
 * Ponto de Entrada da Aplicação Web.
 */

// Tratamento de erros básico
error_reporting(E_ALL);
ini_set('display_errors', '0');

require_once __DIR__ . '/config/app.php';

// Carrega rotas e despacha requisição
$router = require_once __DIR__ . '/routes/web.php';
$router->dispatch();
