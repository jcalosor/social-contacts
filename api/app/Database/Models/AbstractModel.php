<?php
declare(strict_types=1);

namespace App\Database;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class AbstractModel extends Model
{
    /**
     * The "booting" method of the model, generate and set the uuid.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName()
    {
        return 'id';
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }

    /**
     * Overwrite the timestamp implementation to a more readable format.
     *
     * @return mixed[]
     *
     * @throws \Exception
     */
    public function toArray(): array
    {
        $timestamps = [
            'created_at' => $this->__dateFormatter($this->getCreatedAtColumn(), 'Y-m-d'),
            'updated_at' => $this->__dateFormatter($this->getUpdatedAtColumn(), 'Y-m-d')
        ];

        return \array_merge(parent::toArray(), $timestamps);
    }

    /**
     * Date formatter to specified format.
     *
     * @param string $timestamp
     * @param string $format
     *
     * @return string
     *
     * @throws \Exception
     */
    private function __dateFormatter(string $timestamp, string $format): string
    {
        return (new Carbon(\strtotime($timestamp)))->format($format);
    }
}
