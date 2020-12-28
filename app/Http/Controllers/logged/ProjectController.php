<?php

namespace App\Http\Controllers\logged;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

use App\Project;
use App\User;
use App\Img;

class ProjectController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ((Auth::user()->role->role) == "admin") {

            $projects = Project::get();
            // Se utente semplice visualizza solo i propri progetti

        } elseif ((Auth::user()->role->role) == "user") {
            $projects = Project::where('projects.user_id', '=', Auth::id())->get();
        }

        return view('logged.projects', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shirts = [
            ['type'=>'black.png'],
            ['type' => 'red.png'],
            ['type' => 'white.png']
        ];
        $logos =
        [
            ['type' => 'puzzled.png'],
            ['type' => 'sad.png'],
            ['type' => 'happy.png']
        ];
        return view('logged.create', compact('shirts','logos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|min:6|max:300',
                'tshirt' => 'required|min:3|max:50',
                'logo' => 'required|min:3|max:50',
                'user_id' => 'numeric|exists:users,id'
            ],
            [
                'required' => ':attribute is a required field',
                'numeric' => ':attribute must be a number',
                'exists' => 'the project needs to be associated to an existing user',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->messages();
            return response()->json($error);
        }

        $project = Project::create($request->all());

        //OVERLAY + WATERMARK
        //Full
        $img = Image::make(public_path('/img/tshirts/' . $project->tshirt))->resize(300, 300);
        $img2 = Image::make(public_path('/img/logos/' . $project->logo))->resize(100, 100);
        $wm = Image::make(public_path('/img/logos/nss.ico'))->resize(70, 70);
        /* insert watermark at bottom-right corner with 10px offset */
        $img->insert($img2, 'center');
        $img->encode('png');
        $img->insert($wm, 'bottom-right', 10, 10);
        $img->encode('png');

        $path = Auth::user()->lastname . $project->id ;
        $name_file = 'full';
        $type = '.png';
        Storage::put('public/images/' . $path .'/' . $name_file . $type, $img->encode());

        Img::insert(
            [
                'created_at' => Carbon::now(),
                'path' => 'public/images/' . $path . '/' . $name_file . $type,
                'project_id' => $project->id,
            ]
        );
        //Mid
        $img = Image::make(public_path('/img/tshirts/' . $project->tshirt))->resize(200, 200);
        $img2 = Image::make(public_path('/img/logos/' . $project->logo))->resize(70, 70);
        $wm = Image::make(public_path('/img/logos/nss.ico'))->resize(50, 50);
        /* insert watermark at bottom-right corner with 10px offset */
        $img->insert($img2, 'center');
        $img->encode('png');
        $img->insert($wm, 'bottom-right', 10, 10);
        $img->encode('png');

        $path = Auth::user()->lastname . $project->id ;
        $name_file = 'mid';
        $type = '.png';
        Storage::put('public/images/' . $path .'/' . $name_file . $type, $img->encode());

        Img::insert(
            [
                'created_at' => Carbon::now(),
                'path' => 'public/images/' . $path . '/' . $name_file . $type,
                'project_id' => $project->id,
            ]
        );
        //thumbnail
        $img = Image::make(public_path('/img/tshirts/' . $project->tshirt))->resize(100, 100);
        $img2 = Image::make(public_path('/img/logos/' . $project->logo))->resize(33, 33);
        $wm = Image::make(public_path('/img/logos/nss.ico'))->resize(20, 20);
        /* insert watermark at bottom-right corner with 10px offset */
        $img->insert($img2, 'center');
        $img->encode('png');
        $img->insert($wm, 'bottom-right', 10, 10);
        $img->encode('png');

        $path = Auth::user()->lastname . $project->id ;
        $name_file = 'thumbnail';
        $type = '.png';
        Storage::put('public/images/' . $path .'/' . $name_file . $type, $img->encode());

        Img::insert(
            [
                'created_at' => Carbon::now(),
                'path' => 'public/images/' . $path . '/' . $name_file . $type,
                'project_id' => $project->id,
            ]
        );

        Storage::disk('local')->put(('public/images/' . $path . '/progetto.txt'), $project->title);
        return redirect()->route('user.index')->with('status', 'Hai creato correttamente il tuo progetto "' . $project->title . '"');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shirts = [
            ['type' => 'black.png'],
            ['type' => 'red.png'],
            ['type' => 'white.png']
        ];
        $logos =
        [
            ['type' => 'puzzled.png'],
            ['type' => 'happy.png'],
            ['type' => 'sad.png']
        ];

        $project = Project::find($id);
        if ($project->user_id == Auth::id()){
            return view('logged.edit', compact('project', 'shirts', 'logos'));
        } else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['updated_at'] = Carbon::now('Europe/Rome');
        $project = Project::find($id);
        $project->update($data);

        //OVERLAY + WATERMARK
        //Full
        $img = Image::make(public_path('/img/tshirts/' . $project->tshirt))->resize(300, 300);
        $img2 = Image::make(public_path('/img/logos/' . $project->logo))->resize(100, 100);
        $wm = Image::make(public_path('/img/logos/nss.ico'))->resize(70, 70);
        /* insert watermark at bottom-right corner with 10px offset */
        $img->insert($img2, 'center');
        $img->encode('png');
        $img->insert($wm, 'bottom-right', 10, 10);
        $img->encode('png');

        $path = Auth::user()->lastname . $project->id;
        $name_file = 'full';
        $type = '.png';
        Storage::put('public/images/' . $path . '/' . $name_file . $type, $img->encode());

        Img::insert(
            [
                'created_at' => Carbon::now(),
                'path' => 'public/images/' . $path . '/' . $name_file . $type,
                'project_id' => $project->id,
            ]
        );
        //Mid
        $img = Image::make(public_path('/img/tshirts/' . $project->tshirt))->resize(200, 200);
        $img2 = Image::make(public_path('/img/logos/' . $project->logo))->resize(70, 70);
        $wm = Image::make(public_path('/img/logos/nss.ico'))->resize(50, 50);
        /* insert watermark at bottom-right corner with 10px offset */
        $img->insert($img2, 'center');
        $img->encode('png');
        $img->insert($wm, 'bottom-right', 10, 10);
        $img->encode('png');

        $path = Auth::user()->lastname . $project->id;
        $name_file = 'mid';
        $type = '.png';
        Storage::put('public/images/' . $path . '/' . $name_file . $type, $img->encode());

        Img::insert(
            [
                'created_at' => Carbon::now(),
                'path' => 'public/images/' . $path . '/' . $name_file . $type,
                'project_id' => $project->id,
            ]
        );
        //thumbnail
        $img = Image::make(public_path('/img/tshirts/' . $project->tshirt))->resize(100, 100);
        $img2 = Image::make(public_path('/img/logos/' . $project->logo))->resize(33, 33);
        $wm = Image::make(public_path('/img/logos/nss.ico'))->resize(20, 20);
        /* insert watermark at bottom-right corner with 10px offset */
        $img->insert($img2, 'center');
        $img->encode('png');
        $img->insert($wm, 'bottom-right', 10, 10);
        $img->encode('png');

        $path = Auth::user()->lastname . $project->id;
        $name_file = 'thumbnail';
        $type = '.png';
        Storage::put('public/images/' . $path . '/' . $name_file . $type, $img->encode());

        Img::insert(
            [
                'created_at' => Carbon::now(),
                'path' => 'public/images/' . $path . '/' . $name_file . $type,
                'project_id' => $project->id,
            ]
        );

        Storage::disk('local')->put(('public/images/' . $path . '/progetto.txt'), $project->title);
        return redirect()->route('user.index')->with('status', 'Hai modificato il tuo progetto');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */

    public function destroy($id)
    {
        $path = Auth::user()->lastname . $id;
        DB::table('projects')->where('id', '=', $id)->delete();

        Storage::deleteDirectory('public/images/'.$path);
        return redirect()->back()->with('status', 'Hai eliminato il progetto');

    }

}
