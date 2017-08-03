<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elasticsearch\ClientBuilder;
use Elastica\Client as ElasticaClient;
use Elastica;
use Faker\Factory as Faker;
class ClientController extends Controller
{
  //Elasticsearch-php client
    protected $elasticsearch;

  //Elastica client
    protected $elastica;


  //elastica Index
  protected $elasticaIndex;

  //set up our clients
    public function __construct(){
      $this->elasticsearch=ClientBuilder::create()->build();

      //create an elastic client
      $elasticaConfig=[
        'host'=>'localhost',
        'port'=>9200,
        'index'=>'pets'
      ];
      $this->elastica = new ElasticaClient($elasticaConfig);

      $this->elasticaIndex=$this->elastica->getIndex('pets');

    }
    //test Elasticsearch-php client
    public function elasticsearchTest(){
      dump($this->elasticsearch);

      //retrieve a document that we have indexed
      echo "\n\nRetrieve a document:\n";
      $params=[
        'index'=>'pets',
        'type'=>'dog',
        'id'=>'1'
      ];
      $response=$this->elasticsearch->get($params);
      dump($response);
    }

    //test elastica client
    public function elasticaTest(){
      //view our elastic client object
      dump($this->elastica);
      //view elastica index
      dump($this->elasticaIndex);

      //Get the types and mappings

      echo "\n\nGet types and mapping";
      $dogType=$this->elasticaIndex->getType('dog');
      dump($dogType->getMapping());

      //retrieve a document that we have indexed
      echo "\n\nGet a document";
      $response=$dogType->getDocument('1');
      dump($response);

    }


    //data strucctures with Elasticsearch-php
    public function elasticsearchData(){
      $params=[
        'index'=>'pets',
        'type' =>'bird',
        'body' =>[
          'bird' =>[
            '_source'=>[
              'enabled'=>true
            ],
            'properties'=>[
              'name'  =>array('type'=>'string'),
              'age'  =>array('type'=>'long'),
              'gender'  =>array('type'=>'string'),
              'color'  =>array('type'=>'string'),
              'braveBird'  =>array('type'=>'boolean'),
              'hometown'  =>array('type'=>'string'),
              'about'  =>array('type'=>'text'),
              'registered'  =>array('type'=>'date'),
            ]
          ]
        ]
      ];
  //    $response=$this->elasticsearch->indices()->putMapping($params);
  //    dump($response);

      $params=[
        'index' =>'pets',
        'type' =>'bird'
      ];

      $response=$this->elasticsearch->indices()->getMapping($params);
      dump($response);


      $params=[
        'index' =>'pets',
        'type' =>'bird',
        'id'=>'1',
        'body'=>[
            'name' =>'Charlie Skittles',
            'age' =>'13',
            'gender' =>'male',
            'color' =>'brown',
            'braveBird' =>true,
            'hometown' =>'Phoenix, Arizona',
            'about' =>'Lorem ipsum dolor sit amet. consectetur adipiscing elit. Maecenas pharetra lobortis
                 nec ultricies ante velit viverra ex. Vestibulum laoreet cursus',
            'registered' =>date('Y-m-d'),
        ]
      ];
      $response=$this->elasticsearch->index($params);
      dump($response);

      //bulk index documents
      $faker=Faker::create();
      $params=[];

      for ($i=0;$i<100;$i++){
        $params['body'][]=[
            'index' =>[
              '_index'=>'pets',
              '_type'=>'bird',
            ]
        ];
        $gender=$faker->randomElement(['male','female']);
        $age=$faker->numberBetween(1,15);

        $params['body'][]=[
          'name' =>$faker->name($gender),
          'age' =>$age,
          'gender' =>$gender,
          'color' =>$faker->safeColorName,
          'braveBird' =>$faker->boolean,
          'hometown' =>"{$faker->city},{$faker->state}",
          'about' =>$faker->realText(),
          'registered' =>$faker->dateTimeBetween("-{$age} years",'now')->format('Y-m-d'),
        ];
      }

      $response=$this->elasticsearch->bulk($params);
      dump($response);
    }


    public function elasticaData(){
      $catType=$this->elasticaIndex->getType('cat');
      $mapping= new Elastica\Type\Mapping($catType,[
        'name'  =>array('type'=>'string'),
        'age'  =>array('type'=>'long'),
        'gender'  =>array('type'=>'string'),
        'color'  =>array('type'=>'string'),
        'prettyKitty'  =>array('type'=>'boolean'),
        'hometown'  =>array('type'=>'string'),
        'about'  =>array('type'=>'text'),
        'registered'  =>array('type'=>'date'),
      ]);

//      $response=$mapping->send();
//      dump($response);

    //index a document
    $catDocument = new Elastica\Document();
    $catDocument->setData([
      'name' =>'Meowlixander Hamilton',
      'age' =>'4',
      'gender' =>'male',
      'color' =>'orange',
      'prettyKitty' =>true,
      'hometown' =>'Portland, Oregon',
      'about' =>'Lorem ipsum dolor sit amet. consectetur adipiscing elit. Maecenas pharetra lobortis
           nec ultricies ante velit viverra ex. nec ultricies ante
           Sapien turpis egestas est, nec ultricies ante Vestibulum laoreet cursus',
      'registered' =>date('Y-m-d'),
    ]);


    $response=$catType->addDocument($catDocument);
    dump($response);


    //bulk index documents
    $faker=Faker::create();
    $documents=[];

    for ($i=0;$i<100;$i++){
      $gender=$faker->randomElement(['male','female']);
      $age=$faker->numberBetween(1,15);

      $documents[]=(new Elastica\Document())->setData([
        'name' =>$faker->name($gender),
        'age' =>$age,
        'gender' =>$gender,
        'color' =>$faker->safeColorName,
        'prettyKitty' =>$faker->boolean,
        'hometown' =>"{$faker->city},{$faker->state}",
        'about' =>$faker->realText(),
        'registered' =>$faker->dateTimeBetween("-{$age} years",'now')->format('Y-m-d'),
      ]);


    }
    $response=$catType->addDocuments($documents);
    dump($response);

    }

}
