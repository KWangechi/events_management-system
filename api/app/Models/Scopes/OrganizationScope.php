<?php

namespace App\Models\Scopes;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OrganizationScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model)
    {
        if (request()->route('organization')) {
            $organization = Organization::where('slug', request()->route('organization'))->firstOrFail();
            $builder->where('organization_id', $organization->id)->with('organization');
        }
    }
}
