<?php

$finder = PhpCsFixer\Finder::create()
    ->in(
        [
            __DIR__ . '/src',
            __DIR__ . '/tests',
        ]
    )
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return PhpCsFixer\Config::create()
    ->setRules(
        [
            'psr0'                                        => false,
            '@PSR2'                                       => true,
            'align_multiline_comment'                     => true,
            'array_indentation'                           => true,
            'array_syntax'                                => [
                'syntax' => 'short',
            ],
            'blank_line_after_opening_tag'                => false,
            'blank_line_before_statement'                 => [
                'statements' => [
                    'break',
                    'case',
                    'continue',
                    'for',
                    'foreach',
                    'if',
                    'return',
                    'switch',
                    'throw',
                    'try',
                    'while',
                ],
            ],
            'braces'                                      => true,
            'cast_spaces'                                 => [
                'space' => 'single',
            ],
            'class_definition'                            => true,
            'combine_consecutive_issets'                  => true,
            'combine_consecutive_unsets'                  => true,
            'compact_nullable_typehint'                   => true,
            'concat_space'                                => [
                'spacing' => 'one',
            ],
            'declare_strict_types'                        => true,
            'dir_constant'                                => true,
            'function_to_constant'                        => true,
            'function_typehint_space'                     => true,
            'increment_style'                             => [
                'style' => 'post',
            ],
            'is_null'                                     => true,
            'linebreak_after_opening_tag'                 => false,
            'logical_operators'                           => true,
            'lowercase_cast'                              => true,
            'lowercase_static_reference'                  => true,
            'magic_constant_casing'                       => true,
            'method_argument_space'                       => [
                'on_multiline' => 'ensure_fully_multiline',
            ],
            'method_chaining_indentation'                 => true,
            'modernize_types_casting'                     => true,
            'native_constant_invocation'                  => true,
            'native_function_casing'                      => true,
            'native_function_invocation'                  => true,
            'new_with_braces'                             => true,
            'no_alias_functions'                          => true,
            'no_blank_lines_after_class_opening'          => true,
            'no_blank_lines_after_phpdoc'                 => true,
            'no_empty_phpdoc'                             => true,
            'no_empty_statement'                          => true,
            'no_extra_blank_lines'                        => true,
            'no_leading_import_slash'                     => true,
            'no_mixed_echo_print'                         => true,
            'no_multiline_whitespace_around_double_arrow' => true,
            'no_null_property_initialization'             => true,
            'no_short_bool_cast'                          => true,
            'no_short_echo_tag'                           => true,
            'no_spaces_after_function_name'               => true,
            'no_spaces_inside_parenthesis'                => true,
            'no_superfluous_elseif'                       => true,
            'no_trailing_comma_in_singleline_array'       => true,
            'no_trailing_whitespace'                      => true,
            'no_trailing_whitespace_in_comment'           => true,
            'no_unneeded_control_parentheses'             => true,
            'no_unused_imports'                           => true,
            'no_useless_else'                             => true,
            'no_useless_return'                           => true,
            'no_whitespace_before_comma_in_array'         => true,
            'ordered_imports'                             => true,
            'phpdoc_align'                                => true,
            'phpdoc_scalar'                               => true,
            'protected_to_private'                        => true,
            'return_type_declaration'                     => true,
            'set_type_to_cast'                            => true,
            'simplified_null_return'                      => true,
            'single_blank_line_at_eof'                    => true,
            'single_class_element_per_statement'          => [
                'elements' => ['property'],
            ],
            'single_import_per_statement'                 => true,
            'single_line_after_imports'                   => true,
            'switch_case_semicolon_to_colon'              => true,
            'switch_case_space'                           => true,
            'ternary_to_null_coalescing'                  => true,
            'trailing_comma_in_multiline_array'           => true,
            'visibility_required'                         => [
                'elements' => ['property', 'method', 'const'],
            ],
            'yoda_style'                                  => false,
        ]
    )
    ->setRiskyAllowed(true)
    ->setFinder($finder);
