<?php


    namespace App\Services;


    use Illuminate\Http\Request;

    class ValidateService
    {
        public function department(Request $request)
        {
            $request->validate([
                'name' => 'required|max:255',
                'description' => 'required',
            ],
                [
                    'name.required' => __('custom.validate.required', ['value' => 'Имя']),
                    'description.required' => __('custom.validate.required', ['value' => 'Описание']),
                    'name.max' => __('custom.validate.max', ['value' => 255]),
                ]);
        }

        public function user(Request $request, $edit = false)
        {
            if(!$edit) {
                $request->validate([
                    'name' => 'required|max:255',
                    'email' => 'required|email|unique:users,email'.$request->id,
                    'password' => 'required|min:6'
                ],
                    [
                        'name.required' => __('custom.validate.required', ['value' => 'Имя']),
                        'name.max' => __('custom.validate.max', ['value' => 255]),
                        'email.required' => __('custom.validate.required', ['value' => 'Email']),
                        'email.unique' => __('custom.validate.unique', ['value' => 'Email']),
                        'email.email' => __('custom.validate.email'),
                        'password.required' => __('custom.validate.required', ['value' => 'Пароль']),
                        'password.min' => __('custom.validate.min', ['value' => 6])
                    ]);
            } else {
                $request->validate([
                    'name' => 'max:255',
                    'email' => 'email',
                ],
                    [
                        'name.max' => __('custom.validate.max', ['value' => 255]),
                        'email.email' => __('custom.validate.email'),
                    ]);
            }
        }
    }
