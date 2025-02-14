<?php
namespace App\Services;

use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Exceptions\HttpResponseException;


class EmployeeService
{    public function get()
    {
        try {
            $employees = Employee::all();

            return $employees;
        } catch (QueryException $e) {
            throw $e;
        }
    }

    public function register(array $data)
    {
        try {
            $employee = Employee::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'department' => $data['department'],
            ]);

            return $employee;
        } catch (QueryException $e) {
            throw $e;
        }
    }


    public function update(array $data, string $id)
    {
        try {
            $employee = Employee::find($id);

            if (!$employee) {
                throw new HttpResponseException(response()->json([
                    'message' => 'Funcionário não encontrado.',
                ], 404));
            }

            $employee->update($data);

            return $employee;

        }    catch (QueryException $e) {
            throw new HttpResponseException(response()->json([
                'message' => 'Erro ao atualizar o funcionário.',
            ], 500));
        }

    }
    public function delete(string $id)
    {
        try {
            $employee = Employee::find($id);

            if (!$employee) {
                throw new HttpResponseException(response()->json([
                    'message' => 'Funcionário não encontrado.',
                ], 404));
            }

            $employee->delete();

            return $employee;

        }    catch (QueryException $e) {
            throw $e;
        }
    }
    }
