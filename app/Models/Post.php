<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{
    public String $title;
    public String $body;
    public String $date;
    public String $slug;

    public function __construct($title,$body,$date,$slug)
    {
        $this->$title = $title;
        $this->$body = $body;
        $this->$date = $date;
        $this->$slug = $slug;

    }

    public static  function  find($slug)
    {
        return static::all()->firstWhere('slug',$slug);

        if (!file_exists($path = resource_path("posts/{$slug}.html")
        )){
        return redirect('/');
            throw  new ModelNotFoundException();
        }

        return cache()->remember("posts.$slug",now()->addSecond(10),function ()use($path) {

            return file_get_contents($path);
        });

    }


    public static function all(){

        return  cache()->rememberForever('posts.all',function (){
            return collect(File::files(resource_path("posts")))->map(function ($file){
                $object = YamlFrontMatter::parseFile($file);
                return new Post(
                    $object->matter("title"),
                    $object->body(),
                    $object->matter("date"),
                    $object->matter("slug"),

                );
            })->sortBy('date');
        });



         return array_map(function ($file){
            $object = YamlFrontMatter::parseFile($file);

            return new Post(
                $object->matter("title"),
                $object->body(),
                $object->matter("date"),
            );
        },$files);

        $posts = [];

        foreach($files as $file){
            $object = YamlFrontMatter::parseFile($file);

            $posts[]= new Post(
                $object->matter("title"),
                $object->body(),
                $object->matter("date"),
            );
        }
        return $posts;

        return array_map(function ($file){

          $object = YamlFrontMatter::parseFile($file);
          return $object->body;
        },$files);

        return collect($files)->map(function ($file){
            $object = YamlFrontMatter::parseFile($file);
            return $object->title;
        })->sort('date');
    }

}
