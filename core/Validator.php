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

    public static function email($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function password($password): array
    {
        $errors = [];
        
        // Longitud mínima
        if (strlen($password) < 8) {
            $errors[] = 'La contraseña debe tener al menos 8 caracteres';
        }
        
        // Al menos una mayúscula
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'La contraseña debe contener al menos una letra mayúscula';
        }
        
        // Al menos una minúscula
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'La contraseña debe contener al menos una letra minúscula';
        }
        
        // Al menos un número
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'La contraseña debe contener al menos un número';
        }
        
        // Al menos un carácter especial
        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = 'La contraseña debe contener al menos un carácter especial';
        }
        
        return $errors;
    }

    public static function validateRegistration(array $data): array
    {
        $errors = self::required($data, ['usuario', 'email', 'password', 'confirmPassword', 'nombre', 'apellidos']);
        
        // Validar email
        if (isset($data['email']) && !empty($data['email']) && !self::email($data['email'])) {
            $errors['email'] = 'El formato del email no es válido';
        }
        
        // Validar contraseña
        if (isset($data['password']) && !empty($data['password'])) {
            $passwordErrors = self::password($data['password']);
            if (!empty($passwordErrors)) {
                $errors['password'] = implode('. ', $passwordErrors);
            }
        }
        
        // Confirmar contraseña
        if (isset($data['password'], $data['confirmPassword']) && 
            $data['password'] !== $data['confirmPassword']) {
            $errors['confirmPassword'] = 'Las contraseñas no coinciden';
        }
        
        return $errors;
    }

    public static function validateUserCreation(array $data): array
    {
        $errors = self::required($data, ['usuario', 'email', 'password', 'nombre', 'apellidos', 'rol']);
        
        // Validar email
        if (isset($data['email']) && !empty($data['email']) && !self::email($data['email'])) {
            $errors['email'] = 'El formato del email no es válido';
        }
        
        // Validar contraseña
        if (isset($data['password']) && !empty($data['password'])) {
            $passwordErrors = self::password($data['password']);
            if (!empty($passwordErrors)) {
                $errors['password'] = implode('. ', $passwordErrors);
            }
        }
        
        // Validar rol
        if (isset($data['rol']) && !in_array($data['rol'], ['user', 'admin'])) {
            $errors['rol'] = 'El rol debe ser user o admin';
        }
        
        return $errors;
    }
}