<?php
declare(strict_types=1);

namespace App\Database\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class AbstractModel extends Model
{
    /**
     * The accepted status.
     *
     * @const string
     */
    public const ACCEPTED_STATUS = 'accepted';

    /**
     * The active status.
     *
     * @const string
     */
    public const ACTIVE_STATUS = 'active';

    /**
     * The confirmed status.
     *
     * @const string
     */
    public const CANCELED = 'canceled';

    /**
     * The confirmed status.
     *
     * @const string
     */
    public const CONFIRMED_STATUS = 'confirmed';

    /**
     * The declined status.
     *
     * @const string
     */
    public const DECLINED_STATUS = 'declined';

    /**
     * The deleted status.
     *
     * @const string
     */
    public const DELETED_STATUS = 'deleted';

    /**
     * The pending status.
     *
     * @const string
     */
    public const PENDING_STATUS = 'pending';

    /**
     * The read status, indicates the message has already been opened.
     *
     * @const string
     */
    public const READ_STATUS = 'read';

    /**
     * List of all the system wide statuses.
     *
     * @const string[]
     */
    protected const STATUSES = [
        self::ACCEPTED_STATUS,
        self::ACTIVE_STATUS,
        self::CONFIRMED_STATUS,
        self::DECLINED_STATUS,
        self::DELETED_STATUS,
        self::PENDING_STATUS
    ];

    /**
     * The unread status, indicates the message is still new
     *
     * @const string
     */
    public const UNREAD_STATUS = 'unread';

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
     * Verifies if the given status is an existing status.
     *
     * @param string $status
     *
     * @return bool
     */
    public function checkStatus(string $status): bool
    {
        return \array_key_exists($status, self::STATUSES);
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
