<?php

namespace App\Http\Controllers;

use App\Models\cat_imagenes;
use Illuminate\Http\Request;

class CatImagenesController extends Controller
{
    private $catImagenes;
    /**
     * Inyectamos el model que se ocupara
     */
    public function __construct( cat_imagenes $catImagenes )
    {
        $this->catImagenes = $catImagenes;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $imagenes = $this->catImagenes->get();

        foreach ($imagenes as $item) {

           $data = "data:image/png;base64,".base64_encode (file_get_contents( public_path( 'storage/'.$item->route ) ) );
          $item['base64'] = $data;

        }

        return response($imagenes, 200)
                        ->header('Content-Type', 'text/json');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Methods: POST');


        $image=$request->image;

        if($image){

            $img = substr($image, strpos($image, ",")+1);
            $data = base64_decode($img);

           \Storage::disk('public')->put($request->nombre.".png", $data );

        }

        $this->catImagenes::create([
            'name' => $request->nombre,
            'route' => $request->nombre.".png",
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $data=array(
            'image'=>$image,
            'status'=>'success'
        );

        return response()->json($data,200);

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
