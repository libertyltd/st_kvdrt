<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 26.07.16
 * Time: 16:04
 *
 * Данный класс рабоатет с файлами изображений для любых сущностей
 * Определяет структуру хранения данных, а так же делает миниатюры изображений
 */

namespace App;


use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Image;
use Storage;

class ImageStorage {

    /* Диск по умолчанию где делать миниатюры и хранить оригиналы */
    public static $defaultDisk = 'public';

    /* Кодировка имен файлов по умолчанию */
    protected static $defaultEncodingName = 'UTF-8';

    /* Путь к директории с файлами вычисляется автоматически в конструкторе */
    protected $pathToDir = '';

    public function __construct(Model $class = null) {
        if (is_null($class)) {
            throw new ImageStorageException('Не задан класс-держатель изображений');
        }

        $this->pathToDir = str_replace("\\",'-', get_class($class)).'/'.$class->id.'/';

        if (!Storage::disk($this::$defaultDisk)->exists($this->pathToDir)) {
            Storage::disk($this::$defaultDisk)->makeDirectory($this->pathToDir);
        }
    }

    /**
     * Сохраняет изображения в неймспейсе
     *
     * @param $uploadedFiles array
     * @param $nameSpace
     */
    public function save ($uploadedFiles, $nameSpace) {
        if (!Storage::disk($this::$defaultDisk)->exists($this->pathToDir.$nameSpace)) {
            Storage::disk($this::$defaultDisk)->makeDirectory($this->pathToDir.$nameSpace);
        }

        /* Мы не можем сохранить пустоту */
        if (is_null($uploadedFiles)) {
            return;
        }

        /* Удалим изображения, которые удалил пользователь в форме */
        if (isset($_REQUEST[$nameSpace])) {
            foreach($_REQUEST[$nameSpace] as $key => $fileToDelete) {
                if (isset($fileToDelete['remove'])) {
                    if (!$this->deleteFile($nameSpace, urldecode($fileToDelete['remove']))) {
                        $this->deleteFile($nameSpace, $fileToDelete['remove']);
                    }
                }
            }
        }

        $notSaveImage = [];
        /* Определим файлы которые были удалены перед отправкой формы */
        if (isset($_REQUEST[$nameSpace])) {
            foreach($_REQUEST[$nameSpace] as $key => $filename) {
                if (isset($filename['notupload'])) {
                    $notSaveImage[] = urlencode($filename['notupload']);//$filename['notupload'];
                }
            }
        }

        /**
         * @var $uploadedFile UploadedFile
         */
        //dd(count($uploadedFiles));

        foreach ($uploadedFiles as $uploadedFile) {

            if (gettype($uploadedFile) !== 'object') {
                continue;
            }
            if (!empty($uploadedFile) && !isset($uploadedFile->remove) && !isset($uploadedFile->notupload)) {
                /*Тут добавить проверку на наличие такого же файла по имени*/
                $name = $uploadedFile->getClientOriginalName();//urlencode($uploadedFile->getClientOriginalName());


                /* Поищем полученное имя в массиве для файлов которые не надо загружать */
                if (!empty($notSaveImage)) {
                    $skipSave = false;
                    foreach ($notSaveImage as $notSaveName) {
                        if ($name === $notSaveName) {
                            $skipSave = true;
                        }
                    }

                    if ($skipSave) {
                        continue;
                    }
                }

                $info = pathinfo($name);

                $baseName = basename($name,'.'.$info['extension']);
                $extension = $info['extension'];
                $nameIsFree = false;
                $nameIterator = '';
                while (!$nameIsFree) {
                    if (Storage::disk($this::$defaultDisk)->exists($this->pathToDir.$nameSpace.'/'.$baseName.$nameIterator.'.'.$extension)) {
                        if ($nameIterator == '') {
                            $nameIterator = 1;
                        } else {
                            $nameIterator++;
                        }
                    } else {
                        $nameIsFree = true;
                        if ($nameIterator != '') {
                            $name = $baseName.$nameIterator.'.'.$extension;
                        }
                    }
                }

                Storage::disk($this::$defaultDisk)->put(
                    $this->pathToDir.$nameSpace.'/'.$name,
                    file_get_contents($uploadedFile->getRealPath())
                );
            }
        }
    }

    /**
     * Возвращает список всех url путей файлов находящихся в неймспейсе
     * @param $nameSpace
     * @return array
     */
    public function get ($nameSpace, $urlPathType=true) {
        $files = Storage::disk($this::$defaultDisk)->files($this->pathToDir.$nameSpace);
        $filesArray = [];

        foreach ($files as $file) {
            if ($urlPathType) {
                $filesArray[] = Storage::disk($this::$defaultDisk)->url(urlencode($file));
            } else {
                $filesArray[] = $file;
            }
        }

        return $filesArray;
    }



    public function getOrigImage ($namespace, $urlPathType=true) {
        $files = Storage::disk($this::$defaultDisk)->files($this->pathToDir.$namespace);
        $filesArray = [];

        foreach ($files as $file) {
            list($baseName, $extension) = $this->getFileNameAndExtension($file);
            if (!preg_match("/(.*)_derived_(.*).{$extension}/", $file)) {
                /* Оригинальный файл */
                if ($urlPathType) {
                    $filesArray[] = Storage::disk($this::$defaultDisk)->url($this->pathToDir.$namespace.'/'.urlencode($baseName).'.'.$extension);
                } else {
                    $filesArray[] = $file;
                }
            }
        }

        return $filesArray;
    }



    /**
     * Возвращает массив кропированных изображений находящихся в неймспейсе
     * если миниатюра изображения уже создана, то просто возвращает url пути
     * @param $namespace
     * @param int $width
     * @param int $height
     * @return array
     */
    public function getCropped ($namespace, $width=300, $height=300) {
        $files = $this->get($namespace, false);
        $croppedFiles = [];
        foreach ($files as $file) {
            list($baseName, $extension) = $this->getFileNameAndExtension($file);

            if (!preg_match("/(.*)_derived_(.*).{$extension}/", $file) && !Storage::disk($this::$defaultDisk)->exists($this->pathToDir.$namespace.'/'.$baseName.'_derived_'.$width.'x'.$height.'.'.$extension)) {
                Image::make(Storage::disk('public')->get($this->pathToDir.$namespace.'/'.$baseName.'.'.$extension))->fit($width,$height)->save(storage_path('app/'.$this::$defaultDisk.'/'.$this->pathToDir.$namespace.'/'.$baseName.'_derived_'.$width.'x'.$height.'.'.$extension));
                $croppedFiles[] = Storage::disk($this::$defaultDisk)->url($this->pathToDir.$namespace.'/'.urlencode($baseName).'_derived_'.$width.'x'.$height.'.'.$extension);
            } else {
                if (preg_match("/(.*)_derived_{$width}x{$height}.{$extension}/", $file)) {
                    $croppedFiles[] = Storage::disk($this::$defaultDisk)->url($this->pathToDir.$namespace.'/'.urlencode($baseName).'.'.$extension);
                }
            }


        }

        return $croppedFiles;
    }

    /**
     * Удаляет файл а так же его диревативы
     * @param $namespace
     * @param $fullNameOfFile
     * @return bool
     */
    public function deleteFile ($namespace, $fullNameOfFile) {
        list($baseName, $extension) = $this->getFileNameAndExtension($fullNameOfFile);
        $files = $this->get($namespace, false);

        /* Тут предполагаем что почти всегда будет диреватив файла */
        /* По этому готовим правильное имя */
        $clearName = preg_replace('/_derived_(.*)/i', '', $baseName);
        if ($clearName !== $baseName) {
            /* Было передано имя дереватива, так что изменим $baseName */
            $baseName = $clearName;
        }

        Storage::disk('public')->delete($this->pathToDir.$namespace.'/'.$baseName.'.'.$extension);
        foreach ($files as $file) {
            if (preg_match("/(.*){$baseName}_derived_(.*)/", $file)) {
                /*Удаляем файл*/
                list($nameDeletedFiles, $extensionDeletedFiles) = $this->getFileNameAndExtension($file);
                return Storage::disk('public')->delete($this->pathToDir.$namespace.'/'.$nameDeletedFiles.'.'.$extensionDeletedFiles);
            }
        }
        return false;
    }

    /**
     * Удаляет директорию с деривативами
     */
    public function deleteNamespaceDir () {
        if (Storage::disk($this::$defaultDisk)->exists($this->pathToDir)) {
            Storage::disk($this::$defaultDisk)->deleteDirectory($this->pathToDir);
        }
    }


    /**
     * Возвращает имя файла и его расширение в виде массива
     * @param $fullNameOfFile
     * @return mixed
     */
    private function getFileNameAndExtension ($fullNameOfFile) {
        $info = pathinfo($fullNameOfFile);
        $baseName = basename($fullNameOfFile,'.'.$info['extension']);
        $extension = $info['extension'];

        $name = [];
        $name[] = $baseName;
        $name[] = $extension;

        return $name;
    }



}

class ImageStorageException extends Exception {
}