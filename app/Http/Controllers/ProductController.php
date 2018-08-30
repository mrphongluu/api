<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $page = request()->has('page') ? request('page') : 1;
        $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', 'http://blog.vn/api/product?page=' . $page);
            $products =  json_decode($res->getBody(), false);
            return view('api.index', compact('products'));

    }

    public function show($id, Request $request)
    {
        $id=$request->id;
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://blog.vn/api/product/'.$id );
        $products =  json_decode($res->getBody(), false);
        return view('api.show', compact('products'));

    }

    public function store(Request $request)
    {
        $data= $request->all();
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', 'http://blog.vn/api/product',['form_params' => $data] );
        $products =  json_decode($res->getBody(), false);
        return redirect()->route('api.index');
    }

    public function update($id, Request $request)
    {
        $data= $request->all();
        $client = new \GuzzleHttp\Client();
        $res = $client->request('PUT', "http://blog.vn/api/product/{$id}",['form_params' => $data]);
        $products =  json_decode($res->getBody(), false);
        return redirect()->route('api.index');
    }

    public function destroy($id, Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->delete('http://blog.vn/api/product/'. $id);
        return redirect()->route('api.index');
    }
}
