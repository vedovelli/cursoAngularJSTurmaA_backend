<?php

/**
* Para efeito de brevidade este controller acessa dados direto
* no DB usando o model Product. Para um exemplo melhor, veja
* UserController
*/
class ProductController extends BaseController{

	public function index()
	{
		$products = Product::orderBy('id', 'DESC')->get();
		return Response::json($products, 200);
	}

	public function store()
	{
		$product = new Product();
		$product->fill(Input::all());
		$product->save();
		return Response::json($product, 200);
	}

	public function show($id)
	{
		$product = Product::find($id);
		if(is_null($product))
		{
			return Response::json(['erro' => 'Produto não encontrado'], 400);
		} else {
			return Response::json($product, 200);
		}
	}

	public function update($id)
	{
		$product = Product::find($id);
		if(is_null($product))
		{
			return Response::json(['erro' => 'Produto não encontrado'], 400);
		} else {
			$product->fill(Input::all());
			$product->save();
			return Response::json($product, 200);
		}
	}

	public function destroy($id)
	{
		$product = Product::find($id);
		if(is_null($product))
		{
			return Response::json(['erro' => 'Produto não encontrado'], 400);
		} else {
			$product->delete();
			return Response::json(['response' => 'success'], 200);
		}
	}

}