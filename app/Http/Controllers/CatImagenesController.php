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
        $imagenes = $this->catImagenes->orderBy('id', 'desc')->get();

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
        $image = $request->image;
        $type = explode( '/', $request->type);
        $nombre = str_replace(' ', '_',$request->nombre);

        if($image)
        {
            $img = substr($image, strpos($image, ",")+1);
            $data = base64_decode($img);

           \Storage::disk('public')->put($nombre.".".$type[1], $data );
        }

        $this->catImagenes::create([
            'name' => $request->nombre,
            'route' => $nombre.".".$type[1],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $data=array(
            'status'=>'success'
        );

        return response($data, 200)
                ->header('Content-Type', 'text/json');
    }
}
