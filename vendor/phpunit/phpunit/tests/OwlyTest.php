<?php
class OwlyTest extends PHPUnit_Framework_TestCase
{
	
	private $owly;
	
	public function __construct()
	{
		$this->owly = new Owly();
	}
	
	public function testUrlInfo()
	{
		// Arrange
		$testShortUrl = "http://ow.ly/1234"; //will give us back hash 1234
	
		// Act	
		$res = $this->owly->urlInfo($testShortUrl);
	
		// Assert
		$res_array = $res->json();
		$hash = $res_array['results']['hash'];
		$this->assertEquals("1234",$hash);
	}
	
    public function testUrlShorten()
    {
        // Arrange
        $testLongUrl = "http://www.hootsuite.com"; //will give back hash 3tBG6D

        // Act		
        $res = $this->owly->urlShorten($testLongUrl);

        // Assert
        $res_array = $res->json();   
        $hash = $res_array['results']['hash'];
        $this->assertEquals("3tBG6D",$hash);
    }
    
    public function testUrlExpand()
    {
    	// Arrange
    	$testShortUrl = "http://ow.ly/1234"; //will give us back long url http://clipblast.com/clip/2554278189
    	    
    	// Act
    	$res = $this->owly->urlExpand($testShortUrl);
    
    	// Assert
    	$res_array = $res->json();
    	$longUrl = $res_array['results']['longUrl'];
    	$this->assertEquals("http://clipblast.com/clip/2554278189",$longUrl);
    }
}