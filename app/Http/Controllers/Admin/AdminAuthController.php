<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Services\AdminAuthService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    protected AdminAuthService $adminAuthService;

    protected UserService $userService;

    public function __construct(
        AdminAuthService $adminAuthService,
        UserService $userService
    ) {
        $this->adminAuthService = $adminAuthService;
        $this->userService = $userService;
    }

    public function showLogin(): View
    {
        return view('admin.login');
    }

    public function login(AdminLoginRequest $request): RedirectResponse
    {
        $loggedIn = $this->adminAuthService->login(
            $request->mobile,
            $request->password
        );

        if (!$loggedIn) {
            return back()
                ->withErrors([
                    'mobile' => 'Invalid admin credentials.',
                ])
                ->withInput();
        }

        return redirect()->route('admin.dashboard');
    }

    public function dashboard(): View
    {
        $counts = $this->userService->getDashboardCounts();

        return view('admin.dashboard', [
            'counts' => $counts,
        ]);
    }

    public function logout(): RedirectResponse
    {
        $this->adminAuthService->logout();

        return redirect()->route('admin.login');
    }
}