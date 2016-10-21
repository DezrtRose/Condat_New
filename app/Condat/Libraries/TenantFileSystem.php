<?php
namespace App\Condat\Libraries;

use Illuminate\Support\Facades\Request;
use League\Flysystem\Exception;

class TenantFileSystem {

    /**
     * Base Path
     * @var
     */
    protected $basePath;
    /**
     * Base URl
     * @var
     */
    protected $baseUrl;
    /**
     * Selected Folder
     * @var
     */
    protected $folder;
    /**
     * Unique bucket ID for each tenant
     * @var string
     */
    protected $bucket;
    /**
     * Temporary folder name
     * @var string
     */
    protected $tempName = 'temp';
    /**
     * root upload folder
     * @var string
     */
    protected $uploadRoot = 'files';
    /**
     * file permission for write/read folder
     * @var string
     */
    protected $filePermission = 0777;


    function __construct()
    {
        $this->bucket = $this->setBucket();
        $this->setBasePath();
        $this->setBaseUrl();
    }

    /**
     * Set Base Path
     */
    function setBasePath()
    {
        // $this->basePath = public_path() . '/' . $this->uploadRoot . '/' . $this->bucket . '/';
        $this->basePath = $this->uploadRoot . '/' . $this->bucket . '/';

    }

    /**
     * Set Base Url
     */
    function setBaseUrl()
    {
        $this->baseUrl = tenant()->url() . $this->uploadRoot . '/' . $this->bucket . '/';
    }


    /**
     * Set Bucket for each Tenant
     * @return mixed
     * @throws \Exception
     */
    private function setBucket()
    {
        $item = \DB::table('settings')->select('value')->where('name', 'folder')->first();

        if ($item != null)
            return $item->value;
        else
            throw new \Exception('Bucket ID not found');
    }

    /**
     * Define selected folder
     * @param $folder
     * @param bool $create
     * @return $this
     * @throws Exception
     */
    function folder($folder, $create = true)
    {
        if ($this->isFolderExist($folder)) {
            $this->folder = $folder;
        } else {
            //if ($create) {
                $this->folder = $folder;
                $this->create();
            //} else {
                //throw new Exception('Folder not exist');
            //}
        }
        return $this;
    }

    /**
     * check for folder existence
     * @param $folder
     * @return bool
     */
    function isFolderExist($folder)
    {
        if (!is_dir($this->path($folder))) {
            return false;
        }

        return true;
    }

    /**
     * Create selected folder
     * @return bool
     */
    function create()
    {
        $dir = trim($this->path(), '/');
        if (!is_dir($dir))
            mkdir($dir, 0777, true);

        return true;
    }

    /**
     * return full absolute path of a file or folder
     * @param string $file
     * @return string
     */
    function path($file = '')
    {
        return $this->basePath . $this->folder . '/' . $file;
    }

    /**
     * return full absolute url of a file or folder
     * @param string $file
     * @return string
     */
    function url($file = '')
    {
        return $this->baseUrl . $this->folder . '/' . $file;
    }


    /**
     * delete a file within selected folder
     * @param $file
     * @return bool
     */
    function delete($file)
    {
        if (file_exists($this->path($file))) {
            return unlink($this->path($file));
        }

        return false;
    }


    /**
     * upload file to selected folder
     * @param $file
     * @param null $fileName
     * @return array|bool
     */
    function upload($file, $fileName = null)
    {
        if (Request::hasFile($file) || Request::file($file)->isValid()) {
            $extension = Request::file($file)->getClientOriginalExtension();
            if($fileName == null) {
                $fullName = Request::file($file)->getClientOriginalName();
                $fileName = pathinfo($fullName, PATHINFO_FILENAME);
            }
            $destinationPath = $this->path();
            $fileName = $this->getFilename($fileName, $extension);
            $data = Request::file($file)->move($destinationPath, $fileName);
            $return = ['pathName' => str_replace('\\', '/',url($data->getPathname())), 'fileName' => $data->getFilename()];

            return $return;
        } else {
            return false;
        }
    }


    /**
     * download file
     * @param $filename
     * @return array|bool
     */
    function download($fileName)
    {
        $destinationPath = $this->path();
        $external_path = str_replace('local', '', base_path());
        $file = $external_path.$destinationPath.$fileName;

        if(\File::exists($file)) {
            $headers = array(
                'Content-Type: application/pdf',
            );
            return response()->download($file, $fileName, $headers);
            //return \Response::download($file);
        } else {
            abort(404);
        }
    }

    /**
     * get file name of uploaded file
     * @param $fileName
     * @param $extension
     * @return string
     */
    function getFileName($fileName, $extension)
    {
        if (is_null($fileName))
            $fileName = uniqid() . '_' . time() . '.' . $extension;
        else
            $fileName = $fileName . '.' . $extension;

        return $fileName;
    }

    /**
     * get temporary path
     * @param string $file
     * @return string
     */
    function tempPath($file = '')
    {
        return $this->basePath . $this->tempName . '/' . $file;
    }

    /**
     * get temporary url
     * @param string $file
     * @return string
     */
    function tempUrl($file = '')
    {
        return $this->baseUrl . $this->tempName . '/' . $file;
    }


    /**
     * copy file from temporary path to selected folder
     * @param $file
     * @param null $rename
     * @param bool $delete
     * @return bool
     */
    function copyFromTemp($file, $rename = null, $delete = true)
    {
        $newFile = is_null($rename) ? $file : $rename;
        if (file_exists($this->tempPath($file))) {
            if (copy($this->tempPath($file), $this->path($newFile))) {
                if ($delete) {
                    return unlink($this->tempPath($file));
                }

                return true;
            }
        }

        return false;
    }


}