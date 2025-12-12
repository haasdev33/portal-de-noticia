<?php

namespace App\Helpers;

use App\Models\User;

class PermissionHelper
{
    /**
     * Check if user can view admin panel
     */
    public static function canAccessAdmin(?User $user): bool
    {
        return $user && ($user->isAdmin() || $user->isEditor());
    }

    /**
     * Check if user can manage users
     */
    public static function canManageUsers(?User $user): bool
    {
        return $user && $user->isAdmin();
    }

    /**
     * Check if user can manage articles
     */
    public static function canManageArticles(?User $user): bool
    {
        return $user && ($user->isAdmin() || $user->isEditor());
    }

    /**
     * Check if user can manage pages
     */
    public static function canManagePages(?User $user): bool
    {
        return $user && ($user->isAdmin() || $user->isEditor());
    }

    /**
     * Check if user can edit specific article
     */
    public static function canEditArticle(?User $user, $article): bool
    {
        if (!$user) {
            return false;
        }
        
        if ($user->isAdmin()) {
            return true;
        }
        
        if ($user->isEditor() && $user->id === $article->user_id) {
            return true;
        }
        
        return false;
    }

    /**
     * Check if user can delete specific article
     */
    public static function canDeleteArticle(?User $user, $article): bool
    {
        return self::canEditArticle($user, $article);
    }

    /**
     * Get role label
     */
    public static function getRoleLabel(?User $user): string
    {
        if (!$user) {
            return 'Visitante';
        }

        if ($user->isAdmin()) {
            return 'Administrador';
        }

        if ($user->isEditor()) {
            return 'Editor';
        }

        return 'Usuário';
    }

    /**
     * Get role badge color
     */
    public static function getRoleBadgeClass(?User $user): string
    {
        if (!$user) {
            return 'bg-secondary';
        }

        if ($user->isAdmin()) {
            return 'bg-danger';
        }

        if ($user->isEditor()) {
            return 'bg-warning';
        }

        return 'bg-secondary';
    }
}
