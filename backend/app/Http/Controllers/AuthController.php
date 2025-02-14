<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Teste Sefaz - API",
 *     version="1.0.0",
 *     description="API documentation for test sefaz"
 * )
 */

class AuthController extends Controller
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

/**
 * @OA\Post(
 *      path="/register",
 *      summary="Register a new user",
 *      description="Register a new user with email and password",
 *      tags={"user"},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="email", type="string"),
 *              @OA\Property(property="password", type="string")
 *          )
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="User created successfully",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string"),
 *              @OA\Property(property="data", type="object")
 *          )
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="Invalid Input",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string"),
 *              @OA\Property(property="data", type="object")
 *          )
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Internal Server Error",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string"),
 *              @OA\Property(property="data", type="object")
 *          )
 *      )
 * )
 */

    public function register(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'O campo de email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'email.unique' => 'Este email já está cadastrado.',
            'password.required' => 'O campo de senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
        ]);

        $user = $this->authService->register($data);

        return response()->json([
            'message' => 'Usuário cadastrado com sucesso',
            'data' => $user
        ], 201);
    }
/**
 * @OA\Post(
 *      path="/login",
 *      summary="Login in App",
 *      description="Authenticate in app with email and password",
 *      tags={"user"},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="email", type="string", format="email"),
 *              @OA\Property(property="password", type="string", format="password")
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Token generated successfully",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string"),
 *              @OA\Property(property="data", type="object")
 *          )
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="Invalid Input",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string"),
 *              @OA\Property(property="data", type="object")
 *          )
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Internal Server Error",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string"),
 *              @OA\Property(property="data", type="object")
 *          )
 *      )
 * )
 */

public function login(Request $request)
{
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'O campo de email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'password.required' => 'O campo senha é obrigatório.',
        ]);

        $token = $this->authService->login($data);

        return response()->json([
            'token' => $token,
        ], 200);

}

}

