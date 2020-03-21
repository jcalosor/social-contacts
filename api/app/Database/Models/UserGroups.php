<?php
declare(strict_types=1);

namespace App\Database\Models;

final class UserGroups extends AbstractModel
{
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
}
