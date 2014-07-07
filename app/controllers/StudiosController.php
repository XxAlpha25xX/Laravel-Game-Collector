<?php 

class StudiosController extends BaseController {


	/**
	* Renders the view where Studio items are listed.
	*
	* Loads the studios_home.blade.php page passing the collection of all Studio objects.
	*
	* @param void
	*
	* @return View $view
	*
	*/
	public function home(){

		//Retrieve studios to list.
		$studios = Studio::all();
		return View::make('studios_home',compact('studios'));
	}


	/**
	* Renders the view where Studio items are created.
	*
	* Loads the studios_create.blade.php page passing field values from past requests (if any) and world regions.
	*
	* @param Studio $studio The studio to create
	*
	* @return View $view
	*
	*/
	public function create(){

		//World regions to present in created form.
		$world_regions = $this->get_world_regions();

		//Fields to be saved from past request ( if any )
		$fields 	= array('name','founded','country');
		$fields_old = array();
		foreach ($fields as $value) {
			$fields_old[$value] = Input::old($value);
		}
		//Create the view.
		return View::make('studios_create',array(
			'world_regions'	=>	$world_regions,
			'fields_old'	=>	$fields_old,
			'submit_to'		=>	action('StudiosController@handleForm'),
			'title'			=>	'Add Studio',
			));
	}


	/**
	* Renders the view where Studio items are edited.
	*
	* Loads the studios_edit.blade.php page passing the existing object attributes and world regions.
	*
	* @param Studio $studio The studio to edit
	*
	* @return View $view
	*
	*/
	public function edit(Studio $studio){

		//Retrieve world regions to list in created form.
		$world_regions = $this->get_world_regions();

		//Fields to set with existing object attributes.
		$fields_old = array(
			'name'		=>	$studio->name,
			'founded'	=>	$studio->founded,
			'country'	=>	$studio->country->id,
			'logo'		=> $studio->logo,
			);

		//Create the view
		return View::make('studios_create',array(
			'world_regions'	=>	$world_regions ,
			'fields_old'	=>	$fields_old,
			'submit_to'		=>	action('StudiosController@handleForm'),
			'title'			=>	'Edit Studio',
			'id'			=>	$studio->id,
			));
	}


	/**
	* Renders the view where Studio deletion confirmation is required.
	*
	* Loads the studios_delete.blade.php page together the provided Game instance.
	*
	* @param Studio $studio The studio to edit
	*
	* @return View $view
	*
	*/
	public function delete($studio){

		//Create the view
		return View::make('studios_delete',compact('studio'));
	}


	/**
	* Handles post request from deletion view form.
	*
	* Validates the received form data, if validator->passes() retrieves the object to delete , deletes 
	*	it's ownership from Game & Member instances where such and associates a default studio to belong, after this
	*	proceeds to un-persist the studio. If validator->fails() re-render's the page with errors.
	* 
	* @param void
	*
	* @return View $view
	*
	*/
	public function handleDelete(){

		//Get all the data from the request.
		$data = Input::all();

		//Set rules for validator
		$rules = array('id'	=>	'required|exists:studios,id');

		//Validate data with established rules.
		$validator = Validator::make($data,$rules);


		if($validator->passes()){

			//Get the object and collection of objects belonging to it.
			$studio 		   = Studio::find(Input::get('id'));
			$games 			   = $studio->games;
			$members 		   = $studio->members;
			$merged_collection = $games->merge($members);

			//Associate objects belonging to it to 'Indie' studio and save.
			$merged_collection->each(function($item){
				global $studio;
				$item->studio_id = null;
				$defStudio 		 = Studio::find('5');	
				$item->studio()->associate($defStudio);
				$item->save();
			});

			//Delete studio.
			$studio->delete();

			return Redirect::action('StudiosController@home');
		}

	//Redirect/reload page with errors to render.
	return Redirect::action('StudiosController@delete',Input::get('id'))->withErrors($validator);

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
		$rules = array(
			'name'		=>	'required|alpha_num|min:2|max:20|unique:studios,name',
			'country'	=>	'required|numeric|exists:countries,id',
			'founded'	=>	'required|date_format:Y-m-d',
			'logo'		=>	'required|image',
			);

		$has_file = Input::hasFile('logo');

		if($is_edit){
			$rules['id'] = 'required|numeric|exists:studios,id';
			if(!$has_file){
				unset($rules['logo']);
			}
		}

		//Validate data with established rules.
		$validator = Validator::make($data,$rules);

		if($validator->passes()){

			//Get the object.
			$studio 	  	 = ($is_edit == true)?Studio::find(Input::get('id')):new Studio;
			$studio->name 	 = Input::get('name');
			$studio->founded = Input::get('founded');

			//Associate Country.
			$country = Country::find(intval(Input::get('country')));
			$studio->country()->associate($country);

			if(($has_file && $is_edit) || (!$is_edit)) {
				//General path of storage.
				$save_path = public_path().'/img/studio_logos';

				//Delete old logo.
				$tokens    = explode('/', $studio->logo);
				$file_name = $tokens[sizeof($tokens)-1];
				File::delete($save_path . '/' . $file_name);

				//Save new logo.
				$file_name 	  = Input::get('name') . '_' . Input::get('country') . '.' . Input::file('logo')->guessExtension();
				Input::file('logo')->move($save_path,$file_name);
				$studio->logo = URL::asset('img/studio_logos/'.$file_name);
			}

			//Persist updated/created item on database.
			$studio->save();
			
			//Redirect to listing.
			return Redirect::action('StudiosController@home');
		}

		//Flash correct items to be rendered on redirected view.
		$failed_fields 	 = array_keys($validator->failed());
		$failed_fields[] = 'logo';
		Input::flashExcept($failed_fields);

		//Redirect/reload page with errors to render.
		if($is_edit == true){
			return Redirect::action('StudiosController@edit',Input::get('id'))->withErrors($validator);
		} else {
			return Redirect::action('StudiosController@create')->withErrors($validator);
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