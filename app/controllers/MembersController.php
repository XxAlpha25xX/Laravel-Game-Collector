<?php 

class MembersController extends BaseController {


	/**
	* Renders the view where member items are listed.
	*
	* Loads the members_home.blade.php page passing the collection of all member objects.
	*
	* @param void
	*
	* @return View $view
	*
	*/
	public function home(){

		//Retrieve members to list in home page.
		$members = Member::all();

		return View::make('members_home',compact('members'));
	}


	/**
	* Renders the view where member items are created.
	*
	* Loads the members_create.blade.php page passing field values from past requests (if any) and world regions.
	*
	* @param Member $member The member to create
	*
	* @return View $view
	*
	*/
	public function create(){

		//Retrieve world regions to list.
		$world_regions = $this->get_world_regions();

		//Retrieve studios to list.
		$studios = Studio::all();

		//Retrieve roles to list.
		$roles	 = Role::all();

		//Retrieve studies to list.
		$studies = Study::all();

		//Fields to be saved from past request ( if any )
		$fields 	= array('name','bornt','studio','country','role','study');
		$fields_old = array();
		foreach ($fields as $value) {
			$fields_old[$value] = Input::old($value);
		}
		//Create the view.
		return View::make('members_create',array(
			'world_regions'	=>	$world_regions,
			'studios'		=>	$studios,
			'fields_old'	=>	$fields_old,
			'submit_to'		=>	action('MembersController@handleForm'),
			'title'			=>	'Add member',
			'studies'		=>	$studies,
			'roles'			=>	$roles,
			'studios'		=>	$studios,
			'submit_msg'	=>	'Create'
			));
	}


	/**
	* Renders the view where member items are edited.
	*
	* Loads the members_edit.blade.php page passing the existing object attributes and world regions.
	*
	* @param Member $member The member to edit
	*
	* @return View $view
	*
	*/
	public function edit(member $member){

		//Retrieve world regions to list.
		$world_regions = $this->get_world_regions();

		//Retrieve studios to list.
		$studios = Studio::all();

		//Retrieve roles to list.
		$roles = Role::all();

		//Retrieve studies to list.
		$studies = Study::all();

		//Fields to set with existing object attributes.
		$fields_old = array(
			'name'		=>	$member->name,
			'bornt'	=>	$member->bornt,
			'face'		=> $member->face,
			'studio'	=>	$member->studio->id,
			'country'	=>	$member->country->id,
			'role'	=>	$member->role->id,
			'study'	=>	$member->study->id
			);

		//Create the view
		return View::make('members_create',array(
			'world_regions'	=>	$world_regions,
			'studios'	=>	$studios ,
			'fields_old'	=>	$fields_old,
			'submit_to'		=>	action('MembersController@handleForm'),
			'title'			=>	'Edit Member',
			'id'			=>	$member->id,
			'studies'		=>	$studies,
			'roles'			=>	$roles,
			'studios'		=>	$studios,
			'submit_msg'	=>	'Save'
			));
	}


	/**
	* Renders the view where member item deletion confirmation is required.
	*
	* Loads the members_delete.blade.php page together the provided Member instance.
	*
	* @param Member $member The member to edit
	*
	* @return View $view
	*
	*/
	public function delete($member){
		//Create the view
		return View::make('members_delete',compact('member'));
	}


	/**
	* Renders the view where member is to be attached to a game.
	*
	* Loads the members_game_add.blade.php page together the provided Member instance.
	*
	* @param Member $member The member to edit
	*
	* @return View $view
	*
	*/
	public function addGame($member){

		$games 		 = Game::all();
		$games_added = $member->games()->lists('id');

		$games = $games->filter(function($game) use ($games_added){
			return !in_array($game->id,$games_added);
		});

		//Create the view
		return View::make('members_add_game',array(
			'member'	=>	$member,
			'games'		=>	$games
			));

	}


	/**
	* Renders the view where member is to be un-attached to a game.
	*
	* Loads the members_remove_game.blade.php page together the provided Member instance.
	*
	* @param Member $member The member to edit
	*
	* @return View $view
	*
	*/
	public function removeGame($member){
		
		//Retrieve member games to list.
		$games = $member->games;

		//Create the view
		return View::make('members_remove_game',array(
			'member'	=>	$member,
			'games'		=>	$games
			));	}

	/**
	* Handles post request from deletion view form.
	*
	* Validates the received form data, if validator->passes() retrieves the object to delete , deletes 
	*	it's attachment from Game instances where such, after this proceeds to un-persist the member.
	*	If validator->fails() re-render's the page with errors.
	* 
	* @param void
	*
	* @return View $view
	*
	*/
	public function handleDelete(){

		//Get all the data from the request.
		$data  = Input::all();

		//Set rules for validator
		$rules = array('id'	=>	'required|exists:members,id');

		//Validate data with established rules.
		$validator = Validator::make($data,$rules);


		if($validator->passes()){

			//Get the object and collection of objects attached to it.
			$member 	 = Member::find(Input::get('id'));
			$games = $member->games;

			//Detach attached objects.
			$games->each(function($game) use($member){
				$game->members()->detach($member);
				$game->save();
			});

			//Delete member.
			$member->delete();

			return Redirect::action('MembersController@home');
		}

	//Redirect/reload page with errors to render.
	return Redirect::action('MembersController@delete',Input::get('id'))->withErrors($validator);

	}

	/**
	* Handles post request from creation and editing view forms.
	*
	* Validates the received form data, if validator->passes() creates/retrieves the object , sets/updates 
	*	it's attributes and proceeds to persist to the database.
	* 
	* @param void
	*
	* @return View $view
	*
	*/
	public function handleForm(){

		//Set the flag to trigger the two behaviors.
		$is_edit = (Input::has('id'))?true:false;

		//Get all the data from the request.
		$data 	 = Input::all();

		//Set rules for validator.
		$name_rule = 'required|alpha_num|min:2|max:20|unique:members,name';
		$name_rule .= ($is_edit)?',' . Input::get('id'):'';
		$rules = array(
			'name'		=>	$name_rule,
			'studio'	=>	'required|numeric|exists:studios,id',
			'bornt'		=>	'required|date_format:Y-m-d',
			'face'		=>	'required|image',
			'country'	=>	'required|numeric|exists:countries,id',
			'role'		=>	'required|numeric|exists:roles,id',
			'study'		=>	'required|numeric|exists:studies,id',
			);

		$has_file = Input::hasFile('face');

		if($is_edit){
			$rules['id'] = 'required|numeric|exists:members,id';
			if(!$has_file){
				unset($rules['face']);
			}
		}

		//Validate data with established rules.
		$validator = Validator::make($data,$rules);

		if($validator->passes()){

			//Get the object.
			$member 	   = ($is_edit == true)?Member::find(Input::get('id')):new Member;
			$member->name  = Input::get('name');
			$member->bornt = Input::get('bornt');

			//Associate Studio.
			$studio = Studio::find(intval(Input::get('studio')));
			$member->studio()->associate($studio);

			//Associate Country
			$country = Country::find(intval(Input::get('country')));
			$member->country()->associate($country);

			//Associate Role
			$role = Role::find(intval(Input::get('role')));
			$member->role()->associate($role);

			//Associate Study
			$study = Study::find(intval(Input::get('study')));
			$member->study()->associate($study);


			if(($has_file && $is_edit) || (!$is_edit)) {
				//General path of storage.
				$save_path = public_path().'/img/member_faces';

				//Delete old face.
				$tokens    = explode('/', $member->face);
				$file_name = $tokens[sizeof($tokens)-1];
				File::delete($save_path . '/' . $file_name);

				//Save new face.
				$file_name 	  = Input::get('name') . '_' . Input::get('studio') . '.' . Input::file('face')->guessExtension();
				Input::file('face')->move($save_path,$file_name);
				$member->face = URL::asset('img/member_faces/'.$file_name);
			}

			//Persist updated/created member on database.
			$member->save();
			
			//Redirect to listing.
			return Redirect::action('MembersController@home');
		}

		//Flash correct members to be rendered on redirected view.
		$failed_fields 	 = array_keys($validator->failed());
		$failed_fields[] = 'face';
		Input::flashExcept($failed_fields);

		//Redirect/reload page with errors to render.
		if($is_edit == true){
			return Redirect::action('MembersController@edit',Input::get('id'))->withErrors($validator);
		} else {
			return Redirect::action('MembersController@create')->withErrors($validator);
		}


	}


	/**
	* Handles post request from add/remove game view form.
	*
	* Validates the received form data, if validator->passes() , retrieves the object to update it's relationship
	*	on which outcome is determined by the $is_remove flag and does so.
	* 
	* @param void
	*
	* @return View $view
	*
	*/
	public function handleGame(){

		$is_remove = (Input::has('remove'))?true:false;

		//Get all the data from the request.
		$data  = Input::all();

		//Set rules for validator
		$rules = array('id'	=>	'required|exists:members,id','game'	=>	'required|exists:games,id');

		//Validate data with established rules.
		$validator = Validator::make($data,$rules);

		if($validator->passes()){

			//Get the object
			$member = Member::find(Input::get('id'));
			$game 	= Game::find(Input::get('game'));

			//Set/remove relationship
			if($is_remove){
				$member->games()->detach($game);
			} else {
				$games_added = $member->games()->lists('id');
				if(!in_array($game->id,$games_added)){
					$member->games()->save($game);
				}
			}

			//Save member.
			$member->save();

			return Redirect::action('MembersController@home');
		}


	//Redirect/reload page with errors to render.
	if($is_remove){
		return Redirect::action('MembersController@removeGame',Input::get('id'))->withErrors($validator);
	} else {
		return Redirect::action('MembersController@addGame',Input::get('id'))->withErrors($validator);
	}

	}

	/**
	* Queries countries by continent
	*
	* Queries country objects by their region_code attribute and returns an array organized by continent name
	* 
	* @param void
	*
	* @return array $world_regions
	*
	*/
	private function get_world_regions(){

		//Query countries by region code being continent code.
		return array(
			'Africa'	=>	Country::where('region_code','=','002')->get(),
			'America'	=>	Country::where('region_code','=','019')->get(),
			'Asia'		=>	Country::where('region_code','=','142')->get(),
			'Europe'	=>	Country::where('region_code','=','150')->get(),
			'Oceania'	=>	Country::where('region_code','=','009')->get()
			);
	}

}


?>