<?php 

class GamesController extends BaseController {


	/**
	* Renders the view where game items are listed.
	*
	* Loads the games_home.blade.php page passing the collection of all game objects.
	*
	* @param void
	*
	* @return View $view
	*
	*/
	public function home(){

		//Retrieve games to list in home page.
		$games = Game::all();
		return View::make('games_home',compact('games'));
	}


	/**
	* Renders the view where game items are created.
	*
	* Loads the games_create.blade.php page passing field values from past requests (if any) and world regions.
	*
	* @param Game $game The game to create
	*
	* @return View $view
	*
	*/
	public function create(){

		//World regions to present in created form.
		$studios = Studio::all();

		//Fields to be saved from past request ( if any )
		$fields 	= array('name','release','studio');
		$fields_old = array();
		foreach ($fields as $value) {
			$fields_old[$value] = Input::old($value);
		}
		//Create the view.
		return View::make('games_create',array(
			'studios'	=>	$studios,
			'fields_old'	=>	$fields_old,
			'submit_to'		=>	action('GamesController@handleForm'),
			'title'			=>	'Add game',
			'submit_msg'	=>	'Create'
			));
	}


	/**
	* Renders the view where game items are edited.
	*
	* Loads the games_edit.blade.php page passing the existing object attributes and studios.
	*
	* @param Game $game The game to edit
	*
	* @return View $view
	*
	*/
	public function edit(game $game){

		//Retrieve studios to list.
		$studios = Studio::all();

		//Fields to set with existing object attributes.
		$fields_old = array(
			'name'		=>	$game->name,
			'release'	=>	$game->release,
			'cover'		=> $game->cover,
			'studio'	=>	$game->studio->id
			);

		//Create the view
		return View::make('games_create',array(
			'studios'	=>	$studios ,
			'fields_old'	=>	$fields_old,
			'submit_to'		=>	action('GamesController@handleForm'),
			'title'			=>	'Edit game',
			'id'			=>	$game->id,
			'submit_msg'	=>	'Save'
			));
	}


	/**
	* Renders the view where game item deletion confirmation is required.
	*
	* Loads the games_delete.blade.php page together the provided Game instance.
	*
	* @param Game $game The game to edit
	*
	* @return View $view
	*
	*/
	public function delete($game){

		//Create the view
		return View::make('games_delete',compact('game'));
	}


	/**
	* Handles post request from deletion view form.
	*
	* Validates the received form data, if validator->passes() retrieves the object to delete , deletes 
	*	it's attachment from Member instances where such, after this proceeds to un-persist the member.
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
		$rules = array('id'	=>	'required|exists:games,id');

		//Validate data with established rules.
		$validator = Validator::make($data,$rules);


		if($validator->passes()){

			//Get the object and collection of objects attached to it.
			$game 	 = Game::find(Input::get('id'));
			$members = $game->members;

			//Detach attached objects.
			$members->each(function($member) use ($game){
				$member->games()->detach($game);
				$member->save();
			});

			//Delete game.
			$game->delete();

			return Redirect::action('GamesController@home');
		}

	//Redirect/reload page with errors to render.
	return Redirect::action('GamesController@delete',Input::get('id'))->withErrors($validator);

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
		$name_rule = 'required|alpha_num|min:2|max:20|unique:games,name';
		$name_rule .= ($is_edit)?',' . Input::get('id'):'';
		$rules = array(
			'name'		=>	$name_rule,
			'studio'	=>	'required|numeric|exists:studios,id',
			'release'	=>	'required|date_format:Y-m-d',
			'cover'		=>	'required|image'
			);

		$has_file = Input::hasFile('cover');

		if($is_edit){
			$rules['id'] = 'required|numeric|exists:games,id';
			if(!$has_file){
				unset($rules['cover']);
			}
		}

		//Validate data with established rules.
		$validator = Validator::make($data,$rules);

		if($validator->passes()){

			//Get the object.
			$game 	  	   = ($is_edit == true)?Game::find(Input::get('id')):new game;
			$game->name    = Input::get('name');
			$game->release = Input::get('release');

			//Associate Studio.
			$studio = Studio::find(intval(Input::get('studio')));
			$game->studio()->associate($studio);

			if(($has_file && $is_edit) || (!$is_edit)) {
				//General path of storage.
				$save_path = public_path().'/img/game_covers';

				//Delete old cover.
				$tokens    = explode('/', $game->cover);
				$file_name = $tokens[sizeof($tokens)-1];
				File::delete($save_path . '/' . $file_name);

				//Save new cover.
				$file_name 	  = Input::get('name') . '_' . Input::get('studio') . '.' . Input::file('cover')->guessExtension();
				Input::file('cover')->move($save_path,$file_name);
				$game->cover  = URL::asset('img/game_covers/'.$file_name);
			}

			//Persist updated/created member on database.
			$game->save();
			
			//Redirect to listing.
			return Redirect::action('GamesController@home');
		}

		//Flash correct items to be rendered on redirected view.
		$failed_fields 	 = array_keys($validator->failed());
		$failed_fields[] = 'cover';
		Input::flashExcept($failed_fields);

		//Redirect/reload page with errors to render.
		if($is_edit == true){
			return Redirect::action('GamesController@edit',Input::get('id'))->withErrors($validator);
		} else {
			return Redirect::action('GamesController@create')->withErrors($validator);
		}


	}

}


?>