<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    public function index(Request $request)
    {
        $query = Config::query();
        $search_query = $request->input('search_query');
        if ($request->has('search_query') && !empty($search_query)) {
            $query->where(function ($query) use ($search_query) {
                $query->where('name', 'like', '%' . $search_query . '%');
            });
        }
        $data['configs'] = $query->orderBy('id', 'ASC')->paginate(50);
        $data['searchParams'] = $request->all();
        return view('admin/config/manage_config', $data);
    }

    public function show(Request $request)
    {
        $config = Config::where('id', $request->id)->first();
        if (!empty($config)) {
            $htmlresult = view('admin/config/configs_ajax', compact('config'))->render();
            $finalResult = response()->json(['msg' => 'success', 'response' => $htmlresult]);
            return $finalResult;
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Configuration not found.']);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'error', 'response' => $validator->errors()->first()]);
        }
        $config = Config::where('id', $request->id)->first();
        if (!empty($config)) {
            $config->value = $request->value;
            $config->save();
            return response()->json(['msg' => 'success', 'response' => 'Configuration updated successfully.']);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Configuration not found.']);
        }
    }

    public function destroySession(Request $request)
    {
        $username = Config::where('key', 'api_username')->first()->value;
        $password = Config::where('key', 'api_password')->first()->value;
        $session_id = Config::where('key', 'session_id')->first()->value;
        $title = Config::where('key', 'api_title')->first()->value;
        $client = new Client();

        // Corrected URL string interpolation
        $url = "https://www.lodestarss.com/Live/$title/Login/login.php";

        $response = $client->request('POST', $url, [
            'form_params' => [
                'username' => $username,
                'password' => $password,
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json',
                // Corrected header value
                'Cookie' => "$title=$session_id",
            ],
        ]);


        $session_id = json_decode($response->getBody())->session_id;
        $session = Config::where('key', 'session_id')->first();
        $session->value = $session_id;
        $query = $session->save();


        if ($query) {
            return response()->json([
                'msg' => 'success',
                'response' => 'Session ID updated successfully.',
                'session_id' => $session_id,
            ]);
        } else {
            return response()->json([
                'msg' => 'error',
                'response' => 'Failed to update session ID.',
            ], 500);
        }
    }
}
