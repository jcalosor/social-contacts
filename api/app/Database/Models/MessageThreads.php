<?php
/** @noinspection PhpMissingFieldTypeInspection this is due to laravel-lumen's implementation. */
declare(strict_types=1);

namespace App\Database\Models;

final class MessageThreads extends AbstractModel
{
    /**
     * The static table name value.
     *
     * @var string
     */
    public const TABLE_NAME = 'message_threads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'user_connections_id'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the user connection this contact belongs to.
     *
     * @return \App\Database\Models\UserConnections
     */
    public function getUserConnections(): UserConnections
    {
        /** @var \App\Database\Models\UserConnections $userConnections */
        $userConnections = $this
            ->belongsTo(UserConnections::class, 'user_connections_id', 'id', 'user_connections')
            ->first();

        return $userConnections;
    }
}
