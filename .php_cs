<?php

$header = <<<EOF
BabDev Transifex Package

(c) Michael Babker <michael.babker@gmail.com>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

return Symfony\CS\Config\Config::create()
    ->setUsingLinter(false)
    ->setUsingCache(true)
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers([
        // contrib
        'align_double_arrow',
        'align_equals',
        'concat_with_spaces',
        'header_comment',
        'ordered_use',
        'short_array_syntax',
        // symfony
        'array_element_no_space_before_comma',
        'array_element_white_space_after_comma',
        'blankline_after_open_tag',
        'empty_return',
        'function_typehint_space',
        'include',
        'join_function',
        'list_commas',
        'multiline_array_trailing_comma',
        'no_blank_lines_after_class_opening',
        'no_empty_lines_after_phpdocs',
        'phpdoc_indent',
        'phpdoc_inline_tag',
        'phpdoc_no_empty_return',
        'phpdoc_params',
        'phpdoc_scalar',
        'phpdoc_short_description',
        'phpdoc_trim',
        'phpdoc_type_to_var',
        'phpdoc_types',
        'phpdoc_var_without_name',
        'remove_lines_between_uses',
        'return',
        'single_array_no_trailing_comma',
        'single_blank_line_before_namespace',
        'single_quote',
        'spaces_cast',
        'ternary_spaces',
        'trim_array_spaces',
        'unused_use',
    ])
    ->finder(
        Symfony\CS\Finder\DefaultFinder::create()
            ->in([__DIR__ . '/src', __DIR__ . '/tests'])
    );
