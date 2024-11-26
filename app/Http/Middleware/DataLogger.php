<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DataLogger
{
    private $start_time;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $this->start_time = microtime(true);
        return $next($request);
    }
    public function terminate($request, $responce)
    {
        if (env('API_DATALOGGER', true)) {
            if (env('API_DATALOGGER_USE_DB', true)) {
                $endTime = microtime(true);
                $log = new Log();
                $log->time = gmdate('Y-m-d H:i:s');
                $log->duration = number_format($endTime - LARAVEL_START, 3);
                $log->ip = $request->ip();
                $log->url = $request->fullUrl();
                $log->method = $request->method();
                $input = $request->getContent();
                $log->input = empty($input) ? null : $input;
                $log->save();
            }
            else
            {
                $endTime = microtime(true);
                $filename = 'api_datalogger_' . date('d-m-y') . '.log';
                $dataToLog = "Time: " . gmdate("F j, Y, g:i a") . "\n";
                $dataToLog = "Duration: " . number_format($endTime - LARAVEL_START, 3) . "\n";
                $dataToLog = "IP Adress: " . $request->ip() . "\n";
                $dataToLog = "URL: " . $request->fullUrl() . "\n";
                $dataToLog = "Method: " . $request->method() . "\n";
                $dataToLog = "Input: " . $request->getContent() . "\n";
                File::append(storage_path('logs' . DIRECTORY_SEPARATOR . $filename), $dataToLog . "UI" . str_repeat(" ", 20));
            }
        }
    }
}
