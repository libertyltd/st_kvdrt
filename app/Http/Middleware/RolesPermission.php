<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class RolesPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param String $entity
     * @return mixed
     */
    public function handle($request, Closure $next, $entity)
    {
        $Entity = new $entity();

        $path = $request->path();
        /* Получаем массив нашего пути */
        $path = explode('/', $path);

        if ($request->isMethod('GET')) {
            /* У нас все разделы в админке начинаются с /home/<название_сущности>/<что_то_там> */
            if (!isset($path[2])) {
                /* это точно вызов метода index */
                if (Auth::user()->cannot('index', $Entity)) {
                    abort(403, 'Доступ запрещен');
                }

            }

            if (isset($path[2]) && $path[2]==='create') {
                /* точно отобразим форму создания сущности */
                if (Auth::user()->cannot('add', $Entity)) {
                    abort(403, 'Доступ запрещен');
                }

            }

            if (isset($path[2]) && !isset($path[3]) && is_int($path[2])) {
                /* точно форма для просмотра сущности */
                if (Auth::user()->cannot('view', $Entity)) {
                    abort(403, 'Доступ запрещен');
                }

            }

            if (isset($path[3]) && $path[3] === 'edit') {
                /* Точно редактирование сущности */
                if (Auth::user()->cannot('edit', $Entity)) {
                    abort(403, 'Доступ запрещен');
                }
            }
        }

        if ($request->isMethod('POST')) {
            if (!isset($path[2])) {
                /* точно сохранение после создания */
                if (Auth::user()->cannot('add', $Entity)) {
                    abort(403, 'Доступ запрещен');
                }

            }
        }

        if ($request->isMethod('PUT')) {
            if (isset($path[2]) && is_int($path[2])) {
                /* точно сохранение данных при обновлении */
                if (Auth::user()->cannot('edit', $Entity)) {
                    abort(403, 'Доступ запрещен');
                }

            }
        }

        if ($request->isMethod('DELETE')) {
            if (isset($path[2]) && is_int($path[2])) {
                /* точно удаление сущности */
                if (Auth::user()->cannot('delete', $Entity)) {
                    abort(403, 'Доступ запрещен');
                }
            }
        }



        return $next($request);
    }
}
