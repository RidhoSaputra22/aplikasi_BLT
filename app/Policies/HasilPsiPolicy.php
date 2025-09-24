<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Admin;
use App\Models\HasilPsi;
use Illuminate\Auth\Access\Response;

class HasilPsiPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User | Admin $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User | Admin $user, HasilPsi $hasilPsi): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User | Admin $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User | Admin $user, HasilPsi $hasilPsi): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User | Admin $user, HasilPsi $hasilPsi): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User | Admin $user, HasilPsi $hasilPsi): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User | Admin $user, HasilPsi $hasilPsi): bool
    {
        return true;
    }
}
