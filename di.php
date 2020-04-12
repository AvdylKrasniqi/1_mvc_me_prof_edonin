<?php

// Registered services.
$__services = [];

// Created services (singleton).
$__serviceCache = [];

function di_resolve($name) {
  global $__services, $__serviceCache;

  // Nese gjendet ne cache, ktheje
  if (isset($__serviceCache[$name])) {
    return $__serviceCache[$name];
  }

  // Nese eshte i regjistruar si servis, krijoje, pastaj ktheje
  if (isset($__services[$name])) {
    $instance = di_instantiate($__services[$name]);
    $__serviceCache[$name] = $instance;
    return $instance;
  }

  // Nese ekziston si factory, krijoje, pastaj ktheje
  if (is_callable($name . '_factory')) {
    $instance = di_instantiate($name . '_factory');
    $__serviceCache[$name] = $instance;
    return $instance;
  }

  // Nese ekziston si funksion global, ktheje
  if (is_callable($name)) {
    return $name;
  }

  throw new Exception("Service '$name' could not be resolved.");
}

function di_instantiate($service) {
  if (is_callable($service)) {
    $reflection = new ReflectionFunction($service);
    $args = di_resolve_params($reflection);
    return $service(...$args);
  }

  $reflection = new ReflectionClass($service);
  $ctor = $reflection->getConstructor();
  if ($ctor == null) {
    return new $service();
  } else {
    $args = di_resolve_params($ctor);
    return new $service(...$args);
  }
}

function di_resolve_params($reflection) {
  return array_map(
    function ($parameter) {
      return di_resolve($parameter->name);
    },
    $reflection->getParameters()
  );
}

function di_register($name, $service = null) {
  global $__services;
  $__services[$name] = $service ?? $name;
}

function di_register_value($name, $value) {
  global $__serviceCache;
  $__serviceCache[$name] = $value;
}

function di_is_registered($name) {
  global $__services;
  return isset($__services[$name]);
}

abstract class Service { }
