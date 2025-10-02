<?php
namespace Core;


final class Validator
{
    public static function required(array $data, array $fields): array
    {
        $errors = [];
        foreach ($fields as $f) {
            if (!isset($data[$f]) || trim((string) $data[$f]) === '') {
                $errors[$f] = 'El campo ' . $f . ' es obligatorio';
            }
        }
        return $errors;
    }
}