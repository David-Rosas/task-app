<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Display the register view.
     *
     * @return \Inertia\Response
     */
    public function register()
    {
        return Inertia::render('Auth/Register');
    }
    /**
     * Display the register view.
     *
     * @return \Inertia\Response
     */
    public function registerStore(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:100'],
                'email' => ['required', 'email'],
                'password' => ['required'],
                'first_name' => ['required'],
                'last_name' => ['required'],
            ]);

            if ($validator->fails()) {

                return response()->json(
                    [
                        'success' => false,
                        'message' => $validator->errors()->first(),
                        'error' => $validator->errors(),
                        'status' => 406,
                    ],
                    406
                );
            }

            $input = $request->all();

            User::factory()->create([
                'name' => $input['name'],
                'first_name' => $input['first_name'],
                'last_name' =>$input['last_name'],
                'email' => $input['email'],
                'password' => bcrypt($input['password']),
            ]);

            return Redirect::route('login')->with('success', 'User created.');

        } catch (Exception $error) {
            return Response()->json(
                [
                    'message' => $error->getMessage(),
                    'line' => $error->getLine(),
                    'file' => $error->getFile(),
                ],
                500
            );
        }
    }
    /**
     * Handle an incoming authentication request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
