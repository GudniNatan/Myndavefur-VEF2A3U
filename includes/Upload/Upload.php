<?php
namespace Includes;
class Upload {
    protected $uploaded = [];
    protected $destination;
    protected $tempdestination;
    protected $max = 51200;
    protected $messages = [];
    protected $permitted = [
        'image/gif',
        'image/jpeg',
        'image/pjpeg',
        'image/png'
    ];
    protected $typeCheckingOn = true;
    protected $notTrusted = ['bin', 'cgi', 'exe', 'js', 'pl', 'php', 'py', 'sh'];
    protected $suffix = '.upload';
    protected $newName;
    protected $renameDuplicates;
    protected $success;
    protected $tmp_name;
    protected $imgname;
    protected $imgdesc;
    protected $user_id;
    protected $category_id;
    protected $name_list;

    public function __construct($path, $temppath) {
        if (!is_dir($path) || !is_writable($path)) {
            throw new \Exception("$path must be a valid, writable directory.");
        }
        $this->destination = $path;
        $this->tempdestination = $temppath;
    }

    public function upload($renameDuplicates = true) {
        $this->renameDuplicates = $renameDuplicates;
        $uploaded = current($_FILES);
        if (is_array($uploaded['name'])) {
            // deal with multiple uploads
            foreach ($uploaded['name'] as $key => $value) {
                $currentFile['name'] = $uploaded['name'][$key];
                $currentFile['type'] = $uploaded['type'][$key];
                $currentFile['tmp_name'] = $uploaded['tmp_name'][$key];
                $currentFile['error'] = $uploaded['error'][$key];
                $currentFile['size'] = $uploaded['size'][$key];
                if ($this->checkFile($currentFile)) {
                    $this->moveFile($currentFile);
                    if ($this->typeCheckingOn) {
                        $this->resizeImage($currentFile);
                    }
                }
            }
        } else {
            if ($this->checkFile($uploaded)) {
                $this->moveFile($uploaded);
                $this->addImage($uploaded);
                if ($this->typeCheckingOn) {
                    $this->resizeImage($uploaded);
                }
            }
        }
    }

    protected function resizeImage($file){
        require_once("includes/img_resize.php");
        $tmpname = $this->tempdestination;
        $tmpname .= isset($this->newName) ? $this->newName : $file['name'];
        $size = 400;
        $save_dir = "img/temp/thumbs/";
        $save_name = "thumb_";
        $save_name .= isset($this->newName) ? $this->newName : $file['name'];
        $resize = img_resize($tmpname, $size, $save_dir, $save_name);
        if (!$resize) {
            $this->messages[] =  "Gat ekki gert smámynd.";
        }
    }

    public function getMessages() {
        return $this->messages;
    }
    public function getNameList() {
        return $this->name_list;
    }

    public function getMaxSize() {
        return number_format($this->max/1024, 1) . ' KB';
    }

    public function getSuccessStatus(){
        return $this->success;
    }

    public function setMaxSize($num) {
        if (is_numeric($num) && $num > 0) {
            $this->max = (int) $num;
        }
    }
    public function allowAllTypes($suffix = true) {
        $this->typeCheckingOn = false;
        if (!$suffix) {
            $this->suffix = '';  // empty string
        }
    }

    protected function checkFile($file) {
        $accept = true;
        if ($file['error'] != 0) {
            $this->getErrorMessage($file);
            // stop checking if no file submitted
            if ($file['error'] == 4) {
                return false;
            } else {
                $accept = false;
            }
        }
        if (!$this->checkSize($file)) {
            $accept = false;
        }
        if ($this->typeCheckingOn) {
            if (!$this->checkType($file)) {
                $accept = false;
            }
        }
        if ($accept) {
            $this->checkName($file);
        }
        return $accept;
    }

    protected function getErrorMessage($file) {
        switch($file['error']) {
            case 1:
            case 2:
                $this->messages[] = $file['name'] . ' er of stór: (max: ' .
                    $this->getMaxSize() . ').';
                break;
            case 3:
                $this->messages[] = $file['name'] . ' var aðeins upphalað að hluta til.';
                break;
            case 4:
                $this->messages[] = 'Engin skrá send.';
                break;
            default:
                $this->messages[] = 'Því miður varð vandamál við að hlaða upp ' . $file['name'];
                break;
        }
    }

    protected function checkSize($file) {
        if ($file['error'] == 1 || $file['error'] == 2) {
            return false;
        } elseif ($file['size'] == 0) {
            $this->messages[] = $file['name'] . ' er tóm skrá.';
            return false;
        } elseif ($file['size'] > $this->max) {
            $this->messages[] = $file['name'] . ' fer yfir stærðarmörk skráa (' . $this->getMaxSize() . ').';
            return false;
        } else {
            return true;
        }
    }

    protected function checkType($file) {
        if (in_array($file['type'], $this->permitted)) {
            return true;
        } else {
            if (!empty($file['type'])) {
                $this->messages[] = $file['name'] . ' er ekki leyfð tegund af skrá.';
            }
            return false;
        }
    }

    protected function checkName($file) {
        $this->newName = null;
        $nospaces = str_replace(' ', '_', $file['name']);
        if ($nospaces != $file['name']) {
            $this->newName = $nospaces;
        }
        $extension = pathinfo($nospaces, PATHINFO_EXTENSION);
        if (!$this->typeCheckingOn && !empty($this->suffix)) {
            if (in_array($extension, $this->notTrusted) || empty($extension)) {
                $this->newName = $nospaces . $this->suffix;
            }
        }
        if ($this->renameDuplicates) {
            $name = isset($this->newName) ? $this->newName : $file['name'];
            $existing = array_merge(scandir($this->destination),scandir($this->tempdestination));
            if (in_array($name, $existing)) {
                // rename file
                $basename = pathinfo($name, PATHINFO_FILENAME);
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $i = 1;
                do {
                    $this->newName = $basename . '_' . $i++;
                    if (!empty($extension)) {
                        $this->newName .= ".$extension";
                    }
                } while (in_array($this->newName, $existing));
            }
        }
    }

    protected function moveFile($file) {
        $filename = isset($this->newName) ? $this->newName : $file['name'];
        $this->name_list[] = $filename;
        $this->success = move_uploaded_file($file['tmp_name'], $this->tempdestination . $filename);
        if ($this->success) {
            $result = 'Upphleðsla skráarinnar ' . $file['name'] . ' tókst';
            if (!is_null($this->newName)) {
                $result .= ', og hún var endurnefnd ' . $this->newName;
            }
            $this->messages[] = $result;
        } else {
            $this->messages[] = 'Gat ekki hlaðið upp ' . $file['name'];
        }
    }

    protected function addImage($file)
    {
        require_once './includes/dbcon.php';
        require_once './includes/Images/Images.php';
        $dbImages = new Images($conn);


        $image_path .= isset($this->newName) ? $this->newName : $file['name'];
        if (!isset($this->imgname) || is_null($this->imgname)) {
            $this->imgname = $image_path;
        }
        if (!isset($this->imgdesc) ||is_null($this->imgdesc)) {
            $this->imgdesc = null;
        }

        $result = $dbImages->newImage($this->imgname, $image_path, $this->imgdesc, $this->category_id, $this->user_id);

        if (!$result) {
            $this->messages[] = 'Vandamál við að setja ' . $file['name'] . ' inn í gagnagrunn';
        }
    }

}