<?php

namespace App\Models\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

/**
 * Trait to automatically log model changes to audit_logs table.
 */
trait Auditable
{
    /**
     * Boot the auditable trait.
     */
    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            $model->writeAuditLog('created', null, $model->getAuditPayload());
        });

        static::updated(function ($model) {
            $model->writeAuditLog('updated', $model->getOriginal(), $model->getAuditPayload());
        });

        static::deleted(function ($model) {
            $model->writeAuditLog('deleted', $model->getOriginal(), null);
        });
    }

    /**
     * Get the payload to log (can be overridden in models).
     */
    protected function getAuditPayload(): array
    {
        return $this->getAttributes();
    }

    /**
     * Write an audit log entry.
     */
    protected function writeAuditLog(?string $eventType, $oldValues, $newValues): void
    {
        // Skip if running in console (migrations, seeds, etc.)
        if (app()->runningInConsole() && !app()->runningUnitTests()) {
            return;
        }

        AuditLog::create([
            'company_id'  => $this->company_id ?? null,
            'user_id'     => Auth::id(),
            'event_type'  => $eventType,
            'description' => $this->getAuditDescription($eventType),
            'ip_address'  => request()?->ip(),
            'user_agent'  => request()?->userAgent(),
            'entity_type' => static::class,
            'entity_id'   => $this->id,
            'old_values'  => $oldValues ? json_encode($oldValues) : null,
            'new_values'  => $newValues ? json_encode($newValues) : null,
        ]);
    }

    /**
     * Generate audit description (can be overridden in models).
     */
    protected function getAuditDescription(string $eventType): string
    {
        $modelName = class_basename($this);
        return sprintf('%s %s (ID: %s)', $modelName, $eventType, $this->id);
    }
}
