<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bootgrid;
use App\Tipo;
use App\Http\Requests\TipoRequest;

class TipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('tipo.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('tipo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoRequest $request)
    {
        $data = $request->only ( array_keys($request->rules()) );

//        $validated = $request->validated();
        $tipo = new Tipo($data);

        $tipo->save();
        $retorno['status'] = 1;
        $retorno['message'] = 'Tipo cadastrado com sucesso';

        return response()->json($retorno);

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
     * @param  Tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function edit(Tipo $tipo)
    {
        //
        return view('tipo.edit', compact('tipo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function update(TipoRequest $request, Tipo $tipo)
    {
        $data = $request->only( array_keys($request->rules()) );
        $tipo->fill($data);
        $tipo->save();
        $retorno['status'] = 1;
        $retorno['message'] = 'Tipo alterado com sucesso';

        return response()->json($retorno);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tipo $tipo)
    {
        $tipo->delete();

        $retorno['status'] = 1;
        $retorno['message'] = 'Tipo excluído com sucesso';

        return response()->json($retorno);

    }

    public function bootgrid(Request $request)
    {
        $searchPhrase = $request->searchPhrase;
        $rowCount = ($request->rowCount > 0 ? $request->rowCount : 0);
        $current = ($request->current ? ($request->current - 1) * $rowCount : 0);

        $tipo = Tipo::where('nome', 'like', "%{$searchPhrase}%");

        foreach ($request->sort as $item => $value) {
            $tipo->orderBy($item, $value);
        }

        $bootgrid = new Bootgrid();
        $bootgrid->total = $tipo->count();
        $bootgrid->rowCount = $rowCount;
        if ($rowCount > 0) {
            $bootgrid->current = $request->current;
            $bootgrid->rows = $tipo->take($rowCount)->skip($current)->get();
        } else {
            $bootgrid->rows = $tipo->get();
            $bootgrid->current = 1;
        }
        return response()->json($bootgrid);
    }
}
