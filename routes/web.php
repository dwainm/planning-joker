<?php

use App\Http\Controllers\GithubController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
		return redirect('/dashboard');
});

Route::get('/project/{id}', function ($id) {
		$issues = get_project_issues($id);

		return view('project',
				[
				'title'=>'Project',
				'id'  => $id,
				'issues'=> $issues,
				]);
});

Route::post('/project/{id}', function ($id){
	$field_id = "PVTF_lAHOABolQs2J4s4CTh_w"; // temporary harcoded untill settings is implemented where w
	update_estimate_values($id,$field_id, $_POST['estimate']??[]);
	return redirect('/project/'. $id );

});


if( ! function_exists('update_estimate_values') ) {
	function update_estimate_values( $project_id, $field_id, $new_values ) {
		$counter = 0;
		$updates = '';
		foreach( $new_values as $issue_id => $new_value )
		{
			$counter++;
			$updates .= sprintf('
			update%s: updateProjectV2ItemFieldValue(
						input: {
							projectId: "%s"
					itemId: "%s"
					fieldId: "%s"
					value: { 
					number: %d        
					}
					}
					) {
					projectV2Item {
						id
					 }
					}

			', $counter, $project_id, $issue_id, $field_id, $new_value);
		}
		$query = ['query' => sprintf('mutation {%s } ',$updates)];
		$response = gh_graphql_query($query);

		if( ! isset( $response->data)) {
			abort(400);
		}
	}
}
/** Auth Routes */
Route::get('/auth/github', [GithubController::class, 'redirect'])->name('github.login');
Route::get('/auth/github/callback', [GithubController::class, 'callback']);

Route::get('/dashboard', function () {
		return view('dashboard',
				[
				'title'=>'Welcome',
				'projects'=> get_projects(),
				]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * Functions
 */
if( ! function_exists('gh_query') ) {
function gh_query( $url, $body, $headers= []) {
	$token = Crypt::decryptString(Auth::user()->gh_token);

	$response = Http::withToken($token)
	->withHeaders(array_merge( $headers, [
			'Content-Type' => 'application/json',
	]))
	->post(
				$url,
				$body
			  );

	return json_decode($response);
}
}

if( ! function_exists('get_project_number_fields') ) {
function get_project_number_fields(){
		$name = Auth::user()->nickname;

		$query = [
		'query' => 'query ($username: String!){
		user(login: $username) {
		projectsV2(first: 20) {
		nodes {
		id
		title
		}
		}
		}
		}
		' ,
		'variables' => [
		'username' => $name,
		]
		];

		$response = gh_graphql_query($query);
		if( ! isset( $response->data->user->projectsV2->nodes)) {
			return [];
		}
		
		$projects =  $response->data->user->projectsV2->nodes;
		$fields = [];
		
		foreach ($projects as $project) {
				$query = ['query' =>'
				query apiGetAllFields($project_id: ID!) {
					node(id: $project_id) {
						... on ProjectV2 {
							fields(first: 20) {
								nodes {
									... on ProjectV2Field {
										id
											name
											dataType
									}
									... on ProjectV2IterationField {
										id
											name
											configuration {
												iterations {
													startDate
														id
												}
											}
									}
									... on ProjectV2SingleSelectField {
										id
											name
											options {
												id
													name
											}
									}
								}
							}
						}
					}
				}
			' ,
				'variables' => [
					'project_id' => $project->id,
				]
					];

			$response = gh_graphql_query($query);
			$responsFields = isset( $response->data->node->fields->nodes) ?  $response->data->node->fields->nodes : [];

			if( empty( $responsFields) ) {
				continue;
			}

			foreach( $responsFields as $field )
			{
				if ( ! isset($field->dataType) || $field->dataType != "NUMBER" )
				{
					continue;
				}

				$fields[$project->id] = [];
				$fields[$project->id]['project_title'] =  $project->title;	
				$fields[$project->id]['id'] =  $field->id;	
				$fields[$project->id]['name'] =  $field->name;	
			}
		}
		return $fields;
}
}

if( ! function_exists('get_projects') ) {
function get_projects(){
		$name = Auth::user()->nickname;

		$query = [
		'query' => 'query ($username: String!){
		user(login: $username) {
		projectsV2(first: 20) {
		nodes {
		id
		title
		}
		}
		}
		}
		' ,
		'variables' => [
		'username' => $name,
		]
		];

		$response = gh_graphql_query($query);
		if( ! isset( $response->data->user->projectsV2->nodes)) {
			return [];
		}
		
		return  $response->data->user->projectsV2->nodes;
}
}

if( ! function_exists('gh_graphql_query') ) {
function gh_graphql_query($query){
	return gh_query('https://api.github.com/graphql', $query );
}
}


if( ! function_exists('get_project_issues') ) {
function get_project_issues($id){

	/**
	 * All custom fields are build on common field types.
	 *
	 * The query below you'll see we list all field types we desire as these
	 * store the value in a unique field name. This is a really terrible API
	 * design, but I guess you can't get the same value field name in
	 * GraphQL if the types do not match.
	 */
	$query = [
		'query' => 'query apiGetProjectIssues($project_id: ID!) {
			node(id: $project_id) {
				... on ProjectV2 {
					items(first: 100) {
						nodes {
							id
								fieldValues(first: 100) {
									nodes {

										... on ProjectV2ItemFieldTextValue {
issue_title: text
				 field{
					 ... on ProjectV2FieldCommon {
						 id
						 name
					 }
				 }
										}
										... on ProjectV2ItemFieldDateValue {
value_date: date
				field{
					... on ProjectV2FieldCommon {
						id
						name
					}
				}
										}
										... on ProjectV2ItemFieldSingleSelectValue{
value_name: name
				field{
					... on ProjectV2FieldCommon {
						id
						name
					}
				}
										}
										... on ProjectV2ItemFieldNumberValue{
value_number: number
				  field{
					  ... on ProjectV2FieldCommon {
						  id
						  name
					  }
				  }
										}

										... on ProjectV2ItemFieldIterationValue {
value_iteration: title
					 field{
						 ... on ProjectV2FieldCommon {
							 id
							 name
						 }
					 }
										}
									}   
								}
						}
					}
				}
			}
		}	',
		'variables' => [
			'project_id' => $id,
		]
			];
	$response = gh_graphql_query($query);
	$issues = $response->data->node->items->nodes;

	// We need to convert the data into something that's easier to work with
	$simplified_issues = [];

	$issue_title = '';
	foreach ($issues as $issue) {
		$issue_id = $issue->id;
		// Supply defaults as we expect to have on template.
		$fields = [
			"estimate" => ["value"=>0, "id"=>"n/a"],
			"status" => ["value"=>0, "id"=>"n/a"],
		];

		foreach ($issue->fieldValues->nodes as $field) {
			if (count( (array)$field) == 0){
				continue;
			}

			if( property_exists( $field, 'issue_title') ) {
				$issue_title = $field->issue_title;
			}

			if( property_exists( $field, 'value_number') ) {
				$fields[strtolower($field->field->name)]=[];
				$fields[strtolower($field->field->name)]['value'] = $field->value_number;
				$fields[strtolower($field->field->name)]['id'] = $field->field->id;
			}

			if( property_exists( $field, 'value_name') ) {
				$fields[strtolower($field->field->name)]=[];
				$fields[strtolower($field->field->name)]['value'] = $field->value_name;
				$fields[strtolower($field->field->name)]['id'] = $field->field->id;
			}
		}

		$simplified_issues[] = [
			"id" => $issue_id,
			"title" => $issue_title,
			"fields"=> $fields,
		];
	}

	return $simplified_issues;
}
}

/**
query apiGetAllFields{
  node(id: "PVT_kwHOABolQs2J4g") {
    ... on ProjectV2 {
      fields(first: 20) {
        nodes {
          ... on ProjectV2Field {
            id
            name
          }
          ... on ProjectV2IterationField {
            id
            name
            configuration {
              iterations {
                startDate
                id
              }
            }
          }
          ... on ProjectV2SingleSelectField {
            id
            name
            options {
              id
              name
            }
          }
        }
      }
    }
}
}
*/

require __DIR__.'/auth.php';
