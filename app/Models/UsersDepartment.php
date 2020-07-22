<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class UsersDepartment extends Model
    {
        protected $table = 'user_departments';
        public $timestamps = false;
        protected $fillable = [
            'user_id',
            'department_id'
        ];

        public function user()
        {
            return $this->belongsTo('App\Models\User')->withDefault();
        }

        public function department()
        {
            return $this->belongsTo('App\Models\Department')->withDefault();
        }
    }
