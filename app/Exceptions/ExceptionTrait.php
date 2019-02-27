<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Http\Response;

trait ExceptionTrait
{

	public function apiException($request, $e)
	{
		if($e instanceof ModelNotFoundException)
            {
            
            return response()->json([
                'errors' => 'No encontrado'
                ], Response::HTTP_NOT_FOUND);
            }

            if($e instanceof NotFoundHttpException)
            {
                return response()->json([
                'errors' => 'Ruta incorrecta'
                ], Response::HTTP_NOT_FOUND);
            }

            return parent::render($request, $e);
	}
} 