<?php

namespace App\Repositories\Wordpress;

use App\Models\Wordpress\User;
use App\Models\Wordpress\UserMeta;
use App\Repositories\Contracts\Wordpress\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    protected User $user;
    protected UserMeta $meta;

    public function __construct(User $user, UserMeta $meta)
    {
        $this->user = $user;
        $this->meta = $meta;
    }

    public function getUsers(int $rpp): LengthAwarePaginator
    {
        return $this->user->with('meta')->paginate($rpp);
    }

    public function findByID(int|string $id): ?User
    {
        return $this->user->with('meta')->find($id);
    }

    public function create(array $param): User
    {
        $user = $this->user->create([
            'user_login' => $param['username'],
            'user_email' => $param['email'],
            'user_pass' => md5($param['password']),
            'user_registered' => now(),
            'user_url' => $param['website'] ?? '',
        ]);
        $metaFields = [
            ['user_id' => $user->ID, 'meta_key' => 'first_name', 'meta_value' => $param['first_name'] ?? ''],
            ['user_id' => $user->ID, 'meta_key' => 'last_name', 'meta_value' => $param['last_name'] ?? ''],
            ['user_id' => $user->ID, 'meta_key' => 'nickname', 'meta_value' => $param['first_name'] ?? $param['username']],
            ['user_id' => $user->ID, 'meta_key' => 'wp_capabilities', 'meta_value' => serialize([$param['role'] => true])],
        ];
        $this->meta->insert($metaFields);

        return $user;
    }

    public function update(int|string $id, array $param): ?User
    {
        return DB::transaction(function () use ($id, $param) {
            $data = [
                'user_login' => $param['username'],
                'user_email' => $param['email'],
                'user_url' => $param['website'] ?? '',
            ];
            if (!empty($param['password'])) {
                $data['user_pass'] = md5($param['password']);
            }

            $this->user->where('ID', $id)->update($data);

            $metaFields = [
                'first_name' => $param['first_name'] ?? '',
                'last_name' => $param['last_name'] ?? '',
                'nickname' => $param['first_name'] ?? $param['username'],
                'wp_capabilities' => serialize([$param['role'] => true]),
            ];
            foreach ($metaFields as $key => $value) {
                $this->meta->updateOrInsert(
                    ['user_id' => $id, 'meta_key' => $key],
                    ['meta_value' => $value]
                );
            }

            return $this->findByID($id);
        });
    }

    public function delete(int|string $id): bool
    {
        return DB::transaction(function () use ($id) {
            $this->meta->where('user_id', $id)->delete();
            $this->user->where('ID', $id)->delete();
            return true;
        });
    }

    public function isUsernameTaken(string $username, int|string|null $excludeId = null): bool
    {
        return $this->user->where('user_login', $username)->when($excludeId, fn($query) => $query->where('ID', '!=', $excludeId))->exists();
    }

    public function isEmailTaken(string $email, int|string|null $excludeId = null): bool
    {
        return $this->user->where('user_email', $email)->when($excludeId, fn($query) => $query->where('ID', '!=', $excludeId))->exists();
    }
}
