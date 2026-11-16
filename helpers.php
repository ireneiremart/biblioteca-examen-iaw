<?php

require_once __DIR__ . '/config.php';

function h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function request_value($name, $default = '')
{
    $source = strtolower(FORM_METHOD) === 'post' ? $_POST : $_GET;

    if (!isset($source[$name]) || !is_scalar($source[$name])) {
        return $default;
    }

    return trim((string) $source[$name]);
}

function request_array($name)
{
    $source = strtolower(FORM_METHOD) === 'post' ? $_POST : $_GET;
    $values = isset($source[$name]) && is_array($source[$name]) ? $source[$name] : [];

    return array_values(array_filter($values, 'is_scalar'));
}

function page_url($page, $params = [])
{
    $query = $params ? '?' . http_build_query($params) : '';
    return $page . $query;
}

function field_input($name, $value = '', $required = true)
{
    $field = FIELDS[$name];
    $required_attribute = $required ? ' required' : '';
    $step = $name === 'preu' ? ' step="0.01" min="0"' : '';

    return sprintf(
        '<label>%s:<br><input type="%s" name="%s" value="%s" size="%d" maxlength="%d"%s%s></label>',
        h($field['label']),
        h($field['type']),
        h($name),
        h($value),
        (int) $field['size'],
        (int) $field['size'],
        $required_attribute,
        $step
    );
}

function missing_fields($data)
{
    $missing = [];

    foreach (FIELDS as $name => $field) {
        if (!isset($data[$name]) || $data[$name] === '') {
            $missing[] = $field['label'];
        }
    }

    return $missing;
}
