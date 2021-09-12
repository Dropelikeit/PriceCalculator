<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
return $config
    ->setRiskyAllowed(true)
    ->setRules([
    '@PSR2' => true,
    'braces' => false,
    'array_indentation' => true,
    'array_syntax' => [
        'syntax' => 'short',
    ],
    'blank_line_after_opening_tag' => false,
    'blank_line_before_statement' => true,
    'cast_spaces' => true,
    'concat_space' => [
        'spacing' => 'one',
    ],
    'declare_equal_normalize' => true,
    'include' => true,
    'function_typehint_space' => true,
    'linebreak_after_opening_tag' => true,
    'lowercase_cast' => true,
    'lowercase_static_reference' => true,
    'magic_constant_casing' => true,
    'modernize_types_casting' => true,
    'native_function_casing' => true,
    'new_with_braces' => true,
    'no_alternative_syntax' => true,
    'no_empty_comment' => true,
    'no_empty_statement' => true,
    'no_closing_tag' => true,
    'no_extra_blank_lines' => true,
    'no_leading_import_slash' => true,
    'no_leading_namespace_whitespace' => true,
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_null_property_initialization' => true,
    'no_short_bool_cast' => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'no_spaces_around_offset' => true,
    'no_superfluous_elseif' => true,
    'no_trailing_comma_in_list_call' => true,
    'no_trailing_comma_in_singleline_array' => true,
    'no_unneeded_control_parentheses' => true,
    'no_unneeded_curly_braces' => true,
    'no_unneeded_final_method' => true,
    'no_unused_imports' => true,
    'no_useless_else' => true,
    'no_whitespace_before_comma_in_array' => true,
    'no_whitespace_in_blank_line' => true,
    'normalize_index_brace' => true,
    'object_operator_without_whitespace' => true,
    'ordered_imports' => true,
    'phpdoc_annotation_without_dot' => true,
    'phpdoc_indent' => true,
    'phpdoc_no_access' => true,
    'return_type_declaration' => true,
    'short_scalar_cast' => true,
    'simplified_null_return' => true,
    'single_blank_line_before_namespace' => true,
    'single_quote' => true,
    'standardize_not_equals' => true,
    'ternary_operator_spaces' => true,
    'ternary_to_null_coalescing' => true,
    'trim_array_spaces' => true,
    'unary_operator_spaces' => true,
    'visibility_required' => true,
    'trailing_comma_in_multiline' => true,
    'yoda_style' => false,

    /** @risky */
    'strict_comparison' => true,
    'dir_constant' => true,
])->setFinder($finder);
