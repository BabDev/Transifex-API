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
        'empty_return',
        'header_comment',
        'no_useless_else',
        'no_useless_return',
        'ordered_use',
        'short_array_syntax',
        // symfony
        'array_element_no_space_before_comma',
        'array_element_white_space_after_comma',
        'blankline_after_open_tag',
        'function_typehint_space',
        'include',
        'join_function',
        'list_commas',
        'multiline_array_trailing_comma',
        'native_function_casing',
        'new_with_braces',
        'no_blank_lines_after_class_opening',
        'no_empty_lines_after_phpdocs',
        'no_empty_phpdoc',
        'phpdoc_annotation_without_dot',
        'phpdoc_indent',
        'phpdoc_inline_tag',
        'phpdoc_no_empty_return',
        'phpdoc_params',
        'phpdoc_scalar',
        'phpdoc_separation',
        'phpdoc_short_description',
        'phpdoc_single_line_var_spacing',
        'phpdoc_trim',
        'phpdoc_type_to_var',
        'phpdoc_types',
        'phpdoc_var_without_name',
        'remove_lines_between_uses',
        'return',
        'self_accessor',
        'single_array_no_trailing_comma',
        'single_blank_line_before_namespace',
        'single_quote',
        'spaces_after_semicolon',
        'spaces_before_semicolon',
        'spaces_cast',
        'ternary_spaces',
        'trim_array_spaces',
        'unneeded_control_parentheses',
        'unused_use',
        'whitespacy_lines',
    ])
    ->finder(
        Symfony\CS\Finder::create()
            ->in([__DIR__ . '/src', __DIR__ . '/tests'])
    );
