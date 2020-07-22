<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Department extends Model
    {
        /**
         * @var string
         */
        protected $table = 'departments';
        /**
         * @var string[]
         */
        protected $fillable = [
            'name',
            'description',
            'logo'
        ];

        public function users() {
            return $this->belongsToMany('App\Models\User', 'user_departments');
        }
    }
