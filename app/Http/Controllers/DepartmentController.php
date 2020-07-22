<?php

    namespace App\Http\Controllers;

    use App\Models\User;
    use App\Models\UsersDepartment;
    use App\Services\FileService;
    use App\Services\ValidateService;
    use Illuminate\Http\Request;
    use App\Models\Department;
    use Illuminate\Support\Facades\Log;

    class DepartmentController extends Controller
    {
        /**
         * @var FileService
         */
        private $_fileService;
        /**
         * @var ValidateService
         */
        private $_validateService;

        /**
         * DepartmentController constructor.
         */
        public function __construct(FileService $_fileService, ValidateService $_validateService)
        {
            $this->middleware('auth');
            $this->_fileService = $_fileService;
            $this->_validateService = $_validateService;
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            return view('departments.list')->with('departments', Department::with('users')->paginate(4));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            return view('departments.edit')->with('title', __('custom.add'))->with('users', User::all());
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            $this->_validateService->department($request);
            $data = $request->post();
            $users = explode(',', $data['users']);
            unset($data['users']);
            if (($filePath = $this->_fileService->saveLogo($request->file)) == false) {
                Log::error(__('custom.errors.save', ['value' => 'лого']));
                return __('custom.errors.save', ['value' => 'лого']);
            } else {
                $data['logo'] = $filePath;
            }
            if (($department = Department::create($data)) == false) {
                Log::error(__('custom.errors.save', ['value' => 'отдела']));
                return __('custom.errors.save', ['value' => 'отдела']);
            }
            foreach ($users as $id => $checked) {
                if ($checked == "true") {
                    if (UsersDepartment::create(['user_id' => $id, 'department_id' => $department->id]) == false) {
                        Log::error(__('custom.errors.save', ['value' => 'пользователя в отдел']));
                    }
                }
            }
            return __('custom.success.save');
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            return view('departments.edit')
                ->with('title', __('custom.edit'))
                ->with('users', User::all())
                ->with('department', Department::with('users')->find($id));
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
            $this->_validateService->department($request);
            $data = $request->post();
            $department = Department::find($id);
            $department->fill($data)->save();
            foreach (explode(',',$data['users']) as $id=>$checked) {
                if($checked == "") continue;
                if($checked == "false") {
                    UsersDepartment::where('user_id', $id)->delete();
                }
                if($checked == "true") {
                    if (UsersDepartment::create(['user_id' => $id, 'department_id' => $department->id]) == false) {
                        Log::error(__('custom.errors.save', ['value' => 'пользователя в отдел']));
                    }
                }
            }
            return __('custom.success.save');
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            $result = Department::destroy($id);
            return $result ? __('custom.delete_success') : __('custom.delete_error');
        }
    }
