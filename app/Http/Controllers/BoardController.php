<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use App\Http\Resources\BoardResource;
use App\Http\Requests\BoardCreateRequest;

class BoardController extends Controller
{
    // public function index(Request $request)
    // {
    //     return BoardResource::collection($request->user()->boards);

    // }

    public function store(BoardCreateRequest $request){
        $board = Board::create($request->validated());
        return new BoardResource($board);
    }

    public function update(BoardCreateRequest $request, Board $board){
        $data = $request->validated();
        $board->update($data);

        return new BoardResource($board);
    }

    public function destroy(Board $board, Request $request){
        $board->load('project');
        abort_if($board->project->user_id !== $request->user_id, 403, 'You are not authorized to delete this board');
        $board->delete();

        return response()->json(['message' => 'Board deleted successfully']);
    }
}
