<?php

namespace App\Http\Controllers\Threads;

use App\Models\Reply;
use App\Models\Thread;
use foo\bar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RepliesController extends Controller
{
    /**
     * RepliesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $channelId
     * @param Thread $thread
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\RedirectResponse
     */
    public function store($channelId, Thread $thread)
    {

        $this->validate(\request(), [
            'body' => 'required',
        ]);

        $reply = $thread->addReply([
            'body' => \request('body'),
            'user_id' => auth()->id()
        ]);

        if(\request()->expectsJson())
            return $reply->load('owner');

        return back()->with('flash', 'Your reply has been posted.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Reply $reply
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->update(\request(['body']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {

        $this->authorize('update', $reply);

        $reply->delete();

        $flashMessage = 'Reply successfully deleted.';
        if(\request()->expectsJson()) {
            return response(['status' => $flashMessage]);
        }

        return back()
            ->with('flash', $flashMessage);
    }
}
