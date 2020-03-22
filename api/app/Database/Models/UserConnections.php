<?php
/** @noinspection PhpMissingFieldTypeInspection this is due to laravel-lumen's implementation. */
declare(strict_types=1);

namespace App\Database\Models;

final class UserConnections extends AbstractModel
{
    public static $inviteeStatuses = [
        'accept' => self::ACCEPTED_STATUS,
        'decline' => self::DECLINED_STATUS
    ];

    public static $inviterStatuses = [
        'cancel' => self::CANCELED,
        'pending' => self::PENDING_STATUS
    ];

    /**
     * Map the available / allowed statuses to this model.
     *
     * @var mixed[]
     */
    public static $statusMapper = [
        'accept' => self::ACCEPTED_STATUS,
        'decline' => self::DECLINED_STATUS,
        'cancel' => self::CANCELED,
        'delete' => self::DELETED_STATUS
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invitee_id',
        'inviter_id',
        'status'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the user where this invitee belongs to.
     *
     * @return \App\Database\Models\User
     */
    public function getInvitee(): User
    {
        /** @var \App\Database\Models\User $user */
        $user = $this->belongsTo(User::class, 'invitee_id', 'id')->first();

        return $user;
    }

    /**
     * Get the user where this invitee belongs to.
     *
     * @return \App\Database\Models\User
     */
    public function getInviter(): User
    {
        /** @var \App\Database\Models\User $user */
        $user = $this->belongsTo(User::class, 'inviter_id', 'id')->first();

        return $user;
    }

    /**
     * Associate the invitee of this user connection.
     *
     * @param \App\Database\Models\User $invitee
     *
     * @return self
     */
    public function setInvitee(User $invitee): self
    {
        $this->belongsTo(User::class, 'invitee_id', 'id', 'invitee')->associate($invitee);

        return $this;
    }

    /**
     * Associate the inviter of this user connection.
     *
     * @param \App\Database\Models\User $inviter
     *
     * @return self
     */
    public function setInviter(User $inviter): self
    {
        $this->belongsTo(User::class, 'inviter_id', 'id', 'inviter')->associate($inviter);

        return $this;
    }
}