# System info package

### Description

For now shows only opcache status information.

### Install

- Use composer:
- 
    ````
    composer require artemalexeev/systeminfo
    ````

### Usage
For getting opcache status information you can use the following code:
  
    use ArtemAlieksieiev\SystemInfo\OpcacheStatus;
    
    (new OpcacheStatus())->display();

Or for real example check `examples/opcache_demo.php` file.
