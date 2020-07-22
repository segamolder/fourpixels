<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ValidateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * @var ValidateService
     */
    private $_validateService;

    /**
     * UserController constructor.
     */
    public function __construct(ValidateService $_validateService)
    {
        $this->_validateService = $_validateService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.list')->with('users', User::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.edit')->with('title', __('custom.add'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->_validateService->user($request);
        if ((User::create($request->post())) == false) {
            Log::error(__('custom.errors.save', ['value' => 'пользователя']));
            return __('custom.errors.save', ['value' => 'пользователя']);
        }
        return view('users.list')->with('message', __('custom.success.save'))->with('users', User::paginate(10));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('users.edit')
            ->with('title', __('custom.edit'))
            ->with('user', User::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->_validateService->user($request, true);
        $data = $request->post();
        if($request->password == null) unset($data['password']);
        $user = User::find($id);
        $user->fill($data)->save();
        return view('users.list')->with('message', __('custom.success.save'))->with('users', User::paginate(10));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = User::destroy($id);
        return view('users.list')->with('message', $result ? __('custom.delete_success') : __('custom.delete_error'))->with('users', User::paginate(10));
    }
}
