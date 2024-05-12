<?php 

namespace Lune\Routing;

/**
 * Represents a route in the application.
 */
class Route { 
   /**
    * The URI pattern of the route.
    *
    * @var string
    */
   protected string $uri;

   /**
    * The action to be executed when the route is matched.
    *
    * @var \Closure
    */
   protected \Closure $action; 

   /**
    * The regular expression generated from the URI pattern.
    *
    * @var string
    */
   protected string $regex;

   /**
    * The parameters extracted from the URI pattern.
    *
    * @var array
    */
   protected array $parameters;

   /**
    * Create a new Route instance.
    *
    * @param string $uri The URI pattern of the route.
    * @param \Closure $action The action to be executed when the route is matched.
    */
   public function __construct(string $uri, \Closure $action) {
      $this->uri = $uri;
      $this->action = $action;
      $this->regex = preg_replace('/\{([a-zA-Z]+)\}/', '([a-zA-Z0-9]+)', $uri);
      preg_match_all('/\{([a-zA-Z]+)\}/', $uri, $parameters);
      $this->parameters = $parameters[1];
  }

   /**
    * Get the URI pattern of the route.
    *
    * @return string The URI pattern.
    */
   public function uri(){ 
    return $this->uri;
   }

   /**
    * Get the action to be executed when the route is matched.
    *
    * @return \Closure The action.
    */
   public function action(){ 
    return $this->action;
   }

   /**
    * Check if the route matches the given URI.
    *
    * @param string $uri The URI to match against.
    * @return bool True if the route matches, false otherwise.
    */
   public function matches(string $uri): bool {
    return preg_match("#^$this->regex/?$#", $uri);
   }

   /**
    * Check if the route has any parameters.
    *
    * @return bool True if the route has parameters, false otherwise.
    */
   public function hasParameters(): bool { 
    return count($this->parameters) > 0 ;
   }

   /**
    * Parse the parameters from the given URI.
    *
    * @param string $uri The URI to parse parameters from.
    * @return array The parsed parameters.
    */
   public function parseParameters(string $uri): array {
      preg_match("#^$this->regex$#", $uri, $arguments);
    
      return array_combine($this->parameters, array_slice($arguments, 1));
     
 }
}

?>