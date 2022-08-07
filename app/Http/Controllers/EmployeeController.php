<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\Create;
use App\Http\Requests\Employee\Update;
use App\Models\employees;
use Exception;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function create(Create $request)
    {
        try {
            $params = $request->except('_method', '_token', 'id');
            $file_name = '';
            $image = $request->file('Image');
            if (isset($image)) {
                $file_name = time() . '_' . $image->getClientOriginalName();;
                $file_path = $request->file('Image')->storeAs('uploads', $file_name, 'public');
            }

            $save = new employees();
            $save->Employee_Name = $params['Employee_Name'];
            $save->Email = $params['Email'];
            $save->Address = $params['Address'];
            $save->Phone = $params['Phone'];
            $save->DOB = $params['DOB'];
            $save->image = $file_name;
            $save->save();

            return response()->json("Employee details saved successfully", 200);
        } catch (Exception $ex) {
        }
    }

    public function get()
    {
        try {
            $employee = employees::get()->toArray();
            // $employee = employees::paginate(10)->toArray();
            return response()->json($employee, 200);
        } catch (Exception $ex) {
        }
    }

    public function update(Update $request)
    {
        try {
            $params = $request->except('_method', '_token');
            $file_name = '';
            $image = $request->file('Image');
            if (isset($image)) {
                $file_name = time() . '_' . $image->getClientOriginalName();;
                $file_path = $request->file('Image')->storeAs('uploads', $file_name, 'public');
            }
            $updatearray = [
                'Employee_Name' => $params['Employee_Name'],
                'Email' => $params['Email'],
                'Address' => $params['Address'],
                'Phone' => $params['Phone'],
                'DOB' => $params['DOB'],
                'image' => $file_name
            ];
            $update = employees::where('id', $params['id'])->update($updatearray);
            if ($update) {
                return response()->json("Employee details updated successfully", 200);
            } else {
                return response()->json("Something Went Wrong", 400);
            }
        } catch (Exception $ex) {
        }
    }

    public function delete($id)
    {
        try {
            $delete = employees::where('id', $id)->delete();
            return response()->json("Employee deleted successfully.", 200);
        } catch (Exception $ex) {
        }
    }
}
