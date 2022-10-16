<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class User
{
    /**
     * Return a value for the field.
     *
     * @param null                                                $rootValue   Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param mixed[]                                             $args        The arguments that were passed into the field.
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext $context     Arbitrary data that is shared between all fields of a single query.
     * @param \GraphQL\Type\Definition\ResolveInfo                $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     *
     * @return mixed
     */
    public function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
//        // TODO implement the resolver
//        if($args["id"]){
        ////            return "ok";
//            return \App\User::find($args["id"]);
//        }
//        return null;
    }

    public function all($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $client = new \GuzzleHttp\Client();
//        $foo = $client->get('http://example.com/foo');
        $bar = $client->get('https://jsonblob.com/api/4947d44b-7c76-11e9-8e48-31658d025df1', ['accept-encoding' => 'application/json']);

        return json_decode($bar->getBody()->getContents())->data->users;
        // TODO implement the resolver
        return \App\User::all();
//        return [
//            [
//                "id" => 1,
//                "name" => "toto",
//                "created_at" => now()
//            ],
//            [
//                "id" => 2,
//                "name" => "ata",
//                "created_at" => null
//            ],
//
//
//        ];
    }
}

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Post
{
    /**
     * Return a value for the field.
     *
     * @param null                                                $rootValue   Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param mixed[]                                             $args        The arguments that were passed into the field.
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext $context     Arbitrary data that is shared between all fields of a single query.
     * @param \GraphQL\Type\Definition\ResolveInfo                $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     *
     * @return mixed
     */
    public function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        // TODO implement the resolver
    }

    public function getUserPosts($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $client = new \GuzzleHttp\Client();

        $bar = $client->get('https://jsonblob.com/api/7d0df1f3-7c7e-11e9-8e48-9f486a70afbc', ['accept-encoding' => 'application/json']);

        // Simulation de la discrimintaion par user ID (process traiter par l'api')
        // MICROSERVICE:
        //  $posts = Post::ofUser($request['user_id'])->get();
        //  return $response->json($posts->toArray());
        $posts = collect((json_decode($bar->getBody()->getContents()))->data->posts);

        $posts = $posts->filter(function ($item, $key) use ($args) {
            $user_id = $args['user_id'];

            return $item->user_id == $user_id;
        });
        // Fin de Simulation de la discrimintaion par user ID (process traiter par l'api')

        return $posts->toArray();
    }
}
