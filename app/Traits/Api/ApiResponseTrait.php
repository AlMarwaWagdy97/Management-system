<?php

namespace App\Traits\Api;


trait ApiResponseTrait
{

    public $paginate_num = 5;

    public function apiResponse($data = null, $message = null, $code = 200, $token = null)
    {
        $response = [
            'success' => in_array($code, $this->successCode()) ? true : false,
            'data' => $data,
        ];
        if ($message) $response['message'] = $message;

        return response($response, $code);
    }

    public function successCode()
    {
        return [
            200,
            201,
            202
        ];
    }
    //    public function notFoundResponse($msg='not found !'){
    //        return $this->apiResponse(null, $msg, 404);
    //    }
    public function notFoundResponse($msg = 'not found !')
    {

        $res['success'] = false;
        $res['error']['code']  =  404;
        $res['error']['message'] =  $msg;
        return  response()->json($res);
    }

    public function deleteResponse()
    {
        return $this->apiResponse(null, 'Delete success !', 404);
    }




    /**
     * Return error
     *
     * @param string $msg
     * @param integer $code
     * @return void
     */
    public function error($msg = 'Error Accourd.', $code = 404)
    {
        http_response_code($code);
        header('Content-Type: application/json');
        $response = [
            "success" => false,
            "error" => [
                "code" => $code,
                "message" => $msg
            ]
        ];
        return exit(json_encode($response));
    }

    /**
     * check if fieled is mandatory
     *
     * @param string $fieled
     * @return error|string
     */
    public function required($fieled)
    {
        if (!@isset($_POST[$fieled])) {
            return $this->error($fieled . ' field is mandatory');
        } else {
            return $_POST[$fieled];
        }
    }

    /**
     * check if array of fields is exist or not
     *
     * @param array $fieleds
     * @return array|response
     */
    public function requiredArray(array $fieleds)
    {
        $msg = '';
        foreach ($fieleds as $fieled) {
            if (!@isset($_POST[$fieled])) {
                $msg .=  "$fieled field is mandatory. ";
            }
            @$post_fields[$fieled] = $_POST[$fieled];
        }
        if (!empty($msg)) {
            return $this->error($msg);
        } else {
            return $post_fields;
        }
    }
}
