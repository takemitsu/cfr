<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $services = Service::orderBy('id', 'desc')
            ->paginate();

        return view('admin.service.index', ['services' => $services]);
    }

    public function create()
    {
        return view('admin.service.edit');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'url' => 'required|url|min:10|max:255',
            'favicon' => 'required|string|min:10|max:255',
        ]);

        $service = new Service();
        $service->name = $request->name;
        $service->url = $request->url;
        $service->favicon = $request->input('favicon','');
        $service->save();

        return redirect()->route('admin.service.index');
    }

    public function edit(Service $service)
    {
        return view('admin.service.edit', ['service' => $service]);
    }
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'url' => 'required|url|min:10|max:255',
            'favicon' => 'required|string|min:10|max:255',
        ]);

        $service->name = $request->name;
        $service->url = $request->url;
        $service->favicon = $request->input('favicon','');
        $service->save();

        return redirect()->route('admin.service.index');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return;
    }
}
