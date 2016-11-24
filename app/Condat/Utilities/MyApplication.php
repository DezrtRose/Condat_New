<?php

namespace App\Condat\Utilities;
use Illuminate\Foundation\Application;

class MyApplication extends Application {

    /**
     * Get the path to the public / web directory.
     *
     * @return string
     */
    public function publicPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'public';
    }

}
