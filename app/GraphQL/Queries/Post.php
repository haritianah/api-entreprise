<?php

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
//        return [
//            [
//                "id" => 1,
//                "title" => "titre1",
//                "content" => "toto c'est le plus beau1",
//                "user_id" => 1
//            ],
//            [
//                "id" => 2,
//                "title" => "titre2",
//                "content" => "toto c'est le plus beau2",
//                "user_id" => 2
//            ],
//
//
//        ];

        return $rootValue;

        // TODO implement the resolver
        $client = new \GuzzleHttp\Client();

        $bar = $client->get('https://jsonblob.com/api/7d0df1f3-7c7e-11e9-8e48-9f486a70afbc', ['accept-encoding' => 'application/json']);

        $posts = collect((json_decode($bar->getBody()->getContents()))->data->posts);

        return $posts->first(function ($item, $key) use ($args) {
            $post_id = $args['id'];

            return $item->id == $post_id;
        });
    }
}
