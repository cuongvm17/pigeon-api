<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Pigeon\Application\Requests\CreateNewOrderRequest;
use Pigeon\Application\Services\CreateOrderService;
use Pigeon\Domain\Exceptions\InvalidDeadlineException;
use Pigeon\Domain\Exceptions\NotFoundPigeonException;

/**
 * Class OrderController
 * @package App\Http\Controllers\Api
 */
class OrderController extends Controller
{
    /**
     * @param Request $request
     * @param CreateOrderService $createOrderService
     * @return JsonResponse
     */
    public function __invoke(
        Request $request,
        CreateOrderService $createOrderService
    ): JsonResponse
    {
        try {
            $createOrderService->exec(new CreateNewOrderRequest($request->all()));

            return $this->sendSuccess('Create order successful!');
        } catch (NotFoundPigeonException $e) {
            return $this->sendError('Not found any valid pigeons!', Response::HTTP_BAD_REQUEST);
        } catch (InvalidDeadlineException $e) {
            return $this->sendError('Invalid deadline!', Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            Log::error("Create new order has error: ", ['error' => $e->getMessage()]);

            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }
}