<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SignUpRequest;
use App\Models\User;
use App\Services\UserServiceInterface;
use App\Http\Requests\User\SignInRequest;
use App\Type;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /** @var \App\Services\UserServiceInterface UserService */
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function getSignIn()
    {
        return view('pages.user.auth.signin', [
        ]);
    }

    public function postSignIn(SignInRequest $request)
    {
        $user = $this->userService->signIn($request->all());
        if (empty($user)) {
            return redirect()->action('User\AuthController@getSignIn')->withErrors(
                [
                    'errors' => 'Wrong Password',
                ]
            );
        }

        return \RedirectHelper::intended(action('User\IndexController@index'));
    }

    public function getSignUp()
    {
        $types = Type::all();
        return view('pages.user.auth.signup', ['types' => $types
        ]);
    }

    public function postSignUp(SignUpRequest $request)
    {
        $user = $this->userService->signUp($request->all());
        if (empty($user)) {
            return redirect()->action('User\AuthController@getSignUp');
        }
        return \RedirectHelper::intended(action('User\IndexController@index'))->with('message', 'Register successfully!');
    }

    public function logout(){
        auth()->logout();
        // redirect to homepage
        return redirect('/');
    }
}
