<?php
/**
 * Created by PhpStorm.
 * User: luoming
 * Date: 2017/11/27
 * Time: 17:02
 */

namespace App\Api\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends BaseController
{
//    protected $layout = "layouts.main";

    public function store(Request $request)
    {
        // grab credentials from the request
        $input = $request->only(['email', 'password']);
//        dd(Hash::make($input['password']));
        try {
            $user = User::whereEmail($input['email'])->first();
//            dd(Hash::check($input['password'], $user->password));
//            dd(empty($user));
            if (empty($user) || ! Hash::check($input['password'], $user->password)) {
                $this->response->errorUnauthorized('邮箱或密码错误');
            } else {
                $token = JWTAuth::fromUser($user);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            $this->response->errorInternal('创建 token 失败');
        }

        // all good so return the token
        return $this->response->array(['data' => ['token' => $token]]);
    }

    /**
     * 刷新token
     */
    protected function update()
    {
        return $this->response->created();
    }

    /**
     * 注销登录
     */
    protected function destroy()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return $this->response->noContent();
    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }
}