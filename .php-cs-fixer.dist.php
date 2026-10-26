<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(['src', 'test', 'integrations'])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => ['class', 'const', 'function'],
        ],
        'phpdoc_summary' => false,
        'phpdoc_to_comment' => false,
        '@PSR12' => true,
        'declare_strict_types' => true,
        'single_quote' => true,
        'yoda_style' => [
            'equal' => true,
            'identical' => true,
        ],
        'blank_line_before_statement' => [
            'statements' => ['for', 'foreach', 'if', 'return', 'switch'],
        ],
        'class_attributes_separation' => [
            'elements' => ['method' => 'one'],
        ],
        'trailing_comma_in_multiline' => [
            'elements' => ['arrays', 'arguments', 'parameters'],
        ],
        'no_empty_phpdoc' => true,
        'phpdoc_trim' => true,
        'phpdoc_no_empty_return' => true,
        'phpdoc_scalar' => true,
        'no_unused_imports' => true,
        'concat_space' => ['spacing' => 'one'],
        'array_syntax' => ['syntax' => 'short'],
        'list_syntax' => ['syntax' => 'short'],
        'no_null_property_initialization' => true,
        'native_function_invocation' => ['include' => ['@compiler_optimized'], 'scope' => 'all', 'strict' => false],
        'ordered_class_elements' => true,
        'php_unit_method_casing' => false,
        'fully_qualified_strict_types' => false,
    ])
    ->setFinder($finder)
    ->setCacheFile('.php_cs.' . getenv('PHP_VERSION') . '.cache')
    ->setUsingCache(true);
