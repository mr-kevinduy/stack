<?php

namespace App\Http\Controllers\Web\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Support\UploadHelper;

class UploadController extends FrontController
{
    protected ?string $resource = 'uploads';

    public function index()
    {
        $compact = [];

        $compact['code'] = uniqcode();

        return redirect()->route($this->routeName('upload-index.create'), $compact);
    }

    public function uploadIndexCreate(Request $request, string $code)
    {
        $request->session()->forget([
            $this->sessionKey($code.'_upload_video'),
            $this->sessionKey($code.'_upload_thumbnail'),
        ]);

        $compact = [];

        $compact['code'] = $code;

        return $this->view('index', $compact);
    }

    public function uploadIndexStore(Request $request, string $code)
    {
        $compact = [];

        $params = $request->except(['_token']);

        $compact['code'] = $code;

        $sessionData = array_merge($params, $compact);

        $request->session()->put($this->sessionKey($code.'_upload_index'), $sessionData);

        return redirect()->route($this->routeName('upload-video.create'), $compact);
    }

    public function uploadVideoCreate(Request $request, string $code)
    {
        $compact = [];

        $compact['code'] = $code;

        return $this->view('upload-video', $compact);
    }

    public function uploadVideoStore(Request $request, string $code)
    {
        $compact = [];

        $compact['code'] = $code;

        $file = $request->file('qqfile');
        $fileName = $request->input('qqfilename', '');
        $partIndex = $request->input('qqpartindex', 0);
        $totalParts = $request->input('qqtotalparts', 1);
        $resume = $request->input('qqresume', false);
        $uuid = $request->input('qquuid');

        $uploaded = UploadHelper::upload([
            'done' => false,
            'file' => $file,
            'fileName' => $fileName,
            'partIndex' => $partIndex,
            'totalParts' => $totalParts,
            'resume' => $resume,
            'uuid' => $uuid,
        ], $code);

        if ($uploaded['status_code'] !== 200) {
            return response()->json([
                'success' => $uploaded['status_code'],
                'error' => $uploaded['message'],
            ]);
        }

        $file = $uploaded['data'];

        // Complete request.
        if (! empty($file)) {
            $sessionData = array_merge($compact, [
                'file' => $file,
            ]);

            $request->session()->put($this->sessionKey($code.'_upload_video'), $sessionData);
        }

        return response()->json([
            'success' => true,
            'code' => $code,
            'file' => $file,
        ]);
    }

    public function uploadChunkStore(Request $request, string $code)
    {
        $file = $request->file('qqfile');
        $fileName = $request->input('qqfilename', '');
        $partIndex = $request->input('qqpartindex', 0);
        $totalParts = $request->input('qqtotalparts', 1);

        $tempDir = storage_path('app/uploads/' . $fileName);
        if (! File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0755, true);
        }

        // Lưu từng phần của file vào thư mục tạm thời
        $file->move($tempDir, "part_{$partIndex}");

        // Kiểm tra nếu tất cả các phần đã được tải lên
        if (count(scandir($tempDir)) - 2 == $totalParts) {
            $finalPath = storage_path('app/uploads/') . $fileName;

            // Kết hợp các phần thành một file hoàn chỉnh
            $outFile = fopen($finalPath, 'wb');
            for ($i = 0; $i < $totalParts; $i++) {
                $partPath = $tempDir . "/part_{$i}";
                fwrite($outFile, file_get_contents($partPath));
                unlink($partPath); // Xóa phần sau khi ghép
            }
            fclose($outFile);
            rmdir($tempDir);

            // Gửi yêu cầu chuyển mã đến Node.js
            $this->transcodeVideo($finalPath);

            return response()->json(['success' => true], 200);
        }

        return response()->json(['success' => true], 200);
    }

    public function uploadVideoDestroy(Request $request, string $code)
    {
        $compact = [];

        $compact['code'] = $code;

        return response()->json([
            'success' => true,
            'code' => $code,
        ]);
    }

    public function uploadThumbnailCreate(Request $request, string $code)
    {
        $compact = [];

        $params = $request->all();

        $compact['code'] = $code;

        return $this->view('upload-thumbnail', $compact);
    }

    public function uploadThumbnailStore(Request $request, string $code)
    {
        dd($request->all());

        $compact = [];

        $params = $request->all();

        $compact['code'] = $code;

        $sessionData = array_merge($params, $compact);

        $request->session()->put($this->sessionKey($code.'_upload_thumbnail'), $sessionData);

        return redirect()->route($this->routeName('confirm'), $compact);
    }

    public function uploadThumbnailDestroy(Request $request, string $code)
    {
        $compact = [];

        $compact['code'] = $code;

        return response()->json([
            'success' => true,
            'code' => $code,
        ]);
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

    public function store(Request $request, string $code)
    {

    }

    private function transcodeVideo($filePath)
    {
        // Sử dụng cURL hoặc Guzzle để gửi yêu cầu đến Node.js API
        // Example với Guzzle
        $client = new \GuzzleHttp\Client();
        $client->post('http://localhost:3000/transcode', [
            'json' => ['filePath' => $filePath]
        ]);
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
