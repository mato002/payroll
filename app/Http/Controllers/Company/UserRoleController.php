<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function index()
    {
        /** @var Company|null $company */
        $company = currentCompany();

        if (! $company instanceof Company) {
            /** @var \App\Models\User $authUser */
            $authUser = auth()->user();
            $company = $authUser?->companies()->where('is_active', true)->first();
        }

        abort_unless($company, 404, 'Company not found');

        $users = $company->members()
            ->with(['roles'])
            ->orderBy('users.name')
            ->paginate(20);

        return view('company.users-roles.index', [
            'company' => $company,
            'users'   => $users,
        ]);
    }

    public function create()
    {
        /** @var Company|null $company */
        $company = currentCompany();

        if (! $company instanceof Company) {
            /** @var \App\Models\User $authUser */
            $authUser = auth()->user();
            $company = $authUser?->companies()->where('is_active', true)->first();
        }

        abort_unless($company, 404, 'Company not found');

        $roles = $company->roles()
            ->orderBy('name')
            ->get();

        return view('company.users-roles.create', [
            'company' => $company,
            'roles'   => $roles,
        ]);
    }

    public function store(Request $request)
    {
        /** @var Company|null $company */
        $company = currentCompany();

        if (! $company instanceof Company) {
            /** @var \App\Models\User $authUser */
            $authUser = auth()->user();
            $company = $authUser?->companies()->where('is_active', true)->first();
        }

        abort_unless($company, 404, 'Company not found');

        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $role = Role::query()
            ->where('company_id', $company->id)
            ->whereKey($data['role_id'])
            ->firstOrFail();

        $user = User::firstOrCreate(
            ['email' => $data['email']],
            ['name' => $data['name'], 'password' => bin2hex(random_bytes(10))]
        );

        if (! $user->wasRecentlyCreated && $user->name !== $data['name']) {
            $user->update(['name' => $data['name']]);
        }

        $company->members()->syncWithoutDetaching([
            $user->id => [
                'is_owner'   => false,
                'status'     => 'active',
                'invited_at' => now(),
                'joined_at'  => now(),
            ],
        ]);

        UserRole::updateOrCreate(
            [
                'company_id' => $company->id,
                'user_id'    => $user->id,
            ],
            [
                'role_id'    => $role->id,
            ]
        );

        return redirect()
            ->route('companies.users-roles.index', ['company' => $company->slug])
            ->with('success', 'User added to company successfully.');
    }

    public function edit($user)
    {
        /** @var Company|null $company */
        $company = currentCompany();

        if (! $company instanceof Company) {
            /** @var \App\Models\User $authUser */
            $authUser = auth()->user();
            $company = $authUser?->companies()->where('is_active', true)->first();
        }

        abort_unless($company, 404, 'Company not found');

        /** @var User $userModel */
        $userModel = $company->members()->where('users.id', $user)->firstOrFail();

        $roles = $company->roles()
            ->orderBy('name')
            ->get();

        $currentUserRole = UserRole::query()
            ->where('company_id', $company->id)
            ->where('user_id', $userModel->id)
            ->first();

        $currentRoleId = $currentUserRole?->role_id;

        return view('company.users-roles.edit', [
            'company'       => $company,
            'user'          => $userModel,
            'roles'         => $roles,
            'currentRoleId' => $currentRoleId,
        ]);
    }

    public function update(Request $request, $user)
    {
        /** @var Company|null $company */
        $company = currentCompany();

        if (! $company instanceof Company) {
            /** @var \App\Models\User $authUser */
            $authUser = auth()->user();
            $company = $authUser?->companies()->where('is_active', true)->first();
        }

        abort_unless($company, 404, 'Company not found');

        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        /** @var User $userModel */
        $userModel = $company->members()->where('users.id', $user)->firstOrFail();

        $userModel->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        $role = Role::query()
            ->where('company_id', $company->id)
            ->whereKey($data['role_id'])
            ->firstOrFail();

        UserRole::updateOrCreate(
            [
                'company_id' => $company->id,
                'user_id'    => $userModel->id,
            ],
            [
                'role_id'    => $role->id,
            ]
        );

        return redirect()
            ->route('companies.users-roles.index', ['company' => $company->slug])
            ->with('success', 'User updated successfully.');
    }

    public function destroy($user)
    {
        /** @var Company|null $company */
        $company = currentCompany();

        if (! $company instanceof Company) {
            /** @var \App\Models\User $authUser */
            $authUser = auth()->user();
            $company = $authUser?->companies()->where('is_active', true)->first();
        }

        abort_unless($company, 404, 'Company not found');

        /** @var User $userModel */
        $userModel = $company->members()->where('users.id', $user)->firstOrFail();

        // Detach from company and remove role mapping for this company
        $company->members()->detach($userModel->id);

        UserRole::query()
            ->where('company_id', $company->id)
            ->where('user_id', $userModel->id)
            ->delete();

        return redirect()
            ->route('companies.users-roles.index', ['company' => $company->slug])
            ->with('success', 'User removed from company.');
    }
}
