<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return Service::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'url' => 'required|url',
            'favicon' => 'url',
        ]);

        // TODO: 気になったら重複チェックとか色々する。

        $service = new Service();
        $service->name = $request->name;
        $service->url = $request->url;
        $service->favicon = $request->favicon;
        $service->save();

        return $service;
    }

    public function show(Service $service)
    {
        return $service;
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string',
            'url' => 'required|url',
            'favicon' => 'url',
        ]);

        $service->name = $request->name;
        $service->url = $request->url;
        $service->favicon = $request->favicon;
        $service->save();

        return $service;
    }

    public function destroy(Service $service)
    {
        // TODO: 紐づくプロジェクトがあれば削除させない

        $service->delete();
        return;
    }
}
