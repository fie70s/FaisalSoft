<?php

namespace App\Http\Controllers\Admin\Hotspot;

use App\Http\Controllers\Controller;
use App\Models\HotspotUser;
use App\Models\MikroTikDevice;
use App\Services\MikroTik\Hotspot\UserService;
use App\Services\MikroTik\Hotspot\HotspotUserSyncService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $users;
    protected HotspotUserSyncService $sync;

    public function __construct(
        UserService $users,
        HotspotUserSyncService $sync
    ) {
        $this->users = $users;
        $this->sync = $sync;
    }


    public function index(Request $request)
    {
        $device = MikroTikDevice::first();


        if (!$device) {
            return view(
                'admin.hotspot.users.index',
                [
                    'users' => collect([]),
                    'device' => null,
                    'profiles' => collect([]),
                    'error' => 'لا يوجد جهاز MikroTik'
                ]
            );
        }


        try {

            $this->sync->sync($device);


            $query = HotspotUser::where(
                'mikrotik_device_id',
                $device->id
            );


            if ($request->filled('search')) {

                $query->where(function ($q) use ($request) {

                    $q->where(
                        'username',
                        'like',
                        '%' . $request->search . '%'
                    )

                    ->orWhere(
                        'comment',
                        'like',
                        '%' . $request->search . '%'
                    );

                });
            }


            if ($request->status == 'active') {

                $query->where(
                    'disabled',
                    false
                );
            }


            if ($request->status == 'disabled') {

                $query->where(
                    'disabled',
                    true
                );
            }


            if ($request->filled('profile')) {

                $query->where(
                    'profile',
                    $request->profile
                );
            }


            /*
            |--------------------------------------------------------------------------
            | فلتر نوع الباقة
            |--------------------------------------------------------------------------
            */


            if ($request->package == 'limited') {

                $query->whereNotNull('limit_bytes_total')
                      ->where('limit_bytes_total', '>', 0);
            }


            if ($request->package == 'unlimited') {

                $query->where(function ($q) {

                    $q->whereNull('limit_bytes_total')
                      ->orWhere('limit_bytes_total', 0);

                });
            }


            /*
            |--------------------------------------------------------------------------
            | الفرز
            |--------------------------------------------------------------------------
            */


            $sort = $request->get(
                'sort',
                'username'
            );


            $order = strtolower(
                $request->get(
                    'order',
                    'asc'
                )
            );


            if (!in_array($order, ['asc', 'desc'])) {
                $order = 'asc';
            }


            $allowedSorts = [

                'username',
                'profile',
                'bytes_in',
                'bytes_out',
                'limit_bytes_total',
                'uptime',
                'disabled',
                'created_at',
                'updated_at'

            ];


            if (!in_array($sort, $allowedSorts)) {

                $sort = 'username';

            }


            $query->orderBy(
                $sort,
                $order
            );


            $users = $query
                ->paginate(20)
                ->withQueryString();


            $profiles = $this->users->profiles($device);


            return view(
                'admin.hotspot.users.index',
                [
                    'users' => $users,
                    'device' => $device,
                    'profiles' => $profiles,
                    'error' => null
                ]
            );


        } catch (\Throwable $e) {


            return view(
                'admin.hotspot.users.index',
                [
                    'users' => collect([]),
                    'device' => $device,
                    'profiles' => collect([]),
                    'error' => $e->getMessage()
                ]
            );
        }
    }
        public function sync()
    {
        $device = MikroTikDevice::first();


        if (!$device) {

            return back()->with(
                'error',
                'لا يوجد جهاز MikroTik'
            );

        }


        $count = $this->sync->sync($device);


        return back()->with(
            'success',
            "تمت مزامنة {$count} مستخدم"
        );
    }



    public function create()
    {
        $device = MikroTikDevice::first();


        $profiles = [];


        if ($device) {

            $profiles = $this->users->profiles($device);

        }


        return view(
            'admin.hotspot.users.create',
            [
                'profiles' => $profiles
            ]
        );
    }



    public function store(Request $request)
    {
        $device = MikroTikDevice::first();


        if (!$device) {

            return back()->with(
                'error',
                'لا يوجد جهاز MikroTik'
            );

        }


        $data = $request->validate([

            'username' => 'required|string',
            'password' => 'nullable|string',
            'profile' => 'nullable|string',
            'limit_uptime' => 'nullable|string',
            'limit_bytes_total' => 'nullable|numeric',
            'comment' => 'nullable|string',

        ]);



        $this->users->create(
            $device,
            [

                'username' => $data['username'],
                'password' => $data['password'] ?? null,
                'profile' => $data['profile'] ?? null,
                'limit-uptime' => $data['limit_uptime'] ?? null,
                'limit-bytes-total' => $data['limit_bytes_total'] ?? null,
                'comment' => $data['comment'] ?? null,

            ]
        );



        $this->sync->sync($device);



        return redirect()
            ->route('admin.hotspot.users.index')
            ->with(
                'success',
                'تم إنشاء المستخدم بنجاح'
            );
    }

        public function edit(string $id)
    {
        $device = MikroTikDevice::first();


        if (!$device) {

            return back()->with(
                'error',
                'لا يوجد جهاز MikroTik'
            );

        }


        $user = $this->users->find(
            $device,
            $id
        );


        $profiles = $this->users->profiles($device);


        return view(
            'admin.hotspot.users.edit',
            compact('user', 'profiles')
        );
    }



    public function update(Request $request, string $id)
    {
        $device = MikroTikDevice::first();


        if (!$device) {

            return back()->with(
                'error',
                'لا يوجد جهاز MikroTik'
            );

        }


        $data = $request->validate([

            'password' => 'nullable|string',
            'profile' => 'nullable|string',
            'limit_uptime' => 'nullable|string',
            'limit_bytes_total' => 'nullable|numeric',
            'comment' => 'nullable|string',

        ]);



        $this->users->update(
            $device,
            $id,
            [

                'password' => $data['password'] ?? null,
                'profile' => $data['profile'] ?? null,
                'limit-uptime' => $data['limit_uptime'] ?? null,
                'limit-bytes-total' => $data['limit_bytes_total'] ?? null,
                'comment' => $data['comment'] ?? null,

            ]
        );



        $this->sync->sync($device);



        return redirect()
            ->route('admin.hotspot.users.index')
            ->with(
                'success',
                'تم تحديث المستخدم'
            );
    }



    public function destroy(string $id)
    {
        $device = MikroTikDevice::first();


        if (!$device) {

            return back()->with(
                'error',
                'لا يوجد جهاز MikroTik'
            );

        }


        $this->users->delete(
            $device,
            $id
        );


        $this->sync->sync($device);


        return back()->with(
            'success',
            'تم حذف المستخدم'
        );
    }



    public function enable(string $id)
    {
        $device = MikroTikDevice::first();


        if (!$device) {

            return back()->with(
                'error',
                'لا يوجد جهاز MikroTik'
            );

        }


        $this->users->enable(
            $device,
            $id
        );


        $this->sync->sync($device);


        return back()->with(
            'success',
            'تم تفعيل المستخدم'
        );
    }



    public function disable(string $id)
    {
        $device = MikroTikDevice::first();


        if (!$device) {

            return back()->with(
                'error',
                'لا يوجد جهاز MikroTik'
            );

        }


        $this->users->disable(
            $device,
            $id
        );


        $this->sync->sync($device);


        return back()->with(
            'success',
            'تم تعطيل المستخدم'
        );
    }



    public function sessions(string $id)
    {
        $device = MikroTikDevice::first();


        if (!$device) {

            return back()->with(
                'error',
                'لا يوجد جهاز MikroTik'
            );

        }


        $user = HotspotUser::where(
            'mikrotik_device_id',
            $device->id
        )
        ->where(
            'mikrotik_id',
            $id
        )
        ->firstOrFail();



        $sessions = $this->users->activeSessions(
            $device,
            $user->username
        );


        return view(
            'admin.hotspot.users.sessions',
            compact('user', 'sessions')
        );
    }



    public function disconnect(string $session)
    {
        $device = MikroTikDevice::first();


        if (!$device) {

            return back()->with(
                'error',
                'لا يوجد جهاز MikroTik'
            );

        }


        $this->users->disconnect(
            $device,
            $session
        );


        return back()->with(
            'success',
            'تم قطع الاتصال'
        );
    }
}