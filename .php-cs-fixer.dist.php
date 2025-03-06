<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/app')
    ->in(__DIR__ . '/tests')
    ->exclude('vendor');

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@PSR12' => true,
    'array_syntax' => ['syntax' => 'short'],
    'binary_operator_spaces' => [
        'operators' => [
            '='  => 'align_single_space_minimal',
            '=>' => 'align_single_space_minimal'
        ]
    ],
    'blank_line_before_statement' => [
        'statements' => ['return']
    ],
    // Add other rules as required by your team’s standards
])
    ->setFinder($finder)
    ->setRiskyAllowed(true);
