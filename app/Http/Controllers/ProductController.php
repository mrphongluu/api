<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Guzzle\Http\Exception\ClientErrorResponseException;
use GuzzleHttp\Exception\RequestException;

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
        $client = new \GuzzleHttp\Client();
        try {
            $res = $client->get('http://blog.vn/api/product/'.$id );
        } catch (RequestException $e){
            $response = $e->getResponse();
            $responseBodyAsString = json_decode((string) $response->getBody()->getContents() );
            return response()->json($responseBodyAsString);
        }
        $products =  json_decode($res->getBody(), false);
        if(!empty($products)){
            return view('api.show', compact('products'));
        }
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
