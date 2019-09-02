<?php

/*
 * Copyright 2017 Royal Botanic Gardens Victoria.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace VicFlora\Http\Controllers\API;

use Illuminate\Http\Request;
use League\Fractal;
use VicFlora\Http\Controllers\Controller;

/**
 * The ApiController class is the superclass of all API controllers; it contains 
 * some methods that are used in all these controllers
 * 
 * @SWG\Swagger(
 *   @SWG\Info(
 *     title="VicFlora API",
 *     description="",
 *     version="1.0.0",
 *     @SWG\Contact(
 *       name="Niels Klazenga, Royal Botanic Gardens Victoria",
 *       email="Niels.Klazenga@rbg.vic.gov.au",
 *       url="https://vicflora.rbg.vic.gov.au"
 *     )
 *   ),
 *   host="vicflora.rbg.vic.gov.au",
 *   basePath="/api",
 *   schemes={"https"},
 *   consumes={"application/json", "multipart/form-data"},
 *   produces={"application/json", "application/vnd.api+json"}
 * )
 */
class ApiController extends Controller
{
    protected $fractal;
    
    public function __construct()
    {
        $this->middleware('cors');
        $this->setFractalManager();
    }
    
    /**
     * Sets the Fractal manager, with the appropriate response type based on the 
     * Accept header and parses the requested includes and excludes
     */
    protected function setFractalManager()
    {
        $this->fractal = new Fractal\Manager();
        if (\request()->header('accept') == 'application/vnd.api+json') {
            $baseUrl = url('api');
            $this->fractal->setSerializer(new \League\Fractal\Serializer\JsonApiSerializer($baseUrl));
        }
        if (\request()->input('include')) {
            $this->fractal->parseIncludes(\request()->input('include'));
        }
        if (\request()->input('exclude')) {
            $this->fractal->parseExcludes(\request()->input('exclude'));
        }
    }
    
    /**
     * Redirects to the specified route and adds the request input data and 
     * Accept header
     * 
     * @param string $route
     * @param string $key
     * @param int $value
     * @return array
     */
    protected function apiRedirect($route, $key, $value)
    {
        $params = [
                $key => $value,
                'include' => request()->input('include'),
                'exclude' => request()->input('exclude'),
                'redirectUrl' => env('APP_URL', 'https://vicflora.rbg.vic.gov.au') . '/' .request()->path()
            ];
        return redirect()->route($route, $params, 302, [
                'accept' => request()->header('accept')
            ]);
    }
    
    /**
     * Checks for flash data and appends a meta section with a redirect message 
     * to the return array
     * 
     * @param array $data
     * @return \Illuminate\Http\Response;
     */
    protected function responseWithRedirectMessage($data)
    {
        $referrer = request()->input('redirectUrl');
        if ($referrer) {
            $data['meta']['redirect-message'] = 'Redirected from: ' . $referrer;
        }
        return \response()->json($data);
    }
    
    protected function errorResponse($status, $message=false)
    {
        switch ($status) {
            case 400:
                $data = [
                    'status' => $status,
                    'message' => $message
                ];
                return response()->json($data, $status);
            case 404:
                $data = [
                    'status' => $status,
                    'message' => $message ?: "The requested resource could not be found"
                ];
                return response()->json($data, $status);
            default:
                break;
        }
    }
    
    public function checkUuid($id) {
        if (preg_match('/^\{?[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}\}?$/', $id)) {
            return true;
        } else {
            return false;
        }    
    }
    
    public function apiDocs(Request $request)
    {
        $swagger = \Swagger\scan(app_path());
        if ($request->header('accept') == 'application/json'
                || $request->input('format') === 'json') {
            return response()->json($swagger);
        }
        else {
            return view('api', [
                'swagger' => json_encode($swagger)
            ]);
        }
    }

}