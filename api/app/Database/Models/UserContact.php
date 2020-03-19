<?php
/** @noinspection PhpMissingFieldTypeInspection this is due to laravel-lumen's implementation. */
declare(strict_types=1);

namespace App\Database\Models;

use App\Database\AbstractModel;

final class UserContact extends AbstractModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users_id',
        'contacts_id'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the user where this contact's belongs to.
     *
     * @return \App\Database\Models\User
     */
    public function getUser(): User
    {
        /** @var \App\Database\Models\User $user */
        $user = $this->belongsTo(User::class, 'id', 'users_id')->first();

        return $user;
    }

    /**
     * Associate the group this contact's belongs to.
     *
     * @param \App\Database\Models\Group $group
     *
     * @return self
     */
    public function setGroup(Group $group): self
    {
        $this->belongsTo(Group::class, 'groups_id', 'id', 'group')->associate($group);

        return $this;
    }

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
