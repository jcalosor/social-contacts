<?php
/** @noinspection PhpMissingFieldTypeInspection this is due to laravel-lumen's implementation. */
declare(strict_types=1);

namespace App\Database\Models;

use App\Database\AbstractModel;
use Illuminate\Database\Eloquent\Collection;

class User extends AbstractModel
{
    /** @var null|\Illuminate\Database\Eloquent\Collection */
    protected $contacts;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'password',
        'address',
        'city',
        'zip',
        'country',
        'email',
        'phone'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Return a collection of contacts associated to the User.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getContacts(): Collection
    {
        return $this->hasMany(UserContact::class, 'user_id', 'id')->get();
    }

    /**
     * Batch set contacts.
     *
     * @param \App\Database\Models\UserContact[] $contacts
     *
     * @return $this
     */
    public function setContacts(array $contacts): self
    {
        $this->contacts = new Collection($contacts);

        return $this;
    }
}
