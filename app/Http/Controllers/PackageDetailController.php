<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nelexa\GPlay\GPlayApps;
use Nelexa\GPlay\Model\AppId;
use Nelexa\GPlay\Exception\GooglePlayException;

class PackageDetailController extends Controller
{
    public function index()
    {
        $packageName = 'com.whatsapp';
        $gplay = new GPlayApps();
        try {
            $appDetails = $gplay->getAppInfo(new AppId($packageName,'en', 'in'));
            return ($appDetails);
        }catch (GooglePlayException $e) {
            $result = false;
            return response()->json($result);
        }
    }
    public function detail(Request $request)
    {
        $validated = $request->validate([
            'package_name' => 'required',
        ]);
        $gplay = new GPlayApps();
        $packageName = $request->package_name;
        try {
            $appDetails = $gplay->getAppInfo(new AppId($packageName,'en', 'in'));
            if (isset($appDetails)) {
                $result = true;
                $version = $appDetails->getappVersion();
                if($version == null)
                {
                    $version = "null";
                }
                $data = ['app_status'=>$result,'version'=>$version];
                return response()->json($data);
            }
        } catch (GooglePlayException $e) {
            $result = false;
                $version = "";
                $data = ['app_status'=>$result,'version'=>$version];
                return response()->json($data);
        }
    }
}
