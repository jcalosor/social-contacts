<?php
/** @noinspection PhpMissingFieldTypeInspection this is due to laravel-lumen's implementation. */
declare(strict_types=1);

namespace App\Database\Models;

final class UserContact extends AbstractModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contacts_id',
        'user_connections_id',
        'users_id',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Associate the contact that belongs to the user.
     *
     * @param \App\Database\Models\User $contact
     *
     * @return self
     */
    public function setContact(User $contact): self
    {
        $this->belongsTo(User::class, 'contacts_id', 'id', 'contact')->associate($contact);

        return $this;
    }

    /**
     * Associate the user this contact's belongs to.
     *
     * @param \App\Database\Models\User $user
     *
     * @return self
     */
    public function setUser(User $user): self
    {
        $this->belongsTo(User::class, 'users_id', 'id', 'user')->associate($user);

        return $this;
    }
}
