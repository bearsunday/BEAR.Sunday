<?php

namespace BEAR\App\sample;

// Page Class
class ResourceDSL extends Page
{
use DefaultView;
    
    /**
     * @Inject
     * @Named("wheather=wheather,user=user,friend=friend,news=news")
     */
    public function __construct(
        Resource $resource,
        Ro $wheather,
        Ro $user,
        Ro $news
    ){
        $this->resource = $resouce;
        $this->weather = $weather;
        $this->user = $user;
        $this->news = $news;
    }
    
    /**
     * @param int $userId
     * @return ResourceObject
     * 
     * @Auth("role=member")
     * @Validate
     * @RequestCache
     * @Log
     */
    public function onGet($userId)
    {
        // instance
        $this['title'] = 'User Page';
        // resource request with resource object;
        $this['weather'] = $this->resource->get->object($this->weather)->request();
        // resource request with resource uri;
        $this['user'] = $this->resource->get->uri('app://self/user')->request();
        // resource eager request with resource object;
        $this['weather'] = $this->resource->get->object($this->weather)->cached->eager->request();
        // resource element eager request with resource object;
        $this['tokyo'] = $this->resource->get->object($this->weather)->request()['tokyo'];
        // pagignation request
        $this['tokyo'] = $this->resource->get->object($this->entry)->page()->per(10)->request();
        // resource element eager request with resource object;    
        $this['news'] = $this->resource->uri('csv://path/tp/news.csv')->cache->request();
        $this['time'] = function(){ return new \DateTime;};
        // with intercepter annotation
        $this['friend'] = $this->resource->get->object($this->user)->withAnotation(array('Auth', 'Log'))->request();
        return $this;
    }
    
    public function onPostLogin($id, $pass)
    {
        $this->body['isAuthValid'] = $this->resource
        ->post
        ->object($this->auth)
        ->withQuery(['id' => $id, 'pass' => $pass])
        ->csrf
        ->poe
        ->request()['is_valid'];
    }
}