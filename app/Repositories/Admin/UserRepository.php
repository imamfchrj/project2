<?php

namespace App\Repositories\Admin;

use Carbon\Carbon;
use DB;

use App\Repositories\Admin\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Role;
use Modules\Jib\Entities\Minitiator;

class UserRepository implements UserRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $users = (new User())->with('roles');

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $users = $users->orderBy($field, $sort);
            }
        }

//        if (!empty($options['filter']['start_date']) && !empty($options['filter']['end_date'])) {
//            $startDate = Carbon::parse($options['filter']['start_date']);
//            $endDate = Carbon::parse($options['filter']['end_date']);
//
//            $users = $users->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
//        }

        if (!empty($options['filter']['q'])) {
            $users = $users->where('name', 'LIKE', "%{$options['filter']['q']}%")
                ->orWhere('email', 'LIKE', "%{$options['filter']['q']}%")
                ->orWhere('nik', 'LIKE', "%{$options['filter']['q']}%")
                ->orWhere('nik_gsd', 'LIKE', "%{$options['filter']['q']}%");
        }

        $users = $users->select(
            'users.id',
            'users.nik',
            'users.nik_gsd',
            'users.name',
            'users.objid_posisi',
            'users.email',
            'a.nama_posisi'
        )
            ->join('m_initiator as a', 'a.user_id', '=', 'users.id')
            ->groupby(
                'users.id',
                'users.nik',
                'users.nik_gsd',
                'users.name',
                'users.objid_posisi',
                'users.email',
                'a.nama_posisi'
            );

        if ($perPage) {
            return $users->paginate($perPage);
        }

        return $users->get();
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }

    public function create($params = [])
    {
//        return DB::transaction(function () use ($params) {

        $cek_initiator = Minitiator::where('id', $params['initiator_id'])->firstorfail();
        $params['password'] = Hash::make($params['password']);
//            $user = User::create($params);

        $user = new User();
        $user->nik = $params['nik'];
        $user->nik_gsd = $params['nik_gsd'];
        $user->name = $params['name'];
        $user->objid_posisi = $cek_initiator->objid_posisi;
        $user->email = $params['email'];
        $user->password = $params['password'];
        $this->syncRolesAndPermissions($params, $user);
        $user->save();

        $cek_initiator->user_id = $user->id;

        return $cek_initiator->save();
//        });
    }

    public function update($id, $params = [])
    {
        $user = User::findOrFail($id);
        $cek_initiator = Minitiator::where('id', $params['initiator_id'])->firstorfail();

//        if (!$params['password']) {
//            unset($params['password']);
//        } else {
//            $params['password'] = Hash::make($params['password']);
//        }

//        return DB::transaction(function () use ($params, $user) {
//            $user->update($params);
//            $this->syncRolesAndPermissions($params, $user);

        $user->nik = $params['nik'];
        $user->nik_gsd = $params['nik_gsd'];
        $user->name = $params['name'];
        $user->objid_posisi = $cek_initiator->objid_posisi;
        $user->email = $params['email'];
        if (!$params['password']) {
            unset($params['password']);
        } else {
            $user->password = Hash::make($params['password']);
        }
        $this->syncRolesAndPermissions($params, $user);

        return $user->save();
//        });
    }

    public function update_profile($id, $params = [])
    {
        $user = User::findOrFail($id);

        $user->nik = $params['nik'];
        $user->nik_gsd = $params['nik_gsd'];
        $user->name = $params['name'];
        $user->email = $params['email'];
        if (!$params['password']) {
            unset($params['password']);
        } else {
            $user->password = Hash::make($params['password']);
        }

        return $user->save();
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        return $user->delete();
    }

    /**
     * Sync roles and permissions
     *
     * @param Request $request
     * @param $user
     * @return string
     */
    private function syncRolesAndPermissions($params, $user)
    {
        // Get the submitted roles
        $roles = isset($params['role_id']) ? [$params['role_id']] : [];
        $permissions = isset($params['permissions']) ? $params['permissions'] : [];

        // Get the roles
        $roles = Role::find($roles);

        // check for current role changes
        if (!$user->hasAllRoles($roles)) {
            // reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
            // handle permissions
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);

        return $user;
    }
}
