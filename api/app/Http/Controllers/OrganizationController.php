<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationRequest;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    public function index()
    {

        $organizations = Organization::all();
        return $this->successResponse($organizations, 'Organizations retrieved successfully');
    }

    public function show($orgSlug)
    {
        $organization = Organization::where('slug', $orgSlug)->first();
        if (!$organization) {
            return $this->errorResponse('Organization not found', 404);
        }
        return $this->successResponse($organization, 'Organization retrieved successfully');
    }

    public function store(OrganizationRequest $orgRequest)
    {
        $organization = Organization::create($orgRequest->all());
        return $this->successResponse($organization, 'Organization created successfully', 201);
    }

    public function update(OrganizationRequest $orgRequest, $orgSlug)
    {
        $organization = Organization::where('slug', $orgSlug)->first();
        if (!$organization) {
            return response()->json(['message' => 'Organization not found'], 404);
        }
        $organization->update($orgRequest->all());
        return $this->successResponse($organization, 'Organization updated successfully');
    }

    public function destroy($orgSlug)
    {
        $organization = Organization::where('slug', $orgSlug)->first();
        if (!$organization) {
            return $this->errorResponse('Organization not found', 404);
        }
        $organization->delete();
        return $this->successResponse(null, 'Organization deleted successfully', 204);
    }
}
