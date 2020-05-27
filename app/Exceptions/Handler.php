<?php

namespace App\Exceptions;

use App\Jobs\System\SendErrorSystemToAdmin;
use App\Models\Setting;
use Exception;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {

		if (app()->environment('prod')
			&& $this->shouldReport($exception))
		{
			$flag = $this->addFlagErrorsSystem();
			if ($flag)
			{
				\Log::warning("[send email error system]");
				$e       = FlattenException::create($exception);
				$handler = new \Symfony\Component\Debug\ExceptionHandler();
				$content = $handler->getHtml($e);
				SendErrorSystemToAdmin::dispatch($content)
					->onConnection('database')
					->onQueue('errors-email')
					->delay(now()->addMinutes(1));
			}
		}

		parent::report($exception);
    }

    protected function addFlagErrorsSystem()
	{
		$flag = false;
		$setting = \DB::table('settings_api')->first();

		if ($setting)
		{
			if ($setting->is_error_system == Setting::STATUS_SUCCESS)
			{
				\DB::table('settings_api')->update([
					'is_error_system' => Setting::STATUS_ERRORS
				]);
				$flag = true;
			}
		}else{
			\DB::table('settings_api')->insert([
				'is_error_system' => Setting::STATUS_ERRORS
			]);
			$flag = true;
		}

		return $flag;
	}

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
    	if ($this->isHttpException($exception))
		{
			switch ($exception->getStatusCode())
			{
				case 404:
					return redirect()->route('exception.404');
					break;
			}
		}

        return parent::render($request, $exception);
    }
}
