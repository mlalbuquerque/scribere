<?php

class OSCheckTraitTest extends PHPUnit_Framework_TestCase
{
    
    private $osCheck;
    
    public function setUp()
    {
        $this->osCheck = $this->getMockForTrait(\App\Helper\OSCheckTrait::class);
    }
    
    public function testReturnsUnixRunningOnUnix()
    {
        $this->assertEquals('unix', $this->osCheck->OS('Unix'));
    }
    
    public function testReturnsUnixRunningOnLinux()
    {
        $this->assertEquals('unix', $this->osCheck->OS('Linux'));
    }
    
    public function testReturnsUnixRunningOnMacOs()
    {
        $this->assertEquals('unix', $this->osCheck->OS('Darwin'));
    }
    
    public function testReturnsUnixRunningOnFreeBSD()
    {
        $this->assertEquals('unix', $this->osCheck->OS('FreeBSD'));
    }
    
    public function testReturnsUnixRunningOnOpenBSD()
    {
        $this->assertEquals('unix', $this->osCheck->OS('OpenBSD'));
    }
    
    public function testReturnsUnixRunningOnNetBSD()
    {
        $this->assertEquals('unix', $this->osCheck->OS('NetBSD'));
    }
    
    public function testReturnsWindowsRunningOnWindowsXP()
    {
        $this->assertEquals('windows', $this->osCheck->OS('WIN32'));
    }
    
    public function testReturnsWindowsRunningOnWindowsServer()
    {
        $this->assertEquals('windows', $this->osCheck->OS('WindowsNT'));
    }
    
    public function testReturnsWindowsRunningOnWindows7()
    {
        $this->assertEquals('windows', $this->osCheck->OS('WINNT'));
    }
    
    public function testReturnsWindowsRunningOnWindows8()
    {
        $this->assertEquals('windows', $this->osCheck->OS('Windows'));
    }
    
    public function testReturnsWindowsRunningOnWindows10()
    {
        $this->assertEquals('windows', $this->osCheck->OS('Windows10'));
    }
    
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage OS not determined!
     */
    public function testOsNotDeterminedException()
    {
        $this->osCheck->OS('Unrecognized Operating System');
    }
    
}
