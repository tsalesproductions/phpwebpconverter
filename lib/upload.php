<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
    header('Content-Type: application/json; charset=utf-8');
    
    ini_set('upload_max_filesize', '1024M');
    ini_set('memory_limit', '1024M');
    include_once("../vendor/autoload.php");

    use \Gumlet\ImageResize;
    use \Gumlet\ImageResizeException;
    
    class ImageResizeTest{
        public function __construct(){
            $status = [
                'status' => true,
                'msg' => ''
            ];
        
            $allowed_ext= array('jpg','jpeg','png','gif');
        
            if(isset($_FILES['upload'])){
                $file_name = $_FILES['upload']['name'];
                $file_size = $_FILES['upload']['size'];
                $file_tmp = $_FILES['upload']['tmp_name'];
                $file_ext = strtolower(explode('.',$file_name)[count(explode('.',$file_name)) - 1]);
        
                $check = getimagesize($_FILES["upload"]["tmp_name"]);
        
                if(in_array($file_ext,$allowed_ext) === false){
                    $status['status'] = false;
                    $status['msg'] = 'Extension not allowed';
                }
        
                if($file_size > 10485760)
                {
                    $status['status'] = false;
                    $status['msg'] = 'Extension not allowed';
                }
        
                if($status['status']){
                    $filename = "myme_".rand(0000000001,9999999999).'.webp';

                    $image = new ImageResize($_FILES["upload"]["tmp_name"]);
                    $image->resizeToWidth(300);
                    $image->save("../uploads/".$filename);
                    
                    echo json_encode([
                        'status' => $status['status'],
                        'msg' => $status['msg'],
                        'file' => $filename
                    ]);
                }else{
                    echo json_encode([
                        'status' => $status['status'],
                        'msg' => $status['msg'],
                        'file' => null
                    ]);
                }
            }
        }
    }

    new ImageResizeTest();