<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $allowed_images = ['jpg', 'png', 'jpeg'];
    protected $allowed_videos = ['mp4', 'ogg', 'webm'];

    protected function respondSuccess($message = 'Done!', $code = 200)
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], $code);
    }

    protected function respondWithError($message = 'Failed!', $code = 400)
    {
        return Response::json([
            'success' => false,
            'message' => $message
        ], $code);
    }

    protected function respondWithData($data = [], $message = 'Done!', $code = 200)
    {
        return Response::json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function respondWithAdditionalData($data = [], $additional_data, $message = 'Done!', $code = 200)
    {
        $response['success'] = true;
        $response['message'] = $message;
        $response['data'] = $data;
        return Response::json(array_merge($response, $additional_data), $code);
    }

    protected function respondWithDataWithPagination($data = [], $message = 'Done!', $code = 200)
    {
        $response['success'] = true;
        $response['message'] = $message;
        $response['data'] = $data->items();
        $response['urls'] = [
            'next_url' => $data->nextPageUrl(),
            'prev_url' => $data->previousPageUrl(),
        ];
        return Response::json($response, $code);
    }

    protected function respondWithErrorKey($key, $message = 'Failed!', $code = 200)
    {
        return Response::json([
            'success' => false,
            'key' => $key,
            'message' => $message
        ], $code);
    }

    public function generate_short_link($url){
        $headers = array(
            'Content-Type: application/json',
        );

        $parameters = [
            'dynamicLinkInfo' => [
                'domainUriPrefix' => 'https://safeourtomorrows.page.link',
                'link' => $url,
                'androidInfo' => [
                    'androidPackageName' => 'com.safeourtomorrow.dev',
                ],
                'iosInfo' => [
                    'iosBundleId' => 'com.safeourtomorrow.dev',
                    'iosCustomScheme' => 'com.googleusercontent.apps.444837009594-juk4i08lj6boaognnhp0duclpcdfhvrs',
                    'iosAppStoreId' => ''
                ],
                // "navigationInfo" => [
                //     "enableForcedRedirect" => 0,
                // ],
            ],
            'suffix' => ['option' => 'SHORT']
        ];

        $key = 'AIzaSyAnjQn6uUJ7LXOWC2swnxitFSaCZyIpP-c';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://firebasedynamiclinks.googleapis.com/v1/shortLinks?key='.$key);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_REFERER, config('app.url'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameters));

        $e = json_decode(curl_exec($ch));
        return ($e->shortLink ?? false);
    }

    public function upload_user_profile($file){
        if(!in_array($file->getClientOriginalExtension(),$this->allowed_images)){
            return false;
        }
        $path = $file->store('images/users');
        return Storage::url($path);
    }

    public function upload_project_image($file){
        if(!in_array($file->getClientOriginalExtension(),$this->allowed_images)){
            return false;
        }
        $path = $file->store('images/projects');
        return Storage::url($path);
    }

    public function upload_newsfeed_image($file)
    {
        if (!in_array($file->getClientOriginalExtension(), $this->allowed_images)
            && !in_array($file->getClientOriginalExtension(), $this->allowed_videos)) {
            return false;
        }
        $path = $file->store('images/newsfeeds');
        return Storage::url($path);
    }

    public function defaultLanguage()
    {
        return "en";
    }

    public function defaultCurrency()
    {
        return "USD";
    }

    public function removeFile($path){
        if(File::exists($path)){
            File::delete($path);
        }
    }
}
