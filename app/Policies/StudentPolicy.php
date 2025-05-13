<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Student;

class StudentPolicy
{
    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin', 'teacher']);
    }
    public function store(User $user)
{
    return $this->create($user);
}

    public function view(User $user, Student $student)
    {
        return $user->role === 'admin' || 
              ($user->role === 'teacher' && $student->teacher_id == $user->id);
    }

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Student $student)
    {
        return $user->role === 'admin' || 
              ($user->role === 'teacher' && $student->teacher_id == $user->id);
    }

    public function delete(User $user, Student $student)
    {
        return $user->role === 'admin';
    }
}