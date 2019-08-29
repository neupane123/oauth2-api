<?php

namespace App\Providers;

use App\Course;
use App\Policies\CoursePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        // 'App\Course'    =>  'App\Policies\CoursePolicy',
        Course::class    =>  CoursePolicy::class,
        Student::class    =>  StudentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensCan([
            'view-users' => 'view all users',
            'manage-students' => 'token auth scope for managing students',
            'manage-courses' => 'token auth scope for managing courses',

        ]);

        // Passport::tokensCan([
        //     'view-students' => 'view all students'
        // ]);

        // Passport::tokensCan([
        //     'create-course' => 'create course taught'
        // ]);

        // Passport::tokensCan([
        //     'edit-course' => 'edit course taught'
        // ]);

        // Passport::tokensCan([
        //     'delete-course' => 'delete course taught'
        // ]);


        Gate::define('view-users', function ($user) {
                return $user->role === 'admin';
        });

        Gate::define('view-students', function ($user) {
                return $user->role === 'admin';
        });
    }
}
