<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use App\Models\Tournament;
use App\Models\UsersOrganizers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrganizerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function index()
    {
        $userId = Auth::user()->id;
        $data = UsersOrganizers::with(['organizer'])->where('user_id', $userId)->get();

        // dd($data->first()->organizer);

        return view('organizer.list', [
            'title' => 'Organizer List',
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('organizer.create', [
            'title' => 'Buat Organizer'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $leaderId = Auth::user()->id;

        $validatedData = $request->validate([
            'name' => 'required|max:50|unique:organizers,name',
            'description' => 'required|max:50',
            'contact' => 'required|max:50',
            'logo_img' => 'image|file|max:1000',
            'banner_img' => 'image|file|max:5096'
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);
        $validatedData['logo_img'] = $request->file('logo_img')->store('organizer-logo');
        $validatedData['banner_img'] = $request->file('banner_img')->store('organizer-banner');

        $organizer = Organizer::create($validatedData);

        UsersOrganizers::create([
            'user_id' => $leaderId,
            'organizer_id' => $organizer->id,
            'role' => 'Leader'
        ]);

        return redirect()->route('organizer.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $organizerData = Organizer::with(['tournaments'])->where('slug', $slug)->first();
        if ($organizerData) {
            $user = Auth::user();
            $userRole = null;

            if ($user) {
                $userRole = UsersOrganizers::where('user_id', $user->id)->first()->role;
            }


            return view('organizer.detail', [
                'title' => $organizerData->name,
                'organizerData' => $organizerData,
                'userRole' => $userRole
            ]);
        }
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $data = Organizer::where('slug', $slug)->first();

        return view('organizer.edit', [
            'title' => 'Edit ' . $data->name,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $oldData = Organizer::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|max:50|unique:organizers,name,' . $id,
            'description' => 'required|max:50',
            'contact' => 'required|max:50',
            'logo_img' => 'image|file|max:1000',
            'banner_img' => 'image|file|max:5096'
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);

        if ($request->logo_img != null) {
            if ($oldData->logo_img) {
                Storage::delete($oldData->logo_img);
            }
            $validatedData['logo_img'] = $request->file('logo_img')->store('team-logo');
        }
        if ($request->banner_img != null) {
            if ($oldData->banner_img) {
                Storage::delete($oldData->banner_img);
            }
            $validatedData['banner_img'] = $request->file('banner_img')->store('team-bg');
        }

        Organizer::where('id', $id)
            ->update($validatedData);

        $newData = Organizer::findOrFail($id);

        return redirect()->route('organizer_dashboard', $newData->slug);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $organizer = Organizer::findOrFail($id);

        Storage::delete($organizer->logo_img);
        Storage::delete($organizer->banner_img);

        $organizer->delete();

        return redirect()->route('organizer.index');
    }

    public function dashboard(string $slug)
    {
        $userId = Auth::user()->id;
        $organizerId = Organizer::where('slug', $slug)->first()->id;
        // dd($organizerId);
        $data = UsersOrganizers::with(['user', 'organizer'])
            ->where('user_id', $userId)
            ->where('organizer_id', $organizerId)->first();
        $userRole = $data->role;

        $organizerData = $data->organizer->first();

        return view('organizer.dashboard', [
            'title' => 'Dashboard ' . $organizerData->name,
            'headerTitle' => 'Dashboard',
            'organizerData' => $organizerData
        ]);
    }

    public function tournaments(string $slug)
    {
        $organizerData = Organizer::where('slug', $slug)->first();
        $tournaments = Tournament::where('id_organizer', $organizerData->id);

        if (request('search')) {
            $tournaments = $tournaments->where('name', 'like', '%' . request('search') . '%');
        }
        return view('organizer.tournaments', [
            'title' => 'Turnamen ' . $organizerData->name,
            'headerTitle' => 'Turnamen',
            'organizerData' => $organizerData,
            'tournaments' => $tournaments->paginate(10)
        ]);
    }
}
