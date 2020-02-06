<?php

namespace App\Http\Controllers;

use App\Utility\ApiClient;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\ValidationException;
use ReflectionClass;
use ReflectionProperty;
use Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $apiClient;

    function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
        $this->getJwtAuthToken();
    }

    function getJwtAuthToken()
    {
        $response = $this->apiClient->post('users/auth');
        if (isset($response['data']) && isset($response['data']['token'])) {
            session()->put('token', $response['data']['token']);
            session()->save();
        } else {
            abort(500);
        }
    }

    /**
     * @param $totalRecord
     * @param $page
     * @param $limit
     *
     * @return array
     */
    public function createPaginationMeta($totalRecord, $page, $limit)
    {
        if (0 == $limit) {
            $limit = $totalRecord;
        }

        // Make sure that we won't divide by zero
        $limit = (int) $limit == 0 ? $limit = 25 : $limit;

        return [
            'total' => (int) $totalRecord,
            'perPage' => (int) $limit,
            'currentPage' => (int) $page,
            'lastPage' => ceil($totalRecord / $limit),
        ];
    }

    public function throwNotFoundEntity($message)
    {
        throw new HttpResponseException(response()->json([
            'status_code' => JsonResponse::HTTP_NOT_FOUND,
            'errors' => $message
        ], JsonResponse::HTTP_NOT_FOUND));
    }

    public function throwForbidden($message)
    {
        throw new HttpResponseException(response()->json([
            'status_code' => JsonResponse::HTTP_FORBIDDEN,
            'errors' => $message
        ], JsonResponse::HTTP_FORBIDDEN));
    }

    public function throwUnprocessableEntity($validator)
    {
        $validationException = new ValidationException($validator);
        throw new HttpResponseException(response()->json([
            'status_code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            'code' => $validationException->getCode(),
            'errors' => $validationException->errors()
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }

    public function createExceptionResponse($error, $errorText = '')
    {
        if (!$errorText) {
            $errorText = 'error.input_error';
        }

        throw new HttpResponseException(response()->json([
            'status_code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            $error => $errorText
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }

    public function handleEntity($entity, array $values)
    {
        if (isset($values['_method'])) {
            unset($values['_method']);
        }

        $class = get_class($entity);

        // check passed fields if its exist in the entity before processing.
        $allProperties = [];
        $reflect = new ReflectionClass($class);
        $properties   = $reflect->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED);
        foreach ($properties as $property) {
            $allProperties[] = $property->getName();
        }

        // filling the passed data
        foreach ($values as $k => $v) {
            if (!in_array($k, $allProperties)) {
                $this->createExceptionResponse($k, trans_choice('messages.error.fieldNotExist', 0));
            }

            if (!method_exists($class, $name = 'set'.$k)) {
                throw new \RuntimeException(sprintf('Unknown key "%s" for "@%s".', $k, get_class($this)));
            }

            // skip adding or updating order
            if ($k == 'order') {
                continue;
            }

            // for type array fields
            if (is_array($v)) {
                if ($v[0] === null) {
                    $v = null;
                } else {
                    array_walk($v, function (&$element, $index) {
                        $element = (int)$element;
                    });
                }
            }

            $entity->$name($v);
        }

        return $entity;
    }
}
