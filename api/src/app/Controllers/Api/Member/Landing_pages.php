<?php

namespace App\Controllers\Api\Member;
use App\Controllers\BaseController;
use Exception;

class Landing_pages extends BaseController {

    private $upload_path = "uploads/studyrooms/";

    public function __construct() {
        parent::__construct();
        //do_nothing
    }

    public function getIndex() {
        $user_id = userId();
        $lps = service("LandingPages")->findAll([
            ["where", "user_id", $user_id]
        ]);
        $pages = [];
        foreach ($lps as $key => $lp) {
            if(strpos($lp->page_code,"photo")) {
                $lp->page_content = base_url($lp->page_content);
            }
            $pages[$lp->page_code] = $lp->page_content;
        }
        return $this->respond(compact("pages"));
    }

    public function postIndex(){
        $rules = [
            'section6.testimoni'     => 'required|valid_url',
            'section7.testimoni'     => 'required|valid_url',
            'section9.testimoni'     => 'required|valid_url',
            'section10.testimoni'    => 'required|valid_url',
        ];

        $section6_photo = $this->request->getFile("section6.photo");
        if($section6_photo->getSize()) {
            $rules['section6.photo'] = 'uploaded[section6.photo]|is_image[section6.photo]|mime_in[section6.photo,image/jpg,image/jpeg,image/png]';
        }

        $section10_photo = $this->request->getFile("section10.photo");
        if($section10_photo->getSize()) {
            $rules['section10.photo'] = 'uploaded[section10.photo]|is_image[section10.photo]|mime_in[section10.photo,image/jpg,image/jpeg,image/png]';
        }
        
        try {
            if ($this->validate($rules)) {
                $db = db_connect();
                $db->transStart();
                $user_id = user("id");

                $files = $this->request->getFiles();

                foreach ($files as $fileKey => $fileValues) {
                    foreach ($fileValues as $key => $value) {
                        $obj = new \stdClass();
                        $obj->user_id = $user_id;
                        $obj->page_code = "{$fileKey}.{$key}";

                        if($value->isValid() && !$value->hasMoved()) {

                            $file_name = upload_img($value, $this->upload_path, [
                                ['fit', 740, 740, 'center'],
                            ]);
                            $obj->page_content = $this->upload_path . $file_name;

                            $page = service("LandingPages")->findOne([
                                ["where", "page_code", $obj->page_code],
                                ["where", "user_id", $user_id]
                            ]);
                            if($page) {
                                service("LandingPages")->update($page->id, $obj);
                            } else {
                                service("LandingPages")->create($obj);
                            }
                        }
                    }
                }

                $posts = $this->request->getPost();
                foreach ($posts as $postKey => $postValues) {
                    foreach ($postValues as $key => $value) {
                        $obj = new \stdClass();
                        $obj->user_id = $user_id;
                        $obj->page_code = "{$postKey}.{$key}";
                        $obj->page_content = $value;

                        if($key=="testimoni") {
                            $obj->page_content = youtube_embed($obj->page_content);
                            if($obj->page_content=='') {
                                throw new Exception("Format url salah.");
                            }
                        }

                        $page = service("LandingPages")->findOne([
                            ["where", "page_code", $obj->page_code],
                            ["where", "user_id", $user_id]
                        ]);
                        if($page) {
                            service("LandingPages")->update($page->id, $obj);
                        } else {
                            service("LandingPages")->create($obj);
                        }
                    }
                }
                $db->transComplete();
                return $this->response->setJSON([
                    "message" => "Landing page diperbarui!"
                ]);
            } else {
                return $this->response->setStatusCode(400)->setJSON([
                    "message" => lang("Validation.invalid"),
                    "errors" => $this->validator->getErrors()
                ]);
            }
            
        } catch (Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                "message" => $e->getMessage()
            ]);
        }
    }

}