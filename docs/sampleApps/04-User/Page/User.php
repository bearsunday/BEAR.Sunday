<?php

namespace BEAR\App\sample;

// Page Class
class User extends Page
{
    use DefaultView;
    
	/**
	 * @Inject
	 * @Named("user=user,friend=friend,news=news")
	 */
	public function __construct(
		Resource $resource,
		Ro $user,
		Ro $friend,
		Ro $news
	){
		$this->resource = $resouce;
		$this->user = $user;
		$this->friend = $friend;
		$this->news = $news;
	}
	
	public function onGet($userId)
	{
	    // instance
		$this['title'] = 'User Page';
		// resource request;
		$this['weather'] = $this->resource->object($this->weather)->get();
		// rsource link request
		$this['user'] = $this->resource->object($this->user)->link('friend')->get(['id' => $userId]);
		// resource uri request
		$this['news'] = $this->resource->object('csv://path/tp/news.csv')->lazy->get();
		// rsouce eager request
		$this['news'] = $this->resource->object('csv://path/tp/news.csv')->eager->get();
		$this['news'] = $this->resource->object('csv://path/tp/news.csv')->intercept('@Cache')->get();
		$this['time'] = function(){ return new \DateTime;};
	}
	
	public function onPostLogin($id, $pass)
	{
		$this->body['isAuthValid'] = $this->resource->post($this->auth, ['id' => $id, 'pass' => $pass])['is_valid'];
	}
}
class User extends App
{
    public $body;
    
    public function onGet($userId)
	{
// 	    $this->body['user'] = $this->quesry($sql);
	    $this->body = $this->quesry($sql);
// 	    return $result;
	}
}