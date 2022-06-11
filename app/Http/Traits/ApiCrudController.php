<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Validator;

trait ApiCrudController
{

    public $messages = [
        'required' => 'The :attribute field is required.',
    ];
    public function index()
    {
        $data = $this->model;
        return $this->handleSuccess($this->model_resource::collection($data->paginate(10)), 'retrieved!');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $rules = $this->rules($request->method());
        $validator = Validator::make($input, $rules, $this->messages);
        
        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }
        try {
            $model = $this->model::create($validator->validated());
            return $this->handleSuccess(new $this->model_resource($model), 'created!');
        } catch (\PDOException $e) {
            return response()->json(['message' => $e->errorInfo[2]], 404);
        }
        
    }
    
    public function show($id)
    {
        $data = $this->model::find($id);
        if (is_null($data)) {
            return $this->handleError('Not found!');
        }
        return $this->handleSuccess(new $this->model_resource($data), 'retrieved!');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $rules = $this->rules($request->method(), $id);
        $validator = Validator::make($input,  $rules, $this->messages);

        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }

        try {
            $data = $this->model::find($id);
            $data->update($validator->validated());

            return $this->handleSuccess(new $this->model_resource($data), 'updated!');
        } catch (\PDOException $e) {
            return response()->json(['message' => $e->errorInfo[2]], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->model::find($id);
            if (is_null($data)) {
                return $this->handleError('Not found!');
            }
            $this->model::destroy($id);
            return response()->json(['message' => __('apps::api.messages.deleted')]);

        } catch (\PDOException $e) {
            return response()->json(['message' => $e->errorInfo[2]], 400);
        }
    }

    public function handleSuccess($data, $message, $code = 200)
    {
        $res = [
            'success' => true,
            'data'    => $data,
            'message' => $message == 'success' ? __('apps::api.message.success') : $message,
        ];
        
        return response()->json($res, $code);
    }

    public function handleError($error, $errorMessage = [], $code = 404)
    {
        $res = [
            'success' => false,
            'message' => $error,
            'message' => $error == 'error' ? __('apps::api.message.error') : $error,

        ];
        if(!empty($errorMessage)){
            $res['data'] = $errorMessage;
        }
        return response()->json($res, $code);
    }
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, $this->invalidData($validator->errors()->first() , $validator->errors()));
    }

    public function setResource($model_resource): void
    {
        $this->model_resource = $model_resource;
    }

    public function getResource()
    {
        return $this->model_resource;
    }

    public function Pagination(Request $request ,$order = 'id', $sort = 'desc')
    {
        $records = $this->Query($request)->orderBy($order, $sort)->paginate($request->records_count ?? 10);
        return $records;
    }

    public function Query($request)
    {  
        $query = $this->model->where(
            function ($query) use ($request) {
                $query->where($request->search_column ?? 'id', 'LIKE', '%' . $request->search_key . '%');
            });
        return $query;
    }
}
