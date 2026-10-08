<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\View\View;
use App\Http\Requests\AdminUserRequest;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\RedirectResponse;
use App\Models\User;


class UserController extends Controller
{
    use ImageUploadTrait;

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): View
    {
        $users = $this->userService->getUsers();

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create');
    }
    public function store(AdminUserRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            $imagePaths = $this->uploadProfileImage(
                $request->file('profile_image')
            );

            $data = array_merge($data, $imagePaths);
        }

        $this->userService->createUser($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }
    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }
    public function update(
        AdminUserRequest $request,
        User $user
    ): RedirectResponse {
        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            $imagePaths = $this->uploadProfileImage(
                $request->file('profile_image')
            );

            $data = array_merge($data, $imagePaths);
        }

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $this->userService->updateUser($user, $data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }
    public function destroy(User $user): RedirectResponse
    {
        $this->userService->deleteUser($user);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}