<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

URL::forceRootUrl(env('APP_URL'));

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', 'API\\ApiController@apiDocs');

Route::resource('agents', "API\\AgentController");


Route::get('references/{reference}/publishedIn', 
        'API\\ReferenceController@showPublishedIn')
        ->name('references.publishedIn');
Route::get('references/{reference}/creator', 
        'API\\ReferenceController@showCreator')
        ->name('references.creator');
Route::get('references/{reference}/modifiedBy', 
        'API\\ReferenceController@showModifiedBy')
        ->name('references.modifiedBy');
Route::resource('references', "API\\ReferenceController");


Route::get('names/{name}/namePublishedIn', 
        'API\\NameController@showNamePublishedIn')
        ->name('names.namePublishedIn');
Route::get('names/{name}/creator', 
        'API\\NameController@showCreator')
        ->name('name.creator');
Route::get('names/{name}/modifiedBy', 
        'API\\NameController@showModifiedBy')
        ->name('names.modifiedBy');
Route::resource('names', "API\\NameController");

Route::get('taxa/search', 'API\\SolariumController@search');
Route::get('taxa/{taxon}/name', 
        'API\\TaxonController@hasScientificName')
        ->name('taxa.name');
Route::get('taxa/{taxon}/nameAccordingTo', 
        'API\\TaxonController@showNameAccordingTo')
        ->name('taxa.nameAccordingTo');
Route::get('taxa/{taxon}/classification', 
        'API\\TaxonController@classification')
        ->name('taxa.classification');
Route::get('taxa/{taxon}/siblings', 
        'API\\TaxonController@siblings')
        ->name('taxa.siblings');
Route::get('taxa/{taxon}/children', 
        'API\\TaxonController@children')
        ->name('taxa.children');
Route::get('taxa/{taxon}/synonyms', 
        'API\\TaxonController@synonyms')
        ->name('taxa.synonyms');
Route::get('taxa/{taxon}/acceptedNameUsage', 
        'API\\TaxonController@hasAcceptedNameUsage')
        ->name('taxa.acceptedNameUsage');
Route::get('taxa/{taxon}/parentNameUsage', 
        'API\\TaxonController@hasParentNameUsage')
        ->name('taxa.parentNameUsage');
Route::get('taxa/{taxon}/treatments', 
        'API\\TaxonController@treatments')
        ->name('taxa.treatments');
Route::get('taxa/{taxon}/currentTreatment', 
        'API\\TaxonController@currentTreatment')
        ->name('taxa.currentTreatment');
Route::get('taxa/{taxon}/changes', 
        'API\\TaxonController@changes')
        ->name('taxa.changes');
Route::get('taxa/{taxon}/bioregionDistribution', 
        'API\\TaxonController@distribution')
        ->name('taxa.bioregionDistribution');
Route::get('taxa/{taxon}/stateDistribution', 
        'API\\TaxonController@stateDistribution')
        ->name('taxa.stateDistribution');
Route::get('taxa/{taxon}/features', 
        'API\\TaxonController@listFeatures')
        ->name('taxa.features.list');
Route::get('taxa/{taxon}/images', 
        'API\\TaxonController@images')
        ->name('taxa.images');
Route::get('taxa/{taxon}/heroImage', 
        'API\\TaxonController@showHeroImage')
        ->name('taxa.heroImage');
Route::get('taxa/{taxon}/references', 
        'API\\TaxonController@showReferences')
        ->name('taxa.references');
Route::get('taxa/{taxon}/key', 
        'API\\TaxonController@findKey')
        ->name('taxa.key');
Route::get('taxa/{taxon}/creator', 
        'API\\TaxonController@showCreator')
        ->name('taxon.creator');
Route::get('taxa/{taxon}/modifiedBy', 
        'API\\TaxonController@showModifiedBy')
        ->name('taxa.modifiedBy');
Route::get('taxa/{taxon}/vernacularNames', 
        'API\\TaxonController@listVernacularNames')
        ->name('api.taxa.vernacularNames');
Route::resource('taxa', "API\\TaxonController", [
    'as' => 'api',
    'parameters' => [
         'taxa' => 'taxon'
    ]
]);

Route::get('images/{image}/occurrence', 
        'API\\ImageController@showOccurrence')
        ->name('images.occurrence');
Route::get('images/{image}/accessPoints', 
        'API\\ImageController@showAccessPoints')
        ->name('images.accessPoints');
Route::resource('images', "API\\ImageController");
Route::resource('occurrences', "API\\OccurrenceController");
Route::resource('access-points', "API\\AccessPointController");
Route::resource('accessPoints', "API\\AccessPointController");

Route::get('treatments/{guid}:{version}', "API\\TreatmentController@show")
        ->name('treatments.show');
Route::get('treatments/{guid}:{version}/forTaxon', "API\\TreatmentController@showForTaxon")
        ->name('treatments.forTaxon');
Route::get('treatments/{guid}:{version}/asTaxon', "API\\TreatmentController@showAsTaxon")
        ->name('treatments.asTaxon');
Route::get('treatments/{guid}:{version}/acceptedNameUsage', "API\\TreatmentController@showAcceptedNameUsage")
        ->name('treatments.acceptedNameUsage');
Route::get('treatments/{guid}:{version}/source', "API\\TreatmentController@showSource")
        ->name('treatments.source');
Route::get('treatments/{guid}:{version}/creator', "API\\TreatmentController@showCreator")
        ->name('treatments.asCreator');
Route::get('treatments/{guid}:{version}/modifiedBy', "API\\TreatmentController@showModifiedBy")
        ->name('treatments.asTaxon');
Route::resource('treatments', "API\\TreatmentController", [
    'except' => ['show']
]);

Route::resource('vernacular-names', "API\\VernacularNameController", [
    'only' => ['show']
]);

Route::resource('changes', "API\\ChangeController");
Route::resource('glossary/terms', "API\\Glossary\\TermController");
Route::resource('glossary/relationships', "API\\Glossary\\RelationshipController");

Route::get('solr/fields', 'API\\SolariumController@solrFields');
Route::get('solr/ping', 'API\\SolariumController@ping');

