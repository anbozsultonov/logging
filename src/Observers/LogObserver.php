<?php

namespace Model\Logging\Observers;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogObserver
{
    public function creating(Model $model): void
    {
        $this->log('creating', $model);
    }

    public function updating(Model $model): void
    {
        $this->log('updating', $model);
    }


    public function deleting(Model $model): void
    {
        $this->log('deleting', $model);
    }

    private function log(string $action, Model $model): void
    {
        $tableName = $model->getTable();
        $user = Auth::user();
        $newData = $model->getDirty();
        $oldData = [];
        if ($action === 'updating') {
            $oldData = $this->getOldData($newData, $model);
        }

        Log::build([
            'driver' => 'daily',
            'bubble' => false,
            'path' => storage_path("logs/{$tableName}/logs.log")
        ])->info(json_encode([
            'action'     => $action,
            'table'      => $tableName,
            'user_id'    => $user->id ?? null,
            'user_email' => $user->email ?? null,
            'old_data'   => $oldData,
            'new_data'   => $newData
        ], JSON_THROW_ON_ERROR));
    }

    private function getOldData(array $newData, Model $model): array
    {
        $oldData = [];
        $originalData = $model->getOriginal();

        foreach ($newData as $key => $d) {
            if($key === 'updated_at') {
                continue;
            }

            $oldData[$key] = $originalData[$key];
        }

        return $oldData;
    }
}
