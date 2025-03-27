<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use Illuminate\Http\Request;
use App\Services\HallService;
class HallController extends Controller
{
    protected $hallService;

    public function __construct(HallService $hallService)
    {
        $this->hallService = $hallService;
    }

    public function index()
    {
        return response()->json($this->hallService->getAllHalls());
    }

    public function show($id)
    {
        return response()->json($this->hallService->getHallById($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'capacity' => 'required|integer',
            'type' => 'required|in:standard,vip'
        ]);
        return response()->json($this->hallService->createHall($data), 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|string',
            'capacity' => 'sometimes|integer',
            'type' => 'sometimes|in:standard,vip'
        ]);
        return response()->json($this->hallService->updateHall($id, $data));
    }

    public function destroy($id)
    {
        return response()->json(['deleted' => $this->hallService->deleteHall($id)]);
    }
}
