<?php

namespace App\Helpers\API;


class ResponseBuilder
{
    const SUCCESS = 200;
    const CREATED = 201;
    const NO_CONTENT = 204;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const BAD_REQUEST = 400;
    const UNAUTHERIZED = 401;
    const SERVER_ERROR = 500;
    const VALIDATION_ERROR = 422;

    public static function response($data = null, $message = null, $errors = null, $status = null)
    {
        if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $custom = collect(["message" => $message]);
            $data = $custom->merge($data);
            return response()->json($data);
        } else {
            if ($data != null) {
                $response["data"] = $data;
            }

            $response["message"] = $message;

            if ($errors != null) {
                $response["errors"] = $errors;
            }
            return response()->json($response, $status);
        }
    }

    public static function responseWithoutJson($data = null, $message = null, $errors = null, $status = null) {
        return $data;
    }
}