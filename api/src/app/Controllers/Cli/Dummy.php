<?php

namespace App\Controllers\Cli;
use Exception;
use CodeIgniter\CLI\CLI;
use App\Controllers\Cli\BaseController;

class Dummy extends BaseController {

	public function studyrooms(){
		$db = db_connect();
		$db->transStart();
	    for ($i=1; $i <= 30; $i++) { 
	    	$data = new \stdClass();
			$data->name = "Lorem {$i} ipsum dolor sit amet!";
			$data->description = "Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.";
			$data->photo = "assets/uploads/general/placeholder.jpg";
			$data->code = str_rand();
			$data->user_id = 2;
			$data->created_by = 2;
			$study_room_id = service("StudyRooms")->create($data);
			CLI::write("Create : {$data->name}");

			for ($j=1; $j <= 10; $j++) { 
				$chapter = new \stdClass();
				$chapter->study_room_id = $study_room_id;
				$chapter->name = "Episode {$j}";
				$chapter->code = str_rand();
				$chapter->url = "https://www.youtube.com/watch?v=dQw4w9WgXcQ";
				$chapter->description = "Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.";
				$chapter->created_by = 2;
				service("StudyRooms")->create($chapter);
				CLI::write("Create Sub: {$chapter->name}");
			}
	    }
	    $db->transComplete();
	}

}