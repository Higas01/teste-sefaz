<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmployeeService;
use OpenApi\Annotations as OA;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct()
    {
        $this->employeeService = new EmployeeService();
    }

/**
 * @OA\Get(
 *     path="/employee",
 *     summary="Get all employees",
 *     security={{"Bearer":{}}},
 *     tags={"Employee"},
 *     @OA\Response(
 *         response=200,
 *         description="Employees retrieved successfully"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server Error"
 *     )
 * )
 */
public function get(Request $request)
{
    // Sua lógica para obter funcionários
    $employees = $this->employeeService->get();

    return response()->json([
        'count' => $employees->count(),
        'data' => $employees
    ], 201);
}

/**
 * @OA\Post(
 *     path="/employee",
 *     summary="Create an employee",
 *     security={{"Bearer":{}}},
*      tags={"Employee"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"name", "email", "department"},
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="department", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Employee created successfully"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Invalid Input"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *  *     @OA\Response(
 *         response=500,
 *         description="Server Error"
 *     )
 * )
 */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employees,email',
            'department' => 'required|in:Contabilidade,Financeiro,Atendimento,Orçamento,TI'
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'email.unique' => 'Este email já está cadastrado.',
            'department.required' => 'O campo departament é obrigatório.',
            'department.in' => 'O campo departament é inválido.',
        ]);

        $employee = $this->employeeService->register($data);

        return response()->json([
            'message' => 'Funcionário cadastrado com sucesso',
            'data' => $employee
        ], 201);
    }
/**
 * @OA\Patch(
 *     path="/employee/{id}",
 *     summary="Update an employee",
 *     security={{"Bearer":{}}},
 *     tags={"Employee"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the employee to update",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"name", "email", "department"},
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="department", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Employee updated successfully"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Invalid Input"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Employee not found"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *  *     @OA\Response(
 *         response=500,
 *         description="Server Error"
 *     )
 * )
 */

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'email' => 'email|unique:employees,email,' . $id,
            'department' => 'in:Contabilidade,Financeiro,Atendimento,Orçamento,TI'
        ], [
            'email.email' => 'Por favor, insira um email válido.',
            'email.unique' => 'Este email já está cadastrado.',
            'department.in' => 'O campo departament é inválido.',
        ]);

        $employee = $this->employeeService->update($data, $id);

        return response()->json([
            'message' => 'Funcionário atualizado com sucesso',
            'data' => $employee
        ], 200);
    }
/**
 * @OA\Delete(
 *     path="/employee/{id}",
 *     summary="Delete an employee",
 *     security={{"Bearer":{}}},
 *     tags={"Employee"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the employee to delete",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Employee deleted successfully"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Employee not found"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *  *     @OA\Response(
 *         response=500,
 *         description="Server Error"
 *     )
 * )
 */

    public function delete(Request $request, $id)
    {
        $employee = $this->employeeService->delete($id);

        return response()->json([
            'message' => 'Funcionário deletado com sucesso',
            'data' => $employee
        ], 200);
    }
}

