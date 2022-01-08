<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCompany;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    protected $repository;

    public function __construct(Company $model)
    {
        $this->repository = $model;
    }

    public function index(Request $request)
    {
        $companies = $this->repository->getCompanies($request->get('filter', ''));

        return CompanyResource::collection($companies);
    }

    public function store(StoreUpdateCompany $request)
    {
        $company = $this->repository->create($request->validated());

        return new CompanyResource($company);
    }

    public function show($uuid)
    {
        $company = $this->repository->where('uuid', $uuid)->firstOrFail();

        return new CompanyResource($company);
    }

    public function update(StoreUpdateCompany $request, $uuid)
    {
        $company = $this->repository->where('uuid', $uuid)->firstOrFail();
        $company->update($request->validated());

        return response()->json([
            'message' => 'updated'
        ]);
    }

    public function destroy($uuid)
    {
        $company = $this->repository->where('uuid', $uuid)->firstOrFail();
        $company->delete();

        return response()->json(['message' => 'deleted'], 204);
    }
}
