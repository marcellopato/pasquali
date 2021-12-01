<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('site.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function testURI($uri)
    {
        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
        curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT,10);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpcode;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'uri' => 'required|url',
        ]);
        $httpcode =  $this->testURI($request->uri);
        if($httpcode == 200){
            $site = new Site();
            $site->uri = $request->uri;
            $site->user_id = Auth::user()->id;
            $site->status_code = $httpcode;
            $site->save();

            return redirect()->route('home')->with('message', 'Site cadastrado com sucesso!');
        } 
            return redirect()->back()->with('message', 'Esse site não existe ou está fora do ar');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $site = Site::where('id',$id)->first();
        return view('site.edit')->with('site', $site);
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
        $site = Site::where('id',$id)->first();
        $site->uri = $request->uri;
        $site->update();
        return redirect()->route('home')->with('message', 'Site atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Site::where('id',$id)->delete();
        return redirect()->route('home')->with('message', 'Site apagado com sucesso!');
    }

    public function getSites()
    {
        return DataTables::of(Site::query())->make(true);
    }

    public function checkSites()
    {
        $user = User::where('id', '=', Auth::user()->id)->first();
        $sites = Site::where('user_id', '=', $user->id)->get();
        foreach($sites as $site) {
            $httpcode = $this->testURI($site->uri);
            if ($httpcode == 200){
                $siteTested = Site::where('uri', '=', $site->uri)->first();
                $siteTested->status_code = $site->status_code;
                $siteTested->update();
            } 
            return 1;
        }
    }
}
