<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Windows Azure Library
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Library
 * @desc Windows Azure library 
 * 
 */

// load windows azure library
include APPPATH . 'third_party/WindowsAzure/WindowsAzure.php';
use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\Common\CloudConfigurationManager;
use WindowsAzure\Blob\Models\Block;
use WindowsAzure\Blob\Models\CreateContainerOptions;
use WindowsAzure\Blob\Models\ListContainersOptions;


class Azure {
    
    protected $CI;
    protected $blobRestProxy;
    
    /**
     * let's create the constructor
     */
    public function __construct() {
        $connectionBlob = "DefaultEndpointsProtocol=".AZURE_BLOB_PROTOCOL.";AccountName=".AZURE_BLOB_ACCOUNT.";AccountKey=".AZURE_BLOB_KEY1."";
        $this->blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionBlob);
        $this->CI =& get_instance();
    }
    
    /**
     * create container if not exists
     * @param string $container_name
     */
    public function CreateContainerIfNotExists($container_name) {
        // See if the container already exists.
        $listContainer = $this->blobRestProxy->listContainers();
        $containerExists = false;
        foreach ($listContainer->getContainers() as $container) {
            if ($container->getName() == $container_name) {
                // The container exists.
                $containerExists = true;
                // No need to keep checking.
                break;
            }
        }
        if (!$containerExists) {
            $this->blobRestProxy->createContainer($container_name);
        }
    }
    
    /**
     * upload file to azure blob storage
     * @param array $source_file
     * @param string $container
     * @param string $filename
     * @return string $return file path
     */
    public function UploadFileToStorage($source_file,$container,$filename) {
        $arrext = explode('.', $source_file['name']);
        $jml = count($arrext) - 1;
        $ext = $arrext[$jml];
        $extentions = strtolower($ext);
        $content = file_get_contents($source_file['tmp_name']);
        
        // create container if not exists
        $this->CreateContainerIfNotExists($container);
        $file_name = $filename.'.'.$extentions;
        
        // start uploading file
        $blob_options = new WindowsAzure\Blob\Models\CreateBlobOptions();
        $blob_options->setContentType($source_file['type']);
        $this->blobRestProxy->createBlockBlob($container, $file_name, $content, $blob_options);
        
        $return = $file_name;
        
        return $return;
    }
    
    /**
     * resize uploaded image to blob storage
     * @param string $source_file
     * @param string $temporary_folder
     * @param string $container
     * @param string $prefix
     * @param string $filename
     * @param string $max_width
     * @param string $max_height
     */
    public function ResizeUploadImage($source_file,$temporary_folder,$container,$prefix,$filename,$max_width,$max_height) {
        $image_info = getimagesize($source_file);
        $source_pic_width = $image_info[0];
        $source_pic_height = $image_info[1];

        $x_ratio = $max_width / $source_pic_width;
        $y_ratio = $max_height / $source_pic_height;

        if (($source_pic_width <= $max_width) && ($source_pic_height <= $max_height)) {
            $tn_width = $source_pic_width;
            $tn_height = $source_pic_height;
        } elseif (($x_ratio * $source_pic_height) < $max_height) {
            $tn_height = ceil($x_ratio * $source_pic_height);
            $tn_width = $max_width;
        } else {
            $tn_width = ceil($y_ratio * $source_pic_width);
            $tn_height = $max_height;
        }

        if (!is_dir($temporary_folder)) {
            mkdir($temporary_folder, 0755);
        }

        switch ($image_info['mime']) {
        case 'image/gif':
            if (imagetypes() & IMG_GIF) {
                $src = imageCreateFromGIF($source_file);
                $temporary_folder.="$filename.gif";
                $namafile = "$filename.gif";
            }
            break;

        case 'image/jpeg':
            if (imagetypes() & IMG_JPG) {
                $src = imageCreateFromJPEG($source_file);
                $temporary_folder.="$filename.jpg";
                $namafile = "$filename.jpg";
            }
            break;

        case 'image/pjpeg':
            if (imagetypes() & IMG_JPG) {
                $src = imageCreateFromJPEG($source_file);
                $temporary_folder.="$filename.jpg";
                $namafile = "$filename.jpg";
            }
            break;

        case 'image/png':
            if (imagetypes() & IMG_PNG) {
                $src = imageCreateFromPNG($source_file);
                $temporary_folder.="$filename.png";
                $namafile = "$filename.png";
            }
            break;

        case 'image/wbmp':
            if (imagetypes() & IMG_WBMP) {
                $src = imageCreateFromWBMP($source_file);
                $temporary_folder.="$filename.bmp";
                $namafile = "$filename.bmp";
            }
            break;
        }

        $tmp = imagecreatetruecolor($tn_width, $tn_height);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tn_width, $tn_height, $source_pic_width, $source_pic_height);

        //**** 100 is the quality settings, values range from 0-100.
        switch ($image_info['mime']) {
            case 'image/jpeg':
                imagejpeg($tmp, $temporary_folder.$filename, 100);
                break;

            case 'image/gif':
                imagegif($tmp, $temporary_folder.$filename, 100);
                break;

            case 'image/png':
                imagepng($tmp, $temporary_folder.$filename);
                break;

            default:
                imagejpeg($tmp, $temporary_folder.$filename, 100);
                break;
        }
        
        $tmp_file_path = $temporary_folder.$filename;
        
        // start uploading file
        $content = file_get_contents($tmp_file_path);
        $file_name = $prefix.$namafile;
        $blob_options = new WindowsAzure\Blob\Models\CreateBlobOptions();
        $blob_options->setContentType($image_info['mime']);
        $this->blobRestProxy->createBlockBlob($container, $file_name, $content, $blob_options);
        
        // then delete the temporary file
        @unlink($tmp_file_path);
        
        
        return $filename;
    }
    
    /**
     * delete azure blob storage
     * @param string $container
     * @param string $blob
     * @return boolean
     */
    public function DeleteBlob($container,$blob) {
        try {
            // Delete container.
            $this->blobRestProxy->deleteBlob($container, $blob);
            return TRUE;
        }
        catch(ServiceException $e){
            // Handle exception based on error codes and messages.
            // Error codes and messages are here: 
            // http://msdn.microsoft.com/library/azure/dd179439.aspx
            $code = $e->getCode();
            $error_message = $e->getMessage();
            return $code.": ".$error_message."<br />";
        }
    }
    
    /**
     * download the blob
     * @param string $container
     * @param string $blob
     * @param string $prefix
     */
    public function DownloadBlob($container,$blob,$prefix='') {
        $this->CI->load->helper('download');
        try {
            $getBlob = $this->blobRestProxy->getBlob($container, $blob);
            $file = $getBlob->getContentStream();
            $filename = (($prefix != '') ? str_replace($prefix.'/', '', $blob) : $blob);
            //$blobstream = stream_get_contents($getBlob->getContentStream());
            //$localpath = UPLOAD_DIR.$prefix;
            //$localpath = str_replace('/', '\\', $localpath);
            //file_put_contents($localpath.'\anu.jpg',$blobstream);
            $blobProperties = $getBlob->getProperties();
            $content_type = $blobProperties->getContentType();
            header("Content-type: {$content_type}");
            header("Content-Disposition: attachment; filename=\"{$filename}\"");
            header("Content-Transfer-Encoding: binary"); 
            header("Expires: 0");
            header("Pragma: no-cache");
            fpassthru($file);
            exit();
        }
        catch(ServiceException $e){
            // Handle exception based on error codes and messages.
            // Error codes and messages are here: 
            // http://msdn.microsoft.com/library/azure/dd179439.aspx
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code.": ".$error_message."<br />";
        }
    }
    

}