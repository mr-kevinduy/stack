<?php

namespace App\Http\Controllers\Web\Front;

use Illuminate\Http\Request;

class UploadController extends FrontController
{
    protected ?string $resource = 'uploads';

    public function index()
    {
        $compact = [];

        $compact['code'] = uniqcode();

        return redirect()->route($this->routeName('upload-index'), $compact);
    }

    public function uploadIndex(Request $request, string $code)
    {
        $request->session()->forget([
            $this->sessionKey($code.'_upload_video'),
            $this->sessionKey($code.'_upload_thumbnail'),
        ]);

        $compact = [];

        $params = $request->except(['_token']);

        $compact['code'] = $code;

        if ($request->isMethod('post')) {
            $metadata = array_merge($params, $compact);

            $request->session()->put($this->sessionKey($code.'_upload_index'), $metadata);

            return redirect()->route($this->routeName('upload-video'), $compact);
        }

        return $this->view('index', $compact);
    }

    public function uploadVideo(Request $request, string $code)
    {
        $compact = [];

        $params = $request->all();

        $compact['code'] = $code;

        // if ($request->isMethod('post')) {
        //     $sessionData = array_merge($params, $compact);

        //     $request->session()->put($this->sessionKey($code.'_upload_video'), $sessionData);

        //     return redirect()->route($this->routeName('upload-thumbnail'), $compact);
        // }

        return $this->view('upload-video', $compact);
    }

    public function uploadThumbnail(Request $request, string $code)
    {
        $compact = [];

        $params = $request->all();

        $compact['code'] = $code;

        if ($request->isMethod('post')) {
            $sessionData = array_merge($params, $compact);

            $request->session()->put($this->sessionKey($code.'_upload_thumbnail'), $sessionData);

            return redirect()->route($this->routeName('confirm'), $compact);
        }

        return $this->view('upload-thumbnail', $compact);
    }

    public function confirm(Request $request, string $code)
    {
        $compact = [];

        $compact['code'] = $code;

        $compact['data'] = array_merge(
            $request->session()->get($this->sessionKey($code.'_upload_index')),
            $request->session()->get($this->sessionKey($code.'_upload_video')),
            $request->session()->get($this->sessionKey($code.'_upload_thumbnail'))
        );

        return $this->view('confirm', $compact);
    }

    public function store()
    {

    }

    public function upload(Request $request, string $code)
    {
        $compact = [];

        $compact['code'] = $code;

        $path = $request->input('path', '');

        if (empty($path)) {
            $path = 'uploads/'.$path;
        }

        $result = $this->uploadFile('qqfile', $path, $code);

        if ($result['status_code'] !== 200) {
            return response()->json([
                'success' => $result['status_code'],
                'error' => $result['message'],
            ]);
        }

        $file = current($result['data']);

        $sessionData = [
            'code' => $code,
            'file' => $file,
        ];

        $request->session()->put($this->sessionKey($code.'_upload_video'), $sessionData);

        // return response()->json([
        //     'success' => true,
        //     'code' => $code,
        //     'file' => $file,
        // ]);

        return redirect()->route($this->routeName('upload-thumbnail'), $compact);
    }

    public function uploadFile($name, $path = 'uploads', $newName = '', $allowExtension = [], $childPath = true)
    {
        if (! request()->hasFile($name)) {
            $data=[
                'status_code' => 401,
                'message' => '上传文件为空'
            ];

            return $data;
        }

        $file = request()->file($name);

        if (!is_array($file)) {
            $file = [$file];
        }

        $path = str_replace('.', '', $path);
        $path = trim($path, '/');
        $path = $childPath ? $path.'/'.date('Ymd') : $path;
        $publicPath = public_path($path.'/');

        is_dir($publicPath) || mkdir($publicPath, 0755, true);

        $success = [];

        foreach ($file as $k => $v) {
            if (! $v->isValid()) {
                $data=[
                    'status_code' => 500,
                    'message' => '文件上传出错'
                ];

                return $data;
            }

            $oldName = $v->getClientOriginalName();
            $extension = strtolower($v->getClientOriginalExtension());

            if (! empty($allowExtension) && ! in_array($extension, $allowExtension)) {
                $data=[
                    'status_code' => 500,
                    'message' => $oldName . '的文件类型不被允许'
                ];

                return $data;
            }

            $newFullName = ! empty($newName) ? $newName.'.'.$extension : uniqcode().'.'.$extension;

            if (! $v->move($publicPath, $newFullName)) {
                $data=[
                    'status_code' => 500,
                    'message' => '保存文件失败'
                ];

                return $data;
            } else {
                $success[] = [
                    'name' => $oldName,
                    'path' => '/'.$path.'/'.$newFullName
                ];
            }
        }

        $data=[
            'status_code' => 200,
            'message' => '上传成功',
            'data' => $success
        ];

        return $data;
    }
}
