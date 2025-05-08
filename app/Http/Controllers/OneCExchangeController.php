<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OneCExchangeController extends Controller
{
    public function handle(Request $request)
    {
        $type = $request->query('type');
        $mode = $request->query('mode');

        // Авторизация
        if ($type === 'checkauth') {
            return response("success\nlogin\n123456");
        }

        // Инициализация обмена
        if ($type === 'catalog' && $mode === 'init') {
            return response("zip=no\nfile_limit=1000000");
        }

        // Загрузка файла от 1С
        if ($type === 'catalog' && $mode === 'file') {
            $filename = $request->query('filename');
            $rawData = file_get_contents("php://input");
            Storage::put("1c_exchange/{$filename}", $rawData);
            return response("success");
        }

        // Импорт данных
        if ($type === 'catalog' && $mode === 'import') {
            $filename = $request->query('filename');
            $xml = Storage::get("1c_exchange/{$filename}");
            // Здесь можно распарсить XML и загрузить товары, категории, остатки и т.п.
            // Пример: $xmlObject = simplexml_load_string($xml);

            return response("success");
        }

        return response("failure", 400);
    }
}
