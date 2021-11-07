<?php

spl_autoload_register("createAutoload");

/**
 * @param $class
 */
function createAutoload($class)
{
    $namespace = "Source\\";
    $namespaceSize = strlen($namespace);
    $rootDir = __DIR__ . "/";

    // Remova o namespace do caminho
    $relativePath = substr($class, $namespaceSize);

    if (!checkClassInNamespace($namespace, $namespaceSize, $class)) {
        return;
    }

    // Caminho absoluto para a classe
    $classFile = createAbsolutePath($rootDir, $relativePath);

    if (is_file($classFile)) {
        include_once $classFile;
    }
}

/**
 *  Verifica se o valor do namespace é igual ao caminho da classe nos primeiros caracteres.
 *  Nesse caso, apenas a classe que está dentro do mesmo provedor ou namespace será incluída.
 *
 * @param string $namespace
 * @param int $namespaceSize
 * @param string $class
 * @return bool
 */
function checkClassInNamespace(string $namespace, int $namespaceSize, string $class): bool
{
    if (strncmp($namespace, $class, $namespaceSize) !== 0) {
        return false;
    }
    return true;
}

/**
 * Gerador de caminho absoluto.
 *
 * @param string $rootDir
 * @param string $relativePath
 * @return string
 */
function createAbsolutePath(string $rootDir, string $relativePath): string
{
    return $rootDir . str_replace("\\", "/", $relativePath) . ".php";
}
