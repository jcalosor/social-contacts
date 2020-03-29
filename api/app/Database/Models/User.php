<?php
/** @noinspection PhpMissingFieldTypeInspection this is due to laravel-lumen's implementation. */
declare(strict_types=1);

namespace App\Database\Models;

use Illuminate\Database\Eloquent\Collection;

class User extends AbstractModel
{
    /**
     * Static string value to assign to the avatar field.
     *
     * @var string
     */
    public const AVATAR = 'https://cdn1.iconfinder.com/data/icons/instagram-ui-colored/48/JD-17-512.png';

    /**
     * The static table name value.
     *
     * @var string
     */
    public const TABLE_NAME = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar',
        'first_name',
        'last_name',
        'password',
        'address',
        'city',
        'zip',
        'country',
        'email',
        'phone',
        'logged_in'
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
    protected $hidden = ['password', 'logged_in'];

    /**
     * Return a collection of contacts associated to the User.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getContacts(): Collection
    {
        return $this->hasMany(UserContact::class, 'user_id', 'id')->get();
    }
}
