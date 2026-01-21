<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Crypt;

/**
 * Encrypted string cast for sensitive text fields.
 * Automatically encrypts on save and decrypts on read.
 */
class EncryptedString implements CastsAttributes
{
    /**
     * Transform the attribute from the underlying model values.
     */
    public function get($model, string $key, $value, array $attributes): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            // If decryption fails, return null (data may be unencrypted from before migration)
            \Log::warning("Failed to decrypt {$key} for model " . get_class($model) . " ID {$model->id}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Transform the attribute to its underlying model values.
     */
    public function set($model, string $key, $value, array $attributes): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return Crypt::encryptString($value);
    }
}
